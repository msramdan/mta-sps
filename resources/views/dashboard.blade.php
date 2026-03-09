@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Dashboard') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            @if(!$companyId)
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm border-start border-4 border-warning">
                            <div class="card-body p-4">
                                <h5 class="mb-2"><i class="ti ti-building-store me-2 text-warning"></i>{{ __('Pilih Perusahaan') }}</h5>
                                <p class="mb-0 text-muted">{{ __('Silakan pilih perusahaan dari dropdown di sidebar untuk melihat ringkasan data dan grafik.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 text-center">
                                <h2 class="mb-2">
                                    @php
                                        $hour = date('H');
                                        $greeting = 'Selamat Datang';
                                        if ($hour >= 5 && $hour < 11) $greeting = 'Selamat Pagi';
                                        elseif ($hour >= 11 && $hour < 15) $greeting = 'Selamat Siang';
                                        elseif ($hour >= 15 && $hour < 18) $greeting = 'Selamat Sore';
                                        else $greeting = 'Selamat Malam';
                                    @endphp
                                    {{ $greeting }}, <span class="text-primary">{{ auth()->user()->name }}</span>!
                                </h2>
                                <p class="mb-0 text-muted">Selamat beraktivitas di <strong>Marketrax</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Greeting --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body py-3">
                                <h5 class="mb-0">
                                    @php
                                        $hour = date('H');
                                        $greeting = 'Selamat Datang';
                                        if ($hour >= 5 && $hour < 11) $greeting = 'Selamat Pagi';
                                        elseif ($hour >= 11 && $hour < 15) $greeting = 'Selamat Siang';
                                        elseif ($hour >= 15 && $hour < 18) $greeting = 'Selamat Sore';
                                        else $greeting = 'Selamat Malam';
                                    @endphp
                                    {{ $greeting }}, {{ auth()->user()->name }}!
                                    @if($companyName)
                                        <span class="text-muted fw-normal">— {{ $companyName }}</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Summary Cards --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted small mb-1">{{ __('Total Nilai Kontrak (SPK)') }}</p>
                                        <h4 class="mb-0 fw-bold">Rp {{ number_format($summary['total_nilai_kontrak'], 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="rounded-3 p-2 bg-primary bg-opacity-10">
                                        <i class="ti ti-file-invoice fs-3 text-primary"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted small mb-1">{{ __('Jumlah SPK/PO') }}</p>
                                        <h4 class="mb-0 fw-bold">{{ number_format($summary['jumlah_spk'], 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="rounded-3 p-2 bg-info bg-opacity-10">
                                        <i class="ti ti-checklist fs-3 text-info"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted small mb-1">{{ __('Total Pembayaran Masuk') }}</p>
                                        <h4 class="mb-0 fw-bold text-success">Rp {{ number_format($summary['total_terbayar'], 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="rounded-3 p-2 bg-success bg-opacity-10">
                                        <i class="ti ti-cash fs-3 text-success"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="text-muted small mb-1">{{ __('Piutang') }}</p>
                                        <h4 class="mb-0 fw-bold text-warning">Rp {{ number_format($summary['piutang'], 0, ',', '.') }}</h4>
                                    </div>
                                    <div class="rounded-3 p-2 bg-warning bg-opacity-10">
                                        <i class="ti ti-wallet fs-3 text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Charts Row --}}
                <div class="row g-3 mb-4">
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header border-0 bg-transparent py-3">
                                <h6 class="mb-0"><i class="ti ti-chart-donut me-2"></i>{{ __('Status Pembayaran (Nilai Kontrak)') }}</h6>
                            </div>
                            <div class="card-body">
                                <div style="height: 280px;">
                                    <canvas id="chartStatus"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header border-0 bg-transparent py-3">
                                <h6 class="mb-0"><i class="ti ti-chart-bar me-2"></i>{{ __('SPK per Bulan (Nilai Kontrak)') }}</h6>
                            </div>
                            <div class="card-body">
                                <div style="height: 280px;">
                                    <canvas id="chartSpkBulanan"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tables Row --}}
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header border-0 bg-transparent py-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="ti ti-file-invoice me-2"></i>{{ __('SPK Terbaru') }}</h6>
                                <a href="{{ route('spk.index') }}" class="btn btn-sm btn-outline-primary">{{ __('Semua') }}</a>
                            </div>
                            <div class="card-body p-0">
                                @if($recentSpk->isEmpty())
                                    <div class="p-4 text-center text-muted">{{ __('Belum ada data') }}</div>
                                @else
                                    <div class="list-group list-group-flush">
                                        @foreach($recentSpk as $s)
                                            <a href="{{ route('spk.show', $s) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                                                <span class="fw-medium">{{ $s->no_spk }}</span>
                                                <small class="text-muted">{{ $s->tanggal_spk?->format('d/m/Y') }}</small>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header border-0 bg-transparent py-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="ti ti-calendar me-2"></i>{{ __('Jadwal Mendatang') }}</h6>
                                <a href="{{ route('jadwal-teknisi.index') }}" class="btn btn-sm btn-outline-primary">{{ __('Semua') }}</a>
                            </div>
                            <div class="card-body p-0">
                                @if($upcomingJadwal->isEmpty())
                                    <div class="p-4 text-center text-muted">{{ __('Tidak ada jadwal mendatang') }}</div>
                                @else
                                    <div class="list-group list-group-flush">
                                        @foreach($upcomingJadwal as $j)
                                            <a href="{{ route('jadwal-teknisi.show', $j) }}" class="list-group-item list-group-item-action py-2">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-medium">{{ $j->judul ?: $j->spk?->no_spk ?? 'Jadwal' }}</span>
                                                    <small class="text-muted">{{ $j->tanggal_mulai?->format('d/m') }}</small>
                                                </div>
                                                <small class="text-muted">{{ $j->teknisi->pluck('name')->implode(', ') }}</small>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header border-0 bg-transparent py-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="ti ti-map-pin me-2"></i>{{ __('Kunjungan Terbaru') }}</h6>
                                <a href="{{ route('kunjungan-sales.index') }}" class="btn btn-sm btn-outline-primary">{{ __('Semua') }}</a>
                            </div>
                            <div class="card-body p-0">
                                @if($recentKunjungan->isEmpty())
                                    <div class="p-4 text-center text-muted">{{ __('Belum ada data') }}</div>
                                @else
                                    <div class="list-group list-group-flush">
                                        @foreach($recentKunjungan as $k)
                                            <a href="{{ route('kunjungan-sales.show', $k) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2">
                                                <span class="fw-medium">{{ $k->nama_rs ?? '-' }}</span>
                                                <small class="text-muted">{{ $k->tanggal_visit?->format('d/m/Y') }}</small>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>

    @if($companyId && isset($summary))
        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if(array_sum($chartStatus['labels']) > 0)
                new Chart(document.getElementById('chartStatus'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode(array_keys($chartStatus['labels'])) !!},
                        datasets: [{
                            data: {!! json_encode(array_values($chartStatus['labels'])) !!},
                            backgroundColor: {!! json_encode($chartStatus['colors']) !!},
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
                @else
                document.getElementById('chartStatus').parentElement.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100 text-muted">{{ __("Belum ada data") }}</div>';
                @endif

                @if(!empty($chartSpkBulanan['labels']))
                new Chart(document.getElementById('chartSpkBulanan'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartSpkBulanan['labels']) !!},
                        datasets: [{
                            label: '{{ __("Nilai Kontrak (Rp)") }}',
                            data: {!! json_encode($chartSpkBulanan['values']) !!},
                            backgroundColor: 'rgba(19, 115, 125, 0.7)',
                            borderColor: '#13737D',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(v) {
                                        if (v >= 1e9) return (v/1e9).toFixed(1)+'M';
                                        if (v >= 1e6) return (v/1e6).toFixed(1)+'jt';
                                        if (v >= 1e3) return (v/1e3).toFixed(1)+'k';
                                        return v;
                                    }
                                }
                            }
                        }
                    }
                });
                @else
                document.getElementById('chartSpkBulanan').parentElement.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100 text-muted">{{ __("Belum ada data") }}</div>';
                @endif
            });
        </script>
        @endpush
    @endif
@endsection
