@extends('layouts.app')

@section('title', __('Detail Transaksi'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Detail Transaksi') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- COL KIRI: Informasi Transaksi & Pelanggan -->
                                <div class="col-lg-6 col-md-12">
                                    <!-- 1. Informasi Transaksi -->
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-receipt me-1"></i> Informasi Transaksi
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">No. Referensi</td>
                                                    <td>
                                                        <span class="badge bg-dark">{{ $transaksi->no_referensi }}</span>
                                                    </td>
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
                                                        {{ $transaksi->merchant?->nama_merchant ?? '-' }}
                                                        @if($transaksi->merchant?->kode_merchant)
                                                            <br>
                                                            <span class="badge bg-primary">{{ $transaksi->merchant->kode_merchant }}</span>
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
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-user me-1"></i> Informasi Pelanggan
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Nama</td>
                                                    <td>{{ $transaksi->nama_pelanggan }}</td>
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
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-money-bill me-1"></i> Informasi Pembayaran
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Biaya</td>
                                                    <td class="fs-5">Rp {{ number_format($transaksi->biaya, 0, ',', '.') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Jumlah Dibayar</td>
                                                    <td class="fs-5">Rp {{ number_format($transaksi->jumlah_dibayar, 0, ',', '.') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- COL KANAN: Payload & Callback -->
                                <div class="col-lg-6 col-md-12">
                                    <!-- 4. Payload Generate QR -->
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-code me-1"></i> Payload Generate QR
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            @if ($transaksi->payload_generate_qr)
                                                <pre class="bg-light p-2 rounded mb-0"
                                                    style="max-height: 250px; overflow-y: auto; font-size: 0.75rem;">{{ $transaksi->payload_generate_qr }}</pre>
                                            @else
                                                <span class="text-muted fst-italic">-</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- 5. Callback -->
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-exchange-alt me-1"></i> Callback
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-2">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Tanggal Callback</td>
                                                    <td>{{ $transaksi->tanggal_callback ? $transaksi->tanggal_callback->format('d M Y H:i:s') : '-' }}</td>
                                                </tr>
                                            </table>
                                            @if ($transaksi->callback)
                                                <label class="fw-bold small">Response:</label>
                                                <pre class="bg-light p-2 rounded"
                                                    style="max-height: 200px; overflow-y: auto; font-size: 0.75rem;">{{ $transaksi->callback }}</pre>
                                            @else
                                                <span class="text-muted fst-italic">Belum ada callback</span>
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
