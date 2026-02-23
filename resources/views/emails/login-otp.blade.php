<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Login</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .otp-box { background: #f8f9fa; border: 2px dashed #0d6efd; padding: 20px; text-align: center; font-size: 28px; font-weight: bold; letter-spacing: 8px; margin: 20px 0; }
        .note { font-size: 12px; color: #6c757d; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kode OTP Login</h2>
        <p>Halo {{ $userName }},</p>
        <p>Anda meminta kode OTP untuk login. Gunakan kode berikut:</p>
        <div class="otp-box">{{ $otp }}</div>
        <p>Kode ini berlaku selama <strong>5 menit</strong>. Jangan bagikan kode ini kepada siapapun.</p>
        <p class="note">Jika Anda tidak melakukan permintaan ini, abaikan email ini. Mungkin seseorang salah memasukkan email.</p>
        <p>Terima kasih,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
