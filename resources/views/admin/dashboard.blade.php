<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Digital Archive System</title>
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
            padding: 20px;
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

        /* Dashboard Container */
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
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

        .user-avatar::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: translateX(-100%);
        }

        .user-profile:hover .user-avatar::after {
            animation: shine 0.8s;
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

        .btn-logout::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
        }

        .btn-logout:hover::before {
            left: 100%;
        }

        /* Dashboard Stats */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border-radius: 22px;
            padding: 28px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            border-color: rgba(0, 180, 216, 0.3);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(41, 99, 116, 0.2) 0%, rgba(0, 180, 216, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 1.8rem;
            margin-bottom: 20px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, rgba(41, 99, 116, 0.3) 0%, rgba(0, 180, 216, 0.3) 100%);
        }

        .stat-icon::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        .stat-content h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 2.5rem;
            background: linear-gradient(135deg, #ffffff 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .stat-content p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            padding: 6px 12px;
            background: rgba(42, 157, 143, 0.1);
            border-radius: 12px;
            width: fit-content;
            color: var(--success-color);
        }

        .stat-trend.negative {
            background: rgba(230, 57, 70, 0.1);
            color: var(--danger-color);
        }

        /* Kategori Section */
        .categories-section {
            position: relative;
        }

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

        .btn-primary-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s;
        }

        .btn-primary-action:hover::before {
            left: 100%;
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

        /* Categories Grid */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 30px;
        }

        .category-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            border-radius: 22px;
            padding: 30px;
            border: 1px solid var(--glass-border);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .category-card:hover {
            transform: translateY(-12px) scale(1.03);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            border-color: rgba(0, 180, 216, 0.4);
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .category-card:hover::before {
            opacity: 1;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .category-icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(41, 99, 116, 0.2) 0%, rgba(0, 180, 216, 0.2) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 2rem;
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover .category-icon-wrapper {
            transform: scale(1.15) rotate(10deg);
            background: linear-gradient(135deg, rgba(41, 99, 116, 0.3) 0%, rgba(0, 180, 216, 0.3) 100%);
        }

        .category-icon-wrapper::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s;
        }

        .category-card:hover .card-actions {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-action {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        .btn-edit {
            background: rgba(42, 157, 143, 0.15);
            color: var(--success-color);
            border: 1px solid rgba(42, 157, 143, 0.2);
        }

        .btn-edit:hover {
            background: var(--success-color);
            color: white;
            box-shadow: 0 8px 20px rgba(42, 157, 143, 0.3);
        }

        .btn-delete {
            background: rgba(230, 57, 70, 0.15);
            color: var(--danger-color);
            border: 1px solid rgba(230, 57, 70, 0.2);
        }

        .btn-delete:hover {
            background: var(--danger-color);
            color: white;
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.3);
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .btn-action:hover::before {
            left: 100%;
        }

        .category-info h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .category-info p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .category-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .category-id {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
            padding: 6px 14px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .category-status {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 20px;
            background: rgba(42, 157, 143, 0.15);
            color: var(--success-color);
            border: 1px solid rgba(42, 157, 143, 0.2);
        }

        /* Modal Styling */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(10, 25, 41, 0.9);
            backdrop-filter: blur(10px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            animation: fadeIn 0.4s ease-out;
        }

        .modal-content {
            background: rgba(26, 58, 74, 0.95);
            backdrop-filter: blur(30px) saturate(180%);
            border-radius: 28px;
            padding: 40px;
            max-width: 550px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .modal-header h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: white;
            position: relative;
            padding-bottom: 12px;
        }

        .modal-header h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }

        .btn-close-modal {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-close-modal:hover {
            background: rgba(230, 57, 70, 0.2);
            color: var(--danger-color);
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(0, 180, 216, 0.15);
            background: rgba(255, 255, 255, 0.08);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .icon-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }

        .icon-preview-item {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .icon-preview-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.1);
        }

        .icon-preview-item.selected {
            border-color: var(--secondary-color);
            background: rgba(0, 180, 216, 0.1);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 35px;
        }

        .btn-cancel {
            padding: 14px 28px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .btn-submit {
            padding: 14px 32px;
            background: var(--primary-gradient);
            border: none;
            border-radius: 14px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 25px rgba(41, 99, 116, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(41, 99, 116, 0.4);
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

        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .notification.success .notification-icon {
            background: rgba(42, 157, 143, 0.2);
            color: var(--success-color);
        }

        .notification.error .notification-icon {
            background: rgba(230, 57, 70, 0.2);
            color: var(--danger-color);
        }

        .notification.warning .notification-icon {
            background: rgba(244, 162, 97, 0.2);
            color: var(--warning-color);
        }

        .notification-content p {
            margin: 0;
            font-size: 0.95rem;
            color: white;
            font-weight: 500;
        }

        .btn-close-notification {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            font-size: 1rem;
            padding: 5px;
            margin-left: auto;
            transition: color 0.3s;
        }

        .btn-close-notification:hover {
            color: white;
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

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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
        @media (max-width: 1200px) {
            .categories-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .dashboard-container {
                padding: 0 10px;
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

            .categories-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .dashboard-stats {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }

            .categories-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .category-card {
                padding: 25px;
            }

            .category-icon-wrapper {
                width: 70px;
                height: 70px;
                font-size: 1.8rem;
            }

            .card-actions {
                opacity: 1;
                transform: translateY(0);
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

            .modal-content {
                padding: 25px;
                width: 95%;
            }
        }

        @media (max-width: 576px) {
            .dashboard-header {
                border-radius: 20px;
                padding: 15px;
            }

            .stat-card {
                padding: 25px;
            }

            .stat-icon {
                width: 60px;
                height: 60px;
                font-size: 1.6rem;
            }

            .stat-content h3 {
                font-size: 2rem;
            }

            .category-card:hover {
                transform: translateY(-8px);
            }

            .btn-primary-action,
            .btn-secondary-action {
                padding: 12px 20px;
                font-size: 0.9rem;
            }

            .modal-content {
                padding: 20px;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top: 3px solid var(--accent-color);
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

        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-gradient);
            color: white;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(41, 99, 116, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            transition: all 0.3s;
            animation: pulse 2s infinite;
        }

        .fab:hover {
            transform: scale(1.1) rotate(90deg);
            box-shadow: 0 15px 40px rgba(41, 99, 116, 0.6);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 10px 30px rgba(41, 99, 116, 0.4);
            }

            50% {
                box-shadow: 0 10px 40px rgba(41, 99, 116, 0.6);
            }

            100% {
                box-shadow: 0 10px 30px rgba(41, 99, 116, 0.4);
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 30px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 2px dashed rgba(255, 255, 255, 0.1);
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--accent-color);
            margin-bottom: 25px;
            opacity: 0.5;
            animation: float 6s infinite ease-in-out;
        }

        .empty-state h3 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .empty-state p {
            color: rgba(255, 255, 255, 0.6);
            max-width: 400px;
            margin: 0 auto 30px;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Hover Effects */
        .hover-lift {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #3a7a8c 0%, #00b4d8 100%);
        }
    </style>
</head>

<body>
    <!-- Background Effects -->
    <div class="bg-effects">
        <div class="bg-gradient"></div>
        <div class="bg-gradient"></div>
    </div>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Header -->
        <header class="dashboard-header" data-aos="fade-down" data-aos-duration="800">
            <div class="header-left">
                <h1>Digital Archive System</h1>
                <p>Manajemen Kategori Arsip Digital • Dashboard Admin</p>
            </div>
            <div class="header-right">
                <div class="user-profile" id="userProfile">
                    <div class="user-avatar">A</div>
                    <div class="user-details">
                        <h4>Admin User</h4>
                        <span>admin@lan.go.id</span>
                    </div>
                    <div class="user-role">Admin</div>
                </div>
                <button class="btn-logout" id="logoutBtn">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="dashboard-stats">
            <div class="stat-card hover-lift" data-aos="fade-up" data-aos-delay="100" data-aos-duration="600">
                <div class="stat-icon">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="stat-content">
                    <h3>6</h3>
                    <p>Total Kategori</p>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+2 bulan ini</span>
                    </div>
                </div>
            </div>
            <div class="stat-card hover-lift" data-aos="fade-up" data-aos-delay="200" data-aos-duration="600">
                <div class="stat-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>124</h3>
                    <p>Total Dokumen</p>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+15 bulan ini</span>
                    </div>
                </div>
            </div>
            <div class="stat-card hover-lift" data-aos="fade-up" data-aos-delay="300" data-aos-duration="600">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>8</h3>
                    <p>Pengguna Aktif</p>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+1 bulan ini</span>
                    </div>
                </div>
            </div>
            <div class="stat-card hover-lift" data-aos="fade-up" data-aos-delay="400" data-aos-duration="600">
                <div class="stat-icon">
                    <i class="fas fa-database"></i>
                </div>
                <div class="stat-content">
                    <h3>2.4 GB</h3>
                    <p>Total Penyimpanan</p>
                    <div class="stat-trend">
                        <i class="fas fa-arrow-up"></i>
                        <span>+350 MB bulan ini</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="categories-section">
            <div class="section-header" data-aos="fade-up" data-aos-delay="500">
                <h2 class="section-title">Kategori Arsip</h2>
                <div class="action-buttons">
                    <button class="btn-secondary-action" id="refreshBtn">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                    <button class="btn-primary-action" id="addCategoryBtn">
                        <i class="fas fa-plus"></i>
                        Tambah Kategori
                    </button>
                </div>
            </div>

            <div class="categories-grid" id="categoriesGrid">
                <!-- Category cards will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    <button class="fab" id="fabBtn" title="Tambah Kategori">
        <i class="fas fa-plus"></i>
    </button>

    <!-- Modal for Add/Edit Category -->
    <div class="modal-overlay" id="categoryModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Kategori Baru</h3>
                <button class="btn-close-modal" id="closeModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="categoryForm">
                <input type="hidden" id="categoryId">
                <div class="form-group">
                    <label class="form-label" for="categoryName">
                        <i class="fas fa-tag"></i>
                        Nama Kategori
                    </label>
                    <input type="text" class="form-input" id="categoryName" name="name" required
                        placeholder="Masukkan nama kategori">
                </div>
                <div class="form-group">
                    <label class="form-label" for="categoryDescription">
                        <i class="fas fa-align-left"></i>
                        Deskripsi
                    </label>
                    <textarea class="form-input" id="categoryDescription" name="description" rows="4"
                        placeholder="Masukkan deskripsi kategori"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-icons"></i>
                        Pilih Icon
                    </label>
                    <select class="form-input" id="categoryIcon" name="icon">
                        <option value="fas fa-file-contract">File Contract</option>
                        <option value="fas fa-archive">Archive</option>
                        <option value="fas fa-file-export">File Export</option>
                        <option value="fas fa-trash-alt">Trash</option>
                        <option value="fas fa-star">Star</option>
                        <option value="fas fa-infinity">Infinity</option>
                        <option value="fas fa-folder">Folder</option>
                        <option value="fas fa-folder-open">Folder Open</option>
                        <option value="fas fa-file-alt">File Alt</option>
                        <option value="fas fa-file-pdf">File PDF</option>
                    </select>
                    <div class="icon-preview" id="iconPreview">
                        <!-- Icons will be previewed here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" id="cancelBtn">Batal</button>
                    <button type="submit" class="btn-submit" id="submitBtn">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Sample data
        const categoriesData = [
            {
                id: 1,
                name: "Berita Acara Usul Pindah",
                description: "Dokumen berita acara untuk usul pindah arsip ke tempat penyimpanan baru",
                icon: "fas fa-file-contract",
                status: "active",
                documentCount: 24,
                createdAt: "2024-01-15"
            },
            {
                id: 2,
                name: "Daftar Arsip Inaktif Usul Pindah",
                description: "Daftar arsip inaktif yang diusulkan untuk dipindahkan",
                icon: "fas fa-archive",
                status: "active",
                documentCount: 18,
                createdAt: "2024-01-20"
            },
            {
                id: 3,
                name: "Daftar Arsip Usul Pindah",
                description: "Daftar lengkap arsip yang diusulkan untuk dipindahkan",
                icon: "fas fa-file-export",
                status: "active",
                documentCount: 42,
                createdAt: "2024-02-05"
            },
            {
                id: 4,
                name: "Daftar Arsip Usul Musnah",
                description: "Dokumen usul pemusnahan arsip yang sudah tidak dibutuhkan",
                icon: "fas fa-trash-alt",
                status: "active",
                documentCount: 15,
                createdAt: "2024-02-10"
            },
            {
                id: 5,
                name: "Daftar Arsip Vital",
                description: "Arsip vital yang harus dilindungi dan disimpan dengan keamanan tinggi",
                icon: "fas fa-star",
                status: "active",
                documentCount: 8,
                createdAt: "2024-02-15"
            },
            {
                id: 6,
                name: "Daftar Arsip Permanen",
                description: "Arsip permanen untuk penyimpanan jangka panjang dan pelestarian",
                icon: "fas fa-infinity",
                status: "active",
                documentCount: 17,
                createdAt: "2024-02-20"
            }
        ];

        // User role - change to 'user' to test non-admin view
        const userRole = 'admin';

        // Available icons
        const availableIcons = [
            'fas fa-file-contract',
            'fas fa-archive',
            'fas fa-file-export',
            'fas fa-trash-alt',
            'fas fa-star',
            'fas fa-infinity',
            'fas fa-folder',
            'fas fa-folder-open',
            'fas fa-file-alt',
            'fas fa-file-pdf',
            'fas fa-file-excel',
            'fas fa-file-word',
            'fas fa-file-image',
            'fas fa-file-audio',
            'fas fa-file-video'
        ];

        document.addEventListener('DOMContentLoaded', function () {
            const categoriesGrid = document.getElementById('categoriesGrid');
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            const refreshBtn = document.getElementById('refreshBtn');
            const fabBtn = document.getElementById('fabBtn');
            const categoryModal = document.getElementById('categoryModal');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelBtn');
            const categoryForm = document.getElementById('categoryForm');
            const modalTitle = document.getElementById('modalTitle');
            const logoutBtn = document.getElementById('logoutBtn');
            const notificationContainer = document.getElementById('notificationContainer');
            const iconPreview = document.getElementById('iconPreview');
            const userProfile = document.getElementById('userProfile');

            // Initialize
            loadCategories();
            setupEventListeners();
            createIconPreview();

            function loadCategories() {
                categoriesGrid.innerHTML = '';

                if (categoriesData.length === 0) {
                    categoriesGrid.innerHTML = `
                        <div class="empty-state" data-aos="fade-up">
                            <i class="fas fa-folder-open"></i>
                            <h3>Belum Ada Kategori</h3>
                            <p>Mulai dengan menambahkan kategori arsip pertama Anda untuk mengelola dokumen dengan lebih baik.</p>
                            <button class="btn-primary-action" onclick="openAddModal()" style="margin: 0 auto;">
                                <i class="fas fa-plus"></i>
                                Tambah Kategori Pertama
                            </button>
                        </div>
                    `;
                    return;
                }

                categoriesData.forEach((category, index) => {
                    const card = createCategoryCard(category, index);
                    categoriesGrid.appendChild(card);
                });
            }

            function createCategoryCard(category, index) {
                const card = document.createElement('div');
                card.className = 'category-card hover-lift';
                card.setAttribute('data-aos', 'fade-up');
                card.setAttribute('data-aos-delay', `${100 + (index * 100)}`);
                card.setAttribute('data-aos-duration', '600');

                card.innerHTML = `
                    <div class="card-header">
                        <div class="category-icon-wrapper">
                            <i class="${category.icon}"></i>
                        </div>
                        ${userRole === 'admin' ? `
                            <div class="card-actions">
                                <button class="btn-action btn-edit" onclick="openEditModal(${category.id})" title="Edit Kategori">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" onclick="deleteCategory(${category.id})" title="Hapus Kategori">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        ` : ''}
                    </div>
                    <div class="category-info">
                        <h3>${category.name}</h3>
                        <p>${category.description}</p>
                    </div>
                    <div class="category-footer">
                        <span class="category-id">ID: ${category.id}</span>
                        <span class="category-status">
                            <i class="fas fa-circle"></i>
                            Aktif • ${category.documentCount} dokumen
                        </span>
                    </div>
                `;

                // Add click event for card (view details)
                card.addEventListener('click', function (e) {
                    if (!e.target.closest('.btn-action')) {
                        showNotification(`Membuka kategori: ${category.name}`, 'success');
                        // In real app, redirect to category detail page
                    }
                });

                return card;
            }

            function setupEventListeners() {
                // Add category button
                addCategoryBtn.addEventListener('click', openAddModal);
                fabBtn.addEventListener('click', openAddModal);

                // Refresh button
                refreshBtn.addEventListener('click', function () {
                    showNotification('Data kategori diperbarui', 'success');
                    loadCategories();
                });

                // Modal close buttons
                closeModalBtn.addEventListener('click', closeModal);
                cancelBtn.addEventListener('click', closeModal);

                // Close modal when clicking outside
                categoryModal.addEventListener('click', function (e) {
                    if (e.target === categoryModal) {
                        closeModal();
                    }
                });

                // Form submission
                categoryForm.addEventListener('submit', handleFormSubmit);

                // Logout button
                logoutBtn.addEventListener('click', handleLogout);

                // User profile click
                userProfile.addEventListener('click', function () {
                    showNotification('Membuka profil pengguna', 'success');
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', function (e) {
                    // Escape key closes modal
                    if (e.key === 'Escape' && categoryModal.style.display === 'flex') {
                        closeModal();
                    }

                    // Ctrl + N adds new category (admin only)
                    if (e.ctrlKey && e.key === 'n' && userRole === 'admin') {
                        e.preventDefault();
                        openAddModal();
                    }

                    // Ctrl + R refreshes
                    if (e.ctrlKey && e.key === 'r') {
                        e.preventDefault();
                        refreshBtn.click();
                    }
                });
            }

            function createIconPreview() {
                iconPreview.innerHTML = '';
                availableIcons.forEach(icon => {
                    const iconElement = document.createElement('div');
                    iconElement.className = 'icon-preview-item';
                    iconElement.innerHTML = `<i class="${icon}"></i>`;
                    iconElement.addEventListener('click', function () {
                        // Remove selected class from all icons
                        document.querySelectorAll('.icon-preview-item').forEach(item => {
                            item.classList.remove('selected');
                        });
                        // Add selected class to clicked icon
                        this.classList.add('selected');
                        // Update select value
                        document.getElementById('categoryIcon').value = icon;
                    });
                    iconPreview.appendChild(iconElement);
                });
            }

            function openAddModal() {
                modalTitle.textContent = 'Tambah Kategori Baru';
                categoryForm.reset();
                document.getElementById('categoryId').value = '';
                categoryModal.style.display = 'flex';

                // Reset icon preview selection
                document.querySelectorAll('.icon-preview-item').forEach(item => {
                    item.classList.remove('selected');
                });

                // Select first icon by default
                if (iconPreview.firstChild) {
                    iconPreview.firstChild.classList.add('selected');
                    document.getElementById('categoryIcon').value = availableIcons[0];
                }
            }

            window.openEditModal = function (categoryId) {
                const category = categoriesData.find(c => c.id === categoryId);
                if (!category) return;

                modalTitle.textContent = 'Edit Kategori';
                document.getElementById('categoryId').value = category.id;
                document.getElementById('categoryName').value = category.name;
                document.getElementById('categoryDescription').value = category.description || '';
                document.getElementById('categoryIcon').value = category.icon;

                // Select the correct icon in preview
                document.querySelectorAll('.icon-preview-item').forEach(item => {
                    item.classList.remove('selected');
                    if (item.querySelector('i').className === category.icon) {
                        item.classList.add('selected');
                    }
                });

                categoryModal.style.display = 'flex';
            }

            function closeModal() {
                categoryModal.style.display = 'none';
                categoryForm.reset();
            }

            function handleFormSubmit(e) {
                e.preventDefault();

                const categoryId = document.getElementById('categoryId').value;
                const name = document.getElementById('categoryName').value;
                const description = document.getElementById('categoryDescription').value;
                const icon = document.getElementById('categoryIcon').value;

                if (categoryId) {
                    // Edit existing category
                    const index = categoriesData.findIndex(c => c.id === parseInt(categoryId));
                    if (index !== -1) {
                        categoriesData[index] = {
                            ...categoriesData[index],
                            name,
                            description,
                            icon
                        };
                        showNotification('Kategori berhasil diperbarui!', 'success');
                    }
                } else {
                    // Add new category
                    const newId = categoriesData.length > 0 ? Math.max(...categoriesData.map(c => c.id)) + 1 : 1;
                    categoriesData.push({
                        id: newId,
                        name,
                        description,
                        icon,
                        status: 'active',
                        documentCount: 0,
                        createdAt: new Date().toISOString().split('T')[0]
                    });
                    showNotification('Kategori berhasil ditambahkan!', 'success');
                }

                loadCategories();
                closeModal();
            }

            window.deleteCategory = function (categoryId) {
                if (!confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua dokumen dalam kategori ini juga akan terhapus.')) {
                    return;
                }

                const index = categoriesData.findIndex(c => c.id === categoryId);
                if (index !== -1) {
                    const categoryName = categoriesData[index].name;
                    categoriesData.splice(index, 1);
                    showNotification(`Kategori "${categoryName}" berhasil dihapus!`, 'success');
                    loadCategories();
                }
            }

            function showNotification(message, type = 'success') {
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
            }

            function handleLogout() {
                showNotification('Anda telah logout. Mengarahkan ke halaman login...', 'warning');
                // Add logout animation
                document.body.style.opacity = '0.8';
                setTimeout(() => {
                    window.location.href = 'login.html';
                }, 1500);
            }
        });
    </script>
</body>

</html>