@extends('layouts.app')

@section('title', __(key: 'API Documentation'))

@push('css')
<style>
    .endpoint-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        font-family: monospace;
    }
    .endpoint-badge.post {
        background: #10b981;
        color: white;
    }
    .endpoint-url {
        padding: 12px;
        border-radius: 6px;
        font-family: monospace;
        font-size: 14px;
        border-left: 4px solid #10b981;
        word-break: break-all;
    }
    pre.code-block {
        background: #1e293b;
        color: #e2e8f0;
        padding: 16px;
        border-radius: 6px;
        margin: 0;
        overflow-x: auto;
    }
    pre.code-block code {
        font-family: 'Courier New', monospace;
        font-size: 13px;
        line-height: 1.6;
    }
    .param-table th {
        font-weight: 600;
        font-size: 13px;
    }
    .param-table td {
        font-size: 13px;
    }
    .required-badge {
        background: #ef4444;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 600;
    }
    .optional-badge {
        background: #6b7280;
        color: white;
        padding: 2px 8px;
        border-radius: 3px;
        font-size: 11px;
        font-weight: 600;
    }
    .response-success {
        border-left: 4px solid #10b981;
    }
    .response-error {
        border-left: 4px solid #ef4444;
    }
</style>
@endpush

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __(key: 'API Documentation') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'API Documentation') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Intro Card -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti ti-info-circle text-primary me-2" style="font-size: 24px;"></i>
                                <h5 class="mb-0">Informasi Umum</h5>
                            </div>
                            <p class="text-muted mb-2">Dokumentasi API untuk integrasi sistem pembayaran QRIS. Semua request menggunakan format JSON dan memerlukan autentikasi menggunakan <code>token_qrin</code>.</p>
                            <div class="alert alert-warning border-0 mb-0">
                                <strong><i class="ti ti-shield-lock me-1"></i> Authentication:</strong> Setiap request wajib menyertakan <code>token_qrin</code> yang dapat diperoleh dari dashboard merchant Anda.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Endpoints -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <ul class="nav nav-tabs px-3 pt-3" id="apiTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="generate-qris-tab" data-bs-toggle="tab"
                                            data-bs-target="#generate-qris" type="button" role="tab">
                                        <i class="ti ti-qrcode me-1"></i> Generate QRIS
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="payment-status-tab" data-bs-toggle="tab"
                                            data-bs-target="#payment-status" type="button" role="tab">
                                        <i class="ti ti-file-search me-1"></i> Status Pembayaran
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="webhook-tab" data-bs-toggle="tab"
                                            data-bs-target="#webhook" type="button" role="tab">
                                        <i class="ti ti-webhook me-1"></i> Callback / Webhook
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content p-4" id="apiTabsContent">
                                <!-- Generate QRIS Tab -->
                                <div class="tab-pane fade show active" id="generate-qris" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ti ti-qrcode text-success me-2" style="font-size: 32px;"></i>
                                        <div>
                                            <h5 class="mb-1 fw-bold">1. Generate QRIS - Membuat Kode QR Pembayaran</h5>
                                            <p class="text-muted mb-0 small">Gunakan endpoint ini untuk membuat kode QR yang bisa di-scan customer untuk membayar</p>
                                        </div>
                                    </div>

                                    <!-- Use Case -->
                                    <div class="alert alert-light border mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-bulb-filled text-warning me-1"></i> Kapan Menggunakan Ini?</h6>
                                        <p class="mb-2 small">Contoh penggunaan:</p>
                                        <ul class="small mb-0">
                                            <li>Customer checkout di website/aplikasi Anda dengan total Rp 50.000</li>
                                            <li>Sistem Anda panggil API ini untuk buat kode QRIS dengan nominal Rp 50.000</li>
                                            <li>Tampilkan kode QRIS ke customer untuk di-scan pakai aplikasi banking mereka</li>
                                        </ul>
                                    </div>

                                    <!-- Endpoint Info -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-link me-1"></i> URL API</h6>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="endpoint-badge post">POST</span>
                                            <div class="endpoint-url bg-body-secondary flex-grow-1">http://localhost:8080/v1.0/generate-qris</div>
                                        </div>
                                        <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Kirim request ke URL ini menggunakan method POST</small>
                                    </div>

                                    <!-- Request Parameters -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-file-text me-1"></i> Data yang Perlu Dikirim</h6>
                                        <p class="small text-muted mb-3">Berikut adalah data yang harus Anda sertakan saat memanggil API ini:</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered param-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 200px;">Parameter</th>
                                                        <th style="width: 100px;">Type</th>
                                                        <th style="width: 100px;">Required</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><code>token_qrin</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Wajib</span></td>
                                                        <td><strong>Token keamanan Anda.</strong> Dapatkan dari menu Setting Merchant</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>partnerReferenceNo</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Wajib</span></td>
                                                        <td><strong>Nomor invoice/order Anda.</strong> Contoh: "INV-001", "ORDER-12345" (harus unik untuk setiap transaksi)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>amount.value</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Wajib</span></td>
                                                        <td><strong>Jumlah yang harus dibayar.</strong> Format: "10000.00" (gunakan 2 angka desimal)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>amount.currency</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Wajib</span></td>
                                                        <td><strong>Mata uang.</strong> Untuk Indonesia gunakan "IDR"</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>additionalInfo.validTime</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Opsional</span></td>
                                                        <td><strong>Berapa lama QRIS aktif.</strong> Dalam detik. Default 9000 detik (2.5 jam)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>additionalInfo.tip</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Opsional</span></td>
                                                        <td><strong>Boleh kasih tips atau tidak.</strong> Gunakan "true" atau "false"</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>additionalInfo.qrType</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Opsional</span></td>
                                                        <td><strong>Tipe QRIS.</strong> Gunakan "03" untuk QRIS dinamis (recommended)</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Request Example -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-code me-1"></i> Contoh Request - Cara Memanggil API</h6>
                                        <div class="alert alert-light border mb-2">
                                            <small><i class="ti ti-info-circle me-1"></i><strong>Penjelasan:</strong> Ini contoh data yang Anda kirim untuk membuat QRIS Rp 10.000 dengan nomor order "TRX-2026021312345"</small>
                                        </div>
                                        <pre class="code-block"><code>{
  "token_qrin": "your-merchant-token-here",    <span style="color: #94a3b8;">← Ganti dengan token Anda</span>
  "request_payload_qris": {
    "partnerReferenceNo": "TRX-2026021312345", <span style="color: #94a3b8;">← Nomor invoice/order Anda</span>
    "amount": {
      "value": "10000.00",                     <span style="color: #94a3b8;">← Nominal Rp 10.000</span>
      "currency": "IDR"
    },
    "additionalInfo": {
      "validTime": "9000",                     <span style="color: #94a3b8;">← QRIS aktif 2.5 jam</span>
      "tip": "false",
      "qrType": "03"                           <span style="color: #94a3b8;">← QRIS dinamis</span>
    }
  }
}</code></pre>
                                    </div>

                                    <!-- Response Examples -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3"><i class="ti ti-arrow-back-up me-1"></i> Jawaban dari Sistem</h6>

                                        <!-- Error Response -->
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-circle-x text-danger me-2"></i>
                                                <strong class="text-danger">Jika Ada Kesalahan</strong>
                                            </div>
                                            <p class="small text-muted mb-2">Contoh response ketika token tidak diisi:</p>
                                            <pre class="code-block response-error"><code>{
  "success": false,                    <span style="color: #94a3b8;">← Gagal</span>
  "message": "token_qrin is required", <span style="color: #94a3b8;">← Pesan error</span>
  "data": null
}</code></pre>
                                            <div class="alert alert-danger border-0 mt-2">
                                                <small><i class="ti ti-alert-triangle me-1"></i><strong>Troubleshooting:</strong> Pastikan Anda sudah memasukkan token_qrin yang benar</small>
                                            </div>
                                        </div>

                                        <!-- Success Response -->
                                        <div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-circle-check text-success me-2"></i>
                                                <strong class="text-success">Jika Berhasil</strong>
                                            </div>
                                            <p class="small text-muted mb-2">Response yang Anda terima berisi kode QRIS yang siap ditampilkan:</p>
                                            <pre class="code-block response-success"><code>{
  "success": true,                                        <span style="color: #94a3b8;">← Berhasil!</span>
  "message": "QRIS berhasil di-generate",
  "data": {
    "qrisContent": "00020101021126670016ID.CO.QRIS...",  <span style="color: #94a3b8;">← String QRIS</span>
    "qrisImage": "data:image/png;base64,iVBORw0K...",   <span style="color: #94a3b8;">← Gambar QRIS (base64)</span>
    "partnerReferenceNo": "TRX-2026021312345",          <span style="color: #94a3b8;">← Nomor referensi Anda</span>
    "amount": "10000.00",                               <span style="color: #94a3b8;">← Nominal pembayaran</span>
    "validUntil": "2026-02-13 15:30:00",                <span style="color: #94a3b8;">← Batas waktu bayar</span>
    "status": "pending"                                 <span style="color: #94a3b8;">← Status: menunggu bayar</span>
  }
}</code></pre>
                                            <div class="alert alert-success border-0 mt-2">
                                                <small><i class="ti ti-check me-1"></i><strong>Langkah Selanjutnya:</strong> Tampilkan <code>qrisImage</code> ke customer untuk di-scan. Gunakan <code>partnerReferenceNo</code> untuk cek status pembayaran nanti.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Status Tab -->
                                <div class="tab-pane fade" id="payment-status" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ti ti-file-search text-primary me-2" style="font-size: 32px;"></i>
                                        <div>
                                            <h5 class="mb-1 fw-bold">2. Cek Status Pembayaran - Sudah Dibayar atau Belum?</h5>
                                            <p class="text-muted mb-0 small">Gunakan endpoint ini untuk mengecek apakah transaksi sudah dibayar oleh customer</p>
                                        </div>
                                    </div>

                                    <!-- Use Case -->
                                    <div class="alert alert-light border mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-bulb-filled text-warning me-1"></i> Kapan Menggunakan Ini?</h6>
                                        <p class="mb-2 small">Contoh penggunaan:</p>
                                        <ul class="small mb-0">
                                            <li>Setelah customer scan QRIS, Anda ingin tahu apakah mereka sudah bayar</li>
                                            <li>Customer refresh halaman, Anda perlu cek status terbaru</li>
                                            <li>Untuk konfirmasi sebelum mengirim barang/jasa ke customer</li>
                                        </ul>
                                    </div>

                                    <!-- Endpoint Info -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-link me-1"></i> URL API</h6>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="endpoint-badge post">POST</span>
                                            <div class="endpoint-url bg-body-secondary flex-grow-1">http://localhost:8080/v1.0/payment-status</div>
                                        </div>
                                        <small class="text-muted"><i class="ti ti-info-circle me-1"></i>Kirim request ke URL ini untuk cek status</small>
                                    </div>

                                    <!-- Request Parameters -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-file-text me-1"></i> Data yang Perlu Dikirim</h6>
                                        <p class="small text-muted mb-3">Yang perlu dikirim sangat sederhana, cukup 2 data:</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered param-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 200px;">Parameter</th>
                                                        <th style="width: 100px;">Type</th>
                                                        <th style="width: 100px;">Required</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><code>token_qrin</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Wajib</span></td>
                                                        <td><strong>Token keamanan Anda</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>partnerReferenceNo</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Wajib</span></td>
                                                        <td><strong>Nomor invoice/order yang ingin dicek.</strong> Contoh: "INV-001", "ORDER-12345"</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Request Example -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-code me-1"></i> Contoh Request</h6>
                                        <div class="alert alert-light border mb-2">
                                            <small><i class="ti ti-info-circle me-1"></i><strong>Penjelasan:</strong> Cek status pembayaran untuk order "TRX-2026021312345"</small>
                                        </div>
                                        <pre class="code-block"><code>{
  "token_qrin": "your-merchant-token-here",    <span style="color: #94a3b8;">← Token Anda</span>
  "partnerReferenceNo": "TRX-2026021312345"    <span style="color: #94a3b8;">← Order yang ingin dicek</span>
}</code></pre>
                                    </div>

                                    <!-- Response Examples -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3"><i class="ti ti-arrow-back-up me-1"></i> Kemungkinan Jawaban dari Sistem</h6>

                                        <!-- Success - Pending -->
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-clock text-warning me-2"></i>
                                                <strong class="text-warning">Status: Menunggu Pembayaran</strong>
                                            </div>
                                            <p class="small text-mut ed mb-2">QRIS sudah dibuat tapi customer belum bayar:</p>
                                            <pre class="code-block"><code>{
  "success": true,
  "message": "Transaksi ditemukan",
  "data": {
    "partnerReferenceNo": "TRX-2026021312345",
    "amount": "10000.00",
    "status": "pending",                     <span style="color: #94a3b8;">← Belum dibayar</span>
    "createdAt": "2026-02-13 13:00:00",      <span style="color: #94a3b8;">← Waktu QRIS dibuat</span>
    "validUntil": "2026-02-13 15:30:00"      <span style="color: #94a3b8;">← Batas waktu bayar</span>
  }
}</code></pre>
                                            <div class="alert alert-warning border-0 mt-2">
                                                <small><i class="ti ti-clock me-1"></i><strong>Arti:</strong> Transaksi ditemukan tapi customer belum membayar. Tunggu customer scan dan bayar.</small>
                                            </div>
                                        </div>

                                        <!-- Success - Paid -->
                                        <div class="mb-4">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-circle-check text-success me-2"></i>
                                                <strong class="text-success">Status: Sudah Dibayar ✓</strong>
                                            </div>
                                            <p class="small text-muted mb-2">Customer sudah berhasil membayar:</p>
                                            <pre class="code-block response-success"><code>{
  "success": true,
  "message": "Transaksi ditemukan",
  "data": {
    "partnerReferenceNo": "TRX-2026021312345",
    "amount": "10000.00",
    "status": "success",                     <span style="color: #94a3b8;">← Pembayaran berhasil!</span>
    "paidAt": "2026-02-13 13:15:30",         <span style="color: #94a3b8;">← Waktu customer bayar</span>
    "paymentMethod": "QRIS",                 <span style="color: #94a3b8;">← Metode pembayaran</span>
    "customerName": "John Doe"               <span style="color: #94a3b8;">← Nama pembayar</span>
  }
}</code></pre>
                                            <div class="alert alert-success border-0 mt-2">
                                                <small><i class="ti ti-check me-1"></i><strong>Arti:</strong> Transaksi sudah dibayar! Anda bisa proses pesanan/kirim barang ke customer.</small>
                                            </div>
                                        </div>

                                        <!-- Error - Not Found -->
                                        <div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-circle-x text-danger me-2"></i>
                                                <strong class="text-danger">Transaksi Tidak Ditemukan</strong>
                                            </div>
                                            <p class="small text-muted mb-2">Nomor referensi tidak ada dalam sistem:</p>
                                            <pre class="code-block response-error"><code>{
  "success": false,                        <span style="color: #94a3b8;">← Gagal</span>
  "message": "Transaksi tidak ditemukan",  <span style="color: #94a3b8;">← Pesan error</span>
  "data": null
}</code></pre>
                                            <div class="alert alert-danger border-0 mt-2">
                                                <small><i class="ti ti-alert-triangle me-1"></i><strong>Troubleshooting:</strong> Cek kembali nomor referensi yang Anda kirim, mungkin salah ketik.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Webhook Tab -->
                                <div class="tab-pane fade" id="webhook" role="tabpanel">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ti ti-webhook text-info me-2" style="font-size: 32px;"></i>
                                        <div>
                                            <h5 class="mb-1 fw-bold">3. Callback / Webhook - Notifikasi Otomatis</h5>
                                            <p class="text-muted mb-0 small">Sistem akan mengirim pemberitahuan otomatis ke server Anda saat customer membayar</p>
                                        </div>
                                    </div>

                                    <!-- Simple Explanation -->
                                    <div class="alert alert-light border mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-bulb-filled text-warning me-1"></i> Apa Itu Webhook? (Penjelasan Sederhana)</h6>
                                        <p class="mb-2 small">Bayangkan webhook seperti <strong>notifikasi WhatsApp otomatis</strong>:</p>
                                        <ul class="small mb-2">
                                            <li><strong>Tanpa Webhook:</strong> Anda harus terus-menerus cek status pembayaran ("Sudah bayar belum? Sudah bayar belum?")</li>
                                            <li><strong>Dengan Webhook:</strong> Sistem otomatis kirim pesan ke server Anda begitu customer bayar ("Hei, customer sudah bayar!")</li>
                                        </ul>
                                        <p class="mb-0 small"><strong>Keuntungan:</strong> Lebih efisien, hemat resources, dan customer tidak perlu menunggu lama.</p>
                                    </div>

                                    <!-- How It Works -->
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3"><i class="ti ti-timeline me-1"></i> Cara Kerja Webhook</h6>
                                            <div class="row g-2">
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <div class="badge bg-primary p-2 mb-2 w-100">1. Customer Bayar</div>
                                                        <small class="text-muted">Customer scan QRIS dan bayar</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-arrow-right"></i>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <div class="badge bg-success p-2 mb-2 w-100">2. Sistem Deteksi</div>
                                                        <small class="text-muted">Sistem tahu pembayaran berhasil</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-arrow-right"></i>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="text-center">
                                                        <div class="badge bg-info p-2 mb-2 w-100">3. Kirim ke Server Anda</div>
                                                        <small class="text-muted">Sistem POST data ke URL callback Anda</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Setup Webhook -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-settings me-1"></i> Cara Setting Webhook</h6>
                                        <div class="alert alert-info border-0 mb-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <p class="mb-1"><strong>Langkah Setup:</strong></p>
                                                    <ol class="small mb-0 ps-3">
                                                        <li>Buka menu <strong>Setting Merchant</strong> di dashboard</li>
                                                        <li>Isi field <strong>URL Callback</strong> dengan alamat server Anda</li>
                                                        <li>Simpan dan selesai!</li>
                                                    </ol>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <i class="ti ti-circle-check" style="font-size: 64px; opacity: 0.3;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="small text-muted"><i class="ti ti-info-circle me-1"></i>Contoh URL Callback: <code>https://tokoweb.com/api/payment-notification</code></p>
                                    </div>

                                    <!-- What System Sends -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-file-download me-1"></i> Data yang Dikirim Sistem ke Anda</h6>
                                        <p class="small text-muted mb-3">Ketika customer bayar, sistem akan POST data ini ke URL callback Anda:</p>
                                        <div class="table-responsive mb-3">
                                            <table class="table table-bordered param-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 200px;">Field</th>
                                                        <th style="width: 100px;">Type</th>
                                                        <th>Penjelasan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><code>partnerReferenceNo</code></td>
                                                        <td>String</td>
                                                        <td><strong>Nomor order/invoice Anda</strong> yang tadi dibuat</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>amount</code></td>
                                                        <td>String</td>
                                                        <td><strong>Jumlah yang dibayar</strong> customer</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>status</code></td>
                                                        <td>String</td>
                                                        <td><strong>Status pembayaran:</strong> "success" (berhasil), "failed" (gagal), atau "expired" (kadaluarsa)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>paidAt</code></td>
                                                        <td>String</td>
                                                        <td><strong>Kapan customer bayar</strong> (hanya ada jika status = success)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>paymentMethod</code></td>
                                                        <td>String</td>
                                                        <td><strong>Cara bayar:</strong> "QRIS"</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>customerName</code></td>
                                                        <td>String</td>
                                                        <td><strong>Nama customer</strong> yang bayar</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>signature</code></td>
                                                        <td>String</td>
                                                        <td><strong>Kode keamanan</strong> untuk memastikan data benar dari sistem kami</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <p class="mb-2"><strong><i class="ti ti-code me-1"></i> Contoh Data yang Dikirim:</strong></p>
                                        <div class="alert alert-light border mb-2">
                                            <small><i class="ti ti-info-circle me-1"></i>Sistem akan POST JSON ini ke URL callback Anda saat customer berhasil bayar</small>
                                        </div>
                                        <pre class="code-block"><code>{
  "partnerReferenceNo": "TRX-2026021312345",  <span style="color: #94a3b8;">← Nomor order Anda</span>
  "amount": "10000.00",                        <span style="color: #94a3b8;">← Nominal yang dibayar</span>
  "status": "success",                         <span style="color: #94a3b8;">← Pembayaran berhasil!</span>
  "paidAt": "2026-02-13 13:15:30",             <span style="color: #94a3b8;">← Waktu bayar</span>
  "paymentMethod": "QRIS",
  "customerName": "John Doe",                  <span style="color: #94a3b8;">← Nama pembayar</span>
  "signature": "abc123def456..."               <span style="color: #94a3b8;">← Kode keamanan</span>
}</code></pre>
                                    </div>

                                    <!-- What To Do -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-checklist me-1"></i> Yang Perlu Anda Lakukan</h6>
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="small mb-3"><strong>Server Anda harus:</strong></p>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="border-start border-3 border-primary ps-3">
                                                            <h6 class="fw-bold small mb-2">1. Terima Data</h6>
                                                            <p class="small text-muted mb-0">Buat endpoint yang bisa menerima HTTP POST dengan data JSON</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="border-start border-3 border-success ps-3">
                                                            <h6 class="fw-bold small mb-2">2. Verifikasi Signature</h6>
                                                            <p class="small text-muted mb-0">Cek <code>signature</code> untuk pastikan data dari sistem kami (bukan palsu)</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="border-start border-3 border-info ps-3">
                                                            <h6 class="fw-bold small mb-2">3. Update Order</h6>
                                                            <p class="small text-muted mb-0">Jika status = "success", update status order di database Anda menjadi "Lunas/Paid"</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="border-start border-3 border-warning ps-3">
                                                            <h6 class="fw-bold small mb-2">4. Kirim Response</h6>
                                                            <p class="small text-muted mb-0">Balas dengan HTTP 200 dan JSON konfirmasi</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Expected Response -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-arrow-back-up me-1"></i> Response yang Harus Anda Kirim Balik</h6>
                                        <p class="small text-muted mb-2">Setelah menerima webhook, server Anda harus membalas dengan:</p>
                                        <pre class="code-block response-success"><code>{
  "success": true,         <span style="color: #94a3b8;">← Konfirmasi sudah terima</span>
  "message": "Webhook received"
}</code></pre>
                                        <div class="alert alert-success border-0 mt-2">
                                            <small><i class="ti ti-check me-1"></i><strong>Penting:</strong> Response ini memberitahu sistem bahwa Anda sudah terima notifikasi. Jika tidak ada response, sistem akan coba kirim ulang.</small>
                                        </div>
                                    </div>

                                    <!-- Security Warning -->
                                    <div class="alert alert-warning border-0">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-shield-check me-1"></i> Keamanan Penting!</h6>
                                        <p class="small mb-2"><strong>Selalu verifikasi <code>signature</code>!</strong></p>
                                        <p class="small mb-0">Signature adalah kode keamanan yang memastikan webhook benar-benar dari sistem kami, bukan dari orang jahat yang coba kirim data palsu. Jangan pernah skip verifikasi ini!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Codes Reference -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="ti ti-list-numbers me-1"></i> HTTP Status Codes</h6>
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td><code>200</code></td>
                                    <td>Success - Request berhasil diproses</td>
                                </tr>
                                <tr>
                                    <td><code>400</code></td>
                                    <td>Bad Request - Parameter tidak valid</td>
                                </tr>
                                <tr>
                                    <td><code>401</code></td>
                                    <td>Unauthorized - Token tidak valid</td>
                                </tr>
                                <tr>
                                    <td><code>404</code></td>
                                    <td>Not Found - Data tidak ditemukan</td>
                                </tr>
                                <tr>
                                    <td><code>500</code></td>
                                    <td>Server Error - Terjadi kesalahan server</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3"><i class="ti ti-flag me-1"></i> Transaction Status</h6>
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td><code>pending</code></td>
                                    <td>Menunggu pembayaran</td>
                                </tr>
                                <tr>
                                    <td><code>success</code></td>
                                    <td>Pembayaran berhasil</td>
                                </tr>
                                <tr>
                                    <td><code>failed</code></td>
                                    <td>Pembayaran gagal</td>
                                </tr>
                                <tr>
                                    <td><code>expired</code></td>
                                    <td>QRIS sudah kadaluarsa</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
