<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Litera 📚</title>
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
            padding: 1.5rem 1rem;
        }
        .register-wrap {
            width: 100%; max-width: 480px;
            background: #fff;
            border-radius: 1.5rem;
            box-shadow: 0 24px 64px rgba(13,148,136,.3);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #134e4a, #0d9488);
            padding: 2rem 2rem 1.75rem;
            text-align: center;
        }
        .register-header .logo {
            width: 64px; height: 64px;
            background: #f59e0b;
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.75rem; margin: 0 auto .875rem;
            box-shadow: 0 4px 16px rgba(245,158,11,.4);
        }
        .register-header h5 { color: #fff; font-weight: 800; margin: 0; font-size: 1.2rem; }
        .register-header p  { color: rgba(255,255,255,.65); font-size: .82rem; margin: .3rem 0 0; }
        .register-body { padding: 1.75rem 2rem 2rem; }
        .form-label { font-size: .82rem; font-weight: 600; color: #134e4a; }
        .form-control, .form-select, .input-group-text { border-color: #ccfbf1; }
        .form-control:focus, .form-select:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 .2rem rgba(13,148,136,.18);
        }
        .input-group-text { background: #f0fdf9; color: #0d9488; border-right: none; }
        .input-group .form-control { border-left: none; }
        .btn-daftar {
            background: linear-gradient(135deg, #134e4a, #0d9488);
            border: none; color: #fff;
            padding: .75rem; font-weight: 700;
            border-radius: .75rem; font-size: .95rem;
            transition: opacity .2s, transform .1s;
            width: 100%;
        }
        .btn-daftar:hover { opacity: .9; color: #fff; transform: translateY(-1px); }
        .strength-bar { height: 4px; border-radius: 2px; transition: background .3s; }
        .divider {
            display: flex; align-items: center; gap: .75rem;
            color: #94a3b8; font-size: .8rem; margin: 1.25rem 0;
        }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background:#e2e8f0; }
        .alert-danger  { background:#fff1f2; border-color:#fecdd3; color:#9f1239; border-radius:.75rem; }
        .alert-success { background:#f0fdf4; border-color:#bbf7d0; color:#166534; border-radius:.75rem; }
    </style>
</head>
<body>
    <div class="register-wrap">
        <div class="register-header">
            <div class="logo">📚</div>
            <h5>Daftar Akun Baru</h5>
            <p>Buat akun untuk mengakses perpustakaan Litera</p>
        </div>

        <div class="register-body">
            @if($errors->any())
            <div class="alert alert-danger small mb-3">
                ❌ <strong>{{ $errors->count() }} kesalahan:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST" id="formRegister" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">👤 Nama Lengkap <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Nama lengkap Anda"
                               value="{{ old('name') }}" autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">📧 Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="email@contoh.com"
                               value="{{ old('email') }}">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">📱 Nomor Telepon</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                        <input type="text" name="telepon"
                               class="form-control @error('telepon') is-invalid @enderror"
                               placeholder="08xxxxxxxxxx"
                               value="{{ old('telepon') }}" maxlength="15">
                        @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-text" style="color:#94a3b8">Opsional.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">📍 Alamat</label>
                    <div class="input-group align-items-start">
                        <span class="input-group-text pt-2"><i class="bi bi-geo-alt"></i></span>
                        <textarea name="alamat" rows="2"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Alamat lengkap (opsional)"
                                  maxlength="500">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">🔒 Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="passwordInput"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Minimal 6 karakter">
                        <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-1 mt-2">
                        @for($i=1;$i<=4;$i++)
                        <div class="strength-bar flex-fill" id="bar{{$i}}" style="background:#e2e8f0"></div>
                        @endfor
                    </div>
                    <div id="strengthText" class="form-text"></div>
                </div>

                <div class="mb-4">
                    <label class="form-label">🔒 Konfirmasi Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password_confirmation" id="passwordConfirm"
                               class="form-control" placeholder="Ulangi password">
                        <button class="btn btn-outline-secondary border-start-0" type="button" id="toggleConfirm">
                            <i class="bi bi-eye" id="eyeIconConfirm"></i>
                        </button>
                    </div>
                    <div id="matchMsg" class="form-text"></div>
                </div>

                <div class="rounded-3 p-3 mb-4 small" style="background:#f0fdf9;border:1px solid #ccfbf1;color:#0f766e">
                    ℹ️ Akun yang didaftarkan akan memiliki peran sebagai <strong>Anggota</strong>.
                </div>

                <button type="submit" class="btn-daftar">
                    ✨ Buat Akun Sekarang
                </button>
            </form>

            <div class="divider">atau</div>
            <div class="text-center small" style="color:#64748b">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color:#0d9488">
                    Masuk di sini 🚀
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleVis(inputId, iconId) {
        const inp = document.getElementById(inputId);
        const ico = document.getElementById(iconId);
        inp.type = inp.type === 'password' ? 'text' : 'password';
        ico.classList.toggle('bi-eye'); ico.classList.toggle('bi-eye-slash');
    }
    document.getElementById('togglePassword').addEventListener('click', () => toggleVis('passwordInput','eyeIcon'));
    document.getElementById('toggleConfirm').addEventListener('click',  () => toggleVis('passwordConfirm','eyeIconConfirm'));

    const colors = ['#ef4444','#f97316','#eab308','#22c55e'];
    const labels = ['Sangat lemah','Lemah','Cukup kuat','Kuat 💪'];
    const bars   = [1,2,3,4].map(i => document.getElementById('bar'+i));

    document.getElementById('passwordInput').addEventListener('input', function () {
        let s = 0;
        if (this.value.length >= 6)          s++;
        if (/[A-Z]/.test(this.value))        s++;
        if (/[0-9]/.test(this.value))        s++;
        if (/[^A-Za-z0-9]/.test(this.value)) s++;
        bars.forEach((b,i) => b.style.background = i < s ? colors[s-1] : '#e2e8f0');
        const st = document.getElementById('strengthText');
        st.textContent = this.value ? (labels[s-1] ?? '') : '';
        st.style.color = s > 0 ? colors[s-1] : '#94a3b8';
        checkMatch();
    });

    function checkMatch() {
        const pw  = document.getElementById('passwordInput').value;
        const cfm = document.getElementById('passwordConfirm').value;
        const msg = document.getElementById('matchMsg');
        if (!cfm) { msg.textContent = ''; return; }
        msg.textContent = pw === cfm ? '✅ Password cocok' : '❌ Password tidak cocok';
        msg.style.color = pw === cfm ? '#16a34a' : '#dc2626';
    }
    document.getElementById('passwordConfirm').addEventListener('input', checkMatch);

    document.getElementById('formRegister').addEventListener('submit', function(e) {
        const pw  = document.getElementById('passwordInput').value;
        const cfm = document.getElementById('passwordConfirm').value;
        if (pw !== cfm) {
            e.preventDefault();
            const msg = document.getElementById('matchMsg');
            msg.textContent = '❌ Konfirmasi password tidak cocok.';
            msg.style.color = '#dc2626';
            document.getElementById('passwordConfirm').focus();
        }
    });
    </script>
</body>
</html>
