<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .btn-reset { display: inline-block; background: #13737D; color: #fff !important; padding: 14px 28px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 20px 0; }
        .btn-reset:hover { opacity: 0.9; }
        .note { font-size: 12px; color: #6c757d; margin-top: 20px; }
        .divider { margin: 24px 0; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Kata Sandi</h2>
        <p>Halo {{ $userName }},</p>
        <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda. Klik tombol di bawah untuk membuat kata sandi baru (minimal 8 karakter):</p>
        <p style="margin: 24px 0;">
            <a href="{{ $url }}" class="btn-reset">Reset Kata Sandi</a>
        </p>
        <p>Link ini berlaku selama <strong>{{ $expireMinutes }} menit</strong>. Jika Anda tidak meminta reset kata sandi, abaikan email ini.</p>
        <div class="divider"></div>
        <p class="note">Jika tombol di atas tidak berfungsi, salin dan buka link berikut di browser:<br><a href="{{ $url }}">{{ $url }}</a></p>
        <p class="note">Jangan bagikan link ini kepada siapapun. Tim kami tidak akan pernah meminta kata sandi atau link reset Anda.</p>
        <p>Terima kasih,<br><strong>{{ config('app.name') }}</strong></p>
    </div>
</body>
</html>
