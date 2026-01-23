<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Digital Archive System</title>
    <link rel="icon" href="{{ asset('gambar/lanri.png') }}" type="image/png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary-color: #B7A3E3;
            --primary-gradient: linear-gradient(135deg, #B7A3E3 0%, #9D8BCF 100%);
            --secondary-color: #C8B6E2;
            --accent-color: #D4C5EC;
            --dark-color: #5D4B8C;
            --light-color: #F5F2FF;
            --glass-bg: rgba(255, 255, 255, 0.98);
            --glass-border: rgba(183, 163, 227, 0.2);
            --shadow-light: rgba(183, 163, 227, 0.15);
            --shadow-medium: rgba(183, 163, 227, 0.25);
            --shadow-dark: rgba(93, 75, 140, 0.3);
            --success-color: #8BCA9D;
            --danger-color: #E3A3A3;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #4A376A 0%, #6D5B9E 50%, #9D8BCF 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background Elements */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-particle {
            position: absolute;
            background: var(--accent-color);
            border-radius: 50%;
            animation: float 15s infinite linear;
            opacity: 0.15;
        }

        .bg-particle:nth-child(1) {
            width: 60px;
            height: 60px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
            background: #D4C5EC;
        }

        .bg-particle:nth-child(2) {
            width: 90px;
            height: 90px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
            animation-duration: 20s;
            background: #C8B6E2;
        }

        .bg-particle:nth-child(3) {
            width: 45px;
            height: 45px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
            animation-duration: 25s;
            background: #B7A3E3;
        }

        .bg-particle:nth-child(4) {
            width: 75px;
            height: 75px;
            top: 30%;
            right: 20%;
            animation-delay: 6s;
            background: #9D8BCF;
        }

        /* Main Container */
        .login-container {
            width: 100%;
            max-width: 1000px;
            min-height: 500px;
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow:
                0 15px 40px rgba(93, 75, 140, 0.25),
                0 0 0 1px rgba(183, 163, 227, 0.15);
            position: relative;
            z-index: 1;
            animation: containerAppear 1s ease-out;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
        }

        /* Left Panel - Login Form */
        .login-panel {
            flex: 1;
            padding: 40px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--glass-bg);
            position: relative;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }

        .logo-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            position: relative;
        }

        .logo-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 3s infinite;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #F5F2FF 0%, #E8E2FF 100%);
            border: 3px solid rgba(183, 163, 227, 0.3);
        }

        .logo-img {
            width: 70%;
            height: 70%;
            object-fit: contain;
            position: relative;
            z-index: 1;
        }

        /* Header Text */
        .login-header h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: var(--dark-color);
            font-size: 0.9rem;
            opacity: 0.8;
            max-width: 350px;
            margin: 0 auto;
            line-height: 1.5;
        }

        /* Form Styling */
        .form-container {
            max-width: 350px;
            margin: 0 auto;
            width: 100%;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            color: var(--dark-color);
            font-weight: 500;
            font-size: 0.85rem;
            padding-left: 5px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 16px;
            transition: all 0.3s;
            z-index: 1;
        }

        .form-input {
            width: 100%;
            height: 46px;
            padding: 0 15px 0 45px;
            border: 2px solid #E8E2FF;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: #F9F7FF;
            color: var(--dark-color);
            font-weight: 500;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 3px rgba(183, 163, 227, 0.2);
            transform: translateY(-1px);
        }

        .form-input:focus+.input-icon {
            color: var(--dark-color);
            transform: translateY(-50%) scale(1.05);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-color);
            opacity: 0.5;
            cursor: pointer;
            transition: all 0.3s;
            z-index: 1;
            font-size: 16px;
        }

        .password-toggle:hover {
            opacity: 1;
            color: var(--primary-color);
        }

        /* Remember Me & Forgot Password */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #D1C7EC;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .custom-checkbox.checked {
            background: var(--primary-gradient);
            border-color: var(--primary-color);
        }

        .custom-checkbox.checked::after {
            content: '✓';
            color: white;
            font-size: 11px;
            font-weight: bold;
        }

        .remember-me span {
            color: var(--dark-color);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .forgot-password {
            color: var(--dark-color);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            height: 46px;
            background: var(--primary-gradient);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(183, 163, 227, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.7s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-icon {
            font-size: 16px;
            transition: transform 0.3s;
        }

        .btn-login:hover .btn-icon {
            transform: translateX(4px);
        }

        /* Right Panel - Info Section */
        .info-panel {
            flex: 0.8;
            background: var(--primary-gradient);
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .info-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.08)"/></svg>');
            animation: panelFloat 20s infinite linear;
        }

        .info-content {
            max-width: 350px;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .info-icon {
            font-size: 60px;
            margin-bottom: 20px;
            animation: float 6s ease-in-out infinite;
            color: rgba(255, 255, 255, 0.9);
            filter: drop-shadow(0 4px 10px rgba(93, 75, 140, 0.3));
        }

        /* Info Panel Text */
        .info-content h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 15px;
            line-height: 1.3;
            text-shadow: 0 2px 5px rgba(93, 75, 140, 0.3);
        }

        .info-content p {
            font-size: 0.9rem;
            line-height: 1.6;
            opacity: 0.95;
            margin-bottom: 20px;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 20px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 12px;
            border-radius: 8px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-icon {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-text {
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.5s ease-out;
            border-left: 3px solid transparent;
            font-size: 0.85rem;
            display: none;
        }

        .alert.alert-backend {
            display: flex !important;
        }

        .alert-success {
            background: rgba(139, 202, 157, 0.15);
            border-color: #8BCA9D;
            color: #5D8C6B;
        }

        .alert-error {
            background: rgba(227, 163, 163, 0.15);
            border-color: var(--danger-color);
            color: #9D6B6B;
        }

        /* Animations */
        @keyframes containerAppear {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        @keyframes panelFloat {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(-50%, -50%);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .login-container {
                max-width: 95%;
                min-height: 450px;
            }

            .login-panel {
                padding: 35px 30px;
            }

            .info-panel {
                padding: 35px 25px;
            }
        }

        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
                min-height: auto;
            }

            .info-panel {
                order: -1;
                padding: 30px 25px;
                min-height: 220px;
                background: linear-gradient(135deg, #9D8BCF 0%, #B7A3E3 100%);
            }

            .login-panel {
                padding: 35px 25px;
            }

            .info-content h2 {
                font-size: 1.4rem;
            }

            .login-header h1 {
                font-size: 1.6rem;
            }

            .logo-container {
                width: 60px;
                height: 60px;
                margin-bottom: 15px;
            }
        }

        @media (max-width: 768px) {

            /* Sembunyikan logo, judul, dan subjudul di mobile */
            .logo-container,
            .login-header h1 {
                display: none;
            }

            /* Teks lebih kecil untuk mobile */
            .form-label {
                font-size: 12px !important;
            }

            .form-input {
                font-size: 13px !important;
                height: 44px;
                padding-left: 40px;
            }

            .input-icon {
                font-size: 14px;
                left: 12px;
            }

            .btn-login {
                font-size: 13px !important;
                height: 44px;
            }

            .alert {
                font-size: 12px !important;
                padding: 10px 12px;
            }

            .info-content h2 {
                font-size: 1.3rem;
            }

            .info-content p {
                font-size: 13px;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 12px;
            }

            .login-container {
                border-radius: 14px;
            }

            .login-panel {
                padding: 25px 20px;
            }

            .info-panel {
                padding: 25px 20px;
                min-height: 200px;
            }

            /* Pastikan elemen tetap tersembunyi di mobile */
            .logo-container,
            .login-header h1 {
                display: none;
            }

            /* Teks lebih kecil untuk mobile */
            .form-label {
                font-size: 11px !important;
            }

            .form-input {
                font-size: 12px !important;
                height: 42px;
                padding-left: 38px;
            }

            .input-icon {
                font-size: 13px;
            }

            .btn-login {
                font-size: 12px !important;
                height: 42px;
            }

            .alert {
                font-size: 11px !important;
                padding: 8px 10px;
            }

            .info-content h2 {
                font-size: 1.2rem;
            }

            .info-content p {
                font-size: 12px;
            }

            .info-icon {
                font-size: 50px;
            }
        }

        @media (max-width: 380px) {
            .login-panel {
                padding: 20px 15px;
            }

            .info-panel {
                padding: 20px 15px;
            }

            /* Pastikan elemen tetap tersembunyi di mobile sangat kecil */
            .logo-container,
            .login-header h1 {
                display: none;
            }

            /* Teks lebih kecil untuk mobile sangat kecil */
            .form-label {
                font-size: 10px !important;
            }

            .form-input {
                font-size: 11px !important;
                height: 40px;
                padding-left: 36px;
            }

            .input-icon {
                font-size: 12px;
            }

            .btn-login {
                font-size: 11px !important;
                height: 40px;
            }

            .alert {
                font-size: 10px !important;
                padding: 6px 8px;
            }

            .form-group {
                margin-bottom: 14px;
            }

            .info-content h2 {
                font-size: 1.1rem;
            }

            .info-content p {
                font-size: 11px;
            }
        }

        /* Loading animation */
        .btn-loading {
            position: relative;
            color: transparent;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Error Animation */
        .error-shake {
            animation: shake 0.5s;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-4px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(4px);
            }
        }

        /* Backend error message */
        .backend-error {
            color: #E3A3A3;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }

        /* Additional styling for better mobile touch targets */
        @media (max-width: 768px) {

            .form-input,
            .btn-login {
                min-height: 44px;
            }
        }
    </style>
</head>

<body>
    <!-- Background Elements -->
    <div class="bg-elements">
        <div class="bg-particle"></div>
        <div class="bg-particle"></div>
        <div class="bg-particle"></div>
        <div class="bg-particle"></div>
    </div>

    <!-- Main Container -->
    <div class="login-container">
        <!-- Left Panel - Login Form -->
        <div class="login-panel">
            <!-- Header -->
            <div class="login-header">
                <div class="logo-container">
                    <div class="logo-circle">
                        <img src="{{ asset('gambar/lanri.png') }}" alt="LAN Logo" class="logo-img">
                    </div>
                </div>
                <h1>Digital Archive System</h1>
            </div>

            <!-- Alert Messages -->
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

            <!-- Login Form -->
            <div class="form-container">
                <form id="loginForm" action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <!-- Email Input -->
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-input" id="email" name="email" placeholder="nama@lan.go.id"
                                value="{{ old('email') }}" required>
                        </div>
                        <div class="backend-error" id="emailError"></div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label class="form-label" for="password">Kata Sandi</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-input" id="password" name="password"
                                placeholder="Masukkan kata sandi Anda" required>
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        <div class="backend-error" id="passwordError"></div>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt btn-icon"></i>
                        <span id="btnText">Masuk</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Panel - Info Section -->
        <div class="info-panel">
            <div class="info-content">
                <i class="fas fa-archive info-icon"></i>
                <h2>Secure Digital Archive Management</h2>
                <p>Platform terintegrasi untuk penyimpanan, manajemen, dan akses dokumen digital dengan keamanan tingkat
                    tinggi.</p>

                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <span class="feature-text">Keamanan Data</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-search feature-icon"></i>
                        <span class="feature-text">Pencarian Cepat</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-cloud feature-icon"></i>
                        <span class="feature-text">Cloud Storage</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users feature-icon"></i>
                        <span class="feature-text">Kolaborasi Tim</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elements
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');

            // Toggle Password Visibility
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Reset loading state jika halaman di-refresh dengan error
            loginBtn.disabled = false;
            btnText.textContent = 'Masuk';
            loginBtn.classList.remove('btn-loading');

            // Form Validation
            loginForm.addEventListener('submit', function (e) {
                const email = document.getElementById('email').value;
                const password = passwordInput.value;

                // Sembunyikan alert frontend sebelumnya
                successAlert.style.display = 'none';
                errorAlert.style.display = 'none';

                // Validasi email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    errorMessage.textContent = 'Format email institusi tidak valid!';
                    errorAlert.style.display = 'flex';
                    document.getElementById('email').classList.add('error-shake');
                    setTimeout(() => {
                        document.getElementById('email').classList.remove('error-shake');
                    }, 500);
                    return;
                }

                // Validasi password
                if (password.length < 3) {
                    e.preventDefault();
                    errorMessage.textContent = 'Password harus minimal 3 karakter!';
                    errorAlert.style.display = 'flex';
                    document.getElementById('password').classList.add('error-shake');
                    setTimeout(() => {
                        document.getElementById('password').classList.remove('error-shake');
                    }, 500);
                    return;
                }

                // Jika validasi frontend lolos, biarkan form submit ke backend
                // Tampilkan loading state
                loginBtn.disabled = true;
                btnText.textContent = 'Memproses...';
                loginBtn.classList.add('btn-loading');
            });

            // Validasi real-time untuk email
            document.getElementById('email').addEventListener('blur', function () {
                const email = this.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email && !emailRegex.test(email)) {
                    this.style.borderColor = '#E3A3A3';
                } else {
                    this.style.borderColor = '#E8E2FF';
                }
            });

            // Validasi real-time untuk password
            document.getElementById('password').addEventListener('input', function () {
                if (this.value.length > 0 && this.value.length < 3) {
                    this.style.borderColor = '#E3A3A3';
                } else {
                    this.style.borderColor = '#E8E2FF';
                }
            });

            // Auto-hide alerts setelah beberapa detik - HANYA untuk alert frontend
            const frontendAlerts = document.querySelectorAll('#successAlert, #errorAlert');
            frontendAlerts.forEach(alert => {
                if (alert.style.display !== 'none' && !alert.classList.contains('alert-backend')) {
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 5000);
                }
            });

            // Touch optimization for mobile
            if ('ontouchstart' in window) {
                document.querySelectorAll('.form-input, .btn-login').forEach(element => {
                    element.style.minHeight = '44px';
                });
            }

            // Add hover effects to input fields
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('mouseenter', function () {
                    this.style.borderColor = '#D1C7EC';
                });

                input.addEventListener('mouseleave', function () {
                    if (!this.matches(':focus')) {
                        this.style.borderColor = '#E8E2FF';
                    }
                });
            });
        });
    </script>
</body>

</html>