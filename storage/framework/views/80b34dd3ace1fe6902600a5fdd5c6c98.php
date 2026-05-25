

<?php $__env->startSection('title', 'Struk Saya'); ?>
<?php $__env->startSection('page-title', '🧾 Struk Peminjaman Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="card table-card">
    <div class="card-header py-3">
        <h6 class="mb-0 fw-bold">🧾 Daftar Struk Peminjaman</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>📗 Buku</th>
                        <th>📅 Tgl Pinjam</th>
                        <th>📅 Tgl Kembali</th>
                        <th>🔖 Status</th>
                        <th>💸 Denda</th>
                        <th>🧾 Struk</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $peminjaman; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($loop->iteration); ?></td>
                        <td>
                            <div class="fw-semibold small"><?php echo e($p->buku->judul); ?></div>
                            <div class="text-muted" style="font-size:.72rem">✍️ <?php echo e($p->buku->pengarang); ?></div>
                        </td>
                        <td class="small"><?php echo e($p->tanggal_pinjam->format('d M Y')); ?></td>
                        <td class="small"><?php echo e($p->tanggal_kembali->format('d M Y')); ?></td>
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
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('struk.show', $p)); ?>"
                                   class="btn btn-xs btn-outline-primary" title="Lihat Struk">
                                    🧾
                                </a>
                                <a href="<?php echo e(route('struk.pdf', $p)); ?>"
                                   class="btn btn-xs btn-outline-danger" title="Download PDF" target="_blank">
                                    📄
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">🧾</span>
                            <div class="mt-2">Belum ada struk peminjaman.</div>
                            <a href="<?php echo e(route('peminjaman.create')); ?>" class="btn btn-sm btn-primary mt-2">
                                📝 Ajukan Peminjaman
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($peminjaman->hasPages()): ?>
    <div class="card-footer"><?php echo e($peminjaman->links()); ?></div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/struk/index.blade.php ENDPATH**/ ?>