@extends('layouts.app')

@section('title', __('Detail Jadwal Teknisi'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Jadwal Teknisi') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('jadwal-teknisi.index') }}">{{ __('Jadwal Teknisi') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-calendar-time me-2"></i>{{ __('Informasi Jadwal') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Judul Jadwal') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->judul ?: '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Tanggal Mulai') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->tanggal_mulai?->format('d F Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Tanggal Selesai') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->tanggal_selesai?->format('d F Y') ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Teknisi') }}</div>
                                        <div class="fw-semibold">
                                            {{ $jadwal->teknisi->pluck('name')->implode(', ') ?: '-' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Total Estimasi Biaya') }}</div>
                                        <div class="fw-semibold">
                                            Rp {{ number_format($jadwal->total_estimasi, 2, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                @if($jadwal->keterangan)
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <div class="text-muted small mb-1">{{ __('Keterangan') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->keterangan }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-currency-dollar me-2"></i>{{ __('Detail Estimasi Biaya') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($jadwal->estimasiBiaya->isEmpty())
                                <p class="text-muted mb-0">{{ __('Belum ada data estimasi biaya.') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Keterangan Biaya') }}</th>
                                                <th class="text-end">{{ __('Estimasi Total') }}</th>
                                                <th class="text-center">{{ __('Tanggal Input') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jadwal->estimasiBiaya as $b)
                                            <tr>
                                                <td>{{ $b->keterangan_biaya }}</td>
                                                <td class="text-end">Rp {{ number_format($b->estimasi_total, 2, ',', '.') }}</td>
                                                <td class="text-center">{{ $b->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('jadwal-teknisi.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('Kembali') }}
                        </a>
                        @can('jadwal teknisi edit')
                            <a href="{{ route('jadwal-teknisi.edit', $jadwal->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>{{ __('Edit') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

