<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Litera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 0;
        }
        .register-card {
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
        }
        .register-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            padding: 2rem 2rem 1.75rem;
            text-align: center;
        }
        .register-header .icon-wrap {
            width: 64px; height: 64px;
            background: rgba(255,255,255,.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto .875rem;
            font-size: 1.75rem; color: #fff;
        }
        .register-body { padding: 1.75rem 2rem 2rem; }

        .form-control:focus,
        .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 .2rem rgba(37,99,235,.2);
        }
        .btn-register {
            background: linear-gradient(135deg, #1e3a5f, #2563eb);
            border: none; color: #fff;
            padding: .75rem;
            font-weight: 600;
            border-radius: .75rem;
            transition: opacity .2s;
        }
        .btn-register:hover { opacity: .9; color: #fff; }

        .input-group-text {
            background: #f8fafc;
            border-right: none;
            color: #94a3b8;
        }
        .input-group .form-control {
            border-left: none;
        }
        .input-group .form-control:focus {
            border-left: none;
        }

        /* Password strength bar */
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: width .3s, background .3s;
        }

        .divider {
            display: flex; align-items: center; gap: .75rem;
            color: #94a3b8; font-size: .8rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="register-card">

        
        <div class="register-header">
            <div class="icon-wrap"><i class="bi bi-person-plus-fill"></i></div>
            <h5 class="text-white fw-bold mb-1">Daftar Akun Baru</h5>
            <p class="text-white-50 mb-0 small">Buat akun untuk mengakses perpustakaan</p>
        </div>

        
        <div class="register-body">

            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger rounded-3 border-0 small mb-3">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <strong>Terdapat <?php echo e($errors->count()); ?> kesalahan:</strong>
                    <ul class="mb-0 mt-1 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('register')); ?>" method="POST" id="formRegister" novalidate>
                <?php echo csrf_field(); ?>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold small">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name"
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Nama lengkap Anda"
                               value="<?php echo e(old('name')); ?>"
                               autofocus>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold small">
                        Email <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email"
                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="email@contoh.com"
                               value="<?php echo e(old('email')); ?>">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Nomor Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" name="telepon"
                               class="form-control <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="08xxxxxxxxxx"
                               value="<?php echo e(old('telepon')); ?>"
                               maxlength="15">
                        <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-text">Opsional. Digunakan untuk keperluan kontak.</div>
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Alamat</label>
                    <div class="input-group align-items-start">
                        <span class="input-group-text pt-2"><i class="bi bi-geo-alt"></i></span>
                        <textarea name="alamat" rows="2"
                                  class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  placeholder="Alamat lengkap Anda (opsional)"
                                  maxlength="500"><?php echo e(old('alamat')); ?></textarea>
                        <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-semibold small">
                        Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="passwordInput"
                               class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Minimal 8 karakter">
                        <button class="btn btn-outline-secondary border-start-0"
                                type="button" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mt-2">
                        <div class="d-flex gap-1 mb-1">
                            <div class="strength-bar flex-fill bg-secondary" id="bar1" style="width:0"></div>
                            <div class="strength-bar flex-fill bg-secondary" id="bar2" style="width:0"></div>
                            <div class="strength-bar flex-fill bg-secondary" id="bar3" style="width:0"></div>
                            <div class="strength-bar flex-fill bg-secondary" id="bar4" style="width:0"></div>
                        </div>
                        <div id="strengthText" class="form-text"></div>
                    </div>
                </div>

                
                <div class="mb-4">
                    <label class="form-label fw-semibold small">
                        Konfirmasi Password <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password_confirmation" id="passwordConfirm"
                               class="form-control"
                               placeholder="Ulangi password">
                        <button class="btn btn-outline-secondary border-start-0"
                                type="button" id="toggleConfirm">
                            <i class="bi bi-eye" id="eyeIconConfirm"></i>
                        </button>
                    </div>
                    <div id="matchMsg" class="form-text"></div>
                </div>

                
                <div class="rounded-3 p-3 mb-4 small"
                     style="background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af">
                    <i class="bi bi-info-circle me-2"></i>
                    Akun yang didaftarkan akan memiliki peran sebagai
                    <strong>Anggota</strong> dan mendapatkan nomor anggota secara otomatis.
                </div>

                <button type="submit" class="btn btn-register w-100" id="btnDaftar">
                    <i class="bi bi-person-check me-2"></i>Buat Akun
                </button>
            </form>

            
            <div class="divider my-4">atau</div>
            <div class="text-center small">
                Sudah punya akun?
                <a href="<?php echo e(route('login')); ?>" class="fw-semibold text-decoration-none"
                   style="color:#2563eb">
                    Masuk di sini
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // ── Toggle password visibility ──────────────────────────────────────
    function toggleVis(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
    document.getElementById('togglePassword').addEventListener('click', () => toggleVis('passwordInput', 'eyeIcon'));
    document.getElementById('toggleConfirm').addEventListener('click',  () => toggleVis('passwordConfirm', 'eyeIconConfirm'));

    // ── Password strength ───────────────────────────────────────────────
    const bars = [
        document.getElementById('bar1'),
        document.getElementById('bar2'),
        document.getElementById('bar3'),
        document.getElementById('bar4'),
    ];
    const strengthText = document.getElementById('strengthText');

    function checkStrength(pw) {
        let score = 0;
        if (pw.length >= 8)                    score++;
        if (/[A-Z]/.test(pw))                  score++;
        if (/[0-9]/.test(pw))                  score++;
        if (/[^A-Za-z0-9]/.test(pw))           score++;
        return score;
    }

    const colors  = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
    const labels  = ['Sangat lemah', 'Lemah', 'Cukup kuat', 'Kuat'];

    document.getElementById('passwordInput').addEventListener('input', function () {
        const score = checkStrength(this.value);
        bars.forEach((bar, i) => {
            bar.style.background = i < score ? colors[score - 1] : '#e2e8f0';
        });
        strengthText.textContent = this.value ? labels[score - 1] ?? '' : '';
        strengthText.style.color = score > 0 ? colors[score - 1] : '#94a3b8';
        checkMatch();
    });

    // ── Password match ──────────────────────────────────────────────────
    const matchMsg = document.getElementById('matchMsg');

    function checkMatch() {
        const pw  = document.getElementById('passwordInput').value;
        const cfm = document.getElementById('passwordConfirm').value;
        if (!cfm) { matchMsg.textContent = ''; return; }
        if (pw === cfm) {
            matchMsg.textContent = '✓ Password cocok';
            matchMsg.style.color = '#16a34a';
        } else {
            matchMsg.textContent = '✗ Password tidak cocok';
            matchMsg.style.color = '#dc2626';
        }
    }

    document.getElementById('passwordConfirm').addEventListener('input', checkMatch);

    // ── Cegah submit jika password tidak cocok ──────────────────────────
    document.getElementById('formRegister').addEventListener('submit', function (e) {
        const pw  = document.getElementById('passwordInput').value;
        const cfm = document.getElementById('passwordConfirm').value;
        if (pw !== cfm) {
            e.preventDefault();
            matchMsg.textContent = '✗ Konfirmasi password tidak cocok, periksa kembali.';
            matchMsg.style.color = '#dc2626';
            document.getElementById('passwordConfirm').focus();
        }
    });
    </script>
</body>
</html>
<?php /**PATH C:\Users\aswan\Downloads\perpuss\resources\views/auth/register.blade.php ENDPATH**/ ?>