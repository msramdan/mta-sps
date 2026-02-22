<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi API - QRIN Payment Gateway</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend') }}/favicon.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend') }}/favicon.png">
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; line-height: 1.5; overflow-x: hidden; }
        [data-bs-theme="dark"] { background-color: var(--bg-dark); color: var(--text-light); }
        [data-bs-theme="dark"] .card { background-color: var(--card-dark); color: var(--text-light); border: 1px solid rgba(255,255,255,0.05); }
        [data-bs-theme="dark"] .text-muted { color: var(--text-muted-light) !important; }
        [data-bs-theme="dark"] .navbar { background-color: rgba(15,20,25,0.95) !important; backdrop-filter: blur(15px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        [data-bs-theme="light"] { background-color: var(--bg-light); color: var(--text-dark); }
        [data-bs-theme="light"] .card { background-color: var(--card-light); color: var(--text-dark); border: 1px solid rgba(0,0,0,0.05); }
        [data-bs-theme="light"] .text-muted { color: var(--text-muted-dark) !important; }
        [data-bs-theme="light"] .navbar { background-color: rgba(255,255,255,0.95) !important; backdrop-filter: blur(15px); border-bottom: 1px solid rgba(0,0,0,0.05); }
        h1,h2,h3,h4,h5,h6 { font-weight: 700; line-height: 1.2; }
        .navbar { padding: 0.7rem 0; transition: all 0.3s ease; z-index: 1000; }
        .navbar-brand { font-weight: 800; font-size: 1.8rem; color: var(--primary-color) !important; display: flex; align-items: center; gap: 8px; }
        .nav-link { font-weight: 500; padding: 0.4rem 0.8rem !important; border-radius: 6px; color: inherit !important; }
        [data-bs-theme="dark"] .nav-link:hover { background-color: rgba(19, 115, 125, 0.1); }
        [data-bs-theme="light"] .nav-link:hover { background-color: rgba(19, 115, 125, 0.08); }
        .btn-primary { background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border: none; color: white; font-weight: 600; padding: 0.6rem 1.5rem; border-radius: 8px; transition: all 0.3s ease; }
        .btn-primary:hover { background: linear-gradient(135deg, var(--primary-dark), var(--primary-color)); color: white; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(19, 115, 125, 0.3); }
        .btn-outline { border: 2px solid var(--primary-color); color: var(--primary-color); font-weight: 600; padding: 0.6rem 1.5rem; border-radius: 8px; transition: all 0.3s ease; background: transparent; }
        [data-bs-theme="dark"] .btn-outline { color: var(--text-light); border-color: var(--primary-light); }
        .btn-outline:hover { background-color: var(--primary-color); color: white; transform: translateY(-2px); }
        footer { padding: 1.5rem 0; border-top: 1px solid rgba(255, 255, 255, 0.05); }
        [data-bs-theme="light"] footer { border-top: 1px solid rgba(0, 0, 0, 0.05); }
        .footer-brand { font-weight: 800; font-size: 1.6rem; color: var(--primary-color); margin-bottom: 0.8rem; display: inline-block; }
        .theme-toggle { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s ease; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); }
        [data-bs-theme="light"] .theme-toggle { background: rgba(0, 0, 0, 0.05); border: 1px solid rgba(0, 0, 0, 0.1); }
        .theme-toggle:hover { transform: rotate(180deg); }
        @media (max-width: 992px) {
            .navbar-collapse { padding: 1rem; border-radius: 12px; margin-top: 0.8rem; }
            [data-bs-theme="dark"] .navbar-collapse { background: var(--card-dark); box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15); }
            [data-bs-theme="light"] .navbar-collapse { background: white; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); }
        }
        /* Doc page */
        .doc-hero { padding: 100px 0 40px; }
        .doc-hero h1 { font-size: 2rem; font-weight: 700; background: linear-gradient(135deg, var(--primary-light), var(--accent-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .api-doc-card { border-radius: 14px; overflow: hidden; border: none; }
        .api-doc-card .tab-content { padding: 1.5rem 1.5rem 2rem; }
        .endpoint-badge { display: inline-block; padding: 6px 14px; border-radius: 6px; font-size: 12px; font-weight: 700; font-family: monospace; }
        .endpoint-badge.post { background: #10b981; color: white; }
        .endpoint-url { padding: 14px 16px; border-radius: 8px; font-family: 'Consolas', 'Monaco', monospace; font-size: 14px; border-left: 4px solid #10b981; word-break: break-all; }
        [data-bs-theme="dark"] .endpoint-url { background: rgba(0,0,0,0.2); }
        [data-bs-theme="light"] .endpoint-url { background: #f1f5f9; }
        .code-block { padding: 18px 20px; border-radius: 8px; margin: 0; overflow-x: auto; font-size: 13px; line-height: 1.7; }
        .code-block code { font-family: 'Consolas', 'Monaco', monospace; color: inherit; }
        [data-bs-theme="dark"] .code-block { background: var(--card-dark); color: var(--text-light); border: 1px solid rgba(255,255,255,0.08); }
        [data-bs-theme="light"] .code-block { background: #fff; color: var(--text-dark); border: 1px solid rgba(0,0,0,0.08); }
        [data-bs-theme="dark"] pre.rounded.border { background: var(--card-dark); color: var(--text-light); border: 1px solid rgba(255,255,255,0.08) !important; }
        [data-bs-theme="light"] pre.rounded.border { background: #f8fafc; color: var(--text-dark); border: 1px solid rgba(0,0,0,0.08) !important; }
        .response-success { border-left: 4px solid #10b981 !important; }
        .response-error { border-left: 4px solid #ef4444 !important; }
        .log-detail pre { font-size: 0.8rem; max-height: 400px; overflow: auto; white-space: pre-wrap; word-break: break-all; }
        /* Tab card: kontras & compact di HP */
        .api-doc-card #apiTabs { display: flex; flex-wrap: wrap; gap: 0.25rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding: 0 1rem 0.5rem; }
        [data-bs-theme="light"] .api-doc-card #apiTabs { border-bottom-color: rgba(0,0,0,0.08); }
        .api-doc-card #apiTabs .nav-item { flex: 1; min-width: 0; }
        .api-doc-card #apiTabs .nav-link { width: 100%; text-align: center; padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: 600; border: none; border-bottom: 3px solid transparent; border-radius: 6px; background: rgba(255,255,255,0.04); color: var(--text-muted-light); }
        [data-bs-theme="light"] .api-doc-card #apiTabs .nav-link { background: rgba(0,0,0,0.04); color: var(--text-muted-dark); }
        .api-doc-card #apiTabs .nav-link:hover { color: var(--primary-light); background: rgba(19, 115, 125, 0.12); }
        .api-doc-card #apiTabs .nav-link.active { color: white; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border-bottom-color: transparent; }
        @media (max-width: 576px) {
            .api-doc-card #apiTabs .nav-link { padding: 0.4rem 0.5rem; font-size: 0.8125rem; }
        }
        .param-table { font-size: 14px; }
        .param-table th { font-weight: 600; }
        .param-table code { background: rgba(19, 115, 125, 0.15); padding: 2px 8px; border-radius: 4px; font-size: 13px; }
        .required-badge { background: #ef4444; color: white; padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .optional-badge { background: #6b7280; color: white; padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .section-title { font-size: 1rem; font-weight: 700; margin-bottom: 0.75rem; color: inherit; }
        .coming-soon-block { padding: 4rem 2rem; text-align: center; }
        .coming-soon-block .icon { font-size: 4rem; opacity: 0.4; }
        .coming-soon-block h4 { font-weight: 700; margin-bottom: 0.5rem; }
    </style>
</head>
<body>

    <!-- Navigation (sama dengan master home) -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('frontend') }}/logo.png" alt="QRIN Logo" style="width: 150px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#solutions">Solusi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/api-docs') }}">
                            <i class="fas fa-code me-1"></i> Dokumentasi API
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <div class="theme-toggle" id="themeToggle">
                        <i class="fas fa-moon"></i>
                    </div>
                    <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ url('/register') }}" class="btn btn-outline">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <section class="doc-hero">
        <div class="container">
            <h1><i class="fas fa-book me-2"></i>Dokumentasi API</h1>
            <p class="text-muted">Panduan teknis integrasi QRIS — Generate QRIS dan webhook. Mudah dibaca dan dipahami.</p>
        </div>
    </section>

    <section class="pb-5">
        <div class="container">
            <div class="card api-doc-card shadow-sm">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs pt-3" id="apiTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-generate-qris" data-bs-toggle="tab" data-bs-target="#panel-generate-qris" type="button" role="tab">
                                <i class="fas fa-qrcode me-1 me-sm-2"></i><span class="d-none d-sm-inline">Generate QRIS</span><span class="d-inline d-sm-none">QRIS</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-webhook" data-bs-toggle="tab" data-bs-target="#panel-webhook" type="button" role="tab">
                                <i class="fas fa-webhook me-1 me-sm-2"></i><span class="d-none d-sm-inline">Callback / Webhook</span><span class="d-inline d-sm-none">Webhook</span>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="apiTabsContent">
                        <!-- Tab 1: Generate QRIS -->
                        <div class="tab-pane fade show active" id="panel-generate-qris" role="tabpanel">
                            <h5 class="fw-bold mb-2">1. Generate QRIS</h5>
                            <p class="text-muted mb-4">Endpoint untuk menghasilkan kode QRIS dinamis yang bisa dipindai oleh customer untuk membayar.</p>

                            <div class="row g-3 log-detail">
                                <div class="col-12">
                                    <div class="card border h-100">
                                        <div class="card-header py-2"><h6 class="mb-0 fw-bold">Endpoint</h6></div>
                                        <div class="card-body p-3">
                                            <p class="small text-muted mb-1">Method & URL</p>
                                            <pre class="rounded border p-3 mb-0 response-success">POST https://api.qrin.web.id/v1.0/generate-qris</pre>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border h-100">
                                        <div class="card-header py-2"><h6 class="mb-0 fw-bold">Request Body</h6></div>
                                        <div class="card-body p-3">
                                            <p class="text-muted small mb-2">Kirim JSON dengan <code>Content-Type: application/json</code></p>
                                            <pre class="rounded border p-3 mb-0">{
    "token_qrin": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "request_payload_qris": {
        "no_ref_merchant": "TRX-123456789",
        "amount": { "value": "10000.00", "currency": "IDR" },
        "additional_info": {
            "customer_name": "Nama Pelanggan",
            "customer_email": "emailpelanggan@domain.com",
            "customer_phone": "081234567890"
        }
    }
}</pre>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border h-100">
                                        <div class="card-header py-2"><h6 class="mb-0 fw-bold">Parameter</h6></div>
                                        <div class="card-body p-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered param-table mb-0">
                                                    <thead>
                                                        <tr><th>Parameter</th><th>Type</th><th>Required</th><th>Keterangan</th></tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr><td><code>token_qrin</code></td><td>String</td><td><span class="required-badge">Ya</span></td><td>Token QRIN dari Setting Merchant</td></tr>
                                                        <tr><td><code>request_payload_qris.no_ref_merchant</code></td><td>String</td><td><span class="required-badge">Ya</span></td><td>Nomor referensi unik transaksi</td></tr>
                                                        <tr><td><code>request_payload_qris.amount.value</code></td><td>String</td><td><span class="required-badge">Ya</span></td><td>Nominal (format: "10000.00", minimal 1000.00)</td></tr>
                                                        <tr><td><code>request_payload_qris.amount.currency</code></td><td>String</td><td><span class="required-badge">Ya</span></td><td>Mata uang (wajib "IDR")</td></tr>
                                                        <tr><td><code>request_payload_qris.additional_info.customer_name</code></td><td>String</td><td><span class="optional-badge">Opsional</span></td><td>Nama pelanggan. Jika diisi, panjang 5–100 karakter.</td></tr>
                                                        <tr><td><code>request_payload_qris.additional_info.customer_email</code></td><td>String</td><td><span class="optional-badge">Opsional</span></td><td>Email pelanggan. Jika diisi, harus format email yang valid.</td></tr>
                                                        <tr><td><code>request_payload_qris.additional_info.customer_phone</code></td><td>String</td><td><span class="optional-badge">Opsional</span></td><td>Nomor telepon pelanggan. Jika diisi, 8–13 karakter, diawali 08 atau 62.</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border h-100">
                                        <div class="card-header py-2"><h6 class="mb-0 fw-bold">Response</h6></div>
                                        <div class="card-body p-3">
                                            <p class="small fw-bold text-muted mb-1">Success Response (200 OK)</p>
                                            <pre class="rounded border p-3 mb-3 response-success">{ }</pre>
                                            <p class="small fw-bold text-muted mb-1">Failed / Error Response (400 Bad Request)</p>
                                            <pre class="rounded border p-3 mb-0 response-error">{
    "success": false,
    "message": "token_qrin is required",
    "data": null
}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Callback / Webhook -->
                        <div class="tab-pane fade" id="panel-webhook" role="tabpanel">
                            <h5 class="fw-bold mb-2">2. Callback / Webhook</h5>
                            <p class="text-muted mb-4">Setelah ada pembayaran atau perubahan status, QRIN mengirim data transaksi ke <strong>URL Callback</strong> yang Anda daftarkan di Setting Merchant.</p>

                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-6">
                                    <div class="card border h-100">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">Cara kerja</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <ul class="text-muted mb-0 small">
                                                <li class="mb-1">QRIN mengirim <strong>POST</strong> ke URL callback merchant.</li>
                                                <li class="mb-1">Body berisi JSON data transaksi (status, nominal, dll).</li>
                                                <li class="mb-0">Header <code>X-Callback-Signature</code> = HMAC-SHA256(raw body, <code>token_qrin</code>) untuk validasi.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="card border h-100">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">Status transaksi</h6>
                                        </div>
                                        <div class="card-body p-3 small">
                                            <p class="text-muted mb-2">Nilai field <code>status</code>:</p>
                                            <ul class="mb-0 text-muted">
                                                <li><code>pending</code> — Menunggu</li>
                                                <li><code>success</code> — Berhasil</li>
                                                <li><code>failed</code> — Gagal</li>
                                                <li><code>expired</code> — Kadaluarsa</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4 log-detail">
                                <div class="col-12">
                                    <div class="card border h-100">
                                        <div class="card-header py-2"><h6 class="mb-0 fw-bold">Header yang dikirim QRIN</h6></div>
                                        <div class="card-body p-3">
                                            <p class="small text-muted mb-1">Contoh header</p>
                                            <pre class="rounded border p-3 mb-3">Content-Type: application/json
X-Callback-Signature: &lt;hmac_sha256&gt;</pre>
                                            <p class="small text-muted mb-0"><code>X-Callback-Signature</code> = HMAC-SHA256(<em>raw body JSON</em>, <em>token_qrin</em>).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card border h-100">
                                        <div class="card-header py-2"><h6 class="mb-0 fw-bold">Contoh payload (body) QRIN → Merchant</h6></div>
                                        <div class="card-body p-3">
                                            <p class="small text-muted mb-1">Contoh payload</p>
                                            <pre class="rounded border p-3 mb-0">{
    "id": "ae0e42e0-b759-4cac-98da-9c0752152853",
    "tanggal_transaksi": "2026-02-22T23:52:00+07:00",
    "merchant_id": "04c9e242-3639-46bf-952a-e8221ef0cb5c",
    "no_referensi": "QR000002-260222-773140",
    "no_ref_merchant": "TRX-0001",
    "nama_pelanggan": "Muhammad Saeful Ramdan",
    "email_pelanggan": "saepulramdan244@gmail.com",
    "no_telpon_pelanggan": "083874731480",
    "biaya": 531.72,
    "jumlah_dibayar": 4532,
    "jumlah_diterima": 4000.28,
    "status": "success",
    "beban_biaya": "Pelanggan",
    "created_at": "2026-02-22T23:53:25+07:00",
    "updated_at": "2026-02-22T23:53:59+07:00"
}</pre>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="log-detail">
                                <div class="card border">
                                    <div class="card-header py-2"><h6 class="mb-0 fw-bold">Contoh penanganan callback (PHP)</h6></div>
                                    <div class="card-body p-3">
                                        <p class="text-muted small mb-2">Gunakan <strong>token_qrin</strong> dari Setting Merchant untuk validasi signature.</p>
                                        <pre class="rounded border p-3 mb-0">&lt;?php
$json = file_get_contents('php://input');
$callbackSignature = $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] ?? '';
$tokenQrin = 'token_qrin_anda_dari_dashboard';
$signature = hash_hmac('sha256', $json, $tokenQrin);

if (!hash_equals($signature, $callbackSignature)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid signature']);
    exit;
}

$data = json_decode($json);
if (json_last_error() !== JSON_ERROR_NONE) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

$noRefMerchant = $data->no_ref_merchant;
$status       = $data->status;
// Update transaksi Anda berdasarkan no_ref_merchant

header('Content-Type: application/json');
echo json_encode(['success' => true]);</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </section>

    <!-- Footer (sama dengan master home) -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="footer-brand">QRIN</div>
                    <p class="text-muted mb-2">Solusi pembayaran QRIS untuk bisnis Indonesia.</p>
                    <small class="text-muted">Didukung oleh PT. Teknologi Cipta Aplikasi Nusantara</small>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold mb-2">Kontak</h6>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1"><a href="mailto:saepulramdan244@gmail.com" class="text-muted text-decoration-none">saepulramdan244@gmail.com</a></li>
                                <li class="mb-1"><a href="tel:083874731480" class="text-muted text-decoration-none">0838-7473-1480</a></li>
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
                <p class="mb-0 small">&copy; {{ date('Y') }} QRIN - PT. Teknologi Cipta Aplikasi Nusantara</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle (sama dengan master home)
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme') || 'dark';
        html.setAttribute('data-bs-theme', savedTheme);
        function updateThemeIcon(theme) {
            const icon = themeToggle.querySelector('i');
            if (theme === 'light') { icon.classList.remove('fa-moon'); icon.classList.add('fa-sun'); }
            else { icon.classList.remove('fa-sun'); icon.classList.add('fa-moon'); }
        }
        updateThemeIcon(savedTheme);
        themeToggle.addEventListener('click', function () {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
    </script>
</body>
</html>
