<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>@yield('title') - {{ config('app.name', 'QRIN Payment Gateway') }}</title>
    <meta name="description"
        content="QRIN - Payment Gateway QRIS terbaik di Indonesia. Terima pembayaran dari semua e-wallet dan mobile banking dengan satu integrasi mudah. Biaya QRIS hanya 0.7% + Rp 500. Solusi pembayaran digital untuk UMKM dan bisnis.">
    <meta name="keywords"
        content="payment gateway qris, qris payment, gateway pembayaran qris, qris terintegrasi, api qris, pembayaran digital, e-wallet, mobile banking, gopay, shopeepay, ovo, dana, linkaja, qris murah, qrin payment">
    <meta name="author" content="QRIN - PT. Teknologi Cipta Aplikasi Nusantara">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="QRIN Payment Gateway">
    <meta property="og:title" content="@yield('title') - QRIN: Payment Gateway QRIS Terbaik">
    <meta property="og:description"
        content="Terima pembayaran QRIS dari semua e-wallet & mobile banking. Integrasi mudah, biaya kompetitif 0.7% + Rp 500. Solusi pembayaran digital untuk bisnis Anda.">
    <meta property="og:image" content="{{ asset('frontend') }}/og-image.jpg">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@qrin_id">
    <meta name="twitter:creator" content="@qrin_id">
    <meta name="twitter:title" content="@yield('title') - QRIN Payment Gateway QRIS">
    <meta name="twitter:description"
        content="Payment Gateway QRIS terintegrasi. Dukung Gopay, ShopeePay, OVO, DANA, LinkAja & mobile banking. API mudah, biaya hanya 0.7% + Rp 500.">
    <meta name="twitter:image" content="{{ asset('frontend') }}/twitter-image.jpg">
    <meta name="twitter:image:alt" content="Dashboard QRIN Payment Gateway">

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

    <!-- Additional Meta Tags for Payment Gateway -->
    <meta name="payment:gateway" content="QRIN">
    <meta name="payment:method" content="QRIS, Gopay, ShopeePay, OVO, DANA, LinkAja, Mobile Banking">
    <meta name="payment:fee" content="0.7% + Rp 500 per transaksi">
    <meta name="application-name" content="QRIN Payment Gateway">
    <meta name="apple-mobile-web-app-title" content="QRIN Payment">

    <!-- Business Information -->
    <meta name="business:name" content="PT. Teknologi Cipta Aplikasi Nusantara">
    <meta name="business:contact:email" content="saepulramdan244@gmail.com">
    <meta name="business:contact:phone" content="+62 838 7473 1480">
    <meta name="business:location:country" content="Indonesia">
    <meta name="business:location:region" content="Bogor">

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
