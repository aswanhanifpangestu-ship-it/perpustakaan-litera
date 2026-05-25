<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /* ------------------------------------------------------------------ */
    /* INDEX                                                                */
    /* ------------------------------------------------------------------ */

    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku', 'petugas']);

        // Anggota hanya lihat milik sendiri
        if (Auth::user()->isUser()) {
            $query->where('user_id', Auth::id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('status_denda')) {
            $query->where('status_denda', $request->status_denda);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%{$search}%"));
            });
        }

        $peminjaman = $query->latest()->paginate(10)->withQueryString();

        return view('peminjaman.index', compact('peminjaman'));
    }

    /* ------------------------------------------------------------------ */
    /* CREATE — user mengajukan peminjaman                                  */
    /* ------------------------------------------------------------------ */

    public function create()
    {
        $buku  = Buku::where('stok_tersedia', '>', 0)->orderBy('judul')->get();
        $users = User::where('role', 'user')->where('is_active', true)->orderBy('name')->get();

        return view('peminjaman.create', compact('buku', 'users'));
    }

    /* ------------------------------------------------------------------ */
    /* STORE                                                                */
    /* ------------------------------------------------------------------ */

    public function store(Request $request)
    {
        $isUser = Auth::user()->isUser();

        $rules = [
            'buku_id'         => 'required|exists:buku,id',
            'tanggal_pinjam'  => 'required|date|after_or_equal:today',
            'tanggal_kembali' => [
                'required', 'date', 'after:tanggal_pinjam',
                function ($attr, $value, $fail) use ($request) {
                    $pinjam  = Carbon::parse($request->tanggal_pinjam);
                    $kembali = Carbon::parse($value);
                    if ($kembali->diffInDays($pinjam) > Peminjaman::MAX_HARI_PINJAM) {
                        $fail('Maksimal peminjaman adalah ' . Peminjaman::MAX_HARI_PINJAM . ' hari.');
                    }
                },
            ],
            'catatan' => 'nullable|string|max:500',
        ];

        if (!$isUser) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules, [
            'buku_id.required'         => 'Buku wajib dipilih.',
            'tanggal_pinjam.required'  => 'Tanggal pinjam wajib diisi.',
            'tanggal_kembali.required' => 'Tanggal kembali wajib diisi.',
            'tanggal_kembali.after'    => 'Tanggal kembali harus setelah tanggal pinjam.',
            'user_id.required'         => 'Anggota wajib dipilih.',
        ]);

        $buku = Buku::findOrFail($validated['buku_id']);

        if (!$buku->tersedia()) {
            return back()->with('error', 'Stok buku tidak tersedia.')->withInput();
        }

        // Cek duplikat peminjaman aktif
        $userId = $isUser ? Auth::id() : $validated['user_id'];
        $sudahPinjam = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $validated['buku_id'])
            ->whereIn('status', [Peminjaman::STATUS_PENDING, Peminjaman::STATUS_DISETUJUI])
            ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Sudah ada pengajuan/peminjaman aktif untuk buku ini.')->withInput();
        }

        $data = [
            'user_id'         => $userId,
            'buku_id'         => $validated['buku_id'],
            'tanggal_pinjam'  => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'catatan'         => $validated['catatan'] ?? null,
            'status'          => Peminjaman::STATUS_PENDING,
            'status_denda'    => Peminjaman::DENDA_BELUM_BAYAR,
        ];

        // Admin/petugas langsung disetujui
        if (!$isUser) {
            $data['status']     = Peminjaman::STATUS_DISETUJUI;
            $data['petugas_id'] = Auth::id();
            $buku->decrement('stok_tersedia');
        }

        $record = Peminjaman::create($data);

        // Notifikasi ke admin & petugas jika user mengajukan peminjaman
        if ($isUser) {
            NotificationService::peminjamanBaru($record);
        }

        $pesan = $isUser
            ? 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.'
            : 'Peminjaman berhasil dicatat.';

        return redirect()->route('peminjaman.index')->with('success', $pesan);
    }

    /* ------------------------------------------------------------------ */
    /* SHOW                                                                 */
    /* ------------------------------------------------------------------ */

    public function show(Peminjaman $peminjaman)
    {
        // User hanya bisa lihat milik sendiri
        if (Auth::user()->isUser() && $peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        $peminjaman->load(['user', 'buku.kategori', 'petugas', 'ulasan.user']);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /* ------------------------------------------------------------------ */
    /* APPROVE — admin/petugas setujui pengajuan                           */
    /* ------------------------------------------------------------------ */

    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::STATUS_PENDING) {
            return back()->with('error', 'Hanya pengajuan berstatus pending yang bisa disetujui.');
        }

        $buku = $peminjaman->buku;
        if (!$buku->tersedia()) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        $peminjaman->update([
            'status'     => Peminjaman::STATUS_DISETUJUI,
            'petugas_id' => Auth::id(),
        ]);

        $buku->decrement('stok_tersedia');

        return back()->with('success', 'Peminjaman berhasil disetujui. Struk tersedia di halaman detail peminjaman.');
    }

    /* ------------------------------------------------------------------ */
    /* REJECT — admin/petugas tolak pengajuan                              */
    /* ------------------------------------------------------------------ */

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::STATUS_PENDING) {
            return back()->with('error', 'Hanya pengajuan berstatus pending yang bisa ditolak.');
        }

        $request->validate([
            'alasan_tolak' => 'required|string|max:500',
        ], [
            'alasan_tolak.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $peminjaman->update([
            'status'       => Peminjaman::STATUS_DITOLAK,
            'alasan_tolak' => $request->alasan_tolak,
            'petugas_id'   => Auth::id(),
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /* ------------------------------------------------------------------ */
    /* KEMBALIKAN — proses pengembalian buku                               */
    /* ------------------------------------------------------------------ */

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::STATUS_DISETUJUI) {
            return back()->with('error', 'Hanya peminjaman yang disetujui yang bisa dikembalikan.');
        }

        $request->validate([
            'tanggal_dikembalikan' => 'required|date|after_or_equal:' . $peminjaman->tanggal_pinjam->format('Y-m-d'),
        ], [
            'tanggal_dikembalikan.required'         => 'Tanggal dikembalikan wajib diisi.',
            'tanggal_dikembalikan.after_or_equal'   => 'Tanggal dikembalikan tidak boleh sebelum tanggal pinjam.',
        ]);

        $tanggalDikembalikan = Carbon::parse($request->tanggal_dikembalikan);
        $hasilDenda          = $peminjaman->hitungDenda($tanggalDikembalikan);

        $peminjaman->update([
            'tanggal_dikembalikan'  => $tanggalDikembalikan,
            'status'                => Peminjaman::STATUS_DIKEMBALIKAN,
            'jumlah_hari_terlambat' => $hasilDenda['jumlah_hari_terlambat'],
            'total_denda'           => $hasilDenda['total_denda'],
            'status_denda'          => $hasilDenda['total_denda'] > 0
                                        ? Peminjaman::DENDA_BELUM_BAYAR
                                        : Peminjaman::DENDA_SUDAH_BAYAR,
            'petugas_id'            => Auth::id(),
        ]);

        $peminjaman->buku->increment('stok_tersedia');

        $pesan = 'Buku berhasil dikembalikan.';
        if ($hasilDenda['total_denda'] > 0) {
            $pesan .= ' Denda: Rp ' . number_format($hasilDenda['total_denda'], 0, ',', '.')
                    . ' (' . $hasilDenda['jumlah_hari_terlambat'] . ' hari terlambat).';
        }

        return redirect()->route('peminjaman.index')->with('success', $pesan);
    }

    /* ------------------------------------------------------------------ */
    /* BAYAR DENDA                                                          */
    /* ------------------------------------------------------------------ */

    public function bayarDenda(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::STATUS_DIKEMBALIKAN) {
            return back()->with('error', 'Buku belum dikembalikan.');
        }

        if ($peminjaman->status_denda === Peminjaman::DENDA_SUDAH_BAYAR) {
            return back()->with('error', 'Denda sudah dibayar.');
        }

        if ($peminjaman->total_denda <= 0) {
            return back()->with('error', 'Tidak ada denda untuk peminjaman ini.');
        }

        $peminjaman->update(['status_denda' => Peminjaman::DENDA_SUDAH_BAYAR]);

        return back()->with('success', 'Denda sebesar Rp '
            . number_format($peminjaman->total_denda, 0, ',', '.')
            . ' berhasil ditandai lunas.');
    }

    /* ------------------------------------------------------------------ */
    /* DESTROY                                                              */
    /* ------------------------------------------------------------------ */

    public function destroy(Peminjaman $peminjaman)
    {
        if (in_array($peminjaman->status, [Peminjaman::STATUS_DISETUJUI])) {
            return back()->with('error', 'Tidak dapat menghapus peminjaman yang sedang aktif.');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
