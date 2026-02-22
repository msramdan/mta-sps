@extends('layouts.app')

@section('title', __('Detail Log Query Payment Status'))

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
    $payloadMerchantPretty = $prettyJson($logQueryPaymentStatus->payload_merchant_to_qrin);
    $payloadQrinPretty = $prettyJson($logQueryPaymentStatus->payload_qrin_to_nobu);
    $responsePretty = $prettyJson($logQueryPaymentStatus->response_generate_qr);
@endphp

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Detail Log Query Payment Status') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('log-query-payment-status.index') }}">{{ __('Log Query Payment Status') }}</a>
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
                                    <td class="text-break">{{ $logQueryPaymentStatus->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal</td>
                                    <td>{{ $logQueryPaymentStatus->created_at?->format('d M Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Processing Time</td>
                                    <td>{{ $logQueryPaymentStatus->processing_time ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Transaksi ID</td>
                                    <td class="text-break">{{ $logQueryPaymentStatus->transaksi_id ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Merchant</td>
                                    <td>
                                        @if($logQueryPaymentStatus->merchant)
                                            {{ $logQueryPaymentStatus->merchant->nama_merchant }} ({{ $logQueryPaymentStatus->merchant->kode_merchant }})
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Status</td>
                                    <td>
                                        @if($logQueryPaymentStatus->is_success === true)
                                            <span class="badge bg-success">Sukses</span>
                                        @elseif($logQueryPaymentStatus->is_success === false)
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
                    <div class="card border">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-send me-1"></i> Payload & Response Query Payment Status</h6>
                        </div>
                        <div class="card-body p-3">
                            <p class="small fw-bold text-muted mb-1">Payload Merchant → QRIN</p>
                            <pre class="rounded border p-3 mb-3">{{ $payloadMerchantPretty ?: '-' }}</pre>
                            <p class="small fw-bold text-muted mb-1">Payload QRIN → Nobu</p>
                            <pre class="rounded border p-3 mb-3">{{ $payloadQrinPretty ?: '-' }}</pre>
                            <p class="small fw-bold text-muted mb-1">Response</p>
                            <pre class="rounded border p-3 mb-0">{{ $responsePretty ?: '-' }}</pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('log-query-payment-status.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> {{ __('Kembali') }}
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
