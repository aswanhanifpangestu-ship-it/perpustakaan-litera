

<?php $__env->startSection('title', 'Profil Saya'); ?>
<?php $__env->startSection('page-title', '🪪 Profil Saya'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4 justify-content-center">
    <div class="col-lg-7">

        
        <div class="card table-card mb-4">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">👤 Informasi Profil</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">👤 Nama Lengkap</label>
                            <input type="text" name="name"
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('name', auth()->user()->name)); ?>">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">📧 Email</label>
                            <input type="email" name="email"
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('email', auth()->user()->email)); ?>">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">📱 Telepon</label>
                            <input type="text" name="telepon" class="form-control"
                                   value="<?php echo e(old('telepon', auth()->user()->telepon)); ?>"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🪪 No. Anggota</label>
                            <input type="text" class="form-control"
                                   value="<?php echo e(auth()->user()->no_anggota ?? '—'); ?>" disabled
                                   style="background:#f0fdf9;color:#0f766e">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">📍 Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2"
                                      placeholder="Alamat lengkap..."><?php echo e(old('alamat', auth()->user()->alamat)); ?></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold small">🖼️ Foto Profil</label>
                            <?php if(auth()->user()->foto): ?>
                            <div class="mb-2">
                                <img src="<?php echo e(asset('storage/' . auth()->user()->foto)); ?>"
                                     class="rounded-circle shadow-sm"
                                     style="width:60px;height:60px;object-fit:cover;border:3px solid #ccfbf1">
                            </div>
                            <?php endif; ?>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <div class="form-text">Format JPG/PNG, maks 2MB.</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        💾 Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        
        <div class="card table-card">
            <div class="card-header py-3">
                <h6 class="mb-0 fw-bold">🔒 Ganti Password</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('profile.password')); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold small">🔑 Password Lama</label>
                            <input type="password" name="current_password"
                                   class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Masukkan password lama">
                            <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Password Baru</label>
                            <input type="password" name="password"
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Min. 6 karakter">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">🔒 Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning mt-3">
                        🔑 Ganti Password
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/profile/edit.blade.php ENDPATH**/ ?>