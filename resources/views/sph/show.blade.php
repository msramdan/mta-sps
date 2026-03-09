@extends('layouts.app')

@section('title', __('Detail SPH'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('SPH') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('sph.index') }}">{{ __('SPH') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-file-certificate me-2"></i>{{ __('Informasi SPH') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('No. SPH') }}</div>
                                        <div class="fw-semibold">{{ $sph->no_sph }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('User Created') }}</div>
                                        <div class="fw-semibold">{{ $sph->user?->name ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Tanggal SPH') }}</div>
                                        <div class="fw-semibold">{{ $sph->tanggal_sph?->format('d F Y') }}</div>
                                    </div>
                                </div>
                                @if($sph->kunjunganSale)
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Kunjungan') }}</div>
                                        <div class="fw-semibold">{{ $sph->kunjunganSale->nama_rs }}</div>
                                    </div>
                                </div>
                                @endif
                                @if($sph->keterangan)
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <div class="text-muted small mb-1">{{ __('Keterangan') }}</div>
                                        <div class="fw-semibold">{{ $sph->keterangan }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-history me-2"></i>{{ __('Riwayat Revisi') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($sph->details->isEmpty())
                                <p class="text-muted mb-0">{{ __('Belum ada riwayat revisi.') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Versi</th>
                                                <th>File</th>
                                                <th>Total Download</th>
                                                <th>Catatan</th>
                                                <th>Oleh</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sph->details as $d)
                                            <tr>
                                                <td><strong>v{{ $d->version }}</strong></td>
                                                <td>
                                                    @if($d->file_path)
                                                        <a href="{{ route('sph.download-detail', [$sph, $d]) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                            <i class="ti ti-download"></i> Download
                                                        </a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $d->total_download ?? 0 }}</td>
                                                <td>{{ $d->catatan_revisi ?? '-' }}</td>
                                                <td>{{ $d->creator?->name ?? '-' }}</td>
                                                <td>{{ $d->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('sph.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('Kembali') }}
                        </a>
                        @can('sph edit')
                            <a href="{{ route('sph.revision', $sph) }}" class="btn btn-primary">
                                <i class="ti ti-upload me-1"></i>{{ __('Revisi') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
