@extends('layouts.app')

@section('title', __('Detail Log Resend Callback'))

@push('css')
<style>
    .log-detail pre { font-size: 0.8rem; max-height: 400px; overflow: auto; white-space: pre-wrap; word-break: break-all; }
    .log-callback-card .card-header { cursor: pointer; user-select: none; }
    .log-callback-card .card-header .accordion-icon { transition: transform 0.2s; }
    .log-callback-card .card-header[aria-expanded="true"] .accordion-icon { transform: rotate(180deg); }
</style>
@endpush

@php
    $prettyJson = function ($str) {
        if (empty($str)) return '';
        $d = json_decode($str);
        return $d ? json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : e($str);
    };
    $headerPretty = $prettyJson($logResendCallback->header_resend_callback_qrin_to_merchant);
    $payloadPretty = $prettyJson($logResendCallback->payload_resend_callback_qrin_to_merchant);
    $responsePretty = $prettyJson($logResendCallback->response_resend_callback_qrin_to_merchant);
@endphp

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Detail Log Resend Callback') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('log-callbacks.index') }}">{{ __('Log Callback') }}</a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('log-resend-callbacks.index') }}">{{ __('Log Resend Callback') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row g-3 log-detail">
                <!-- Informasi -->
                <div class="col-12 col-md-6">
                    <div class="card border">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-info-circle me-1"></i> Informasi</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-nowrap" style="width: 38%">ID</td>
                                    <td class="text-break">{{ $logResendCallback->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal</td>
                                    <td>{{ $logResendCallback->created_at?->format('d M Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Resend Callback</td>
                                    <td>{{ $logResendCallback->tanggal_resend_callback_qrin_to_merchant?->format('d M Y H:i:s') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Processing Time</td>
                                    <td>{{ $logResendCallback->processing_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Transaksi ID</td>
                                    <td class="text-break">{{ $logResendCallback->transaksi_id ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Merchant</td>
                                    <td>
                                        @if($logResendCallback->merchant)
                                            {{ $logResendCallback->merchant->nama_merchant }} ({{ $logResendCallback->merchant->kode_merchant }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Metode</td>
                                    <td><span class="badge bg-primary">{{ $logResendCallback->metode ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">URL Callback</td>
                                    <td class="text-break small">{{ $logResendCallback->url_callback ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('log-resend-callbacks.index') }}" class="btn btn-secondary btn-sm">
                            <i class="ti ti-arrow-left"></i> {{ __('Kembali') }}
                        </a>
                    </div>
                </div>

                <!-- Log Resend Callback QRIN → Merchant -->
                <div class="col-12 col-md-6">
                    <div class="card border log-callback-card">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold">
                                <i class="ti ti-arrow-right me-1"></i> Log Resend Callback QRIN → Merchant
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            <p class="small text-muted mb-1">Header</p>
                            <pre class="rounded border p-3 mb-3 small">{{ $headerPretty ?: '-' }}</pre>
                            <p class="small text-muted mb-1">Payload</p>
                            <pre class="rounded border p-3 mb-3">{{ $payloadPretty ?: '-' }}</pre>
                            <p class="small text-muted mb-1">Response</p>
                            <pre class="rounded border p-3 mb-0">{{ $responsePretty ?: '-' }}</pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
