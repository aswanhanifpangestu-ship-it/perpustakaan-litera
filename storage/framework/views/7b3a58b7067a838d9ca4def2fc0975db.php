
<?php if(auth()->guard()->check()): ?>
<?php if(auth()->user()->isUser() && $peminjaman->user_id === auth()->id() && $peminjaman->status === 'dikembalikan'): ?>

    <div class="card table-card mt-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-semibold">
                <i class="bi bi-star me-2 text-warning"></i>
                <?php if($peminjaman->ulasan): ?> Ulasan Anda <?php else: ?> Berikan Ulasan <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">

            <?php if($peminjaman->ulasan): ?>
                
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:40px;height:40px">
                        <i class="bi bi-person-fill text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-semibold"><?php echo e($peminjaman->ulasan->user->name); ?></span>
                            <?php echo $__env->make('ulasan._star_rating', ['rating' => $peminjaman->ulasan->rating, 'size' => 'md'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <span class="text-muted small"><?php echo e($peminjaman->ulasan->created_at->diffForHumans()); ?></span>
                        </div>
                        <?php if($peminjaman->ulasan->komentar): ?>
                            <p class="mb-2 text-muted"><?php echo e($peminjaman->ulasan->komentar); ?></p>
                        <?php else: ?>
                            <p class="mb-2 text-muted fst-italic small">Tidak ada komentar.</p>
                        <?php endif; ?>
                        <form action="<?php echo e(route('ulasan.destroy', $peminjaman->ulasan)); ?>" method="POST"
                              onsubmit="return confirm('Hapus ulasan ini?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i>Hapus Ulasan
                            </button>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                
                <form action="<?php echo e(route('ulasan.store', $peminjaman)); ?>" method="POST" id="formUlasan">
                    <?php echo csrf_field(); ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Rating <span class="text-danger">*</span></label>
                        <div class="star-picker d-flex gap-1" id="starPicker">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <label class="star-label" for="star<?php echo e($i); ?>" title="<?php echo e($i); ?> bintang">
                                    <input type="radio" name="rating" id="star<?php echo e($i); ?>"
                                           value="<?php echo e($i); ?>"
                                           class="d-none"
                                           <?php echo e(old('rating') == $i ? 'checked' : ''); ?>>
                                    <span class="star-icon" data-value="<?php echo e($i); ?>">★</span>
                                </label>
                            <?php endfor; ?>
                        </div>
                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="text-muted small mt-1" id="ratingLabel">Klik bintang untuk memberi rating</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Komentar <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea name="komentar" class="form-control <?php $__errorArgs = ['komentar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  rows="3" maxlength="1000"
                                  placeholder="Bagikan pengalaman membaca buku ini..."><?php echo e(old('komentar')); ?></textarea>
                        <?php $__errorArgs = ['komentar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="text-muted small mt-1">Maks. 1000 karakter</div>
                    </div>

                    <button type="submit" class="btn btn-warning fw-semibold">
                        <i class="bi bi-star-fill me-1"></i>Kirim Ulasan
                    </button>
                </form>
            <?php endif; ?>

        </div>
    </div>

<?php $__env->startPush('styles'); ?>
<style>
.star-picker { cursor: pointer; }
.star-icon {
    font-size: 2rem;
    color: #d1d5db;
    transition: color .15s, transform .1s;
    user-select: none;
}
.star-icon:hover,
.star-icon.active {
    color: #f59e0b;
    transform: scale(1.15);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
    const labels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Bagus', 'Sangat Bagus'];
    const stars  = document.querySelectorAll('#starPicker .star-icon');
    const lbl    = document.getElementById('ratingLabel');

    function highlight(val) {
        stars.forEach(s => {
            s.classList.toggle('active', parseInt(s.dataset.value) <= val);
        });
        lbl.textContent = val ? labels[val] + ' (' + val + '/5)' : 'Klik bintang untuk memberi rating';
    }

    // Restore old value jika ada
    const checked = document.querySelector('#starPicker input[type=radio]:checked');
    if (checked) highlight(parseInt(checked.value));

    stars.forEach(star => {
        star.addEventListener('mouseover', () => highlight(parseInt(star.dataset.value)));
        star.addEventListener('mouseleave', () => {
            const c = document.querySelector('#starPicker input[type=radio]:checked');
            highlight(c ? parseInt(c.value) : 0);
        });
        star.addEventListener('click', () => {
            const val = parseInt(star.dataset.value);
            document.getElementById('star' + val).checked = true;
            highlight(val);
        });
    });
})();
</script>
<?php $__env->stopPush(); ?>

<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/ulasan/_form_ulasan.blade.php ENDPATH**/ ?>