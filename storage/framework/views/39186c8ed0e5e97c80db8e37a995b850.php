

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', '🏠 Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#ccfbf1">
                    <span style="font-size:1.5rem">📗</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#0f766e"><?php echo e($data['totalBuku']); ?></div>
                    <div class="small text-muted">Total Buku</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#ede9fe">
                    <span style="font-size:1.5rem">👥</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#5b21b6"><?php echo e($data['totalAnggota']); ?></div>
                    <div class="small text-muted">Total Anggota</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fef3c7">
                    <span style="font-size:1.5rem">📋</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#d97706"><?php echo e($data['totalDipinjam']); ?></div>
                    <div class="small text-muted">Sedang Dipinjam</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fce7f3">
                    <span style="font-size:1.5rem">⏳</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#be185d"><?php echo e($data['totalPending']); ?></div>
                    <div class="small text-muted">Menunggu Persetujuan</div>
                </div>
            </div>
        </div>
    </div>

    <?php if($user->isUser()): ?>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100 <?php echo e($data['dendaPribadi'] > 0 ? 'border-danger' : ''); ?>">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fee2e2">
                    <span style="font-size:1.5rem">💸</span>
                </div>
                <div>
                    <div class="fw-bold <?php echo e($data['dendaPribadi'] > 0 ? 'text-danger' : ''); ?>" style="font-size:1.1rem">
                        Rp <?php echo e(number_format($data['dendaPribadi'], 0, ',', '.')); ?>

                    </div>
                    <div class="small text-muted">Denda Belum Bayar</div>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100 <?php echo e($data['totalDendaBelumBayar'] > 0 ? 'border-danger' : ''); ?>">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fee2e2">
                    <span style="font-size:1.5rem">💰</span>
                </div>
                <div>
                    <div class="fw-bold <?php echo e($data['totalDendaBelumBayar'] > 0 ? 'text-danger' : ''); ?>" style="font-size:1.1rem">
                        Rp <?php echo e(number_format($data['totalDendaBelumBayar'], 0, ',', '.')); ?>

                    </div>
                    <div class="small text-muted">Total Denda Belum Bayar</div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php if($user->isUser()): ?>

<div class="card table-card">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">📋 Peminjaman Saya</h6>
        <a href="<?php echo e(route('peminjaman.create')); ?>" class="btn btn-sm btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Ajukan Peminjaman
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>📗 Buku</th>
                        <th>📅 Tgl Pinjam</th>
                        <th>📅 Tgl Kembali</th>
                        <th>🔖 Status</th>
                        <th>💸 Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $data['peminjamanSaya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="fw-semibold small"><?php echo e($p->buku->judul); ?></td>
                        <td class="small"><?php echo e($p->tanggal_pinjam->format('d/m/Y')); ?></td>
                        <td class="small"><?php echo e($p->tanggal_kembali->format('d/m/Y')); ?></td>
                        <td><?php echo $__env->make('peminjaman._badge_status', ['status' => $p->status], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                        <td class="small">
                            <?php if($p->total_denda > 0): ?>
                                <span class="<?php echo e($p->status_denda === 'belum_bayar' ? 'text-danger fw-semibold' : 'text-success'); ?>">
                                    Rp <?php echo e(number_format($p->total_denda, 0, ',', '.')); ?>

                                    <?php if($p->status_denda === 'sudah_bayar'): ?> ✅ <?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            <span style="font-size:2rem">📭</span>
                            <div class="mt-2">Belum ada peminjaman.</div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?php echo e(route('peminjaman.index')); ?>" class="btn btn-sm btn-outline-primary">
            Lihat Semua Peminjaman →
        </a>
    </div>
</div>

<?php else: ?>


<?php if($data['pengajuanPending']->count() > 0): ?>
<div class="alert border-0 rounded-3 shadow-sm mb-4 d-flex align-items-center gap-3"
     style="background:#fef3c7;color:#92400e">
    <span style="font-size:1.5rem">⏳</span>
    <div>
        <strong><?php echo e($data['totalPending']); ?> pengajuan peminjaman</strong> menunggu persetujuan.
        <a href="<?php echo e(route('peminjaman.index', ['status' => 'pending'])); ?>"
           class="ms-2 fw-semibold" style="color:#92400e">Proses sekarang →</a>
    </div>
</div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">📋 Peminjaman Terbaru</h6>
                <a href="<?php echo e(route('peminjaman.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>👤 Anggota</th>
                                <th>📗 Buku</th>
                                <th>📅 Tgl Kembali</th>
                                <th>🔖 Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $data['peminjamanTerbaru']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="small fw-semibold"><?php echo e($p->user->name); ?></td>
                                <td class="small text-truncate" style="max-width:150px"><?php echo e($p->buku->judul); ?></td>
                                <td class="small"><?php echo e($p->tanggal_kembali->format('d/m/Y')); ?></td>
                                <td><?php echo $__env->make('peminjaman._badge_status', ['status' => $p->status], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <span style="font-size:1.5rem">📭</span><div class="mt-1">Belum ada data.</div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card table-card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">📗 Buku Terbaru</h6>
                <a href="<?php echo e(route('buku.index')); ?>" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php $__empty_1 = true; $__currentLoopData = $data['bukuTerbaru']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li class="list-group-item px-3 py-2" style="border-color:#ccfbf1">
                        <div class="fw-semibold small text-truncate"><?php echo e($b->judul); ?></div>
                        <div class="text-muted" style="font-size:.75rem">
                            ✍️ <?php echo e($b->pengarang); ?> &bull;
                            <span class="badge" style="background:#ccfbf1;color:#0f766e"><?php echo e($b->kategori->nama ?? '-'); ?></span>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="list-group-item text-center text-muted py-4">
                        <span style="font-size:1.5rem">📭</span><div class="mt-1">Belum ada buku.</div>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/dashboard.blade.php ENDPATH**/ ?>