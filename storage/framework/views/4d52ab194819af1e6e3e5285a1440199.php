

<?php $__env->startSection('title', 'Detail Pengguna'); ?>
<?php $__env->startSection('page-title', '👤 Detail Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    
    <div class="col-lg-4">
        <div class="card table-card text-center">
            <div class="card-body p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:80px;height:80px;background:#ccfbf1;font-size:2.5rem">
                    <?php if($user->role === 'admin'): ?> 👑
                    <?php elseif($user->role === 'petugas'): ?> 🛡️
                    <?php else: ?> 👤
                    <?php endif; ?>
                </div>
                <h5 class="fw-bold mb-1" style="color:#134e4a"><?php echo e($user->name); ?></h5>
                <p class="text-muted small mb-2"><?php echo e($user->email); ?></p>

                <div class="d-flex justify-content-center gap-2 mb-3">
                    <span class="badge rounded-pill px-3 py-2
                        <?php if($user->role === 'admin'): ?> badge-admin
                        <?php elseif($user->role === 'petugas'): ?> badge-petugas
                        <?php else: ?> badge-user <?php endif; ?>">
                        <?php if($user->role === 'admin'): ?> 👑 <?php elseif($user->role === 'petugas'): ?> 🛡️ <?php else: ?> 📖 <?php endif; ?>
                        <?php echo e(ucfirst($user->role)); ?>

                    </span>
                    <?php if($user->is_active): ?>
                        <span class="badge rounded-pill bg-success">✅ Aktif</span>
                    <?php else: ?>
                        <span class="badge rounded-pill bg-secondary">⛔ Nonaktif</span>
                    <?php endif; ?>
                </div>

                <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-warning btn-sm w-100">
                    ✏️ Edit Pengguna
                </a>
            </div>
        </div>
    </div>

    
    <div class="col-lg-8">
        <div class="card table-card mb-4">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">📋 Informasi Pengguna</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted fw-semibold small" width="140">🪪 No. Anggota</td>
                        <td class="small"><?php echo e($user->no_anggota ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📱 Telepon</td>
                        <td class="small"><?php echo e($user->telepon ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📍 Alamat</td>
                        <td class="small"><?php echo e($user->alamat ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold small">📅 Bergabung</td>
                        <td class="small"><?php echo e($user->created_at->format('d M Y')); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">📋 Riwayat Peminjaman</h6>
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
                            <?php $__empty_1 = true; $__currentLoopData = $user->peminjaman->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="small fw-semibold"><?php echo e($p->buku->judul); ?></td>
                                <td class="small"><?php echo e($p->tanggal_pinjam->format('d/m/Y')); ?></td>
                                <td class="small"><?php echo e($p->tanggal_kembali->format('d/m/Y')); ?></td>
                                <td><?php echo $__env->make('peminjaman._badge_status', ['status' => $p->status], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                                <td class="small">
                                    <?php if($p->total_denda > 0): ?>
                                        <span class="<?php echo e($p->status_denda === 'belum_bayar' ? 'text-danger fw-semibold' : 'text-success'); ?>">
                                            Rp <?php echo e(number_format($p->total_denda, 0, ',', '.')); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <span style="font-size:1.5rem">📭</span>
                                    <div class="mt-1 small">Belum ada riwayat peminjaman.</div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?php echo e(route('users.index')); ?>" class="btn btn-outline-secondary btn-sm">
        ← Kembali ke Daftar Pengguna
    </a>
</div>

<?php $__env->startPush('styles'); ?>
<style>
.badge-admin   { background:#fef3c7; color:#92400e; }
.badge-petugas { background:#ccfbf1; color:#0f766e; }
.badge-user    { background:#ede9fe; color:#5b21b6; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/users/show.blade.php ENDPATH**/ ?>