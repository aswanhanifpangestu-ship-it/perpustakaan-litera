<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Data Anggota</title>
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
.report-title .underline { width:60px; height:3px; background:#2563eb; margin:6px auto 0; border-radius:2px; }

.summary { display:table; width:100%; margin-bottom:14px; border-collapse:collapse; }
.sbox { display:table-cell; padding:8px 10px; border:1px solid #e2e8f0; background:#f8fafc; text-align:center; }
.sbox .val { font-size:13px; font-weight:bold; }
.sbox .lbl { font-size:8px; color:#64748b; margin-top:2px; }
.sbox.blue .val  { color:#2563eb; }
.sbox.green .val { color:#16a34a; }
.sbox.red .val   { color:#dc2626; }
.sbox.amber .val { color:#d97706; }

table.main { width:100%; border-collapse:collapse; margin-top:6px; }
table.main thead tr { background:#2563eb; color:#fff; }
table.main thead th { padding:7px 7px; font-size:9px; text-align:left; }
table.main tbody tr:nth-child(even) { background:#eff6ff; }
table.main tbody td { padding:5px 7px; border-bottom:1px solid #e2e8f0; font-size:9px; vertical-align:top; }
.badge-aktif    { background:#dcfce7; color:#16a34a; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-nonaktif { background:#f1f5f9; color:#64748b; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-denda    { background:#fee2e2; color:#dc2626; padding:1px 5px; border-radius:3px; font-size:8px; }
.text-center { text-align:center; }
.text-right  { text-align:right; }

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
    <h3>Laporan Data Anggota Perpustakaan</h3>
    <p>Dicetak pada: <?php echo e(now()->isoFormat('dddd, D MMMM Y')); ?> &nbsp;|&nbsp; Pukul <?php echo e(now()->format('H:i')); ?> WIB</p>
    <div class="underline"></div>
</div>

<div class="summary">
    <div class="sbox blue" style="width:25%">
        <div class="val"><?php echo e($totalUser); ?></div>
        <div class="lbl">Total Anggota</div>
    </div>
    <div class="sbox green" style="width:25%">
        <div class="val"><?php echo e($totalAktif); ?></div>
        <div class="lbl">Anggota Aktif</div>
    </div>
    <div class="sbox amber" style="width:25%">
        <div class="val"><?php echo e($totalPeminjaman); ?></div>
        <div class="lbl">Total Peminjaman</div>
    </div>
    <div class="sbox red" style="width:25%">
        <div class="val"><?php echo e($totalDenda); ?></div>
        <div class="lbl">Anggota Ada Denda</div>
    </div>
</div>

<table class="main">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="6%">No. Anggota</th>
            <th width="20%">Nama</th>
            <th width="22%">Email</th>
            <th width="10%">Telepon</th>
            <th width="7%" class="text-center">Status</th>
            <th width="9%" class="text-center">Tgl Daftar</th>
            <th width="7%" class="text-center">Pinjam</th>
            <th width="7%" class="text-center">Kembali</th>
            <th width="8%" class="text-right">Total Denda</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><?php echo e($u->no_anggota ?? '-'); ?></td>
            <td><strong><?php echo e($u->name); ?></strong></td>
            <td><?php echo e($u->email); ?></td>
            <td><?php echo e($u->telepon ?? '-'); ?></td>
            <td class="text-center">
                <?php if($u->is_active): ?>
                    <span class="badge-aktif">Aktif</span>
                <?php else: ?>
                    <span class="badge-nonaktif">Nonaktif</span>
                <?php endif; ?>
            </td>
            <td class="text-center"><?php echo e($u->created_at->format('d/m/Y')); ?></td>
            <td class="text-center"><?php echo e($u->peminjaman_count); ?></td>
            <td class="text-center"><?php echo e($u->dikembalikan_count); ?></td>
            <td class="text-right">
                <?php if($u->total_denda > 0): ?>
                    <span class="badge-denda">Rp <?php echo e(number_format($u->total_denda, 0, ',', '.')); ?></span>
                <?php else: ?>
                    <span style="color:#16a34a">-</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="10" class="text-center" style="padding:16px;color:#94a3b8">Tidak ada data anggota.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="ttd-section">
    <div class="ttd-box">
        <div class="ttd-title">Mengetahui,</div>
        <div class="ttd-name"><?php echo e($adminName); ?></div>
        <div class="ttd-role">Administrator Litera</div>
    </div>
    <div class="ttd-box"></div>
    <div class="ttd-box">
        <div class="ttd-title"><?php echo e(now()->isoFormat('D MMMM Y')); ?></div>
        <div class="ttd-name"><?php echo e(auth()->user()->name); ?></div>
        <div class="ttd-role"><?php echo e(ucfirst(auth()->user()->role)); ?></div>
    </div>
</div>

<div class="footer">
    <div class="footer-left">Perpustakaan Litera &mdash; Laporan Data Anggota</div>
    <div class="footer-right">Dicetak: <?php echo e(now()->format('d/m/Y H:i')); ?> &nbsp;|&nbsp; Halaman 1</div>
</div>

</body>
</html>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/laporan/pdf_user.blade.php ENDPATH**/ ?>