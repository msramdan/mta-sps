@extends('layouts.app')

@section('title', __(key: 'Dokumentasi API'))

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
                    <h4 class="main-title">{{ __(key: 'Dokumentasi API') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Dokumentasi API') }}</a>
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
                                            <div class="endpoint-url bg-body-secondary flex-grow-1">https://api.qrin.web.id/v1.0/generate-qris</div>
                                        </div>
                                    </div>

                                    <!-- Request Body -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Request Body</h6>
                                        <p class="text-muted small mb-2">Kirim JSON dengan <code>Content-Type: application/json</code></p>
                                        <pre class="code-block"><code>{
    "token_qrin": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "request_payload_qris": {
        "no_ref_merchant": "TRX-123456789",
        "amount": {
            "value": "10000.00",
            "currency": "IDR"
        },
        "additional_info": {
            "customer_name": "Nama Pelanggan",
            "customer_email": "emailpelanggan@domain.com",
            "customer_phone": "081234567890"
        }
    }
}</code></pre>
                                    </div>

                                    <!-- Request Parameters -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Parameter</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered param-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 220px;">Parameter</th>
                                                        <th style="width: 90px;">Type</th>
                                                        <th style="width: 90px;">Required</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><code>token_qrin</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Ya</span></td>
                                                        <td>Token QRIN dari Setting Merchant</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>request_payload_qris.no_ref_merchant</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Ya</span></td>
                                                        <td>Nomor referensi unik transaksi</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>request_payload_qris.amount.value</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Ya</span></td>
                                                        <td>Nominal transaksi (format: "10000.00", minimal 1000.00)</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>request_payload_qris.amount.currency</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Ya</span></td>
                                                        <td>Mata uang (wajib "IDR")</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>request_payload_qris.additional_info.customer_name</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Opsional</span></td>
                                                        <td>Nama pelanggan. Jika diisi, panjang 5–100 karakter.</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>request_payload_qris.additional_info.customer_email</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Opsional</span></td>
                                                        <td>Email pelanggan. Jika diisi, harus format email yang valid.</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>request_payload_qris.additional_info.customer_phone</code></td>
                                                        <td>String</td>
                                                        <td><span class="optional-badge">Opsional</span></td>
                                                        <td>Nomor telepon pelanggan. Jika diisi, 8–13 karakter, diawali 08 atau 62.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Response Examples -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Response</h6>

                                        <div class="mb-3">
                                            <p class="mb-2"><strong class="text-success">Success Response (200 OK)</strong></p>
                                            <pre class="code-block response-success"><code class="text-muted">{ }</code></pre>
                                        </div>

                                        <div>
                                            <p class="mb-2"><strong class="text-danger">Failed / Error Response (400 Bad Request)</strong></p>
                                            <pre class="code-block response-error"><code>{
    "success": false,
    "message": "token_qrin is required",
    "data": null
}</code></pre>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Status Tab -->
                                <div class="tab-pane fade" id="payment-status" role="tabpanel">
                                    <h5 class="mb-3 fw-bold">2. Status Pembayaran</h5>
                                    <p class="text-muted">Endpoint untuk mengecek status pembayaran transaksi berdasarkan nomor referensi merchant.</p>

                                    <!-- Endpoint Info -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Endpoint</h6>
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="endpoint-badge post">POST</span>
                                            <div class="endpoint-url bg-body-secondary flex-grow-1">https://api.qrin.web.id/v1.0/query-payment-status</div>
                                        </div>
                                    </div>

                                    <!-- Request Body -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Request Body</h6>
                                        <p class="text-muted small mb-2">Kirim JSON dengan <code>Content-Type: application/json</code></p>
                                        <pre class="code-block"><code>{
    "token_qrin": "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
    "request_payload_qris": {
        "no_ref_merchant": "TRX-123456789"
    }
}</code></pre>
                                    </div>

                                    <!-- Request Parameters -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-2">Parameter</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered param-table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 220px;">Parameter</th>
                                                        <th style="width: 90px;">Type</th>
                                                        <th style="width: 90px;">Required</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><code>token_qrin</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Ya</span></td>
                                                        <td>Token QRIN dari Setting Merchant</td>
                                                    </tr>
                                                    <tr>
                                                        <td><code>request_payload_qris.no_ref_merchant</code></td>
                                                        <td>String</td>
                                                        <td><span class="required-badge">Ya</span></td>
                                                        <td>Nomor referensi transaksi yang dicek</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Response Examples -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3">Response</h6>

                                        <div class="mb-3">
                                            <p class="mb-2"><strong class="text-success">Success Response (200 OK)</strong></p>
                                            <pre class="code-block response-success"><code class="text-muted">{ }</code></pre>
                                        </div>

                                        <div>
                                            <p class="mb-2"><strong class="text-danger">Failed / Error Response (400 Bad Request)</strong></p>
                                            <pre class="code-block response-error"><code>{
    "success": false,
    "message": "token_qrin is required",
    "data": null
}</code></pre>
                                        </div>
                                    </div>
                                </div>

                                <!-- Webhook Tab -->
                                <div class="tab-pane fade" id="webhook" role="tabpanel">
                                    <h5 class="mb-3 fw-bold">3. Callback / Webhook</h5>
                                    <div class="text-center py-5">
                                        <div class="display-4 text-muted mb-3">
                                            <i class="ti ti-clock-hour-4"></i>
                                        </div>
                                        <h4 class="fw-bold mb-2">Coming Soon</h4>
                                        <p class="text-muted mb-0">Dokumentasi Callback / Webhook akan segera tersedia.</p>
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
