<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRIN - Payment Gateway QRIS Terbaik</title>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #13737D;
            --primary-light: #1a8f9b;
            --primary-dark: #0e575e;
            --secondary-color: #FF9A3D;
            --accent-color: #00D4AA;
            --bg-dark: #0F1419;
            --card-dark: #1A222D;
            --text-light: #F5F7FA;
            --text-muted-light: #94A3B8;
            --bg-light: #F8FAFC;
            --card-light: #FFFFFF;
            --text-dark: #1E293B;
            --text-muted-dark: #64748B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.5;
            overflow-x: hidden;
            position: relative;
        }

        /* Compact spacing */
        .compact-section {
            padding: 40px 0;
        }

        .compact-hero {
            padding-top: 100px;
            padding-bottom: 30px;
            min-height: auto;
        }

        /* Theme Styles */
        [data-bs-theme="dark"] {
            background-color: var(--bg-dark);
            color: var(--text-light);
        }

        [data-bs-theme="dark"] .card {
            background-color: var(--card-dark);
            color: var(--text-light);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        [data-bs-theme="dark"] .bg-section {
            background-color: rgba(19, 115, 125, 0.05);
        }

        [data-bs-theme="dark"] .text-muted {
            color: var(--text-muted-light) !important;
        }

        [data-bs-theme="dark"] .navbar {
            background-color: rgba(15, 20, 25, 0.95) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        [data-bs-theme="light"] {
            background-color: var(--bg-light);
            color: var(--text-dark);
        }

        [data-bs-theme="light"] .card {
            background-color: var(--card-light);
            color: var(--text-dark);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        [data-bs-theme="light"] .bg-section {
            background-color: rgba(19, 115, 125, 0.03);
        }

        [data-bs-theme="light"] .text-muted {
            color: var(--text-muted-dark) !important;
        }

        [data-bs-theme="light"] .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-weight: 700;
            line-height: 1.2;
        }

        /* Navigation */
        .navbar {
            padding: 0.7rem 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--primary-color) !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.4rem 0.8rem !important;
            border-radius: 6px;
            color: inherit !important;
        }

        [data-bs-theme="dark"] .nav-link:hover {
            background-color: rgba(19, 115, 125, 0.1);
        }

        [data-bs-theme="light"] .nav-link:hover {
            background-color: rgba(19, 115, 125, 0.08);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(19, 115, 125, 0.3);
        }

        .btn-outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: transparent;
        }

        [data-bs-theme="dark"] .btn-outline {
            color: var(--text-light);
            border-color: var(--primary-light);
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Hero Section - PROFESSIONAL */
        .hero-section {
            padding-top: 100px;
            padding-bottom: 40px;
            position: relative;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        @media (max-width: 992px) {
            .hero-section {
                padding-top: 90px;
                padding-bottom: 30px;
                min-height: auto;
            }
        }

        .hero-badge {
            display: inline-block;
            background: rgba(19, 115, 125, 0.15);
            color: var(--primary-light);
            border: 1px solid rgba(19, 115, 125, 0.3);
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            margin-top: 0;
        }

        .hero-title {
            font-size: 2.8rem;
            margin-bottom: 1.2rem;
            line-height: 1.1;
            background: linear-gradient(135deg, var(--primary-light), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 0.95rem;
            }
        }

        .hero-subtitle {
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
            max-width: 600px;
        }

        /* Price Highlight */
        .price-highlight {
            display: inline-block;
            color: var(--secondary-color);
            font-weight: 600;
            font-size: 1rem;
            margin: 0.8rem 0 1.5rem;
            padding: 0.5rem 0.8rem;
            background: rgba(255, 154, 61, 0.1);
            border-radius: 8px;
            border-left: 4px solid var(--secondary-color);
        }

        /* Payment Methods - FIXED FOR MOBILE */
        .payment-methods-section {
            margin: 1.8rem 0;
        }

        .payment-methods-section p {
            margin-bottom: 0.8rem !important;
            font-size: 0.9rem;
        }

        .payment-methods-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 0.5rem;
            align-items: center;
            max-width: 700px;
        }

        .payment-method-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 85px;
            flex-shrink: 0;
        }

        .payment-method-img {
            width: 65px;
            height: 65px;
            object-fit: contain;
            padding: 12px;
            border-radius: 14px;
            margin-bottom: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: white;
        }

        [data-bs-theme="dark"] .payment-method-img {
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .payment-method-img:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .mobile-banking-icon {
            width: 65px;
            height: 65px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 14px;
            margin-bottom: 6px;
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(19, 115, 125, 0.2);
            flex-shrink: 0;
        }

        .mobile-banking-icon:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 16px rgba(19, 115, 125, 0.3);
        }

        .payment-method-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted-light);
            margin-top: 3px;
            white-space: nowrap;
        }

        [data-bs-theme="light"] .payment-method-label {
            color: var(--text-muted-dark);
        }

        /* Hero Image - QRIS LOGO STYLE */
        .hero-image {
            width: 100%;
            max-width: 550px;
            border-radius: 18px;
            filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.15));
            animation: floatAnimation 3s ease-in-out infinite;
        }

        [data-bs-theme="dark"] .hero-image {
            filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.2));
        }

        [data-bs-theme="light"] .hero-image {
            filter: drop-shadow(0 15px 30px rgba(0, 0, 0, 0.08));
        }

        /* Features Section */
        .section-title {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
            font-size: 2rem;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .feature-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            border-radius: 12px;
            margin-bottom: 1.2rem;
            font-size: 1.6rem;
            color: white;
        }

        .feature-card {
            padding: 1.5rem;
            height: 100%;
            border-radius: 14px;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
        }

        .feature-card:hover {
            transform: translateY(-6px);
        }

        [data-bs-theme="dark"] .feature-card:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        [data-bs-theme="light"] .feature-card:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
        }

        /* Solutions Section */
        .solution-list li {
            margin-bottom: 1.2rem;
            padding: 0;
            border: none;
            background: transparent;
        }

        .solution-list i {
            color: var(--primary-color);
            font-size: 1.3rem;
            margin-right: 0.8rem;
            min-width: 25px;
        }

        /* Testimonials */
        .testimonial-card {
            padding: 1.5rem;
            border-radius: 14px;
            height: 100%;
            border: none;
        }

        .testimonial-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        /* CTA */
        .cta-card {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            color: white;
            padding: 2.5rem 1.5rem;
            border-radius: 18px;
            border: none;
        }

        /* Footer */
        footer {
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        [data-bs-theme="light"] footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .footer-brand {
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--primary-color);
            margin-bottom: 0.8rem;
            display: inline-block;
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        [data-bs-theme="light"] .theme-toggle {
            background: rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .theme-toggle:hover {
            transform: rotate(180deg);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatAnimation {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        /* Responsive Improvements */
        @media (max-width: 992px) {
            .navbar-collapse {
                padding: 1rem;
                border-radius: 12px;
                margin-top: 0.8rem;
            }

            [data-bs-theme="dark"] .navbar-collapse {
                background: var(--card-dark);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            }

            [data-bs-theme="light"] .navbar-collapse {
                background: white;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            }

            /* Payment methods alignment for tablet */
            .payment-methods-container {
                gap: 15px;
                justify-content: flex-start;
            }

            .payment-method-wrapper {
                width: 80px;
            }

            .payment-method-img,
            .mobile-banking-icon {
                width: 60px;
                height: 60px;
                font-size: 1.4rem;
            }

            .payment-method-label {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .compact-section {
                padding: 30px 0;
            }

            .hero-section {
                padding-top: 80px;
                padding-bottom: 25px;
            }

            /* FIXED: Hero badge spacing from header */
            .hero-badge {
                margin-top: 0.5rem;
                margin-bottom: 1.2rem;
            }

            /* Mobile banking icon layout - 2 rows of 3 */
            .payment-methods-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
                justify-items: center;
                max-width: 400px;
                margin-left: auto;
                margin-right: auto;
            }

            .payment-method-wrapper {
                width: 100px;
                flex-shrink: 0;
            }

            .payment-method-img,
            .mobile-banking-icon {
                width: 70px;
                height: 70px;
                font-size: 1.5rem;
            }

            .payment-method-label {
                font-size: 0.8rem;
                white-space: nowrap;
            }

            .feature-card,
            .testimonial-card {
                padding: 1.2rem;
            }

            .cta-card {
                padding: 2rem 1.2rem;
            }

            .hero-image {
                animation: floatAnimation 3.5s ease-in-out infinite;
            }
        }

        @media (max-width: 576px) {
            /* Even smaller screens */
            .compact-section {
                padding: 25px 0;
            }

            /* Hero badge spacing adjustment */
            .hero-badge {
                margin-top: 1.2rem;
                margin-bottom: 1rem;
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }

            /* Payment methods for very small screens */
            .payment-methods-container {
                gap: 10px;
                grid-template-columns: repeat(3, 1fr);
                max-width: 320px;
            }

            .payment-method-wrapper {
                width: 85px;
            }

            .payment-method-img,
            .mobile-banking-icon {
                width: 55px;
                height: 55px;
                font-size: 1.2rem;
            }

            .payment-method-label {
                font-size: 0.7rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 0.9rem;
                margin-bottom: 1.2rem;
            }

            .price-highlight {
                font-size: 0.9rem;
                margin: 0.6rem 0 1.2rem;
                padding: 0.4rem 0.7rem;
            }

            .payment-methods-section {
                margin: 1.2rem 0;
            }

            .section-title {
                font-size: 1.7rem;
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 375px) {
            /* For very small phones */
            .payment-methods-container {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                max-width: 280px;
            }

            .payment-method-wrapper {
                width: 75px;
            }

            .payment-method-img,
            .mobile-banking-icon {
                width: 50px;
                height: 50px;
                font-size: 1.1rem;
            }

            .payment-method-label {
                font-size: 0.65rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{asset('frontend')}}/logo.png" alt="QRIN Logo" style="width: 150px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#solutions">Solusi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/api-docs') }}">
                            <i class="fas fa-code me-1"></i> Dokumentasi API
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <div class="theme-toggle" id="themeToggle">
                        <i class="fas fa-moon"></i>
                    </div>
                    <a href="/login" class="btn btn-primary">Login</a>
                    <a href="/register" class="btn btn-outline">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - PROFESSIONAL -->
    <section id="hero" class="hero-section compact-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-badge fade-in">Solusi QRIS #1 di Indonesia</div>
                    <h1 class="hero-title fade-in">
                        QRIN: Payment Gateway QRIS
                    </h1>
                    <p class="hero-subtitle fade-in">
                        Terima pembayaran dari semua e-wallet dan mobile banking dengan satu integrasi yang mudah.
                    </p>

                    <div class="price-highlight fade-in">
                        <i class="fas fa-tag me-1"></i> Biaya QRIS hanya 0.7% + Rp 500
                    </div>

                    <!-- Payment Methods - FIXED FOR MOBILE (2 rows of 3) -->
                    <div class="payment-methods-section">
                        <p class="text-muted mb-3">Support pembayaran via:</p>
                        <div class="payment-methods-container fade-in">
                            <!-- Row 1 - Top 3 -->
                            <div class="payment-method-wrapper">
                                <img src="{{asset('frontend')}}/gopay.png" alt="Gopay" class="payment-method-img">
                                <span class="payment-method-label">Gopay</span>
                            </div>
                            <div class="payment-method-wrapper">
                                <img src="{{asset('frontend')}}/spay.png" alt="Shopeepay" class="payment-method-img">
                                <span class="payment-method-label">ShopeePay</span>
                            </div>
                            <div class="payment-method-wrapper">
                                <img src="{{asset('frontend')}}/ovo.png" alt="OVO" class="payment-method-img">
                                <span class="payment-method-label">OVO</span>
                            </div>

                            <!-- Row 2 - Bottom 3 -->
                            <div class="payment-method-wrapper">
                                <img src="{{asset('frontend')}}/dana.png" alt="DANA" class="payment-method-img">
                                <span class="payment-method-label">DANA</span>
                            </div>
                            <div class="payment-method-wrapper">
                                <img src="{{asset('frontend')}}/linkaja.webp" alt="LinkAja" class="payment-method-img">
                                <span class="payment-method-label">LinkAja</span>
                            </div>
                            <div class="payment-method-wrapper">
                                <div class="mobile-banking-icon">
                                    <i class="fas fa-university"></i>
                                </div>
                                <span class="payment-method-label">MBanking</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="text-center">
                        <img src="{{asset('frontend')}}/qris.png" alt="QRIN Dashboard" class="hero-image fade-in">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section compact-section bg-section">
        <div class="container">
            <h2 class="section-title">Kenapa Memilih QRIN?</h2>
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Integrasi Mudah</h4>
                        <p class="text-muted mb-0">API sederhana dan dokumentasi lengkap untuk integrasi cepat.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Aman & Terpercaya</h4>
                        <p class="text-muted mb-0">Sistem keamanan terbaik untuk melindungi setiap transaksi.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Semua Pembayaran</h4>
                        <p class="text-muted mb-0">Dukung semua e-wallet dan bank populer di Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Solutions Section -->
    <section id="solutions" class="solutions-section compact-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                    <div class="text-center">
                        <img src="{{asset('frontend')}}/mockup.png" alt="Dashboard QRIN" class="img-fluid fade-in">
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1 pe-lg-5">
                    <h2 class="fw-bold mb-3">Solusi untuk Bisnis Anda</h2>
                    <p class="lead text-muted mb-4">
                        Kami menyederhanakan pembayaran sehingga Anda bisa fokus pada bisnis.
                    </p>

                    <ul class="solution-list list-unstyled">
                        <li class="d-flex align-items-start mb-3 fade-in">
                            <i class="fas fa-chart-line mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Laporan Real-time</h5>
                                <p class="text-muted mb-0">Pantau transaksi dengan dashboard yang mudah digunakan.</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-3 fade-in">
                            <i class="fas fa-percentage mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Biaya Kompetitif</h5>
                                <p class="text-muted mb-0">Biaya transaksi yang terjangkau untuk semua ukuran bisnis.</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-3 fade-in">
                            <i class="fas fa-headset mt-1"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Support Responsif</h5>
                                <p class="text-muted mb-0">Tim support siap membantu kapan saja Anda butuh.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials-section compact-section bg-section">
        <div class="container">
            <h2 class="section-title">Apa Kata Pelanggan?</h2>
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <div class="card testimonial-card fade-in">
                        <p class="fst-italic mb-3">"QRIS dari QRIN sangat mudah digunakan dan biaya 0.7% sangat masuk
                            akal untuk bisnis kami."</p>
                        <div class="d-flex align-items-center">
                            <img src="{{asset('frontend')}}/https://ui-avatars.com/api/?name=Joko+D&background=13737D&color=fff&size=100"
                                alt="Joko D" class="testimonial-avatar me-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Joko D.</h6>
                                <small class="text-muted">Pemilik Kedai Kopi</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card testimonial-card fade-in">
                        <p class="fst-italic mb-3">"Integrasi cepat, sistem aman. Cocok untuk toko online kami."</p>
                        <div class="d-flex align-items-center">
                            <img src="{{asset('frontend')}}/https://ui-avatars.com/api/?name=Siti+S&background=13737D&color=fff&size=100"
                                alt="Siti S" class="testimonial-avatar me-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Siti S.</h6>
                                <small class="text-muted">Pemilik Online Shop</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card testimonial-card fade-in">
                        <p class="fst-italic mb-3">"Pelanggan senang bisa bayar dengan berbagai metode. Rekomendasi untuk UMKM."</p>
                        <div class="d-flex align-items-center">
                            <img src="{{asset('frontend')}}/https://ui-avatars.com/api/?name=Adi+R&background=13737D&color=fff&size=100"
                                alt="Adi R" class="testimonial-avatar me-3">
                            <div>
                                <h6 class="mb-0 fw-bold">Adi R.</h6>
                                <small class="text-muted">Pemilik Usaha</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="cta-section compact-section">
        <div class="container">
            <div class="cta-card fade-in">
                <h2 class="fw-bold mb-2">Mulai Terima Pembayaran QRIS Sekarang</h2>
                <p class="mb-3">Bergabung dengan ribuan bisnis yang sudah menggunakan QRIN.</p>
                <a href="#" class="btn btn-primary">Daftar Gratis</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="footer-brand">QRIN</div>
                    <p class="text-muted mb-2">Solusi pembayaran QRIS untuk bisnis Indonesia.</p>
                    <small class="text-muted">
                        Didukung oleh PT. Teknologi Cipta Aplikasi Nusantara
                    </small>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Kontak</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1"><a href="mailto:saepulramdan244@gmail.com"
                                        class="text-muted text-decoration-none">saepulramdan244@gmail.com</a>
                                </li>
                                <li class="mb-1"><a href="tel:083874731480"
                                        class="text-muted text-decoration-none">0838-7473-1480</a></li>
                                <li><span class="text-muted">Bogor, Indonesia</span></li>
                            </ul>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Legal</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1"><a href="#" class="text-muted text-decoration-none">Kebijakan Privasi</a></li>
                                <li><a href="#" class="text-muted text-decoration-none">Syarat Layanan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-3 opacity-25">
            <div class="text-center text-muted">
                <p class="mb-0 small">&copy; 2026 QRIN Created By Tecanusa.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        const savedTheme = localStorage.getItem('theme') || 'dark';
        html.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            const icon = themeToggle.querySelector('i');
            if (theme === 'light') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Simple fade-in animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        // Observe elements for animation
        document.addEventListener('DOMContentLoaded', function () {
            const fadeElements = document.querySelectorAll('.feature-card, .testimonial-card, .cta-card, .hero-badge, .hero-title, .hero-subtitle, .price-highlight, .solution-list li, .hero-image, .payment-methods-container, .hero-buttons');

            fadeElements.forEach(el => {
                observer.observe(el);
            });

            // Mobile menu close on click
            const navbarCollapse = document.querySelector('.navbar-collapse');
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                });
            });

            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // Initialize scroll check on load
            if (window.scrollY > 30) {
                navbar.classList.add('scrolled');
            }
        });
    </script>
</body>

</html>
