<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Pengembalian Buku</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DejaVu Sans', sans-serif; font-size:10px; color:#1e293b; }

.kop { display:table; width:100%; border-bottom:3px solid #0d9488; padding-bottom:10px; margin-bottom:14px; }
.kop-logo { display:table-cell; width:70px; vertical-align:middle; text-align:center; }
.kop-logo .logo-box { width:54px; height:54px; background:#134e4a; border-radius:8px; display:inline-block; line-height:54px; text-align:center; font-size:22px; color:#fff; font-weight:bold; }
.kop-text { display:table-cell; vertical-align:middle; padding-left:12px; }
.kop-text h1 { font-size:15px; color:#134e4a; font-weight:bold; }
.kop-text h2 { font-size:11px; color:#0d9488; font-weight:bold; margin-top:2px; }
.kop-text p  { font-size:9px; color:#64748b; margin-top:3px; }

.report-title { text-align:center; margin:10px 0 14px; }
.report-title h3 { font-size:13px; font-weight:bold; color:#134e4a; text-transform:uppercase; letter-spacing:.8px; }
.report-title p  { font-size:9px; color:#64748b; margin-top:3px; }
.report-title .underline { width:60px; height:3px; background:#0d9488; margin:6px auto 0; border-radius:2px; }

.summary { display:table; width:100%; margin-bottom:14px; border-collapse:collapse; }
.sbox { display:table-cell; padding:8px 10px; border:1px solid #ccfbf1; background:#f0fdf9; text-align:center; }
.sbox .val { font-size:13px; font-weight:bold; color:#0f766e; }
.sbox .lbl { font-size:8px; color:#64748b; margin-top:2px; }
.sbox.red .val   { color:#dc2626; }
.sbox.amber .val { color:#d97706; }

table.main { width:100%; border-collapse:collapse; margin-top:6px; }
table.main thead tr { background:#0d9488; color:#fff; }
table.main thead th { padding:7px 7px; font-size:9px; text-align:left; }
table.main tbody tr:nth-child(even) { background:#f0fdf9; }
table.main tbody td { padding:5px 7px; border-bottom:1px solid #ccfbf1; font-size:9px; vertical-align:top; }
.badge-lunas  { background:#dcfce7; color:#166534; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-belum  { background:#fee2e2; color:#991b1b; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-nihil  { background:#f0fdf9; color:#0f766e; padding:1px 5px; border-radius:3px; font-size:8px; }
.text-center { text-align:center; }
.text-right  { text-align:right; }

.ttd-section { margin-top:30px; display:table; width:100%; }
.ttd-box { display:table-cell; width:33%; text-align:center; padding:0 10px; vertical-align:top; }
.ttd-box .ttd-title { font-size:9px; color:#64748b; margin-bottom:4px; }
.ttd-box .ttd-name  { font-size:10px; font-weight:bold; color:#134e4a; margin-top:40px; border-top:1px solid #134e4a; padding-top:4px; }
.ttd-box .ttd-role  { font-size:8px; color:#64748b; }

.footer { margin-top:16px; padding-top:8px; border-top:1px solid #ccfbf1; display:table; width:100%; }
.footer-left  { display:table-cell; font-size:8px; color:#94a3b8; }
.footer-right { display:table-cell; font-size:8px; color:#94a3b8; text-align:right; }
</style>
</head>
<body>

<div class="kop">
    <div class="kop-logo"><div class="logo-box">L</div></div>
    <div class="kop-text">
        <h1>PERPUSTAKAAN LITERA</h1>
        <h2>Sistem Manajemen Perpustakaan Digital</h2>
        <p>Jl. Perpustakaan No. 1 &nbsp;|&nbsp; Telp. (021) 000-0000 &nbsp;|&nbsp; litera@perpustakaan.com</p>
    </div>
</div>

<div class="report-title">
    <h3>Laporan Pengembalian Buku</h3>
    <p>
        @if($filterBulan && $filterTahun)
            Periode: {{ $namaBulan[$filterBulan] ?? $filterBulan }} {{ $filterTahun }}
        @else
            Semua Periode
        @endif
        &nbsp;|&nbsp; Dicetak: {{ now()->isoFormat('dddd, D MMMM Y') }} Pukul {{ now()->format('H:i') }} WIB
    </p>
    <div class="underline"></div>
</div>

<div class="summary">
    <div class="sbox" style="width:25%">
        <div class="val">{{ $totalKembali }}</div>
        <div class="lbl">Total Dikembalikan</div>
    </div>
    <div class="sbox red" style="width:25%">
        <div class="val">{{ $totalTerlambat }}</div>
        <div class="lbl">Terlambat</div>
    </div>
    <div class="sbox amber" style="width:25%">
        <div class="val">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
        <div class="lbl">Total Denda</div>
    </div>
    <div class="sbox" style="width:25%">
        <div class="val" style="color:#166534">Rp {{ number_format($totalDendaLunas, 0, ',', '.') }}</div>
        <div class="lbl">Denda Lunas</div>
    </div>
</div>

<table class="main">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="16%">Anggota</th>
            <th width="22%">Judul Buku</th>
            <th width="10%">Tgl Pinjam</th>
            <th width="10%">Tgl Kembali</th>
            <th width="10%">Tgl Dikembalikan</th>
            <th width="8%" class="text-center">Terlambat</th>
            <th width="10%" class="text-right">Total Denda</th>
            <th width="10%" class="text-center">Status Denda</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pengembalian as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                <strong>{{ $p->user->name }}</strong>
                @if($p->user->no_anggota)<br><span style="color:#94a3b8;font-size:8px">{{ $p->user->no_anggota }}</span>@endif
            </td>
            <td>{{ $p->buku->judul }}</td>
            <td>{{ $p->tanggal_pinjam->format('d/m/Y') }}</td>
            <td>{{ $p->tanggal_kembali->format('d/m/Y') }}</td>
            <td><strong>{{ $p->tanggal_dikembalikan->format('d/m/Y') }}</strong></td>
            <td class="text-center">
                @if($p->jumlah_hari_terlambat > 0)
                    <span style="color:#dc2626;font-weight:bold">{{ $p->jumlah_hari_terlambat }} hr</span>
                @else
                    <span style="color:#166534">Tepat</span>
                @endif
            </td>
            <td class="text-right">
                @if($p->total_denda > 0)
                    <strong style="color:#dc2626">Rp {{ number_format($p->total_denda, 0, ',', '.') }}</strong>
                @else
                    <span style="color:#166534">—</span>
                @endif
            </td>
            <td class="text-center">
                @if($p->total_denda <= 0)
                    <span class="badge-nihil">Nihil</span>
                @elseif($p->status_denda === 'sudah_bayar')
                    <span class="badge-lunas">Lunas</span>
                @else
                    <span class="badge-belum">Belum</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="9" class="text-center" style="padding:16px;color:#94a3b8">Tidak ada data pengembalian.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="ttd-section">
    <div class="ttd-box">
        <div class="ttd-title">Mengetahui,</div>
        <div class="ttd-name">{{ $adminName }}</div>
        <div class="ttd-role">Administrator Litera</div>
    </div>
    <div class="ttd-box"></div>
    <div class="ttd-box">
        <div class="ttd-title">{{ now()->isoFormat('D MMMM Y') }}</div>
        <div class="ttd-name">{{ auth()->user()->name }}</div>
        <div class="ttd-role">{{ ucfirst(auth()->user()->role) }}</div>
    </div>
</div>

<div class="footer">
    <div class="footer-left">Perpustakaan Litera &mdash; Laporan Pengembalian Buku</div>
    <div class="footer-right">Dicetak: {{ now()->format('d/m/Y H:i') }}</div>
</div>

</body>
</html>
