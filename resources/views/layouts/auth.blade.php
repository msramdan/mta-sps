<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>@yield('title') - {{ config('app.name', 'marketrax') }}</title>
    <meta name="description"
        content="Marketrax - Aplikasi manajemen penjualan untuk bisnis Anda.">
    <meta name="keywords"
        content="marketrax, sales management, manajemen penjualan, sistem penjualan">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Marketrax">
    <meta property="og:title" content="@yield('title') - Marketrax">
    <meta property="og:description"
        content="Marketrax - Aplikasi manajemen penjualan.">
    <meta property="og:image" content="{{ asset('frontend') }}/og-image.jpg">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') - Marketrax">
    <meta name="twitter:description"
        content="Marketrax - Aplikasi manajemen penjualan.">
    <meta name="twitter:image" content="{{ asset('frontend') }}/twitter-image.jpg">
    <meta name="twitter:image:alt" content="Marketrax Dashboard">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend') }}/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend') }}/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend') }}/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend') }}/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend') }}/favicon-16x16.png">

    <!-- Manifest -->
    <link rel="manifest" href="{{ asset('frontend') }}/site.webmanifest">

    <!-- Theme Color -->
    <meta name="theme-color" content="#13737D">
    <meta name="msapplication-TileColor" content="#13737D">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="application-name" content="Marketrax">
    <meta name="apple-mobile-web-app-title" content="Marketrax">

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
    @include('layouts.partials.whatsapp-float')
    <script src="{{ asset('backend') }}/assets/js/jquery-3.6.3.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    @stack('js')
</body>

</html>
