

<?php $__env->startSection('title', 'Kategori'); ?>
<?php $__env->startSection('page-title', '🏷️ Manajemen Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    
    <div class="col-lg-4">
        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">➕ Tambah Kategori</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('kategori.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">🏷️ Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama"
                               class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               value="<?php echo e(old('nama')); ?>" placeholder="Nama kategori">
                        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">📝 Deskripsi</label>
                        <textarea name="deskripsi"
                                  class="form-control <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  rows="2" placeholder="Deskripsi kategori..."><?php echo e(old('deskripsi')); ?></textarea>
                        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">➕ Tambah Kategori</button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-8">
        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">🏷️ Daftar Kategori</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>🏷️ Nama</th>
                                <th>📝 Deskripsi</th>
                                <th>📗 Jumlah Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="text-muted small"><?php echo e($kategori->firstItem() + $loop->index); ?></td>
                                <td class="fw-semibold small"><?php echo e($k->nama); ?></td>
                                <td class="text-muted small"><?php echo e($k->deskripsi ?? '—'); ?></td>
                                <td>
                                    <span class="badge rounded-pill" style="background:#ccfbf1;color:#0f766e">
                                        <?php echo e($k->buku_count); ?> buku
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo e(route('kategori.edit', $k)); ?>"
                                           class="btn btn-xs btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?php echo e(route('kategori.destroy', $k)); ?>" method="POST"
                                              onsubmit="return confirm('Hapus kategori ini?')">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <span style="font-size:2rem">🏷️</span>
                                    <div class="mt-2">Belum ada kategori.</div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if($kategori->hasPages()): ?>
            <div class="card-footer"><?php echo e($kategori->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/kategori/index.blade.php ENDPATH**/ ?>