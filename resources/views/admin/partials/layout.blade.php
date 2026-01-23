<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Digital Archive System</title>
    <link rel="icon" href="{{ asset('gambar/lanri.png') }}" type="image/png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-light: #B7A3E3;
            --primary: #B153D7;
            --primary-dark: #9D3AC7;
            --secondary: #8A2DB8;
            --accent: #D4A5FF;
            --success: #4CD964;
            --danger: #FF6B6B;
            --warning: #FFD166;
            --dark: #1A1035;
            --dark-light: #2A1F4A;
            --light: #F8F5FF;
            --gray: #B8A9D9;
            --gray-light: #E8E1FF;
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(183, 163, 227, 0.15);
            --shadow-sm: 0 1px 3px rgba(177, 83, 215, 0.1);
            --shadow-md: 0 4px 6px rgba(177, 83, 215, 0.15);
            --shadow-lg: 0 10px 15px rgba(177, 83, 215, 0.2);
            --shadow-xl: 0 20px 25px rgba(177, 83, 215, 0.25);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-full: 999px;
            --gradient-primary: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            --gradient-secondary: linear-gradient(135deg, var(--primary-light) 0%, var(--primary) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark) 0%, #2A1F4A 50%, #3A2F5A 100%);
            color: var(--light);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Background Pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 10% 20%, rgba(183, 163, 227, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(177, 83, 215, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(138, 45, 184, 0.05) 0%, transparent 60%);
            z-index: 0;
            pointer-events: none;
        }

        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Header */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 0 32px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(183, 163, 227, 0.1);
        }

        .header-left h1 {
            font-size: 28px;
            font-weight: 700;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .header-left p {
            font-size: 14px;
            color: var(--gray);
            font-weight: 400;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            background: var(--dark-light);
            border-radius: var(--radius-lg);
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .user-profile:hover {
            border-color: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--gradient-primary);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .user-info h4 {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
            color: var(--light);
        }

        .user-info span {
            font-size: 11px;
            color: var(--gray);
        }

        /* Logout Button */
        .btn-logout {
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.2);
            color: var(--danger);
            padding: 8px 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-logout:hover {
            background: rgba(255, 107, 107, 0.15);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 107, 107, 0.2);
        }

        /* Buttons */
        .btn {
            padding: 10px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            border: none;
            outline: none;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            border: 1px solid rgba(183, 163, 227, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            background: var(--gradient-secondary);
        }

        .btn-secondary {
            background: rgba(183, 163, 227, 0.1);
            color: var(--gray-light);
            border: 1px solid rgba(183, 163, 227, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(183, 163, 227, 0.15);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Loading */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(26, 16, 53, 0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            backdrop-filter: blur(4px);
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid rgba(183, 163, 227, 0.2);
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Notifications */
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
        }

        .notification {
            background: var(--dark-light);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-md);
            padding: 14px;
            margin-bottom: 10px;
            max-width: 300px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInRight 0.3s ease;
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(10px);
        }

        .notification.success {
            border-left: 3px solid var(--success);
        }

        .notification.error {
            border-left: 3px solid var(--danger);
        }

        .notification.warning {
            border-left: 3px solid var(--warning);
        }

        .notification-icon {
            width: 28px;
            height: 28px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .notification.success .notification-icon {
            background: rgba(76, 217, 100, 0.1);
            color: var(--success);
        }

        .notification.error .notification-icon {
            background: rgba(255, 107, 107, 0.1);
            color: var(--danger);
        }

        .notification-content p {
            font-size: 13px;
            color: white;
            margin: 0;
            flex: 1;
        }

        .notification-close {
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            padding: 2px;
            transition: color 0.2s ease;
        }

        .notification-close:hover {
            color: var(--primary-light);
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

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-container {
                padding: 16px;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 16px;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
                padding: 20px 0 24px 0;
            }

            .header-left h1 {
                font-size: 24px;
            }

            .header-right {
                width: 100%;
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .user-profile {
                flex: 1;
                min-width: 200px;
            }
        }

        @media (max-width: 480px) {
            .header-right {
                flex-direction: column;
                gap: 12px;
            }

            .user-profile,
            .btn-logout {
                width: 100%;
                justify-content: center;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(183, 163, 227, 0.05);
            border-radius: var(--radius-full);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gradient-primary);
            border-radius: var(--radius-full);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gradient-secondary);
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-left">
                <h1>@yield('page-title', 'Digital Archive')</h1>
                <p>@yield('page-subtitle', 'Dashboard Admin')</p>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <div class="user-avatar">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div>
                    <div class="user-info">
                        <h4>{{ Auth::user()->name ?? 'Admin User' }}</h4>
                        <span>{{ Auth::user()->email ?? 'admin@archive.com' }}</span>
                    </div>
                </div>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn-logout" onclick="document.getElementById('logoutForm').submit()">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </div>
        </header>

        <!-- Content -->
        @yield('content')
    </div>

    <!-- Notifications -->
    <div class="notification-container" id="notificationContainer"></div>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 400,
            once: true,
            offset: 50
        });

        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Utility Functions
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        function showNotification(message, type = 'success') {
            const notificationContainer = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-icon">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation' : 'info'}"></i>
                </div>
                <div class="notification-content">
                    <p>${message}</p>
                </div>
                <button class="notification-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;

            notificationContainer.appendChild(notification);

            // Auto remove after 4 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 4000);
        }

        // Session notifications
        @if(session('success'))
            showNotification("{{ session('success') }}", 'success');
        @endif

        @if(session('error'))
            showNotification("{{ session('error') }}", 'error');
        @endif
    </script>

    @yield('scripts')
</body>

</html>