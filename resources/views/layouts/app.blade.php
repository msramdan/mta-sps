<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - QRIN Payment Gateway Admin</title>
    <meta name="description" content="Dashboard Admin QRIN - Kelola pembayaran QRIS, monitor transaksi, dan kontrol semua aspek payment gateway Anda dari satu platform terintegrasi.">
    <meta name="keywords" content="dashboard admin qris, admin panel payment gateway, dashboard qrin, admin pembayaran digital, manajemen transaksi qris, admin e-wallet, kontrol pembayaran">
    <meta name="author" content="QRIN - PT. Teknologi Cipta Aplikasi Nusantara">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="QRIN Payment Gateway">
    <meta property="og:title" content="Dashboard Admin - QRIN Payment Gateway">
    <meta property="og:description" content="Dashboard admin untuk mengelola payment gateway QRIS dengan semua fitur monitoring transaksi, manajemen user, dan laporan real-time.">
    <meta property="og:image" content="{{ asset('frontend') }}/og-image.jpg">
    <meta property="og:locale" content="id_ID">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Dashboard Admin QRIN Payment Gateway">
    <meta name="twitter:description" content="Panel admin untuk kontrol penuh payment gateway QRIS - Transaksi, User Management, dan Monitoring.">
    <meta name="twitter:image" content="{{ asset('frontend') }}/twitter-image.jpg">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend') }}/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend') }}/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('frontend') }}/site.webmanifest">
    <meta name="theme-color" content="#13737D">
    <meta name="msapplication-TileColor" content="#13737D">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="application-name" content="QRIN Admin Dashboard">
    <meta name="apple-mobile-web-app-title" content="QRIN Admin">
    <meta name="business:name" content="PT. Teknologi Cipta Aplikasi Nusantara">
    <meta name="business:contact:email" content="saepulramdan244@gmail.com">
    <meta name="business:contact:phone" content="+62 838 7473 1480">
    <meta name="business:location:country" content="Indonesia">
    <meta name="business:location:region" content="Bogor">

    <link href="{{ asset('backend') }}/assets/vendor/fontawesome/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css" integrity="sha512-gzw5zNP2TRq+DKyAqZfDclaTG4dOrGJrwob2Fc8xwcJPDPVij0HowLIMZ8c1NefFM0OZZYUUUNoPfcoI5jqudw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('backend') }}/assets/vendor/animation/animate.min.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/assets/vendor/flag-icons-master/flag-icon.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/vendor/simplebar/simplebar.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/css/responsive.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="app-wrapper">
        <div class="loader-wrapper">
            <div class="loader_24"></div>
        </div>
        <nav>
            <div class="app-logo">
                <a class="logo d-inline-block" href="index.html">
                    <img alt="QRIN Logo" src="{{ asset('frontend/logo.png') }}" style="width: 110px">
                </a>

                <span class="bg-light-primary toggle-semi-nav d-flex-center">
                    <i class="ti ti-chevron-right"></i>
                </span>

                <div class="d-flex align-items-center nav-profile p-3">
                    <span class="h-45 w-45 d-flex-center b-r-10 position-relative bg-danger m-auto">
                        <img alt="avatar" class="img-fluid b-r-10" src="{{ asset('backend') }}/assets/images/avatar/woman.jpg">
                        <span class="position-absolute top-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
                    </span>
                    <div class="flex-grow-1 ps-2">
                        <h6 class="text-primary mb-0"> Ninfa Monaldo</h6>
                        <p class="text-muted f-s-12 mb-0">Web Developer</p>
                    </div>

                    <div class="dropdown profile-menu-dropdown">
                        <a aria-expanded="false" data-bs-auto-close="true" data-bs-placement="top" data-bs-toggle="dropdown" role="button">
                            <i class="ti ti-settings fs-5"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-item">
                                <a class="f-w-500" href="profile.html" target="_blank">
                                    <i class="ph-duotone ph-user-circle pe-1 f-s-20"></i> Profile Details
                                </a>
                            </li>
                            <li class="app-divider-v dotted py-1"></li>
                            <li class="dropdown-item">
                                <a class="mb-0 text-danger" href="sign_in.html" target="_blank">
                                    <i class="ph-duotone ph-sign-out pe-1 f-s-20"></i> Log Out
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="app-nav" id="app-simple-bar">
                <ul class="main-nav p-0 mt-2">
                    <li class="no-sub">
                        <a href="widget.html">
                            <svg stroke="currentColor" stroke-width="1.5">
                                <use xlink:href="{{ asset('backend') }}/assets/svg/_sprite.svg#squares"></use>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a aria-expanded="false" data-bs-toggle="collapse" href="#maps">
                            <svg stroke="currentColor" stroke-width="1.5">
                                <use xlink:href="{{ asset('backend') }}/assets/svg/_sprite.svg#location"></use>
                            </svg>
                            User & Roles
                        </a>
                        <ul class="collapse" id="maps">
                            <li><a href="google-map.html">Users</a></li>
                            <li><a href="leaflet-map.html">Roles</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="menu-navs">
                <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
                <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
            </div>
        </nav>

        <div class="app-content">
            <div class="">
                <header class="header-main">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-8 col-sm-6 d-flex align-items-center header-left p-0">
                                <span class="header-toggle ">
                                    <i class="ph ph-squares-four"></i>
                                </span>
                            </div>

                            <div class="col-4 col-sm-6 d-flex align-items-center justify-content-end header-right p-0">
                                <ul class="d-flex align-items-center">
                                    <li class="header-dark">
                                        <div class="sun-logo head-icon bg-light-dark rounded-circle f-s-22 p-2">
                                            <i class="ph ph-moon-stars"></i>
                                        </div>
                                        <div class="moon-logo head-icon bg-light-dark rounded-circle f-s-22 p-2">
                                            <i class="ph ph-sun-dim"></i>
                                        </div>
                                    </li>

                                    <li class="header-notification">
                                        <a aria-controls="notificationcanvasRight" class="d-block head-icon position-relative bg-light-dark rounded-circle f-s-22 p-2" data-bs-target="#notificationcanvasRight" data-bs-toggle="offcanvas" href="#" role="button">
                                            <i class="ph ph-bell"></i>
                                            <span class="position-absolute translate-middle p-1 bg-primary border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__slower"></span>
                                        </a>
                                        <div aria-labelledby="notificationcanvasRightLabel" class="offcanvas offcanvas-end header-notification-canvas" id="notificationcanvasRight" tabindex="-1">
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="notificationcanvasRightLabel">Notification</h5>
                                                <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" type="button"></button>
                                            </div>
                                            <div class="offcanvas-body app-scroll p-0">
                                                <div class="head-container">
                                                    <div class="notification-message head-box">
                                                        <div class="message-content-box flex-grow-1 pe-2">
                                                            <a class="f-s-15 text-dark mb-0" href="read_email.html"><span class="f-w-500 text-dark">Gene Hart</span> wants to edit <span class="f-w-500 text-dark">Report.doc</span></a>
                                                            <div>
                                                                <a class="d-inline-block f-w-500 text-success me-1" href="#">Approve</a>
                                                                <a class="d-inline-block f-w-500 text-danger" href="#">Deny</a>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <i class="ph ph-trash f-s-18 text-danger close-btn"></i>
                                                            <div>
                                                                <span class="badge text-light-primary"> sep 23 </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="hidden-massage py-4 px-3">
                                                        <div>
                                                            <i class="ph-duotone ph-bell-ringing f-s-50 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">Notification Not Found</h6>
                                                            <p class="text-dark">When you have any notifications added here,will appear here.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
                <main>
                    <div class="container-fluid">
                        <div class="row m-1">
                            <div class="col-12 ">
                                <h4 class="main-title">Dashboard</h4>
                                <ul class="app-line-breadcrumbs mb-3">
                                    <li class="">
                                        <a class="f-s-14 f-w-500" href="#">
                                            <span>
                                                <i class="ph-duotone ph-newspaper f-s-16"></i> Admin
                                            </span>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a class="f-s-14 f-w-500" href="#">Dashboard</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Selamat Datang di Dashboard QRIN</h6>
                                        <p class="text-muted">Kelola semua transaksi QRIS, monitor pembayaran, dan kontrol sistem payment gateway Anda dari sini.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <div class="go-top">
                    <span class="progress-value">
                        <i class="ti ti-arrow-up"></i>
                    </span>
                </div>

                <footer>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9 col-12">
                                <p class="footer-text f-w-600 mb-0">© 2026 QRIN Created By Tecanusa.</p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="{{ asset('backend') }}/assets/js/jquery-3.6.3.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendor/simplebar/simplebar.js"></script>
    <script src="{{ asset('backend') }}/assets/vendor/phosphor/phosphor.js"></script>
    <script src="{{ asset('backend') }}/assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/script.js"></script>
    <script src="{{ asset('backend') }}/assets/js/customizer.js"></script>
</body>
</html>
