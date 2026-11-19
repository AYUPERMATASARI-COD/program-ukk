<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Parkir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --ink: #10234f;
            --blue: #2f67e8;
            --teal: #0d827b;
            --paper: #f7f9fc;
            --line: #e2e8f0;
        }

        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: #eef3f8;
            background-image: linear-gradient(rgba(16, 35, 79, .035) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(16, 35, 79, .035) 1px, transparent 1px);
            background-size: 28px 28px;
        }
        .login-card {
            width: 100%;
            max-width: 1080px;
            border: none;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 28px 80px rgba(16, 35, 79, .18), 0 4px 16px rgba(16, 35, 79, .06);
        }
        .login-brand {
            min-height: 590px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(150deg, #10234f 0%, #2455c5 58%, #0d827b 120%);
            color: #fff;
            padding: 3.25rem;
        }
        .login-brand::before,
        .login-brand::after {
            content: '';
            position: absolute;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 50%;
        }
        .login-brand::before { width: 370px; height: 370px; right: -145px; top: -130px; box-shadow: 0 0 0 28px rgba(255,255,255,.025), 0 0 0 56px rgba(255,255,255,.025); }
        .login-brand::after { width: 470px; height: 470px; left: -275px; bottom: -300px; }
        .brand-content { position: relative; z-index: 1; }
        .brand-kicker {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 10px;
            background: rgba(255,255,255,.1);
            padding: .55rem .75rem;
            color: rgba(255,255,255,.85);
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }
        .brand-mark {
            width: 58px;
            height: 58px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 16px;
            background: rgba(255,255,255,.12);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 12px 24px rgba(2, 6, 23, .14);
        }
        .brand-title { max-width: 430px; font-family: 'Space Grotesk', sans-serif; font-size: clamp(2.15rem, 4vw, 3.45rem); line-height: 1.04; font-weight: 700; letter-spacing: -.045em; }
        .login-brand p { max-width: 340px; color: rgba(255,255,255,.7) !important; line-height: 1.7; }
        .login-form { background: var(--paper); padding: 4rem 4.25rem; display: flex; flex-direction: column; justify-content: center; }
        .login-form h1 { max-width: 430px; color: var(--ink); font-family: 'Space Grotesk', sans-serif; font-size: clamp(1.8rem, 3vw, 2.35rem); line-height: 1.12; font-weight: 700; letter-spacing: -.04em; }
        .form-label { color: #334155; font-size: .86rem; font-weight: 700; }
        .input-group-text,
        .form-control { border-color: var(--line); background: #fff; padding: .9rem 1rem; }
        .input-group-text { color: var(--blue); min-width: 46px; justify-content: center; }
        .form-control:focus { border-color: var(--blue); box-shadow: 0 0 0 .22rem rgba(47,103,232,.13); }
        .password-toggle { border-color: var(--line); color: #64748b; background: #fff; padding-inline: 1rem; }
        .password-toggle:hover { color: var(--blue); background: #eff6ff; }
        .btn-login {
            border: 0;
            border-radius: 10px;
            background: var(--ink);
            color: #fff;
            padding: .9rem 1rem;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(16,35,79,.2);
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .btn-login:hover { color: #fff; background: var(--blue); transform: translateY(-2px); box-shadow: 0 14px 24px rgba(47,103,232,.24); }
        .login-note { color: #64748b; font-size: .82rem; }
        .parking-scene {
            display: flex;
            gap: .65rem;
            margin: 2.5rem 0 2rem;
            transform: rotate(-3deg);
        }
        .parking-slot {
            position: relative;
            width: 82px;
            height: 112px;
            border: 1px solid rgba(255,255,255,.25);
            border-bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .parking-slot::before {
            content: '';
            position: absolute;
            top: 8px;
            width: 30px;
            height: 4px;
            border-radius: 4px;
            background: rgba(255,255,255,.5);
        }
        .parking-car {
            display: grid;
            place-items: center;
            width: 40px;
            height: 58px;
            border-radius: 13px 13px 9px 9px;
            background: #fbbf24;
            color: #172554;
            box-shadow: 0 8px 12px rgba(2,6,23,.2);
            animation: carPulse 3s ease-in-out infinite;
        }
        .parking-car i { font-size: 1.45rem; }
        .parking-slot:nth-child(2) .parking-car { background: #f8fafc; animation-delay: .35s; }
        .parking-slot:nth-child(3) .parking-car { background: #5eead4; animation-delay: .7s; }
        .login-form { animation: formRise .55s ease-out both; }
        @keyframes carPulse { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
        @keyframes formRise { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .login-status { color: #047857; font-size: .78rem; font-weight: 700; }
        .login-status i { font-size: .55rem; vertical-align: middle; }
        @media (max-width: 767px) {
            body { padding: .75rem; }
            .login-card { border-radius: 20px; }
            .login-brand { min-height: auto; padding: 2.25rem 2rem 2rem; }
            .login-brand .brand-mark { margin-bottom: 1rem; }
            .brand-title { font-size: 2.35rem; }
            .parking-scene { margin: 1.75rem 0 1.5rem; }
            .login-form { padding: 2.5rem 2rem; }
        }
    </style>
</head>
<body>

    <div class="card login-card">
        <div class="row g-0">
            <div class="col-md-5 login-brand d-flex align-items-end">
                <div class="brand-content">
                    <span class="brand-mark"><i class="bi bi-p-square-fill"></i></span>
                    <div class="brand-kicker mb-3"><i class="bi bi-broadcast-pin"></i> Sistem Parkir</div>
                    <div class="brand-title mb-3">Parkir lebih tertib, setiap hari.</div>
                    <p class="mb-0 text-white-50">Kelola kendaraan, transaksi, dan area parkir dari satu sistem.</p>
                    <div class="parking-scene" aria-hidden="true">
                        <div class="parking-slot"><div class="parking-car"><i class="bi bi-car-front-fill"></i></div></div>
                        <div class="parking-slot"><div class="parking-car"><i class="bi bi-car-front-fill"></i></div></div>
                        <div class="parking-slot"><div class="parking-car"><i class="bi bi-car-front-fill"></i></div></div>
                    </div>
                    <div class="small text-white-50"><i class="bi bi-shield-check me-1"></i> Akses aman untuk operasional harian</div>
                </div>
            </div>

            <div class="col-md-7 login-form">
                <div class="mb-4">
                    <h1 class="mb-2">Selamat Datang Di Parkir KABASA</h1>
                    <p class="login-note mb-0">Masuk untuk melanjutkan ke panel sistem parkir.</p>
                    <div class="login-status mt-3"><i class="bi bi-circle-fill me-1"></i> Sistem siap digunakan</div>
                </div>

            {{-- Pesan Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="username" value="{{ old('username', '') }}"
                               class="form-control" placeholder="Masukkan username" autocomplete="off" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password"
                               id="password" class="form-control" placeholder="Masukkan password" autocomplete="off" required>
                        <button type="button" class="btn password-toggle" id="togglePassword" aria-label="Tampilkan password" title="Tampilkan password">
                            <i class="bi bi-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-login w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const passwordIcon = document.getElementById('passwordIcon');

        togglePassword.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            passwordIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
            togglePassword.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
            togglePassword.setAttribute('title', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>
</body>
</html>