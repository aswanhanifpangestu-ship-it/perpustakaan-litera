<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = [
            'totalBuku'      => Buku::count(),
            'totalAnggota'   => User::where('role', 'user')->count(),
            'totalDipinjam'  => Peminjaman::where('status', Peminjaman::STATUS_DISETUJUI)->count(),
            'totalPending'   => Peminjaman::where('status', Peminjaman::STATUS_PENDING)->count(),
        ];

        if ($user->isUser()) {
            // Denda pribadi yang belum dibayar
            $data['dendaPribadi'] = Peminjaman::where('user_id', $user->id)
                ->where('status_denda', Peminjaman::DENDA_BELUM_BAYAR)
                ->where('total_denda', '>', 0)
                ->sum('total_denda');

            $data['peminjamanAktif'] = Peminjaman::where('user_id', $user->id)
                ->where('status', Peminjaman::STATUS_DISETUJUI)
                ->count();

            $data['peminjamanSaya'] = Peminjaman::where('user_id', $user->id)
                ->with('buku')
                ->latest()
                ->take(5)
                ->get();
        } else {
            // Total denda belum bayar (semua user)
            $data['totalDendaBelumBayar'] = Peminjaman::where('status_denda', Peminjaman::DENDA_BELUM_BAYAR)
                ->where('total_denda', '>', 0)
                ->sum('total_denda');

            $data['peminjamanTerbaru'] = Peminjaman::with(['user', 'buku'])
                ->latest()
                ->take(10)
                ->get();

            $data['bukuTerbaru'] = Buku::with('kategori')
                ->latest()
                ->take(5)
                ->get();

            // Pengajuan pending untuk notifikasi
            $data['pengajuanPending'] = Peminjaman::with(['user', 'buku'])
                ->where('status', Peminjaman::STATUS_PENDING)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact('data', 'user'));
    }
}
