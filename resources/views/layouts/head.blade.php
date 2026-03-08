<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ config('app.name', 'MTA-SPS') }} Admin</title>
    <meta name="description"
        content="Dashboard Admin MTA-SPS - MTA Sales Management System. Kelola user, role, dan aktivitas dari satu platform.">
    <meta name="keywords"
        content="MTA-SPS, sales management, dashboard admin, manajemen penjualan">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="robots" content="noindex, nofollow">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="MTA-SPS - MTA Sales Management System">
    <meta property="og:title" content="Dashboard Admin - {{ config('app.name') }}">
    <meta property="og:description"
        content="Dashboard admin MTA-SPS untuk mengelola user, role, dan permission.">
    <meta property="og:image" content="{{ asset('frontend') }}/og-image.jpg">
    <meta property="og:locale" content="id_ID">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Dashboard Admin {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Panel admin MTA-SPS - User Management, Role & Permission.">
    <meta name="twitter:image" content="{{ asset('frontend') }}/twitter-image.jpg">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="theme-color" content="#13737D">
    <meta name="msapplication-TileColor" content="#13737D">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="application-name" content="{{ config('app.name') }} Admin">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">

    <link href="{{ asset('backend') }}/assets/vendor/fontawesome/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com/" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css"
        integrity="sha512-gzw5zNP2TRq+DKyAqZfDclaTG4dOrGJrwob2Fc8xwcJPDPVij0HowLIMZ8c1NefFM0OZZYUUUNoPfcoI5jqudw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('backend') }}/assets/vendor/animation/animate.min.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/vendor/simplebar/simplebar.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/css/responsive.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/vendor/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
    @stack('css')
