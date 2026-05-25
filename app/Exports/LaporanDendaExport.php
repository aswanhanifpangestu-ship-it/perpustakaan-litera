<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanDendaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected int $bulan;
    protected int $tahun;

    public function __construct(int $bulan, int $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        return Peminjaman::with(['user', 'buku'])
            ->where('status', Peminjaman::STATUS_DIKEMBALIKAN)
            ->where('total_denda', '>', 0)
            ->whereMonth('tanggal_dikembalikan', $this->bulan)
            ->whereYear('tanggal_dikembalikan', $this->tahun)
            ->orderBy('tanggal_dikembalikan')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Anggota',
            'Judul Buku',
            'Tgl Pinjam',
            'Tgl Kembali (Rencana)',
            'Tgl Dikembalikan',
            'Hari Terlambat',
            'Denda/Hari (Rp)',
            'Total Denda (Rp)',
            'Status Denda',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->user->name ?? '-',
            $row->buku->judul ?? '-',
            $row->tanggal_pinjam->format('d/m/Y'),
            $row->tanggal_kembali->format('d/m/Y'),
            $row->tanggal_dikembalikan ? $row->tanggal_dikembalikan->format('d/m/Y') : '-',
            $row->jumlah_hari_terlambat,
            number_format($row->buku->denda_per_hari ?? 1000, 0, ',', '.'),
            number_format($row->total_denda, 0, ',', '.'),
            $row->status_denda === 'sudah_bayar' ? 'Sudah Bayar' : 'Belum Bayar',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['rgb' => '2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        $bulanNama = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];
        return 'Laporan ' . ($bulanNama[$this->bulan] ?? $this->bulan) . ' ' . $this->tahun;
    }
}
