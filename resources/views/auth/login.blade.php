<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Litera 📚</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #134e4a 0%, #0d9488 50%, #f59e0b 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 1rem;
        }
        .login-wrap {
            width: 100%; max-width: 420px;
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 24px 64px rgba(13,148,136,.3);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #134e4a, #0d9488);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
        }
        .login-header .logo {
            width: 68px; height: 68px;
            background: #f59e0b;
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; margin: 0 auto 1rem;
            box-shadow: 0 4px 16px rgba(245,158,11,.4);
        }
        .login-header h4 { color: #fff; font-weight: 800; margin: 0; font-size: 1.4rem; }
        .login-header p  { color: rgba(255,255,255,.65); font-size: .85rem; margin: .3rem 0 0; }
        .login-body { padding: 2rem; }
        .form-label { font-size: .82rem; font-weight: 600; color: #134e4a; }
        .form-control, .input-group-text {
            border-color: #ccfbf1;
        }
        .form-control:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 .2rem rgba(13,148,136,.18);
        }
        .input-group-text {
            background: #f0fdf9; color: #0d9488; border-right: none;
        }
        .input-group .form-control { border-left: none; }
        .btn-masuk {
            background: linear-gradient(135deg, #134e4a, #0d9488);
            border: none; color: #fff;
            padding: .75rem; font-weight: 700;
            border-radius: .75rem; font-size: .95rem;
            transition: opacity .2s, transform .1s;
            width: 100%;
        }
        .btn-masuk:hover { opacity: .9; color: #fff; transform: translateY(-1px); }
        .divider {
            display: flex; align-items: center; gap: .75rem;
            color: #94a3b8; font-size: .8rem; margin: 1.25rem 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e2e8f0;
        }
        .alert-danger  { background: #fff1f2; border-color: #fecdd3; color: #9f1239; border-radius: .75rem; }
        .alert-success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; border-radius: .75rem; }
    </style>
</head>
<body>
    <div class="login-wrap">
        <div class="login-header">
            <div class="logo">📚</div>
            <h4>Litera</h4>
            <p>Sistem Perpustakaan Digital</p>
        </div>

        <div class="login-body">
            @if($errors->any())
            <div class="alert alert-danger small mb-3">
                ❌ {{ $errors->first() }}
            </div>
            @endif
            @if(session('success'))
            <div class="alert alert-success small mb-3">
                ✅ {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">📧 Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@contoh.com"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">🔒 Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="pwInput"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePw">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                               style="border-color:#0d9488">
                        <label class="form-check-label small" for="remember" style="color:#64748b">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn-masuk">
                    🚀 Masuk Sekarang
                </button>
            </form>

            <div class="divider">atau</div>

            <div class="text-center small" style="color:#64748b">
                Belum punya akun?
                <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color:#0d9488">
                    Daftar di sini ✨
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePw').addEventListener('click', function () {
            const inp  = document.getElementById('pwInput');
            const icon = document.getElementById('eyeIcon');
            if (inp.type === 'password') {
                inp.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                inp.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    </script>
</body>
</html>
