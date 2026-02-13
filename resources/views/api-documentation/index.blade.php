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
                                    <h5 class="mb-3 fw-bold">1. Generate QRIS</h5>
                                    <p class="text-muted">Endpoint untuk menghasilkan kode QRIS dinamis untuk transaksi pembayaran.</p>

                                    <!-- Endpoint Info -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Endpoint</h6>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="endpoint-badge post">POST</span>
                                            <div class="endpoint-url bg-body-secondary flex-grow-1">http://localhost:8080/v1.0/generate-qris</div>
                                        </div>
                                    </div>

                                    <!-- Request Parameters -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Request Body Parameters</h6>
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
                                                        <td><span class="required-badge">Required</span></td>
                                                        <td>Token autentikasi merchant dari dashboard</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>partnerReferenceNo</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Required</span></td>
                                                        <td>Nomor referensi unik dari sistem merchant</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>amount.value</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Required</span></td>
                                                        <td>Nominal transaksi (format: "10000.00")</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>amount.currency</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Required</span></td>
                                                        <td>Mata uang (default: "IDR")</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>additionalInfo.validTime</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Optional</span></td>
                                                        <td>Waktu valid QRIS dalam detik (default: 9000)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>additionalInfo.tip</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Optional</span></td>
                                                        <td>Izinkan tip ("true" / "false")</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>additionalInfo.qrType</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Optional</span></td>
                                                        <td>Tipe QRIS (03 = Dynamic)</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Request Example -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Request Example</h6>
                                        <pre class="code-block"><code>{
  "token_qrin": "your-merchant-token-here",
  "request_payload_qris": {
    "partnerReferenceNo": "TRX-2026021312345",
    "amount": {
      "value": "10000.00",
      "currency": "IDR"
    },
    "additionalInfo": {
      "validTime": "9000",
      "tip": "false",
      "qrType": "03"
    }
  }
}</code></pre>
                                    </div>

                                    <!-- Response Examples -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Response Examples</h6>

                                        <!-- Error Response -->
                                        <div class="mb-3">
                                            <p class="mb-2"><strong class="text-danger">Error Response (400 Bad Request)</strong></p>
                                            <pre class="code-block response-error"><code>{
  "success": false,
  "message": "token_qrin is required",
  "data": null
}</code></pre>
                                        </div>

                                        <!-- Success Response -->
                                        <div>
                                            <p class="mb-2"><strong class="text-success">Success Response (200 OK)</strong></p>
                                            <pre class="code-block response-success"><code>{
  "success": true,
  "message": "QRIS berhasil di-generate",
  "data": {
    "qrisContent": "00020101021126670016ID.CO.QRIS.WWW011893600009150010990303UMI51440014ID.CO.TELKOM.WWW02180123456789012345670303UMI5204581253033605802ID5915MERCHANT NAME 6015JAKARTA SELATAN61051234062070703A01630445B4",
    "qrisImage": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAA...",
    "partnerReferenceNo": "TRX-2026021312345",
    "amount": "10000.00",
    "validUntil": "2026-02-13 15:30:00",
    "status": "pending"
  }
}</code></pre>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Status Tab -->
                                <div class="tab-pane fade" id="payment-status" role="tabpanel">
                                    <h5 class="mb-3 fw-bold">2. Status Pembayaran</h5>
                                    <p class="text-muted">Endpoint untuk mengecek status pembayaran transaksi berdasarkan nomor referensi.</p>

                                    <!-- Endpoint Info -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Endpoint</h6>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="endpoint-badge post">POST</span>
                                            <div class="endpoint-url bg-body-secondary flex-grow-1">http://localhost:8080/v1.0/payment-status</div>
                                        </div>
                                    </div>

                                    <!-- Request Parameters -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Request Body Parameters</h6>
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
                                                        <td><span class="required-badge">Required</span></td>
                                                        <td>Token autentikasi merchant</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>partnerReferenceNo</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Required</span></td>
                                                        <td>Nomor referensi transaksi yang ingin dicek</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Request Example -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Request Example</h6>
                                        <pre class="code-block"><code>{
  "token_qrin": "your-merchant-token-here",
  "partnerReferenceNo": "TRX-2026021312345"
}</code></pre>
                                    </div>

                                    <!-- Response Examples -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Response Examples</h6>

                                        <!-- Success - Pending -->
                                        <div class="mb-3">
                                            <p class="mb-2"><strong class="text-warning">Success - Pending (200 OK)</strong></p>
                                            <pre class="code-block"><code>{
  "success": true,
  "message": "Transaksi ditemukan",
  "data": {
    "partnerReferenceNo": "TRX-2026021312345",
    "amount": "10000.00",
    "status": "pending",
    "createdAt": "2026-02-13 13:00:00",
    "validUntil": "2026-02-13 15:30:00"
  }
}</code></pre>
                                        </div>

                                        <!-- Success - Paid -->
                                        <div class="mb-3">
                                            <p class="mb-2"><strong class="text-success">Success - Paid (200 OK)</strong></p>
                                            <pre class="code-block response-success"><code>{
  "success": true,
  "message": "Transaksi ditemukan",
  "data": {
    "partnerReferenceNo": "TRX-2026021312345",
    "amount": "10000.00",
    "status": "success",
    "paidAt": "2026-02-13 13:15:30",
    "paymentMethod": "QRIS",
    "customerName": "John Doe"
  }
}</code></pre>
                                        </div>

                                        <!-- Error - Not Found -->
                                        <div>
                                            <p class="mb-2"><strong class="text-danger">Error - Not Found (404)</strong></p>
                                            <pre class="code-block response-error"><code>{
  "success": false,
  "message": "Transaksi tidak ditemukan",
  "data": null
}</code></pre>
                                        </div>
                                    </div>
                                </div>

                                <!-- Webhook Tab -->
                                <div class="tab-pane fade" id="webhook" role="tabpanel">
                                    <h5 class="mb-3 fw-bold">3. Callback / Webhook</h5>
                                    <p class="text-muted">Sistem akan mengirimkan notifikasi ke URL callback merchant ketika terjadi perubahan status transaksi.</p>

                                    <!-- Webhook Info -->
                                    <div class="mb-4">
                                        <div class="alert alert-info border-0">
                                            <h6 class="fw-bold mb-2"><i class="ti ti-settings me-1"></i> Konfigurasi Webhook</h6>
                                            <p class="mb-1">URL Callback dapat dikonfigurasi di halaman <strong>Setting Merchant</strong> pada dashboard Anda.</p>
                                            <p class="mb-0 text-muted small">Pastikan endpoint callback Anda dapat menerima HTTP POST request dengan format JSON.</p>
                                        </div>
                                    </div>

                                    <!-- Webhook Request -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Webhook Request (Dikirim oleh sistem)</h6>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <span class="endpoint-badge post">POST</span>
                                            <div class="endpoint-url bg-body-secondary flex-grow-1">https://your-merchant-site.com/webhook/payment-notification</div>
                                        </div>

                                        <div class="table-responsive mb-3">
                                            <table class="table table-bordered param-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 200px;">Parameter</th>
                                                        <th style="width: 100px;">Type</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><code>partnerReferenceNo</code></td>
                                                        <td>String</td>
                                                        <td>Nomor referensi transaksi</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>amount</code></td>
                                                        <td>String</td>
                                                        <td>Nominal pembayaran</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>status</code></td>
                                                        <td>String</td>
                                                        <td>Status transaksi (success/failed/expired)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>paidAt</code></td>
                                                        <td>String</td>
                                                        <td>Waktu pembayaran (jika success)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>paymentMethod</code></td>
                                                        <td>String</td>
                                                        <td>Metode pembayaran (QRIS)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>signature</code></td>
                                                        <td>String</td>
                                                        <td>Hash signature untuk validasi</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <p class="mb-2"><strong>Webhook Payload Example:</strong></p>
                                        <pre class="code-block"><code>{
  "partnerReferenceNo": "TRX-2026021312345",
  "amount": "10000.00",
  "status": "success",
  "paidAt": "2026-02-13 13:15:30",
  "paymentMethod": "QRIS",
  "customerName": "John Doe",
  "signature": "abc123def456ghi789jkl012mno345pqr678stu901vwx234yz"
}</code></pre>
                                    </div>

                                    <!-- Expected Response -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Expected Response dari Merchant</h6>
                                        <p class="text-muted small mb-2">Endpoint callback merchant harus merespon dengan HTTP 200 untuk konfirmasi penerimaan webhook.</p>
                                        <pre class="code-block response-success"><code>{
  "success": true,
  "message": "Webhook received"
}</code></pre>
                                    </div>

                                    <!-- Verification -->
                                    <div class="alert alert-warning border-0">
                                        <h6 class="fw-bold mb-2"><i class="ti ti-shield-check me-1"></i> Signature Verification</h6>
                                        <p class="mb-0 small">Selalu verifikasi signature yang diterima untuk memastikan webhook berasal dari sistem kami. Signature dihitung menggunakan HMAC-SHA256 dengan secret key merchant Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
