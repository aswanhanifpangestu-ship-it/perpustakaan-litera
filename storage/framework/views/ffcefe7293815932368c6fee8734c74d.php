

<?php $__env->startSection('title', 'Manajemen Ulasan'); ?>
<?php $__env->startSection('page-title', '⭐ Manajemen Ulasan'); ?>

<?php $__env->startSection('content'); ?>


<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fef3c7">
                    <span style="font-size:1.5rem">⭐</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#d97706"><?php echo e($stats['total']); ?></div>
                    <div class="small text-muted">Total Ulasan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#ccfbf1">
                    <span style="font-size:1.5rem">📊</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold" style="color:#0f766e"><?php echo e($stats['rata_rata']); ?></div>
                    <div class="small text-muted">Rata-rata Rating</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#dcfce7">
                    <span style="font-size:1.5rem">😍</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold text-success"><?php echo e($stats['bintang5']); ?></div>
                    <div class="small text-muted">Bintang 5 ★★★★★</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon" style="background:#fee2e2">
                    <span style="font-size:1.5rem">😞</span>
                </div>
                <div>
                    <div class="fs-3 fw-bold text-danger"><?php echo e($stats['bintang1']); ?></div>
                    <div class="small text-muted">Bintang 1 ★</div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card table-card">
    <div class="card-header py-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-9">
                <form action="<?php echo e(route('ulasan.index')); ?>" method="GET" class="d-flex gap-2 flex-wrap">
                    <input type="text" name="search" class="form-control form-control-sm"
                           style="min-width:180px"
                           placeholder="🔍 Cari judul buku atau nama anggota..."
                           value="<?php echo e(request('search')); ?>">
                    <select name="rating" class="form-select form-select-sm" style="width:auto">
                        <option value="">⭐ Semua Rating</option>
                        <?php for($i = 5; $i >= 1; $i--): ?>
                        <option value="<?php echo e($i); ?>" <?php echo e(request('rating') == $i ? 'selected' : ''); ?>>
                            <?php echo e(str_repeat('★',$i)); ?> <?php echo e($i); ?> Bintang
                        </option>
                        <?php endfor; ?>
                    </select>
                    <select name="buku_id" class="form-select form-select-sm" style="width:auto;max-width:200px">
                        <option value="">📗 Semua Buku</option>
                        <?php $__currentLoopData = $buku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($b->id); ?>" <?php echo e(request('buku_id') == $b->id ? 'selected' : ''); ?>>
                            <?php echo e(Str::limit($b->judul, 35)); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search"></i>
                    </button>
                    <?php if(request()->hasAny(['search','rating','buku_id'])): ?>
                        <a href="<?php echo e(route('ulasan.index')); ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x"></i>
                        </a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>📗 Buku</th>
                        <th>👤 Anggota</th>
                        <th>⭐ Rating</th>
                        <th>💬 Komentar</th>
                        <th>📅 Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $ulasan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted small"><?php echo e($ulasan->firstItem() + $loop->index); ?></td>
                        <td>
                            <a href="<?php echo e(route('buku.show', $u->buku)); ?>"
                               class="fw-semibold small text-decoration-none" style="color:#0f766e">
                                <?php echo e($u->buku->judul); ?>

                            </a>
                            <div class="text-muted" style="font-size:.72rem">✍️ <?php echo e($u->buku->pengarang); ?></div>
                        </td>
                        <td>
                            <div class="small fw-semibold"><?php echo e($u->user->name); ?></div>
                            <div class="text-muted" style="font-size:.72rem"><?php echo e($u->user->no_anggota ?? '—'); ?></div>
                        </td>
                        <td>
                            <?php echo $__env->make('ulasan._star_rating', ['rating' => $u->rating, 'size' => 'sm'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <span class="small text-muted ms-1"><?php echo e($u->rating); ?>/5</span>
                        </td>
                        <td class="small text-muted" style="max-width:220px">
                            <?php if($u->komentar): ?>
                                <span title="<?php echo e($u->komentar); ?>"><?php echo e(Str::limit($u->komentar, 60)); ?></span>
                            <?php else: ?>
                                <span class="fst-italic">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?php echo e($u->created_at->format('d M Y')); ?></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="<?php echo e(route('peminjaman.show', $u->peminjaman)); ?>"
                                   class="btn btn-xs btn-outline-primary" title="Lihat Peminjaman">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="<?php echo e(route('ulasan.destroy', $u)); ?>" method="POST"
                                      onsubmit="return confirm('Hapus ulasan ini?')">
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
                        <td colspan="7" class="text-center text-muted py-5">
                            <span style="font-size:2.5rem">⭐</span>
                            <div class="mt-2">Tidak ada ulasan ditemukan.</div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($ulasan->hasPages()): ?>
    <div class="card-footer"><?php echo e($ulasan->links()); ?></div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>.btn-xs { padding:.2rem .45rem; font-size:.75rem; }</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/ulasan/index.blade.php ENDPATH**/ ?>