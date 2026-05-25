<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Data Buku</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'DejaVu Sans', sans-serif; font-size:10px; color:#1e293b; }

/* ── KOP SURAT ── */
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

/* ── JUDUL LAPORAN ── */
.report-title { text-align:center; margin:10px 0 14px; }
.report-title h3 { font-size:13px; font-weight:bold; color:#1e3a5f; text-transform:uppercase; letter-spacing:.8px; }
.report-title p  { font-size:9px; color:#64748b; margin-top:3px; }
.report-title .underline { width:60px; height:3px; background:#2563eb; margin:6px auto 0; border-radius:2px; }

/* ── SUMMARY BOXES ── */
.summary { display:table; width:100%; margin-bottom:14px; border-collapse:collapse; }
.sbox {
    display:table-cell; padding:8px 10px; border:1px solid #e2e8f0;
    background:#f8fafc; text-align:center; width:25%;
}
.sbox .val { font-size:13px; font-weight:bold; color:#1e3a5f; }
.sbox .lbl { font-size:8px; color:#64748b; margin-top:2px; }
.sbox.blue .val  { color:#2563eb; }
.sbox.green .val { color:#16a34a; }
.sbox.red .val   { color:#dc2626; }
.sbox.amber .val { color:#d97706; }

/* ── TABEL ── */
table.main { width:100%; border-collapse:collapse; margin-top:6px; }
table.main thead tr { background:#1e3a5f; color:#fff; }
table.main thead th { padding:7px 7px; font-size:9px; text-align:left; }
table.main tbody tr:nth-child(even) { background:#f8fafc; }
table.main tbody td { padding:5px 7px; border-bottom:1px solid #e2e8f0; font-size:9px; vertical-align:top; }
.badge-tersedia { background:#dcfce7; color:#16a34a; padding:1px 5px; border-radius:3px; font-size:8px; }
.badge-habis    { background:#fee2e2; color:#dc2626; padding:1px 5px; border-radius:3px; font-size:8px; }
.text-center { text-align:center; }
.text-right  { text-align:right; }

/* ── TANDA TANGAN ── */
.ttd-section { margin-top:30px; display:table; width:100%; }
.ttd-box { display:table-cell; width:33%; text-align:center; padding:0 10px; vertical-align:top; }
.ttd-box .ttd-title { font-size:9px; color:#64748b; margin-bottom:4px; }
.ttd-box .ttd-name  { font-size:10px; font-weight:bold; color:#1e3a5f; margin-top:40px; border-top:1px solid #1e3a5f; padding-top:4px; }
.ttd-box .ttd-role  { font-size:8px; color:#64748b; }

/* ── FOOTER ── */
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
    <h3>Laporan Data Koleksi Buku</h3>
    <p>Dicetak pada: <?php echo e(now()->isoFormat('dddd, D MMMM Y')); ?> &nbsp;|&nbsp; Pukul <?php echo e(now()->format('H:i')); ?> WIB</p>
    <div class="underline"></div>
</div>


<div class="summary">
    <div class="sbox blue">
        <div class="val"><?php echo e($totalBuku); ?></div>
        <div class="lbl">Total Judul Buku</div>
    </div>
    <div class="sbox green">
        <div class="val"><?php echo e($totalStok); ?></div>
        <div class="lbl">Total Stok</div>
    </div>
    <div class="sbox amber">
        <div class="val"><?php echo e($totalTersedia); ?></div>
        <div class="lbl">Stok Tersedia</div>
    </div>
    <div class="sbox red">
        <div class="val"><?php echo e($totalHabis); ?></div>
        <div class="lbl">Stok Habis</div>
    </div>
</div>


<table class="main">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="24%">Judul Buku</th>
            <th width="16%">Pengarang</th>
            <th width="14%">Penerbit</th>
            <th width="8%">Tahun</th>
            <th width="12%">Kategori</th>
            <th width="6%" class="text-center">Stok</th>
            <th width="7%" class="text-center">Tersedia</th>
            <th width="9%" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $buku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><strong><?php echo e($b->judul); ?></strong>
                <?php if($b->isbn): ?><br><span style="color:#94a3b8;font-size:8px">ISBN: <?php echo e($b->isbn); ?></span><?php endif; ?>
            </td>
            <td><?php echo e($b->pengarang); ?></td>
            <td><?php echo e($b->penerbit); ?></td>
            <td class="text-center"><?php echo e($b->tahun_terbit); ?></td>
            <td><?php echo e($b->kategori->nama ?? '-'); ?></td>
            <td class="text-center"><?php echo e($b->stok); ?></td>
            <td class="text-center"><?php echo e($b->stok_tersedia); ?></td>
            <td class="text-center">
                <?php if($b->stok_tersedia > 0): ?>
                    <span class="badge-tersedia">Tersedia</span>
                <?php else: ?>
                    <span class="badge-habis">Habis</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr><td colspan="9" class="text-center" style="padding:16px;color:#94a3b8">Tidak ada data buku.</td></tr>
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
    <div class="footer-left">Perpustakaan Litera &mdash; Laporan Data Buku</div>
    <div class="footer-right">Dicetak: <?php echo e(now()->format('d/m/Y H:i')); ?> &nbsp;|&nbsp; Halaman 1</div>
</div>

</body>
</html>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/laporan/pdf_buku.blade.php ENDPATH**/ ?>