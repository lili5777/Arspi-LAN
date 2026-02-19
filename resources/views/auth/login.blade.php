<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Digital Archive System</title>
    <link rel="icon" href="{{ asset('gambar/lanri.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --violet-deep:   #3B1F6A;
            --violet-mid:    #6B46C1;
            --violet-bright: #8B5CF6;
            --violet-light:  #C4B5FD;
            --violet-pale:   #EDE9FE;
            --violet-ghost:  #F5F3FF;
            --white:         #FFFFFF;
            --ink:           #1E1333;
            --muted:         #7C6FA0;
            --border:        rgba(139,92,246,0.15);
            --glass:         rgba(255,255,255,0.72);
            --success:       #059669;
            --error:         #DC2626;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--violet-deep);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ── Layered background ── */
        .bg-canvas {
            position: fixed; inset: 0; z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% -10%, #6B46C1 0%, transparent 55%),
                radial-gradient(ellipse 60% 50% at 90% 110%, #8B5CF6 0%, transparent 50%),
                linear-gradient(160deg, #1E0A3C 0%, #3B1F6A 45%, #2D1558 100%);
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.35;
            animation: drift var(--dur, 18s) ease-in-out infinite alternate;
        }
        .orb-1 { width: 380px; height: 380px; background: #7C3AED; top: -80px; left: -100px; --dur: 22s; }
        .orb-2 { width: 280px; height: 280px; background: #A78BFA; bottom: -60px; right: -60px; --dur: 17s; animation-delay: -8s; }
        .orb-3 { width: 180px; height: 180px; background: #C4B5FD; top: 50%; right: 15%; --dur: 13s; animation-delay: -4s; }

        @keyframes drift {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(40px, 30px) scale(1.08); }
        }

        /* Dot grid texture */
        .dot-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image: radial-gradient(circle, rgba(196,181,253,0.18) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        /* ── Shell ── */
        .shell {
            position: relative; z-index: 1;
            width: 100%; max-width: 980px;
            display: grid;
            grid-template-columns: 1fr 420px;
            min-height: 560px;
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 40px 80px rgba(0,0,0,0.45),
                0 0 0 1px rgba(196,181,253,0.12),
                inset 0 1px 0 rgba(255,255,255,0.08);
            animation: rise 0.9s cubic-bezier(0.22,1,0.36,1) both;
            margin: 20px;
        }

        @keyframes rise {
            from { opacity:0; transform: translateY(32px) scale(0.97); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        /* ── Left: Hero panel ── */
        .hero {
            background: linear-gradient(145deg, rgba(107,70,193,0.55) 0%, rgba(59,31,106,0.8) 100%);
            backdrop-filter: blur(12px);
            padding: 60px 52px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 1px solid rgba(196,181,253,0.12);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C4B5FD' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-top { position: relative; }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 56px;
        }

        .brand-logo {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            padding: 6px;
            backdrop-filter: blur(6px);
        }

        .brand-logo img {
            width: 100%; height: 100%;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .brand-text {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255,255,255,0.7);
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }

        .hero-title span {
            background: linear-gradient(90deg, #C4B5FD, #F0ABFC);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            color: rgba(196,181,253,0.85);
            font-size: 15px;
            line-height: 1.7;
            max-width: 320px;
            font-weight: 300;
        }

        .hero-features {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 48px;
        }

        .feat {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(196,181,253,0.14);
            border-radius: 12px;
            padding: 12px 14px;
            backdrop-filter: blur(4px);
            transition: background 0.3s, border-color 0.3s;
        }

        .feat:hover {
            background: rgba(255,255,255,0.1);
            border-color: rgba(196,181,253,0.28);
        }

        .feat-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, rgba(139,92,246,0.5), rgba(167,139,250,0.3));
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            color: #C4B5FD;
            flex-shrink: 0;
        }

        .feat-label {
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.8);
        }

        /* ── Right: Form panel ── */
        .form-panel {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(20px);
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--violet-bright);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-eyebrow::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 2px;
            background: var(--violet-bright);
            border-radius: 2px;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.03em;
            line-height: 1.2;
        }

        .form-subtitle {
            margin-top: 8px;
            font-size: 14px;
            color: var(--muted);
            font-weight: 300;
        }

        /* Alerts */
        .alert {
            display: none;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 16px;
            border-radius: 12px;
            font-size: 13.5px;
            font-weight: 400;
            margin-bottom: 24px;
            border: 1px solid transparent;
            animation: alertIn 0.4s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes alertIn {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .alert.show, .alert.alert-backend { display: flex !important; }

        .alert-success {
            background: #ECFDF5;
            border-color: #A7F3D0;
            color: #065F46;
        }

        .alert-error {
            background: #FEF2F2;
            border-color: #FECACA;
            color: #991B1B;
        }

        .alert i { margin-top: 2px; flex-shrink: 0; }

        /* Fields */
        .field { margin-bottom: 22px; }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 8px;
            letter-spacing: 0.01em;
        }

        .field-wrap { position: relative; }

        .field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--violet-light);
            font-size: 15px;
            transition: color 0.2s;
            pointer-events: none;
        }

        .field-input {
            width: 100%;
            height: 50px;
            padding: 0 48px 0 46px;
            border: 1.5px solid #E4DEFF;
            border-radius: 14px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            color: var(--ink);
            background: #FAFAFE;
            transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
            outline: none;
        }

        .field-input::placeholder { color: #B5AACF; }

        .field-input:focus {
            border-color: var(--violet-bright);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(139,92,246,0.1);
        }

        .field-input:focus ~ .field-icon,
        .field-wrap:focus-within .field-icon {
            color: var(--violet-mid);
        }

        .field-input.is-invalid { border-color: var(--error) !important; box-shadow: 0 0 0 4px rgba(220,38,38,0.1) !important; }

        .toggle-pw {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #B5AACF;
            font-size: 15px;
            cursor: pointer;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
        }

        .toggle-pw:hover { color: var(--violet-mid); }

        /* Remember + Forgot row */
        .field-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            margin-top: -8px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .chk-box {
            width: 18px; height: 18px;
            border: 1.5px solid #C4B5FD;
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            font-size: 10px;
            color: #fff;
            flex-shrink: 0;
        }

        .chk-box.on {
            background: var(--violet-bright);
            border-color: var(--violet-bright);
        }

        .remember-label { font-size: 13px; color: var(--muted); font-weight: 400; }

        .forgot {
            font-size: 13px;
            font-weight: 500;
            color: var(--violet-bright);
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot:hover { color: var(--violet-deep); text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, var(--violet-mid) 0%, var(--violet-bright) 100%);
            border: none;
            border-radius: 14px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            position: relative;
            overflow: hidden;
            letter-spacing: 0.01em;
        }

        .btn-submit::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(107,70,193,0.38);
        }

        .btn-submit:hover::after { opacity: 1; }

        .btn-submit:active { transform: translateY(0); box-shadow: none; }

        .btn-submit:disabled {
            opacity: 0.75;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-arrow { transition: transform 0.25s; }
        .btn-submit:hover .btn-arrow { transform: translateX(4px); }

        /* Loading spinner */
        .spinner {
            width: 18px; height: 18px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .btn-submit.loading .spinner { display: block; }
        .btn-submit.loading .btn-label,
        .btn-submit.loading .btn-arrow { opacity: 0; }

        /* Shake animation */
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20%,60%  { transform: translateX(-5px); }
            40%,80%  { transform: translateX(5px); }
        }

        .shake { animation: shake 0.5s ease-out; }

        /* ── Responsive ── */
        @media (max-width: 860px) {
            .shell {
                grid-template-columns: 1fr;
                max-width: 460px;
            }

            .hero {
                padding: 36px 36px 32px;
                border-right: none;
                border-bottom: 1px solid rgba(196,181,253,0.12);
            }

            .hero-title { font-size: 1.8rem; }
            .hero-features { margin-top: 28px; }
            .brand { margin-bottom: 28px; }
            .form-panel { padding: 44px 36px; }
        }

        @media (max-width: 500px) {
            .shell { margin: 12px; border-radius: 20px; }
            .hero { padding: 28px 24px; }
            .form-panel { padding: 32px 24px; }
            .form-title { font-size: 1.6rem; }
            .hero-title { font-size: 1.5rem; }
            .hero-features { grid-template-columns: 1fr 1fr; gap: 8px; }
            .feat { padding: 10px 10px; }
        }
    </style>
</head>
<body>

    <div class="bg-canvas">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="dot-grid"></div>

    <div class="shell">

        <!-- Left: Hero -->
        <div class="hero">
            <div class="hero-top">
                <div class="brand">
                    <div class="brand-logo">
                        <img src="{{ asset('gambar/lanri.png') }}" alt="LAN Logo">
                    </div>
                    <span class="brand-text">LAN RI</span>
                </div>

                <h1 class="hero-title">
                    Sistem  Management <span>Pengarsipan</span> Digital
                </h1>
                <p class="hero-desc">
                    Platform terintegrasi untuk penyimpanan, pengelolaan, dan akses dokumen digital lembaga secara aman dan efisien.
                </p>
            </div>

            <div class="hero-features">
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-shield-alt"></i></div>
                    <span class="feat-label">Keamanan Data</span>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-search"></i></div>
                    <span class="feat-label">Pencarian Cepat</span>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <span class="feat-label">Cloud Storage</span>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-users"></i></div>
                    <span class="feat-label">Kolaborasi Tim</span>
                </div>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="form-panel">
            <div class="form-header">
                <div class="form-eyebrow">SIMPADI</div>
                <h2 class="form-title">Selamat Datang</h2>
                {{-- <p class="form-subtitle">Gunakan kredensial institusi Anda</p> --}}
            </div>

            <!-- Alerts -->
            <div class="alert alert-success" id="successAlert">
                <i class="fas fa-check-circle"></i>
                <span>Login berhasil! Mengarahkan ke dashboard...</span>
            </div>

            <div class="alert alert-error" id="errorAlert">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorMessage"></span>
            </div>

            @if(session('error'))
                <div class="alert alert-error alert-backend">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form id="loginForm" action="{{ route('login.submit') }}" method="POST" novalidate>
                @csrf

                <div class="field">
                    <label class="field-label" for="email">Alamat Email</label>
                    <div class="field-wrap">
                        <input
                            type="email"
                            class="field-input"
                            id="email"
                            name="email"
                            placeholder="nama@lan.go.id"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                        >
                        <i class="fas fa-envelope field-icon"></i>
                    </div>
                </div>

                <div class="field">
                    <label class="field-label" for="password">Kata Sandi</label>
                    <div class="field-wrap">
                        <input
                            type="password"
                            class="field-input"
                            id="password"
                            name="password"
                            placeholder="Masukkan kata sandi"
                            required
                            autocomplete="current-password"
                        >
                        <i class="fas fa-lock field-icon"></i>
                        <button type="button" class="toggle-pw" id="togglePassword" tabindex="-1" aria-label="Toggle password">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="field-meta">
                    <label class="remember" id="rememberLabel">
                        <div class="chk-box" id="chkBox"></div>
                        <input type="checkbox" name="remember" id="rememberInput" style="display:none">
                        <span class="remember-label">Ingat saya</span>
                    </label>
                    <a href="#" class="forgot">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="btn-submit" id="loginBtn">
                    <div class="spinner"></div>
                    <span class="btn-label">Masuk</span>
                    <i class="fas fa-arrow-right btn-arrow"></i>
                </button>
            </form>
        </div>

    </div>

    <script>
    (function () {
        const form        = document.getElementById('loginForm');
        const loginBtn    = document.getElementById('loginBtn');
        const emailInput  = document.getElementById('email');
        const pwInput     = document.getElementById('password');
        const togglePw    = document.getElementById('togglePassword');
        const eyeIcon     = document.getElementById('eyeIcon');
        const successAl   = document.getElementById('successAlert');
        const errorAl     = document.getElementById('errorAlert');
        const errorMsg    = document.getElementById('errorMessage');
        const chkBox      = document.getElementById('chkBox');
        const rememberIn  = document.getElementById('rememberInput');
        const rememberLbl = document.getElementById('rememberLabel');

        /* -- Toggle password visibility -- */
        togglePw.addEventListener('click', function () {
            const isPassword = pwInput.type === 'password';
            pwInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        /* -- Custom checkbox -- */
        rememberLbl.addEventListener('click', function (e) {
            if (e.target === rememberIn) return;
            const val = !rememberIn.checked;
            rememberIn.checked = val;
            chkBox.classList.toggle('on', val);
            chkBox.innerHTML = val ? '✓' : '';
        });

        /* -- Helper: show error alert -- */
        function showError(msg, inputEl) {
            errorMsg.textContent = msg;
            errorAl.style.display = 'flex';
            errorAl.classList.remove('show');
            void errorAl.offsetWidth;
            errorAl.classList.add('show');
            if (inputEl) {
                inputEl.classList.add('is-invalid');
                inputEl.classList.add('shake');
                inputEl.addEventListener('animationend', () => inputEl.classList.remove('shake'), { once: true });
                inputEl.focus();
            }
        }

        function clearErrors() {
            errorAl.style.display = 'none';
            successAl.style.display = 'none';
            emailInput.classList.remove('is-invalid');
            pwInput.classList.remove('is-invalid');
        }

        /* -- Real-time border feedback -- */
        emailInput.addEventListener('input', function () {
            if (this.classList.contains('is-invalid') && this.value) this.classList.remove('is-invalid');
        });

        pwInput.addEventListener('input', function () {
            if (this.classList.contains('is-invalid') && this.value) this.classList.remove('is-invalid');
        });

        /* -- Form submit -- */
        form.addEventListener('submit', function (e) {
            clearErrors();

            const email    = emailInput.value.trim();
            const password = pwInput.value;
            const emailRx  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email) {
                e.preventDefault();
                showError('Email tidak boleh kosong.', emailInput);
                return;
            }

            if (!emailRx.test(email)) {
                e.preventDefault();
                showError('Format email tidak valid.', emailInput);
                return;
            }

            if (password.length < 3) {
                e.preventDefault();
                showError('Kata sandi minimal 3 karakter.', pwInput);
                return;
            }

            /* Validasi lolos — loading state */
            loginBtn.disabled = true;
            loginBtn.classList.add('loading');
        });

    })();
    </script>

</body>
</html>