<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk Pengembalian #{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body {
    font-family: 'DejaVu Sans', sans-serif;
    font-size: 11px;
    color: #1e293b;
    width: 100%;
}
.center { text-align: center; }
.bold   { font-weight: bold; }

.header { text-align:center; margin-bottom:10px; }
.header .logo { font-size:22px; margin-bottom:4px; }
.header h2 { font-size:14px; font-weight:bold; color:#134e4a; margin-bottom:2px; }
.header .sub { font-size:9px; color:#64748b; }
.divider { border:none; border-top:2px solid #0d9488; margin:8px 0; }
.divider-thin { border:none; border-top:1px dashed #ccfbf1; margin:6px 0; }

.struk-title { text-align:center; margin:6px 0; }
.struk-title h3 { font-size:11px; font-weight:bold; color:#0f766e; text-transform:uppercase; letter-spacing:.5px; }
.struk-title .no { font-size:10px; color:#64748b; }

.status-box {
    text-align:center; padding:5px; margin:8px 0;
    border-radius:4px; font-weight:bold; font-size:11px;
    background:#dcfce7; color:#166534; border:1px solid #bbf7d0;
}

.section { margin-bottom:8px; }
.section-title {
    font-size:9px; font-weight:bold; text-transform:uppercase;
    letter-spacing:.05em; color:#0f766e;
    background:#f0fdf9; padding:3px 6px;
    border-left:3px solid #0d9488;
    margin-bottom:4px;
}
.info-table { width:100%; border-collapse:collapse; }
.info-table td { padding:2px 4px; font-size:10px; vertical-align:top; }
.info-table .label { color:#64748b; width:120px; }

/* Ringkasan pengembalian */
.summary-box {
    display:table; width:100%; border-collapse:collapse;
    margin:8px 0;
}
.sum-cell {
    display:table-cell; text-align:center;
    padding:6px 4px; border:1px solid #ccfbf1;
    background:#f0fdf9; width:33%;
}
.sum-cell .val { font-size:13px; font-weight:bold; color:#0f766e; }
.sum-cell .lbl { font-size:8px; color:#64748b; margin-top:2px; }
.sum-cell.red .val   { color:#dc2626; }
.sum-cell.amber .val { color:#d97706; }

/* Denda */
.denda-box { padding:8px; border-radius:4px; margin:8px 0; }
.denda-lunas { background:#dcfce7; border:1px solid #bbf7d0; }
.denda-belum { background:#fee2e2; border:1px solid #fecaca; }
.denda-nihil { background:#dcfce7; border:1px solid #bbf7d0; text-align:center; }
.denda-row { display:table; width:100%; }
.denda-left  { display:table-cell; vertical-align:middle; }
.denda-right { display:table-cell; vertical-align:middle; text-align:right; }
.denda-amount { font-size:14px; font-weight:bold; }
.denda-lunas .denda-amount { color:#166534; }
.denda-belum .denda-amount { color:#991b1b; }

/* TTD */
.ttd-section { margin-top:14px; display:table; width:100%; }
.ttd-box { display:table-cell; width:50%; text-align:center; font-size:9px; }
.ttd-box .ttd-name { margin-top:35px; border-top:1px solid #1e293b; padding-top:3px; font-weight:bold; font-size:10px; }
.ttd-box .ttd-role { color:#64748b; }

.footer { text-align:center; margin-top:10px; font-size:9px; color:#94a3b8; }
.footer .thanks { font-size:10px; color:#0f766e; font-weight:bold; margin-top:4px; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div class="logo">📚</div>
    <h2>PERPUSTAKAAN LITERA</h2>
    <div class="sub">Sistem Perpustakaan Digital</div>
    <div class="sub">Jl. Perpustakaan No. 1 | litera@perpustakaan.com</div>
</div>
<hr class="divider">

{{-- JUDUL --}}
<div class="struk-title">
    <h3>Struk Pengembalian Buku</h3>
    <div class="no">No. #{{ str_pad($peminjaman->id, 6, '0', STR_PAD_LEFT) }}</div>
</div>

<div class="status-box">✓ BUKU TELAH DIKEMBALIKAN</div>

<hr class="divider-thin">

{{-- INFO ANGGOTA --}}
<div class="section">
    <div class="section-title">Informasi Anggota</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama</td>
            <td>: <strong>{{ $peminjaman->user->name }}</strong></td>
        </tr>
        <tr>
            <td class="label">No. Anggota</td>
            <td>: {{ $peminjaman->user->no_anggota ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>: {{ $peminjaman->user->email }}</td>
        </tr>
    </table>
</div>

<hr class="divider-thin">

{{-- INFO BUKU --}}
<div class="section">
    <div class="section-title">Informasi Buku</div>
    <table class="info-table">
        <tr>
            <td class="label">Judul</td>
            <td>: <strong>{{ $peminjaman->buku->judul }}</strong></td>
        </tr>
        <tr>
            <td class="label">Pengarang</td>
            <td>: {{ $peminjaman->buku->pengarang }}</td>
        </tr>
        <tr>
            <td class="label">Kategori</td>
            <td>: {{ $peminjaman->buku->kategori->nama ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">ISBN</td>
            <td>: {{ $peminjaman->buku->isbn ?? '—' }}</td>
        </tr>
    </table>
</div>

<hr class="divider-thin">

{{-- RINGKASAN PENGEMBALIAN --}}
<div class="section">
    <div class="section-title">Ringkasan Pengembalian</div>
    <div class="summary-box">
        <div class="sum-cell">
            <div class="val">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</div>
            <div class="lbl">Tgl Pinjam</div>
        </div>
        <div class="sum-cell">
            <div class="val">{{ $peminjaman->tanggal_kembali->format('d/m/Y') }}</div>
            <div class="lbl">Batas Kembali</div>
        </div>
        <div class="sum-cell {{ $peminjaman->jumlah_hari_terlambat > 0 ? 'red' : '' }}">
            <div class="val">{{ $peminjaman->tanggal_dikembalikan->format('d/m/Y') }}</div>
            <div class="lbl">Tgl Dikembalikan</div>
        </div>
    </div>

    <table class="info-table" style="margin-top:4px">
        <tr>
            <td class="label">Durasi Pinjam</td>
            <td>: {{ $peminjaman->tanggal_pinjam->diffInDays($peminjaman->tanggal_dikembalikan) }} hari</td>
        </tr>
        <tr>
            <td class="label">Hari Terlambat</td>
            <td>:
                @if($peminjaman->jumlah_hari_terlambat > 0)
                    <strong style="color:#dc2626">{{ $peminjaman->jumlah_hari_terlambat }} hari</strong>
                @else
                    <strong style="color:#166534">Tepat Waktu ✓</strong>
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Denda/Hari</td>
            <td>: Rp {{ number_format($peminjaman->buku->denda_per_hari, 0, ',', '.') }}</td>
        </tr>
        @if($peminjaman->petugas)
        <tr>
            <td class="label">Diproses oleh</td>
            <td>: {{ $peminjaman->petugas->name }}</td>
        </tr>
        @endif
    </table>
</div>

<hr class="divider-thin">

{{-- DENDA --}}
@if($peminjaman->total_denda > 0)
<div class="denda-box {{ $peminjaman->status_denda === 'sudah_bayar' ? 'denda-lunas' : 'denda-belum' }}">
    <div class="denda-row">
        <div class="denda-left">
            <div class="bold" style="font-size:10px">DENDA KETERLAMBATAN</div>
            <div style="color:#64748b;font-size:9px">
                {{ $peminjaman->jumlah_hari_terlambat }} hari &times;
                Rp {{ number_format($peminjaman->buku->denda_per_hari, 0, ',', '.') }}/hari
            </div>
        </div>
        <div class="denda-right">
            <div class="denda-amount">Rp {{ number_format($peminjaman->total_denda, 0, ',', '.') }}</div>
            <div style="font-size:9px;font-weight:bold">
                {{ $peminjaman->status_denda === 'sudah_bayar' ? '✓ LUNAS' : '✗ BELUM DIBAYAR' }}
            </div>
        </div>
    </div>
</div>
@else
<div class="denda-box denda-nihil">
    <span class="bold" style="color:#166534">✓ Tidak Ada Denda — Tepat Waktu</span>
</div>
@endif

{{-- TANDA TANGAN --}}
<div class="ttd-section">
    <div class="ttd-box">
        <div>Anggota,</div>
        <div class="ttd-name">{{ $peminjaman->user->name }}</div>
        <div class="ttd-role">Anggota</div>
    </div>
    <div class="ttd-box">
        <div>Petugas,</div>
        <div class="ttd-name">{{ $peminjaman->petugas->name ?? 'Petugas' }}</div>
        <div class="ttd-role">{{ ucfirst($peminjaman->petugas->role ?? 'Petugas') }}</div>
    </div>
</div>

<hr class="divider">
<div class="footer">
    <div>Dicetak: {{ now()->format('d M Y, H:i') }} WIB</div>
    <div class="thanks">Terima kasih telah mengembalikan buku tepat waktu 📚</div>
</div>

</body>
</html>
