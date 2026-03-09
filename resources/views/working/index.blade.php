@extends('layouts.app')

@section('title', __('Working - Progress Pekerjaan'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Working - Progress Pekerjaan') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Working') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                {{ __('Daftar jadwal yang memiliki SPK/PO. Klik baris untuk melihat detail dan input progress pekerjaan.') }}
                            </p>
                            @if($jadwalList->isEmpty())
                                <p class="text-muted mb-0">{{ __('Belum ada jadwal dengan SPK/PO.') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Judul') }}</th>
                                                <th>{{ __('SPK/PO') }}</th>
                                                <th>{{ __('Teknisi') }}</th>
                                                <th>{{ __('Total Alat') }}</th>
                                                <th>{{ __('Selesai') }}</th>
                                                <th>{{ __('Progress') }}</th>
                                                <th>{{ __('Aksi') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($jadwalList as $j)
                                                @php
                                                    $totalAlat = (int) ($j->spk?->jumlah_alat ?? 0);
                                                    $selesai = (int) ($j->working_progress_sum_jumlah_selesai ?? 0);
                                                    $percent = $totalAlat > 0 ? min(100, round(($selesai / $totalAlat) * 100, 1)) : 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $j->judul ?: '-' }}</td>
                                                    <td>{{ $j->spk?->no_spk ?? '-' }}</td>
                                                    <td>{{ $j->teknisi->pluck('name')->implode(', ') ?: '-' }}</td>
                                                    <td class="text-center">{{ $totalAlat }}</td>
                                                    <td class="text-center">{{ $selesai }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="progress flex-grow-1" style="height: 20px;">
                                                                <div class="progress-bar {{ $percent >= 100 ? 'bg-success' : '' }}" role="progressbar"
                                                                     style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}"
                                                                     aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span class="small fw-semibold">{{ $percent }}%</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('working.show', $j) }}" class="btn btn-sm btn-primary">
                                                            <i class="ti ti-eye me-1"></i>{{ __('Detail') }}
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
