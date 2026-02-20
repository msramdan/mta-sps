@extends('layouts.app')

@section('title', __('Detail Transaksi'))

@push('css')
<style>
    .transaksi-detail .card { margin-bottom: 1rem !important; }
    .transaksi-detail .card-header { padding: 0.5rem 0.75rem !important; }
    .transaksi-detail .card-header h6 { font-size: 0.95rem; }
    .transaksi-detail .accordion-button { padding: 0.5rem 0.75rem !important; font-size: 0.875rem; }
    .transaksi-detail pre { padding: 0.65rem 0.75rem !important; font-size: 0.75rem; max-height: 200px; }
    @media (min-width: 768px) {
        .transaksi-detail pre { max-height: 240px; font-size: 0.8rem; }
    }
    @media (min-width: 992px) {
        .transaksi-detail .card { margin-bottom: 1.25rem !important; }
        .transaksi-detail pre { max-height: 260px; }
    }
</style>
@endpush

@php
    $prettyJson = function ($str) {
        if (empty($str)) return '';
        $d = json_decode($str);
        return $d ? json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : e($str);
    };
@endphp

@section('content')
    <main>
        <div class="container-fluid px-2 px-md-3">
            <div class="row m-0 m-md-1">
                <div class="col-12">
                    <h4 class="main-title mb-2 mb-md-3">{{ __('Detail Transaksi') }}</h4>
                    <ul class="app-line-breadcrumbs mb-2 mb-md-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('transaksis.index') }}">{{ __('Transaksi') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <div class="card transaksi-detail">
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <!-- COL KIRI: Informasi Transaksi & Pelanggan -->
                                <div class="col-12 col-lg-6">
                                    <!-- 1. Informasi Transaksi -->
                                    <div class="card border">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-receipt me-1"></i> Informasi Transaksi
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold text-nowrap" style="width: 40%">No. Referensi</td>
                                                    <td class="text-break">{{ $transaksi->no_referensi }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">No. Ref. Merchant</td>
                                                    <td>{{ $transaksi->no_ref_merchant ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Tanggal Transaksi</td>
                                                    <td>{{ $transaksi->tanggal_transaksi->format('d M Y H:i:s') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Merchant</td>
                                                    <td>
                                                        @if($transaksi->merchant)
                                                            {{ $transaksi->merchant->kode_merchant ? $transaksi->merchant->kode_merchant . ' - ' : '' }}{{ $transaksi->merchant->nama_merchant ?? '-' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Status</td>
                                                    <td>
                                                        @if ($transaksi->status == 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($transaksi->status == 'success')
                                                            <span class="badge bg-success">Success</span>
                                                        @elseif($transaksi->status == 'failed')
                                                            <span class="badge bg-danger">Failed</span>
                                                        @elseif($transaksi->status == 'expired')
                                                            <span class="badge bg-secondary">Expired</span>
                                                        @else
                                                            <span class="badge bg-light text-dark">Unknown</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 2. Informasi Pelanggan -->
                                    <div class="card border">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-user me-1"></i> Informasi Pelanggan
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Nama</td>
                                                    <td>{{ $transaksi->nama_pelanggan ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Email</td>
                                                    <td>{{ $transaksi->email_pelanggan ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">No. Telepon</td>
                                                    <td>{{ $transaksi->no_telpon_pelanggan ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 3. Informasi Pembayaran -->
                                    <div class="card border">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-money-bill me-1"></i> Informasi Pembayaran
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Biaya</td>
                                                    <td>Rp {{ number_format($transaksi->biaya, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Jumlah Dibayar</td>
                                                    <td>Rp {{ number_format($transaksi->jumlah_dibayar, 0, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- COL KANAN: Log Generate QR & Log Callback -->
                                <div class="col-12 col-lg-6">
                                    <!-- Log Generate QR -->
                                    <div class="card border">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-qrcode me-1"></i> Log Generate QR
                                            </h6>
                                        </div>
                                        <div class="card-body p-0">
                                            @if($transaksi->logGenerateQrs->isEmpty())
                                                <p class="text-muted fst-italic p-3 mb-0">Belum ada log generate QR.</p>
                                            @else
                                                <div class="accordion accordion-flush" id="accordionLogGenerateQr">
                                                    @foreach($transaksi->logGenerateQrs as $index => $log)
                                                        @php
                                                            $accId = 'log-qr-' . $log->id;
                                                            $payloadPretty = $prettyJson($log->payload_generate_qr);
                                                            $responsePretty = $prettyJson($log->response_generate_qr);
                                                        @endphp
                                                        <div class="accordion-item border-bottom">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $accId }}" aria-expanded="false" aria-controls="{{ $accId }}">
                                                                    <span class="me-2 fw-bold">#{{ $index + 1 }}</span>
                                                                    <span class="me-2">{{ $log->created_at->format('d M Y H:i') }}</span>
                                                                    @if($log->is_success === true)
                                                                        <span class="badge bg-success">Sukses</span>
                                                                    @elseif($log->is_success === false)
                                                                        <span class="badge bg-danger">Gagal</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">-</span>
                                                                    @endif
                                                                </button>
                                                            </h2>
                                                            <div id="{{ $accId }}" class="accordion-collapse collapse" data-bs-parent="#accordionLogGenerateQr">
                                                                <div class="accordion-body pt-2 pb-2 px-3">
                                                                    <div class="row g-3">
                                                                        <div class="col-12">
                                                                            <span class="small fw-bold text-muted d-block mb-1">Payload Request</span>
                                                                            <pre class="rounded border mb-0 overflow-auto" >{{ $payloadPretty ?: '-' }}</pre>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <span class="small fw-bold text-muted d-block mb-1">Response</span>
                                                                            <pre class="rounded border mb-0 overflow-auto" >{{ $responsePretty ?: '-' }}</pre>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Log Callback -->
                                    <div class="card border">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-exchange-alt me-1"></i> Log Callback
                                            </h6>
                                        </div>
                                        <div class="card-body p-0">
                                            @if($transaksi->logCallbacks->isEmpty())
                                                <p class="text-muted fst-italic p-3 mb-0">Belum ada log callback.</p>
                                            @else
                                                <div class="accordion accordion-flush" id="accordionLogCallback">
                                                    @foreach($transaksi->logCallbacks as $index => $log)
                                                        @php
                                                            $accId = 'log-cb-' . $log->id;
                                                            $payloadPretty = $prettyJson($log->payload_callback);
                                                            $isSuccess = $log->transaction_status === '00';
                                                            $tgl = $log->tanggal_callback ?? $log->created_at;
                                                        @endphp
                                                        <div class="accordion-item border-bottom">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $accId }}" aria-expanded="false" aria-controls="{{ $accId }}">
                                                                    <span class="me-2 fw-bold">#{{ $index + 1 }}</span>
                                                                    <span class="me-2">{{ $tgl->format('d M Y H:i') }}</span>
                                                                    @if($isSuccess)
                                                                        <span class="badge bg-success">Success</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Failed</span>
                                                                    @endif
                                                                </button>
                                                            </h2>
                                                            <div id="{{ $accId }}" class="accordion-collapse collapse" data-bs-parent="#accordionLogCallback">
                                                                <div class="accordion-body pt-2 pb-2 px-3">
                                                                    <span class="small fw-bold text-muted d-block mb-1">Payload Callback</span>
                                                                    <pre class="rounded border mb-0 overflow-auto" >{{ $payloadPretty ?: '-' }}</pre>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('transaksis.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
