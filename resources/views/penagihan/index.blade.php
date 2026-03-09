@extends('layouts.app')

@section('title', __('Proses Penagihan'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Proses Penagihan') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Proses Penagihan') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-file-invoice me-2"></i>{{ __('Daftar SPK/PO') }}</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                {{ __('Klik baris untuk mengelola checklist dokumen tagihan dan status pembayaran. Status: Pending → Proses Penagihan → Terbayar.') }}
                            </p>
                            @if($spkList->isEmpty())
                                <p class="text-muted mb-0">{{ __('Belum ada data SPK/PO.') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>{{ __('No. SPK/PO') }}</th>
                                                <th>{{ __('No. SPH') }}</th>
                                                <th>{{ __('Nilai Kontrak') }}</th>
                                                <th>{{ __('Status Pembayaran') }}</th>
                                                <th>{{ __('Dokumen') }}</th>
                                                <th>{{ __('Aksi') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($spkList as $spk)
                                                @php
                                                    $p = $spk->penagihan;
                                                    $checked = $p ? $p->dokumen->where('is_checked', true)->count() : 0;
                                                    $total = $p ? $p->dokumen->count() : count(config('penagihan.jenis_dokumen', []));
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
                                                        @if($p)
                                                            @php
                                                                $badgeClass = match($p->status) {
                                                                    'terbayar' => 'bg-success',
                                                                    'proses_penagihan' => 'bg-info',
                                                                    default => 'bg-secondary'
                                                                };
                                                            @endphp
                                                            <span class="badge {{ $badgeClass }}">{{ $p->status_label }}</span>
                                                        @else
                                                            <span class="badge bg-light text-dark">{{ __('Belum dibuat') }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($p)
                                                            <span class="text-muted">{{ $checked }}/{{ $total }}</span> {{ __('dokumen') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('penagihan.show', $spk) }}" class="btn btn-sm btn-primary">
                                                            <i class="ti ti-eye me-1"></i>{{ $p ? __('Kelola') : __('Buat Penagihan') }}
                                                        </a>
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
