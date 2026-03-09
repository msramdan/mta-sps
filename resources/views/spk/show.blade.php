@extends('layouts.app')

@section('title', __('Detail SPK/PO'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('SPK/PO') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('spk.index') }}">{{ __('SPK/PO') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-file-certificate me-2"></i>{{ __('Informasi SPK/PO') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('No. SPK/PO') }}</div>
                                        <div class="fw-semibold">{{ $spk->no_spk }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('No. SPH') }}</div>
                                        <div class="fw-semibold">
                                            @if($spk->sph)
                                                <a href="{{ route('sph.show', $spk->sph) }}">{{ $spk->sph->no_sph }}</a>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Nilai Kontrak') }}</div>
                                        <div class="fw-semibold">Rp {{ $spk->nilai_kontrak_formatted }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Include PPN') }}</div>
                                        <div class="fw-semibold">{{ $spk->include_ppn ? 'Ya' : 'Tidak' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Jumlah Alat') }}</div>
                                        <div class="fw-semibold">{{ $spk->jumlah_alat }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Tanggal SPK') }}</div>
                                        <div class="fw-semibold">{{ $spk->tanggal_spk?->format('d F Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Tanggal Deadline') }}</div>
                                        <div class="fw-semibold">{{ $spk->tanggal_deadline?->format('d F Y') ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('User Created') }}</div>
                                        <div class="fw-semibold">{{ $spk->creator?->name ?? '-' }}</div>
                                    </div>
                                </div>
                                @if($spk->keterangan)
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <div class="text-muted small mb-1">{{ __('Keterangan') }}</div>
                                        <div class="fw-semibold">{{ $spk->keterangan }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('spk.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('Kembali') }}
                        </a>
                        @can('penagihan view')
                            <a href="{{ route('penagihan.show', $spk) }}" class="btn btn-outline-primary">
                                <i class="ti ti-file-invoice me-1"></i>{{ __('Proses Penagihan') }}
                            </a>
                        @endcan
                        @can('spk edit')
                            <a href="{{ route('spk.edit', $spk) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>{{ __('Edit') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
