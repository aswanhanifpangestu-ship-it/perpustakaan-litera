<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Denda <?php echo e($bulanNama); ?> <?php echo e($tahun); ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2563eb; padding-bottom: 12px; }
        .header h2 { font-size: 16px; color: #1e3a5f; margin-bottom: 4px; }
        .header p  { font-size: 11px; color: #64748b; }

        .summary { display: table; width: 100%; margin-bottom: 18px; border-collapse: collapse; }
        .summary-box {
            display: table-cell; width: 25%; padding: 10px 12px;
            border: 1px solid #e2e8f0; background: #f8fafc;
            text-align: center;
        }
        .summary-box .val { font-size: 14px; font-weight: bold; color: #1e3a5f; }
        .summary-box .lbl { font-size: 9px; color: #64748b; margin-top: 2px; }
        .summary-box.danger .val { color: #dc2626; }
        .summary-box.success .val { color: #16a34a; }

        table.main { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.main thead tr { background: #2563eb; color: #fff; }
        table.main thead th { padding: 7px 8px; font-size: 10px; text-align: left; }
        table.main tbody tr:nth-child(even) { background: #f8fafc; }
        table.main tbody td { padding: 6px 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        .badge-lunas    { background: #dcfce7; color: #16a34a; padding: 2px 6px; border-radius: 4px; font-size: 9px; }
        .badge-belum    { background: #fee2e2; color: #dc2626; padding: 2px 6px; border-radius: 4px; font-size: 9px; }
        .text-right     { text-align: right; }
        .text-center    { text-align: center; }
        .text-danger    { color: #dc2626; font-weight: bold; }
        .footer         { margin-top: 20px; font-size: 9px; color: #94a3b8; text-align: right; }
        .total-row td   { font-weight: bold; background: #eff6ff; border-top: 2px solid #2563eb; }
    </style>
</head>
<body>

<div class="header">
    <h2>Laporan Denda Keterlambatan Peminjaman</h2>
    <p>Periode: <?php echo e($bulanNama); ?> <?php echo e($tahun); ?> &nbsp;|&nbsp; Dicetak: <?php echo e(now()->format('d M Y H:i')); ?></p>
</div>


<div class="summary">
    <div class="summary-box">
        <div class="val"><?php echo e($data['totalPeminjaman']); ?></div>
        <div class="lbl">Total Peminjaman</div>
    </div>
    <div class="summary-box danger">
        <div class="val"><?php echo e($data['totalTerlambat']); ?></div>
        <div class="lbl">Kasus Terlambat</div>
    </div>
    <div class="summary-box danger">
        <div class="val">Rp <?php echo e(number_format($data['belumBayar'], 0, ',', '.')); ?></div>
        <div class="lbl">Denda Belum Bayar</div>
    </div>
    <div class="summary-box success">
        <div class="val">Rp <?php echo e(number_format($data['sudahBayar'], 0, ',', '.')); ?></div>
        <div class="lbl">Denda Sudah Bayar</div>
    </div>
</div>


<table class="main">
    <thead>
        <tr>
            <th width="4%">No</th>
            <th width="18%">Anggota</th>
            <th width="22%">Judul Buku</th>
            <th width="11%">Tgl Kembali</th>
            <th width="12%">Tgl Dikembalikan</th>
            <th width="8%" class="text-center">Terlambat</th>
            <th width="10%" class="text-right">Denda/Hari</th>
            <th width="10%" class="text-right">Total Denda</th>
            <th width="5%" class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $data['detailDenda']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($i + 1); ?></td>
            <td><?php echo e($p->user->name ?? '-'); ?></td>
            <td><?php echo e($p->buku->judul ?? '-'); ?></td>
            <td><?php echo e($p->tanggal_kembali->format('d/m/Y')); ?></td>
            <td><?php echo e($p->tanggal_dikembalikan ? $p->tanggal_dikembalikan->format('d/m/Y') : '-'); ?></td>
            <td class="text-center text-danger"><?php echo e($p->jumlah_hari_terlambat); ?> hr</td>
            <td class="text-right">Rp <?php echo e(number_format($p->buku->denda_per_hari ?? 0, 0, ',', '.')); ?></td>
            <td class="text-right text-danger">Rp <?php echo e(number_format($p->total_denda, 0, ',', '.')); ?></td>
            <td class="text-center">
                <?php if($p->status_denda === 'sudah_bayar'): ?>
                    <span class="badge-lunas">Lunas</span>
                <?php else: ?>
                    <span class="badge-belum">Belum</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="9" class="text-center" style="padding:20px;color:#94a3b8">
                Tidak ada data denda pada periode ini.
            </td>
        </tr>
        <?php endif; ?>

        <?php if($data['detailDenda']->count() > 0): ?>
        <tr class="total-row">
            <td colspan="7" class="text-right">TOTAL DENDA:</td>
            <td class="text-right text-danger">Rp <?php echo e(number_format($data['totalDenda'], 0, ',', '.')); ?></td>
            <td></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    Sistem Perpustakaan &mdash; Laporan dibuat otomatis
</div>

</body>
</html>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/laporan/pdf.blade.php ENDPATH**/ ?>