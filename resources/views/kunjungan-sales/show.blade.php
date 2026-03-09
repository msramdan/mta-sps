@extends('layouts.app')

@section('title', __('Detail Kunjungan'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Kunjungan Sales') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('kunjungan-sales.index') }}">{{ __('Kunjungan Sales') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                            @if($kunjungan_sale->evidence)
                                <div class="mb-3 w-100">
                                    <img src="{{ $kunjungan_sale->evidence }}" alt="Evidence Kunjungan"
                                        class="rounded-3 img-fluid shadow-sm w-100"
                                        style="object-fit: cover; max-height: 280px;">
                                </div>
                            @else
                                <div class="mb-3 p-4 rounded-3 d-inline-flex align-items-center justify-content-center bg-light">
                                    <i class="ti ti-building-hospital fs-1 text-primary"></i>
                                </div>
                            @endif
                            <h5 class="mb-2 fw-bold">{{ $kunjungan_sale->nama_rs }}</h5>
                            <span class="badge bg-primary mb-2">
                                <i class="ti ti-user me-1"></i>{{ $kunjungan_sale->user?->name ?? '-' }}
                            </span>
                            <span class="badge bg-secondary">
                                <i class="ti ti-calendar me-1"></i>{{ $kunjungan_sale->tanggal_visit?->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mb-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>{{ __('Informasi Kunjungan') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="ti ti-building me-1"></i>{{ __('Nama RS') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->nama_rs }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="ti ti-user me-1"></i>{{ __('User Created') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->user?->name ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="ti ti-id me-1"></i>{{ __('PIC RS / Contact Person') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->pic_rs }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="ti ti-briefcase me-1"></i>{{ __('Jabatan PIC') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->posisi_pic ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="ti ti-phone me-1"></i>{{ __('No. Telepon PIC') }}</div>
                                        <div class="fw-semibold">
                                            <a href="tel:{{ $kunjungan_sale->no_telp_pic }}" class="text-decoration-none">{{ $kunjungan_sale->no_telp_pic }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1"><i class="ti ti-calendar-event me-1"></i>{{ __('Tanggal Kunjungan') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->tanggal_visit?->format('d F Y') }}</div>
                                    </div>
                                </div>
                                @if($kunjungan_sale->keterangan)
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <div class="text-muted small mb-1"><i class="ti ti-note me-1"></i>{{ __('Keterangan') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->keterangan }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-clock me-2"></i>{{ __('System Info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Dibuat pada') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Diperbarui pada') }}</div>
                                        <div class="fw-semibold">{{ $kunjungan_sale->updated_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('kunjungan-sales.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('Kembali') }}
                        </a>
                        @can('kunjungan sales edit')
                            <a href="{{ route('kunjungan-sales.edit', $kunjungan_sale->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>{{ __('Edit') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
