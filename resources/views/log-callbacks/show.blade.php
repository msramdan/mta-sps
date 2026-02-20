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
    $payloadPretty = $prettyJson($logCallback->payload_callback);
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
                <div class="col-12 col-lg-6">
                    <div class="card border">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-info-circle me-1"></i> Informasi</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-nowrap" style="width: 38%">ID</td>
                                    <td class="text-break">{{ $logCallback->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal</td>
                                    <td>{{ $logCallback->created_at?->format('d M Y H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Callback</td>
                                    <td>{{ $logCallback->tanggal_callback?->format('d M Y H:i:s') ?? '-' }}</td>
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

                <div class="col-12 col-lg-6">
                    <div class="card border">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-send me-1"></i> Payload Callback</h6>
                        </div>
                        <div class="card-body p-3">
                            <pre class="rounded border p-3 mb-0">{{ $payloadPretty ?: '-' }}</pre>
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
