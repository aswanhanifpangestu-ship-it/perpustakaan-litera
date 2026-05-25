<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Data Petugas</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DejaVu Sans', sans-serif; font-size:10px; color:#1e293b; }

.kop { display:table; width:100%; border-bottom:3px solid #1e3a5f; padding-bottom:10px; margin-bottom:14px; }
.kop-logo { display:table-cell; width:70px; vertical-align:middle; text-align:center; }
.kop-logo .logo-box {
    width:54px; height:54px; background:#1e3a5f; border-radius:8px;
    display:inline-block; line-height:54px; text-align:center;
    font-size:22px; color:#fff; font-weight:bold;
}
.kop-text { display:table-cell; vertical-align:middle; padding-left:12px; }
.kop-text h1 { font-size:15px; color:#1e3a5f; font-weight:bold; letter-spacing:.5px; }
.kop-text h2 { font-size:11px; color:#2563eb; font-weight:bold; margin-top:2px; }
.kop-text p  { font-size:9px; color:#64748b; margin-top:3px; }

.report-title { text-align:center; margin:10px 0 14px; }
.report-title h3 { font-size:13px; font-weight:bold; color:#1e3a5f; text-transform:uppercase; letter-spacing:.8px; }
.report-title p  { font-size:9px; color:#64748b; margin-top:3px; }
.report-title .underline { width:60px; height:3px; background:#d97706; margin:6px auto 0; border-radius:2px; }

.summary { display:table; width:100%; margin-bottom:14px; border-collapse:collapse; }
.sbox { display:table-cell; padding:8px 10px; border:1px solid #e2e8f0; background:#f8fafc; text-align:center; }
.sbox .val { font-size:13px; font-weight:bold; }
.sbox .lbl { font-size:8px; color:#64748b; margin-top:2px; }
.sbox.amber .val { color:#d97706; }
.sbox.red .val   { color:#dc2626; }
.sbox.green .val { color:#16a34a; }

table.main { width:100%; border-collapse:collapse; margin-top:6px; }
table.main thead tr { background:#d97706; color:#fff; }
table.main thead th { padding:7px 7px; font-size:9px; text-align:left; }
table.main tbody tr:nth-child(even) { background:#fffbeb; }
table.main tbody td { padding:5px 7px; border-bottom:1px solid #e2e8f0; font-size:9px; vertical-align:top; }
.badge-admin   { background:#fee2e2; color:#dc2626; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-petugas { background:#fef3c7; color:#d97706; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-aktif   { background:#dcfce7; color:#16a34a; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-nonaktif{ background:#f1f5f9; color:#64748b; padding:1px 5px; border-radius:3px; font-size:8px; }
.text-center { text-align:center; }

.ttd-section { margin-top:30px; display:table; width:100%; }
.ttd-box { display:table-cell; width:33%; text-align:center; padding:0 10px; vertical-align:top; }
.ttd-box .ttd-title { font-size:9px; color:#64748b; margin-bottom:4px; }
.ttd-box .ttd-name  { font-size:10px; font-weight:bold; color:#1e3a5f; margin-top:40px; border-top:1px solid #1e3a5f; padding-top:4px; }
.ttd-box .ttd-role  { font-size:8px; color:#64748b; }

.footer { margin-top:16px; padding-top:8px; border-top:1px solid #e2e8f0; display:table; width:100%; }
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
    <h3>Laporan Data Petugas &amp; Admin</h3>
    <p>Dicetak pada: {{ now()->isoFormat('dddd, D MMMM Y') }} &nbsp;|&nbsp; Pukul {{ now()->format('H:i') }} WIB</p>
    <div class="underline"></div>
</div>

<div class="summary">
    <div class="sbox amber" style="width:25%">
        <div class="val">{{ $totalPetugas }}</div>
        <div class="lbl">Total Petugas</div>
    </div>
    <div class="sbox red" style="width:25%">
        <div class="val">{{ $totalAdmin }}</div>
        <div class="lbl">Total Admin</div>
    </div>
    <div class="sbox green" style="width:25%">
        <div class="val">{{ $totalAktif }}</div>
        <div class="lbl">Akun Aktif</div>
    </div>
    <div class="sbox" style="width:25%">
        <div class="val" style="color:#64748b">{{ $totalNonaktif }}</div>
        <div class="lbl">Akun Nonaktif</div>
    </div>
</div>

<table class="main">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="22%">Nama</th>
            <th width="24%">Email</th>
            <th width="10%">Telepon</th>
            <th width="8%" class="text-center">Role</th>
            <th width="8%" class="text-center">Status</th>
            <th width="12%" class="text-center">Tgl Bergabung</th>
            <th width="12%" class="text-center">Peminjaman Diproses</th>
        </tr>
    </thead>
    <tbody>
        @forelse($petugas as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $p->name }}</strong></td>
            <td>{{ $p->email }}</td>
            <td>{{ $p->telepon ?? '-' }}</td>
            <td class="text-center">
                @if($p->role === 'admin')
                    <span class="badge-admin">Admin</span>
                @else
                    <span class="badge-petugas">Petugas</span>
                @endif
            </td>
            <td class="text-center">
                @if($p->is_active)
                    <span class="badge-aktif">Aktif</span>
                @else
                    <span class="badge-nonaktif">Nonaktif</span>
                @endif
            </td>
            <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
            <td class="text-center">{{ $p->peminjaman_diproses }}</td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center" style="padding:16px;color:#94a3b8">Tidak ada data petugas.</td></tr>
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
    <div class="footer-left">Perpustakaan Litera &mdash; Laporan Data Petugas</div>
    <div class="footer-right">Dicetak: {{ now()->format('d/m/Y H:i') }} &nbsp;|&nbsp; Halaman 1</div>
</div>

</body>
</html>
