

<?php $__env->startSection('title', 'Daftar Buku'); ?>
<?php $__env->startSection('page-title', '📗 Daftar Buku'); ?>

<?php use Illuminate\Support\Facades\Storage; ?>

<?php $__env->startSection('content'); ?>
<div class="card table-card">
    <div class="card-header py-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-7">
                <form action="<?php echo e(route('buku.index')); ?>" method="GET" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" class="form-control form-control-sm"
                           placeholder="🔍 Cari judul, pengarang, ISBN..." value="<?php echo e(request('search')); ?>"
                           style="min-width:200px">
                    <select name="kategori" class="form-select form-select-sm" style="width:auto">
                        <option value="">🏷️ Semua Kategori</option>
                        <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k->id); ?>" <?php echo e(request('kategori') == $k->id ? 'selected' : ''); ?>>
                                <?php echo e($k->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if(request()->hasAny(['search','kategori'])): ?>
                        <a href="<?php echo e(route('buku.index')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
            <?php if(auth()->user()->isAdminOrPetugas()): ?>
            <div class="col-md-5 text-md-end">
                <a href="<?php echo e(route('buku.create')); ?>" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>➕ Tambah Buku
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th width="55">Sampul</th>
                        <th>📗 Judul</th>
                        <th>✍️ Pengarang</th>
                        <th>🏷️ Kategori</th>
                        <th>📅 Tahun</th>
                        <th>⭐ Rating</th>
                        <th>📦 Stok</th>
                        <th>✅ Tersedia</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $buku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($buku->firstItem() + $loop->index); ?></td>
                        <td>
                            <?php if($b->sampul_buku && Storage::disk('public')->exists($b->sampul_buku)): ?>
                                <img src="<?php echo e(Storage::disk('public')->url($b->sampul_buku)); ?>"
                                     alt="<?php echo e($b->judul); ?>"
                                     class="rounded shadow-sm"
                                     style="width:38px;height:50px;object-fit:cover">
                            <?php else: ?>
                                <div class="rounded d-flex align-items-center justify-content-center"
                                     style="width:38px;height:50px;background:#ccfbf1">
                                    <span style="font-size:1.1rem">📗</span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="fw-semibold small"><?php echo e($b->judul); ?></div>
                            <?php if($b->isbn): ?>
                                <small class="text-muted">ISBN: <?php echo e($b->isbn); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="small"><?php echo e($b->pengarang); ?></td>
                        <td>
                            <span class="badge rounded-pill"
                                  style="background:#ccfbf1;color:#0f766e;font-size:.72rem">
                                <?php echo e($b->kategori->nama ?? '—'); ?>

                            </span>
                        </td>
                        <td class="small"><?php echo e($b->tahun_terbit); ?></td>
                        <td>
                            <?php $rata = $b->ratingRata(); ?>
                            <?php if($rata > 0): ?>
                                <div class="d-flex align-items-center gap-1">
                                    <span style="color:#f59e0b">★</span>
                                    <span class="small fw-semibold"><?php echo e($rata); ?></span>
                                    <span class="text-muted" style="font-size:.7rem">(<?php echo e($b->ulasan->count()); ?>)</span>
                                </div>
                            <?php else: ?>
                                <span class="text-muted small">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="small fw-semibold"><?php echo e($b->stok); ?></td>
                        <td>
                            <?php if($b->stok_tersedia > 0): ?>
                                <span class="badge rounded-pill bg-success"><?php echo e($b->stok_tersedia); ?></span>
                            <?php else: ?>
                                <span class="badge rounded-pill bg-danger">Habis</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('buku.show', $b)); ?>"
                                   class="btn btn-xs btn-outline-primary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if(auth()->user()->isAdminOrPetugas()): ?>
                                <a href="<?php echo e(route('buku.edit', $b)); ?>"
                                   class="btn btn-xs btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('buku.destroy', $b)); ?>" method="POST"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">📭</span>
                            <div class="mt-2">Tidak ada buku ditemukan.</div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($buku->hasPages()): ?>
    <div class="card-footer"><?php echo e($buku->links()); ?></div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/buku/index.blade.php ENDPATH**/ ?>