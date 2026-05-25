<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class StrukController extends Controller
{
    /**
     * Daftar struk milik user yang login.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['buku', 'petugas'])
            ->where('user_id', Auth::id())
            ->whereIn('status', [
                Peminjaman::STATUS_DISETUJUI,
                Peminjaman::STATUS_DIKEMBALIKAN,
            ])
            ->latest()
            ->paginate(10);

        return view('struk.index', compact('peminjaman'));
    }

    /**
     * Tampilkan struk peminjaman (halaman web).
     */
    public function show(Peminjaman $peminjaman)
    {
        if (Auth::user()->isUser() && $peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($peminjaman->status, [
            Peminjaman::STATUS_DISETUJUI,
            Peminjaman::STATUS_DIKEMBALIKAN,
        ])) {
            return redirect()->route('peminjaman.show', $peminjaman)
                ->with('error', 'Struk hanya tersedia setelah peminjaman disetujui.');
        }

        $peminjaman->load(['user', 'buku.kategori', 'petugas']);

        return view('struk.show', compact('peminjaman'));
    }

    /**
     * Download struk peminjaman sebagai PDF.
     */
    public function pdf(Peminjaman $peminjaman)
    {
        if (Auth::user()->isUser() && $peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($peminjaman->status, [
            Peminjaman::STATUS_DISETUJUI,
            Peminjaman::STATUS_DIKEMBALIKAN,
        ])) {
            return redirect()->route('peminjaman.show', $peminjaman)
                ->with('error', 'Struk hanya tersedia setelah peminjaman disetujui.');
        }

        $peminjaman->load(['user', 'buku.kategori', 'petugas']);

        $pdf = Pdf::loadView('struk.pdf', compact('peminjaman'))
                  ->setPaper('a5', 'portrait');

        return $pdf->download('struk-peminjaman-' . str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Download struk pengembalian sebagai PDF.
     * Hanya tersedia jika status = dikembalikan.
     */
    public function pengembalianPdf(Peminjaman $peminjaman)
    {
        if (Auth::user()->isUser() && $peminjaman->user_id !== Auth::id()) {
            abort(403);
        }

        if ($peminjaman->status !== Peminjaman::STATUS_DIKEMBALIKAN) {
            return redirect()->route('peminjaman.show', $peminjaman)
                ->with('error', 'Struk pengembalian hanya tersedia setelah buku dikembalikan.');
        }

        $peminjaman->load(['user', 'buku.kategori', 'petugas']);

        $pdf = Pdf::loadView('struk.pengembalian', compact('peminjaman'))
                  ->setPaper('a5', 'portrait');

        return $pdf->download('struk-pengembalian-' . str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }
}
