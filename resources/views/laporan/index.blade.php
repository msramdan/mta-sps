@extends('layouts.app')

@section('title', __('Cetak Laporan'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Cetak Laporan') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Cetak Laporan') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-file-export me-2"></i>{{ __('Laporan Lengkap Progress Penjualan (PDF)') }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                {{ __('Pilih SPK/PO untuk mencetak laporan lengkap dari Kunjungan Sales hingga Proses Penagihan. Laporan akan berisi data yang tersedia; tahap yang belum terisi akan ditampilkan sebagai "Belum tersedia".') }}
                            </p>
                            @if($spkList->isEmpty())
                                <p class="text-muted mb-0">{{ __('Belum ada data SPK/PO.') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th>{{ __('No. SPK/PO') }}</th>
                                                <th>{{ __('No. SPH') }}</th>
                                                <th>{{ __('Nilai Kontrak') }}</th>
                                                <th>{{ __('Status Pembayaran') }}</th>
                                                <th>{{ __('Aksi') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($spkList as $spk)
                                                @php
                                                    $p = $spk->penagihan;
                                                    $badgeClass = $p ? match($p->status) {
                                                        'terbayar' => 'bg-success',
                                                        'proses_penagihan' => 'bg-info',
                                                        default => 'bg-secondary'
                                                    } : 'bg-secondary';
                                                @endphp
                                                <tr>
                                                    <td>{{ $spk->no_spk }}</td>
                                                    <td>
                                                        @if($spk->sph ?? null)
                                                            <a href="{{ route('sph.show', $spk->sph) }}">{{ $spk->sph->no_sph }}</a>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>Rp {{ number_format($spk->nilai_kontrak, 2, ',', '.') }}</td>
                                                    <td>
                                                        <span class="badge {{ $badgeClass }}">{{ $p?->status_label ?? __('Belum dibuat') }}</span>
                                                    </td>
                                                    <td>
                                                        @if($p)
                                                            <a href="{{ route('penagihan.laporan', $p) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="ti ti-file-export me-1"></i>{{ __('Cetak PDF') }}
                                                            </a>
                                                        @else
                                                            <a href="{{ route('penagihan.show', $spk) }}" class="btn btn-sm btn-secondary">
                                                                <i class="ti ti-file-plus me-1"></i>{{ __('Buat Penagihan Dahulu') }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
