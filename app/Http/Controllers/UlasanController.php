<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /**
     * Daftar semua ulasan — untuk admin & petugas.
     */
    public function index(Request $request)
    {
        $query = Ulasan::with(['user', 'buku', 'peminjaman']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('buku', fn($q) => $q->where('judul', 'like', "%{$s}%"))
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$s}%"));
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('buku_id')) {
            $query->where('buku_id', $request->buku_id);
        }

        $ulasan = $query->latest()->paginate(15)->withQueryString();
        $buku   = Buku::orderBy('judul')->get(['id', 'judul']);

        // Statistik ringkas
        $stats = [
            'total'       => Ulasan::count(),
            'rata_rata'   => round(Ulasan::avg('rating') ?? 0, 1),
            'bintang5'    => Ulasan::where('rating', 5)->count(),
            'bintang1'    => Ulasan::where('rating', 1)->count(),
        ];

        return view('ulasan.index', compact('ulasan', 'buku', 'stats'));
    }

    /**
     * Simpan ulasan baru — hanya user yang meminjam & sudah dikembalikan.
     */
    public function store(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak memberikan ulasan untuk peminjaman ini.');
        }

        if ($peminjaman->status !== Peminjaman::STATUS_DIKEMBALIKAN) {
            return back()->with('error', 'Ulasan hanya bisa diberikan setelah buku dikembalikan.');
        }

        if ($peminjaman->ulasan) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk peminjaman ini.');
        }

        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min'      => 'Rating minimal 1 bintang.',
            'rating.max'      => 'Rating maksimal 5 bintang.',
            'komentar.max'    => 'Komentar maksimal 1000 karakter.',
        ]);

        Ulasan::create([
            'user_id'       => Auth::id(),
            'buku_id'       => $peminjaman->buku_id,
            'peminjaman_id' => $peminjaman->id,
            'rating'        => $validated['rating'],
            'komentar'      => $validated['komentar'] ?? null,
        ]);

        return back()->with('success', 'Ulasan berhasil disimpan. Terima kasih atas penilaian Anda!');
    }

    /**
     * Hapus ulasan — milik sendiri atau admin/petugas.
     */
    public function destroy(Ulasan $ulasan)
    {
        if ($ulasan->user_id !== Auth::id() && !Auth::user()->isAdminOrPetugas()) {
            abort(403);
        }

        $ulasan->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
