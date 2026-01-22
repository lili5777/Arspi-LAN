<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Digital Archive System')</title>
    <link rel="icon" href="{{ asset('gambar/lanri.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @stack('styles')

    <style>
        :root {
            --primary-color: #296374;
            --primary-gradient: linear-gradient(135deg, #296374 0%, #3a7a8c 100%);
            --secondary-color: #00b4d8;
            --accent-color: #90e0ef;
            --dark-color: #1a3a4a;
            --light-color: #f8f9fa;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.12);
            --shadow-light: rgba(41, 99, 116, 0.15);
            --shadow-medium: rgba(41, 99, 116, 0.25);
            --success-color: #2a9d8f;
            --danger-color: #e63946;
            --warning-color: #f4a261;
            --purple-color: #9d4edd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a1929 0%, #1a3a4a 50%, #296374 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Background Effects */
        .bg-effects {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-gradient {
            position: absolute;
            width: 800px;
            height: 800px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 180, 216, 0.15) 0%, rgba(0, 180, 216, 0) 70%);
            filter: blur(60px);
            animation: float 20s infinite ease-in-out;
        }

        .bg-gradient:nth-child(1) {
            top: -300px;
            right: -200px;
            animation-delay: 0s;
        }

        .bg-gradient:nth-child(2) {
            bottom: -400px;
            left: -200px;
            background: radial-gradient(circle, rgba(144, 224, 239, 0.1) 0%, rgba(144, 224, 239, 0) 70%);
            animation-delay: 5s;
        }

        /* Main Content Area */
        .main-content {
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .content-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Dashboard */
        .dashboard-header {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border-radius: 24px;
            padding: 25px 35px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--glass-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .dashboard-header:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
            opacity: 0.7;
        }

        .header-left h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #90e0ef 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .header-left p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
        }

        .user-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            margin-bottom: 4px;
        }

        .user-details span {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
            display: block;
        }

        .user-role {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--secondary-color);
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 180, 216, 0.3);
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Section Styling */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            padding: 0 10px;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: white;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
        }

        .btn-primary-action {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(41, 99, 116, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-primary-action:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 15px 35px rgba(41, 99, 116, 0.4);
        }

        .btn-primary-action:active {
            transform: translateY(-1px);
        }

        .btn-secondary-action {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 14px 24px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-secondary-action:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(120deg);
            }

            66% {
                transform: translateY(20px) rotate(240deg);
            }
        }

        /* Notification */
        .notification-container {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 3000;
        }

        .notification {
            background: rgba(26, 58, 74, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            border-radius: 18px;
            padding: 20px 25px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            gap: 15px;
            animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            max-width: 400px;
            transform-origin: top right;
        }

        .notification.success {
            border-left: 5px solid var(--success-color);
        }

        .notification.error {
            border-left: 5px solid var(--danger-color);
        }

        .notification.warning {
            border-left: 5px solid var(--warning-color);
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%) scale(0.8);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .main-content {
                padding: 15px;
            }

            .dashboard-header {
                padding: 20px;
                flex-direction: column;
                text-align: center;
            }

            .header-right {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 10px;
            }

            .section-header {
                flex-direction: column;
                gap: 20px;
                align-items: flex-start;
            }

            .action-buttons {
                width: 100%;
                justify-content: space-between;
            }

            .btn-primary-action,
            .btn-secondary-action {
                width: 48%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .dashboard-header {
                border-radius: 20px;
                padding: 15px;
            }

            .btn-primary-action,
            .btn-secondary-action {
                padding: 12px 20px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Background Effects -->
    <div class="bg-effects">
        <div class="bg-gradient"></div>
        <div class="bg-gradient"></div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="content-container">
            @yield('content')
        </div>
    </div>

    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Base JavaScript -->
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Global variables
        const userRole = '{{ Auth::check() && Auth::user()->is_admin ? "admin" : "user" }}';

        // Global notification function
        window.showNotification = function (message, type = 'success') {
            const notificationContainer = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-icon">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                </div>
                <div class="notification-content">
                    <p>${message}</p>
                </div>
                <button class="btn-close-notification" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            notificationContainer.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        };

        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        // Handle form submissions
        document.addEventListener('submit', async function (e) {
            if (e.target.method === 'post' && !e.target.hasAttribute('data-no-ajax')) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const submitBtn = form.querySelector('[type="submit"]');
                const originalText = submitBtn.innerHTML;

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                submitBtn.disabled = true;

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok) {
                        showNotification(data.message || 'Operasi berhasil!', 'success');
                        if (data.redirect) {
                            setTimeout(() => {
                                window.location.href = data.redirect;
                            }, 1500);
                        } else if (data.reload) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                    } else {
                        showNotification(data.message || 'Terjadi kesalahan!', 'error');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                } catch (error) {
                    showNotification('Terjadi kesalahan jaringan!', 'error');
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>