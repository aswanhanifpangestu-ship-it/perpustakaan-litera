<?php

namespace App\Http\Controllers;

use App\Exports\LaporanDendaExport;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /* ------------------------------------------------------------------ */
    /* HELPER                                                               */
    /* ------------------------------------------------------------------ */

    /** Nama admin utama untuk blok tanda tangan PDF */
    private function adminName(): string
    {
        $admin = User::where('role', 'admin')->orderBy('id')->first();
        return $admin ? $admin->name : 'Administrator';
    }

    /** Kumpulkan data statistik denda per bulan/tahun */
    private function getData(int $bulan, int $tahun): array
    {
        $base = Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)
            ->where('total_denda', '>', 0)
            ->whereMonth('tanggal_dikembalikan', $bulan)
            ->whereYear('tanggal_dikembalikan', $tahun);

        $totalDenda  = (clone $base)->sum('total_denda');
        $sudahBayar  = (clone $base)->where('status_denda', 'sudah_bayar')->sum('total_denda');
        $belumBayar  = (clone $base)->where('status_denda', 'belum_bayar')->sum('total_denda');
        $jumlahKasus = (clone $base)->count();

        $totalPeminjaman = Peminjaman::whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->count();

        $totalDikembalikan = Peminjaman::where('status', Peminjaman::STATUS_DIKEMBALIKAN)
            ->whereMonth('tanggal_dikembalikan', $bulan)
            ->whereYear('tanggal_dikembalikan', $tahun)
            ->count();

        $totalTerlambat = Peminjaman::where('jumlah_hari_terlambat', '>', 0)
            ->whereMonth('tanggal_dikembalikan', $bulan)
            ->whereYear('tanggal_dikembalikan', $tahun)
            ->count();

        $bukuPopuler = Buku::withCount(['peminjaman' => function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal_pinjam', $bulan)->whereYear('tanggal_pinjam', $tahun);
        }])
            ->orderByDesc('peminjaman_count')
            ->take(10)
            ->get();

        $anggotaAktif = User::where('role', 'user')
            ->withCount(['peminjaman' => function ($q) use ($bulan, $tahun) {
                $q->whereMonth('tanggal_pinjam', $bulan)->whereYear('tanggal_pinjam', $tahun);
            }])
            ->orderByDesc('peminjaman_count')
            ->take(10)
            ->get();

        $detailDenda = (clone $base)
            ->with(['user', 'buku'])
            ->orderBy('tanggal_dikembalikan')
            ->get();

        return compact(
            'totalDenda', 'sudahBayar', 'belumBayar', 'jumlahKasus',
            'totalPeminjaman', 'totalDikembalikan', 'totalTerlambat',
            'bukuPopuler', 'anggotaAktif', 'detailDenda'
        );
    }

    /* ------------------------------------------------------------------ */
    /* INDEX                                                                */
    /* ------------------------------------------------------------------ */

    public function index(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $data = $this->getData($bulan, $tahun);

        $daftarBulan = [
            '01' => 'Januari',  '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',    '05' => 'Mei',       '06' => 'Juni',
            '07' => 'Juli',     '08' => 'Agustus',   '09' => 'September',
            '10' => 'Oktober',  '11' => 'November',  '12' => 'Desember',
        ];

        return view('laporan.index', compact('data', 'peminjaman', 'bulan', 'tahun', 'daftarBulan'));
    }

    /* ------------------------------------------------------------------ */
    /* EXPORT EXCEL                                                         */
    /* ------------------------------------------------------------------ */

    public function exportExcel(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $nama = 'laporan-denda-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun . '.xlsx';

        return Excel::download(new LaporanDendaExport($bulan, $tahun), $nama);
    }

    /* ------------------------------------------------------------------ */
    /* EXPORT PDF DENDA                                                     */
    /* ------------------------------------------------------------------ */

    public function exportPdf(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $data = $this->getData($bulan, $tahun);

        $daftarBulan = [
            1  => 'Januari',   2  => 'Februari', 3  => 'Maret',
            4  => 'April',     5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',      8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',   11 => 'November',  12 => 'Desember',
        ];

        $bulanNama = $daftarBulan[$bulan] ?? $bulan;

        $pdf = Pdf::loadView('laporan.pdf', compact('data', 'bulan', 'tahun', 'bulanNama'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-denda-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' . $tahun . '.pdf');
    }

    /* ------------------------------------------------------------------ */
    /* EXPORT PDF BUKU                                                      */
    /* ------------------------------------------------------------------ */

    public function exportPdfBuku()
    {
        $buku = Buku::with('kategori')->orderBy('judul')->get();

        $totalBuku     = $buku->count();
        $totalStok     = $buku->sum('stok');
        $totalTersedia = $buku->sum('stok_tersedia');
        $totalHabis    = $buku->where('stok_tersedia', 0)->count();
        $adminName     = $this->adminName();

        $pdf = Pdf::loadView('laporan.pdf_buku', compact(
            'buku', 'totalBuku', 'totalStok', 'totalTersedia', 'totalHabis', 'adminName'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-buku-' . now()->format('Ymd') . '.pdf');
    }

    /* ------------------------------------------------------------------ */
    /* EXPORT PDF PETUGAS                                                   */
    /* ------------------------------------------------------------------ */

    public function exportPdfPetugas()
    {
        $petugas = User::whereIn('role', ['admin', 'petugas'])
            ->withCount(['peminjaman as peminjaman_diproses' => function ($q) {
                $q->whereNotNull('petugas_id');
            }])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        $totalPetugas  = $petugas->where('role', 'petugas')->count();
        $totalAdmin    = $petugas->where('role', 'admin')->count();
        $totalAktif    = $petugas->where('is_active', true)->count();
        $totalNonaktif = $petugas->where('is_active', false)->count();
        $adminName     = $this->adminName();

        $pdf = Pdf::loadView('laporan.pdf_petugas', compact(
            'petugas', 'totalPetugas', 'totalAdmin', 'totalAktif', 'totalNonaktif', 'adminName'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-petugas-' . now()->format('Ymd') . '.pdf');
    }

    /* ------------------------------------------------------------------ */
    /* EXPORT PDF USER / ANGGOTA                                            */
    /* ------------------------------------------------------------------ */

    public function exportPdfUser()
    {
        $users = User::where('role', 'user')
            ->withCount([
                'peminjaman as peminjaman_count',
                'peminjaman as dikembalikan_count' => fn($q) =>
                    $q->where('status', Peminjaman::STATUS_DIKEMBALIKAN),
            ])
            ->withSum(
                ['peminjaman as total_denda' => fn($q) =>
                    $q->where('status_denda', 'belum_bayar')],
                'total_denda'
            )
            ->orderBy('name')
            ->get();

        $totalUser       = $users->count();
        $totalAktif      = $users->where('is_active', true)->count();
        $totalPeminjaman = $users->sum('peminjaman_count');
        $totalDenda      = $users->where('total_denda', '>', 0)->count();
        $adminName       = $this->adminName();

        $pdf = Pdf::loadView('laporan.pdf_user', compact(
            'users', 'totalUser', 'totalAktif', 'totalPeminjaman', 'totalDenda', 'adminName'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-anggota-' . now()->format('Ymd') . '.pdf');
    }

    /* ------------------------------------------------------------------ */
    /* EXPORT PDF PEMINJAMAN                                                */
    /* ------------------------------------------------------------------ */

    public function exportPdfPeminjaman(Request $request)
    {
        $filterBulan = $request->get('bulan');
        $filterTahun = $request->get('tahun');

        $query = Peminjaman::with(['user', 'buku'])->latest();

        if ($filterBulan && $filterTahun) {
            $query->whereMonth('tanggal_pinjam', $filterBulan)
                  ->whereYear('tanggal_pinjam', $filterTahun);
        }

        $peminjaman       = $query->get();
        $totalPeminjaman  = $peminjaman->count();
        $totalDipinjam    = $peminjaman->where('status', 'disetujui')->count();
        $totalDikembalikan= $peminjaman->where('status', 'dikembalikan')->count();
        $totalTerlambat   = $peminjaman->where('jumlah_hari_terlambat', '>', 0)->count();
        $adminName        = $this->adminName();

        $namaBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
            5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November', 12=>'Desember',
        ];

        $pdf = Pdf::loadView('laporan.pdf_peminjaman', compact(
            'peminjaman', 'totalPeminjaman', 'totalDipinjam',
            'totalDikembalikan', 'totalTerlambat',
            'filterBulan', 'filterTahun', 'namaBulan', 'adminName'
        ))->setPaper('a4', 'landscape');

        $nama = 'laporan-peminjaman';
        if ($filterBulan && $filterTahun) {
            $nama .= '-' . str_pad($filterBulan, 2, '0', STR_PAD_LEFT) . '-' . $filterTahun;
        }

        return $pdf->download($nama . '.pdf');
    }

    /* ------------------------------------------------------------------ */
    /* EXPORT PDF PENGEMBALIAN                                              */
    /* ------------------------------------------------------------------ */

    public function exportPdfPengembalian(Request $request)
    {
        $filterBulan = $request->get('bulan');
        $filterTahun = $request->get('tahun');

        $query = Peminjaman::with(['user', 'buku'])
            ->where('status', Peminjaman::STATUS_DIKEMBALIKAN)
            ->latest('tanggal_dikembalikan');

        if ($filterBulan && $filterTahun) {
            $query->whereMonth('tanggal_dikembalikan', $filterBulan)
                  ->whereYear('tanggal_dikembalikan', $filterTahun);
        }

        $pengembalian     = $query->get();
        $totalKembali     = $pengembalian->count();
        $totalTerlambat   = $pengembalian->where('jumlah_hari_terlambat', '>', 0)->count();
        $totalDenda       = $pengembalian->sum('total_denda');
        $totalDendaLunas  = $pengembalian->where('status_denda', 'sudah_bayar')->sum('total_denda');
        $adminName        = $this->adminName();

        $namaBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
            5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November', 12=>'Desember',
        ];

        $pdf = Pdf::loadView('laporan.pdf_pengembalian', compact(
            'pengembalian', 'totalKembali', 'totalTerlambat',
            'totalDenda', 'totalDendaLunas',
            'filterBulan', 'filterTahun', 'namaBulan', 'adminName'
        ))->setPaper('a4', 'landscape');

        $nama = 'laporan-pengembalian';
        if ($filterBulan && $filterTahun) {
            $nama .= '-' . str_pad($filterBulan, 2, '0', STR_PAD_LEFT) . '-' . $filterTahun;
        }

        return $pdf->download($nama . '.pdf');
    }
}
