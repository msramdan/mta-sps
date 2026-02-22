@extends('layouts.app')

@section('title', __('Detail Log Callback'))

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
    $headerNobuPretty = $prettyJson($logCallback->header_callback_nobu_to_qrin);
    $payloadNobuPretty = $prettyJson($logCallback->payload_callback_nobu_to_qrin);
    $responseNobuPretty = $prettyJson($logCallback->response_callback_nobu_to_qrin);
    $headerQrinPretty = $prettyJson($logCallback->header_callback_qrin_to_merchant);
    $payloadQrinPretty = $prettyJson($logCallback->payload_callback_qrin_to_merchant);
    $responseQrinPretty = $prettyJson($logCallback->response_callback_qrin_to_merchant);
    $transactionStatus = $logCallback->transaction_status ?? '';
    $statusDesc = $logCallback->status_desc ?? '';
    $isDescSuccess = stripos($statusDesc, 'Success') !== false;
@endphp

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Detail Log Callback') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('log-callbacks.index') }}">{{ __('Log Callback') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row g-3 log-detail">
                <div class="col-12 col-md-5 col-lg-4">
                    <div class="card border h-100">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-info-circle me-1"></i> Informasi</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-nowrap" style="width: 42%">ID</td>
                                    <td class="text-break small">{{ $logCallback->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal</td>
                                    <td>{{ $logCallback->created_at?->format('d M Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Callback Nobu→QRIN</td>
                                    <td>{{ $logCallback->tanggal_callback_nobu_to_qrin?->format('d M Y H:i:s') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Callback QRIN→Merchant</td>
                                    <td>{{ $logCallback->tanggal_callback_qrin_to_merchant?->format('d M Y H:i:s') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Processing Time</td>
                                    <td>{{ $logCallback->processing_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Transaksi ID</td>
                                    <td class="text-break">{{ $logCallback->transaksi_id ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Merchant</td>
                                    <td>
                                        @if($logCallback->merchant)
                                            {{ $logCallback->merchant->nama_merchant }} ({{ $logCallback->merchant->kode_merchant }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td class="text-break">
                                        @if($transactionStatus === '00')
                                            <span class="badge bg-success">{{ $transactionStatus }}</span>
                                        @elseif($transactionStatus === '06')
                                            <span class="badge bg-danger">{{ $transactionStatus }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $transactionStatus ?: '-' }}</span>
                                        @endif
                                        @if($isDescSuccess)
                                            <span class="badge bg-success">{{ $statusDesc ?: '-' }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $statusDesc ?: '-' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-7 col-lg-8">
                    <div class="card border h-100">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-code me-1"></i> Data Payload Callback</h6>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="text-muted border-bottom pb-2 mb-3"><i class="ti ti-arrow-right me-1"></i> Nobu → QRIN</h6>
                            <p class="small text-muted mb-1">Header</p>
                            <pre class="rounded border p-3 mb-3 small">{{ $headerNobuPretty ?: '-' }}</pre>
                            <p class="small text-muted mb-1">Payload</p>
                            <pre class="rounded border p-3 mb-3">{{ $payloadNobuPretty ?: '-' }}</pre>
                            <p class="small text-muted mb-1">Response</p>
                            <pre class="rounded border p-3 mb-4">{{ $responseNobuPretty ?: '-' }}</pre>

                            <h6 class="text-muted border-bottom pb-2 mb-3"><i class="ti ti-arrow-right me-1"></i> QRIN → Merchant</h6>
                            <p class="small text-muted mb-1">Header</p>
                            <pre class="rounded border p-3 mb-3 small">{{ $headerQrinPretty ?: '-' }}</pre>
                            <p class="small text-muted mb-1">Payload</p>
                            <pre class="rounded border p-3 mb-3">{{ $payloadQrinPretty ?: '-' }}</pre>
                            <p class="small text-muted mb-1">Response</p>
                            <pre class="rounded border p-3 mb-0">{{ $responseQrinPretty ?: '-' }}</pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('log-callbacks.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> {{ __('Kembali') }}
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
