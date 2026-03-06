@extends('layouts.app')

@section('title', __('Detail Log Generate QR'))

@push('css')
<style>
    .log-detail pre { font-size: 0.8rem; max-height: 400px; overflow: auto; white-space: pre-wrap; word-break: break-all; }
</style>
@endpush

@php
    $prettyJson = function ($str) {
        if (empty($str)) return '';
        $d = json_decode($str);
        return $d ? json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : e($str);
    };

    $payloadMerchantPretty = $prettyJson($logGenerateQr->payload_merchant_to_qrin);

    $headerB2bPretty = $prettyJson($logGenerateQr->header_b2b_qrin_to_nobu);
    $payloadB2bPretty = $prettyJson($logGenerateQr->payload_b2b_qrin_to_nobu);
    $responseB2bPretty = $prettyJson($logGenerateQr->response_b2b_from_nobu_to_qrin);

    $headerShowQrPretty = $prettyJson($logGenerateQr->header_show_qr_qrin_to_nobu);
    $payloadShowQrPretty = $prettyJson($logGenerateQr->payload_show_qr_qrin_to_nobu);
    $responseShowQrPretty = $prettyJson($logGenerateQr->response_show_qr_from_nobu_to_qrin);

    $responseMerchantPretty = $prettyJson($logGenerateQr->response_qrin_to_merchant);
@endphp

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Detail Log Generate QR') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('log-generate-qrs.index') }}">{{ __('Log Generate QR') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row g-3 log-detail">
                <div class="col-12 col-lg-6">
                    <div class="card border">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-info-circle me-1"></i> Informasi</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-nowrap" style="width: 38%">ID</td>
                                    <td class="text-break">{{ $logGenerateQr->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal</td>
                                    <td>{{ $logGenerateQr->created_at?->format('d M Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Processing Time</td>
                                    <td>{{ $logGenerateQr->processing_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Transaksi ID</td>
                                    <td class="text-break">{{ $logGenerateQr->transaksi_id ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Merchant</td>
                                    <td>
                                        @if($logGenerateQr->merchant)
                                            {{ $logGenerateQr->merchant->nama_merchant }} ({{ $logGenerateQr->merchant->kode_merchant }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>
                                        @if($logGenerateQr->is_success === true)
                                            <span class="badge bg-success">Sukses</span>
                                        @elseif($logGenerateQr->is_success === false)
                                            <span class="badge bg-danger">Gagal</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    {{-- CARD: Payload Merchant & Payload QRIN → Merchant --}}
                    <div class="card border mb-3">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-send me-1"></i> Payload Generate QR</h6>
                        </div>
                        <div class="card-body p-3">
                            {{-- Payload Merchant → QRIN --}}
                            <p class="small fw-bold text-muted mb-1">Payload Merchant → QRIN</p>
                            <pre class="rounded border p-3 mb-3">{{ $payloadMerchantPretty ?: '-' }}</pre>

                            {{-- Payload QRIN → Merchant --}}
                            <p class="small fw-bold text-muted mb-1">Payload QRIN → Merchant</p>
                            <pre class="rounded border p-3 mb-0">{{ $responseMerchantPretty ?: '-' }}</pre>
                        </div>
                    </div>

                    {{-- CARD: B2B (collapse, default tertutup) --}}
                    <div class="card border mb-3">
                        <div class="card-header py-2">
                            <button class="btn btn-sm btn-link text-decoration-none p-0" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseB2B"
                                    aria-expanded="false"
                                    aria-controls="collapseB2B">
                                <h6 class="mb-0 fw-bold d-flex align-items-center">
                                    <i class="ti ti-arrows-exchange me-1"></i>
                                    B2B (QRIN ↔ Nobu)
                                    <i class="ti ti-chevron-down ms-1 small"></i>
                                </h6>
                            </button>
                        </div>
                        <div id="collapseB2B" class="collapse">
                            <div class="card-body p-3">
                                {{-- B2B - URL / Header / Payload / Response --}}
                                <p class="small fw-bold text-muted mb-1">B2B - URL QRIN → Nobu</p>
                                <pre class="rounded border p-3 mb-3">{{ $logGenerateQr->url_token_b2b ?? '-' }}</pre>

                                <p class="small fw-bold text-muted mb-1">B2B - Header QRIN → Nobu</p>
                                <pre class="rounded border p-3 mb-3">{{ $headerB2bPretty ?: '-' }}</pre>

                                <p class="small fw-bold text-muted mb-1">B2B - Payload QRIN → Nobu</p>
                                <pre class="rounded border p-3 mb-3">{{ $payloadB2bPretty ?: '-' }}</pre>

                                <p class="small fw-bold text-muted mb-1">B2B - Response Nobu → QRIN</p>
                                <pre class="rounded border p-3 mb-0">{{ $responseB2bPretty ?: '-' }}</pre>
                            </div>
                        </div>
                    </div>

                    {{-- CARD: Show QR (collapse, default tertutup) --}}
                    <div class="card border">
                        <div class="card-header py-2">
                            <button class="btn btn-sm btn-link text-decoration-none p-0" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseShowQr"
                                    aria-expanded="false"
                                    aria-controls="collapseShowQr">
                                <h6 class="mb-0 fw-bold d-flex align-items-center">
                                    <i class="ti ti-qrcode me-1"></i>
                                    Show QR (QRIN ↔ Nobu)
                                    <i class="ti ti-chevron-down ms-1 small"></i>
                                </h6>
                            </button>
                        </div>
                        <div id="collapseShowQr" class="collapse">
                            <div class="card-body p-3">
                                {{-- Show QR - URL / Header / Payload / Response --}}
                                <p class="small fw-bold text-muted mb-1">Show QR - URL QRIN → Nobu</p>
                                <pre class="rounded border p-3 mb-3">{{ $logGenerateQr->url_show_qr_b2b ?? '-' }}</pre>

                                <p class="small fw-bold text-muted mb-1">Show QR - Header QRIN → Nobu</p>
                                <pre class="rounded border p-3 mb-3">{{ $headerShowQrPretty ?: '-' }}</pre>

                                <p class="small fw-bold text-muted mb-1">Show QR - Payload QRIN → Nobu</p>
                                <pre class="rounded border p-3 mb-3">{{ $payloadShowQrPretty ?: '-' }}</pre>

                                <p class="small fw-bold text-muted mb-1">Show QR - Response Nobu → QRIN</p>
                                <pre class="rounded border p-3 mb-0">{{ $responseShowQrPretty ?: '-' }}</pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('log-generate-qrs.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> {{ __('Kembali') }}
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
