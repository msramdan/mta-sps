<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>@yield('title') - {{ config('app.name', 'BillingHub.id Admin Panel') }}</title>
    <meta name="description"
        content="Dashboard admin BillingHub.id - Aplikasi billing internet terintegrasi untuk manajemen ISP dan RT RW Net dengan monitoring OLT ZTE C300, C320, HIOSO, HSGQ, Mikrotik, dan sistem otomatis lengkap">
    <meta name="keywords"
        content="dashboard admin billing internet, admin panel billing, sistem admin RT RW Net, admin aplikasi billing, manajemen ISP">
    <meta name="author" content="BillingHub.id">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title') - {{ config('app.name', 'BillingHub.id Admin Panel') }}">
    <meta property="og:description"
        content="Dashboard admin BillingHub.id - Aplikasi billing internet terintegrasi untuk manajemen ISP dan RT RW Net">
    <meta property="og:image" content="{{ asset('backend') }}/assets/images/logo/og-image.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') - {{ config('app.name', 'BillingHub.id Admin Panel') }}">
    <meta name="twitter:description"
        content="Dashboard admin BillingHub.id - Aplikasi billing internet terintegrasi untuk manajemen ISP dan RT RW Net">
    <meta name="twitter:image" content="{{ asset('backend') }}/assets/images/logo/twitter-image.jpg">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('backend') }}/assets/images/logo/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('backend') }}/assets/images/logo/favicon.png">
    <link rel="apple-touch-icon" href="{{ asset('backend') }}/assets/images/logo/apple-touch-icon.png">

    <!-- Manifest -->
    <link rel="manifest" href="{{ asset('backend') }}/assets/images/logo/site.webmanifest">

    <!-- Theme Color -->
    <meta name="theme-color" content="#129BF4">
    <meta name="msapplication-TileColor" content="#129BF4">

    <!-- Preconnect untuk optimasi loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="{{ asset('backend') }}/assets/vendor/tabler-icons/tabler-icons.css" rel="stylesheet" type="text/css">

    <!-- Stylesheets -->
    <link href="{{ asset('backend') }}/assets/vendor/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend') }}/assets/css/responsive.css" rel="stylesheet" type="text/css">
    @stack('css')
</head>

<body>
    @yield('content')
    <script src="{{ asset('backend') }}/assets/js/jquery-3.6.3.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    @stack('js')
</body>

</html>
