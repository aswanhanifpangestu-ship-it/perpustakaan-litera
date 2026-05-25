
<?php if($buku->ulasan->count() > 0): ?>
<div class="card table-card mt-4">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-star-fill text-warning me-2"></i>Ulasan Pembaca
            </h6>
            <div class="d-flex align-items-center gap-2">
                <?php echo $__env->make('ulasan._star_rating', ['rating' => round($buku->ratingRata()), 'size' => 'md'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <span class="fw-bold"><?php echo e($buku->ratingRata()); ?></span>
                <span class="text-muted small">(<?php echo e($buku->ulasan->count()); ?> ulasan)</span>
            </div>
        </div>
    </div>

    
    <?php
        $total = $buku->ulasan->count();
        $dist  = [];
        for ($i = 5; $i >= 1; $i--) {
            $dist[$i] = $buku->ulasan->where('rating', $i)->count();
        }
    ?>
    <div class="card-body border-bottom pb-3">
        <div class="row g-1" style="max-width:360px">
            <?php $__currentLoopData = $dist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $star => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12">
                <div class="d-flex align-items-center gap-2">
                    <span class="small text-muted" style="width:14px"><?php echo e($star); ?></span>
                    <span style="color:#f59e0b;font-size:.85rem">★</span>
                    <div class="progress flex-grow-1" style="height:8px">
                        <div class="progress-bar bg-warning"
                             style="width:<?php echo e($total > 0 ? round($count/$total*100) : 0); ?>%"></div>
                    </div>
                    <span class="small text-muted" style="width:20px"><?php echo e($count); ?></span>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="card-body p-0">
        <?php $__currentLoopData = $buku->ulasan->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="p-3 border-bottom">
            <div class="d-flex align-items-start gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                     style="width:38px;height:38px">
                    <i class="bi bi-person-fill text-primary small"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                        <span class="fw-semibold small"><?php echo e($u->user->name); ?></span>
                        <?php echo $__env->make('ulasan._star_rating', ['rating' => $u->rating, 'size' => 'sm'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <span class="text-muted" style="font-size:.75rem"><?php echo e($u->created_at->diffForHumans()); ?></span>
                    </div>
                    <?php if($u->komentar): ?>
                        <p class="mb-1 small"><?php echo e($u->komentar); ?></p>
                    <?php else: ?>
                        <p class="mb-1 small text-muted fst-italic">Tidak ada komentar.</p>
                    <?php endif; ?>
                </div>
                
                <?php if(auth()->check() && (auth()->user()->isAdminOrPetugas() || auth()->id() === $u->user_id)): ?>
                <form action="<?php echo e(route('ulasan.destroy', $u)); ?>" method="POST"
                      onsubmit="return confirm('Hapus ulasan ini?')" class="flex-shrink-0">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php else: ?>
<div class="card table-card mt-4">
    <div class="card-body text-center text-muted py-4">
        <i class="bi bi-star fs-2 d-block mb-2 text-warning opacity-50"></i>
        Belum ada ulasan untuk buku ini.
    </div>
</div>
<?php endif; ?>

<?php $__env->startPush('styles'); ?>
<style>
.btn-xs { padding: .2rem .45rem; font-size: .75rem; }
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/ulasan/_list_ulasan.blade.php ENDPATH**/ ?>