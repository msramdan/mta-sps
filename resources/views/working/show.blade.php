@extends('layouts.app')

@section('title', __('Progress Pekerjaan - ') . ($jadwal->judul ?: $jadwal->spk?->no_spk))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Progress Pekerjaan') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('working.index') }}">{{ __('Working') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ $jadwal->judul ?: $jadwal->spk?->no_spk }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-progress me-2"></i>{{ __('Info Jadwal') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Judul') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->judul ?: '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('SPK/PO') }}</div>
                                        <div class="fw-semibold">
                                            <a href="{{ route('spk.show', $jadwal->spk) }}">{{ $jadwal->spk?->no_spk }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Total Alat (dari SPK)') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->total_alat }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Sudah Selesai') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->jumlah_selesai }} / {{ $jadwal->total_alat }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded-3 p-3">
                                        <div class="text-muted small mb-2">{{ __('Progress') }}</div>
                                        <div class="progress" style="height: 28px;">
                                            <div class="progress-bar {{ $jadwal->progress_percent >= 100 ? 'bg-success' : '' }} fw-semibold"
                                                 role="progressbar" style="width: {{ min(100, $jadwal->progress_percent) }}%;"
                                                 aria-valuenow="{{ $jadwal->progress_percent }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ number_format($jadwal->progress_percent, 1) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Teknisi') }}</div>
                                        <div class="fw-semibold">{{ $jadwal->teknisi->pluck('name')->implode(', ') ?: '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($canInput)
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-plus me-2"></i>{{ __('Tambah Progress') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('working.store', $jadwal) }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="tanggal" class="form-label">{{ __('Tanggal') }} <span class="text-danger">*</span></label>
                                        <input type="date" name="tanggal" id="tanggal"
                                               class="form-control @error('tanggal') is-invalid @enderror"
                                               value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                                        @error('tanggal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="jumlah_selesai" class="form-label">{{ __('Jumlah Alat Selesai') }} <span class="text-danger">*</span></label>
                                        <input type="number" name="jumlah_selesai" id="jumlah_selesai" min="0"
                                               class="form-control @error('jumlah_selesai') is-invalid @enderror"
                                               value="{{ old('jumlah_selesai') }}" required
                                               placeholder="Contoh: 10">
                                        @error('jumlah_selesai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Sisa: {{ $jadwal->total_alat - $jadwal->jumlah_selesai }} alat</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="keterangan" class="form-label">{{ __('Keterangan') }}</label>
                                        <input type="text" name="keterangan" id="keterangan"
                                               class="form-control @error('keterangan') is-invalid @enderror"
                                               value="{{ old('keterangan') }}" placeholder="Opsional">
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-plus me-1"></i>{{ __('Simpan Progress') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-history me-2"></i>{{ __('Riwayat Progress') }}</h5>
                        </div>
                        <div class="card-body">
                            @if($jadwal->workingProgress->isEmpty())
                                <p class="text-muted mb-0">{{ __('Belum ada input progress.') }}</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Tanggal') }}</th>
                                                <th class="text-center">{{ __('Jumlah Selesai') }}</th>
                                                <th>{{ __('Keterangan') }}</th>
                                                <th>{{ __('Input Oleh') }}</th>
                                                <th>{{ __('Waktu') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $runningTotal = 0; @endphp
                                            @foreach($jadwal->workingProgress as $wp)
                                                @php $runningTotal += $wp->jumlah_selesai; @endphp
                                                <tr>
                                                    <td>{{ $wp->tanggal?->format('d/m/Y') }}</td>
                                                    <td class="text-center">{{ $wp->jumlah_selesai }}</td>
                                                    <td>{{ $wp->keterangan ?? '-' }}</td>
                                                    <td>{{ $wp->creator?->name ?? '-' }}</td>
                                                    <td>{{ $wp->created_at?->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-secondary fw-semibold">
                                                <td>{{ __('Total') }}</td>
                                                <td class="text-center">{{ $jadwal->jumlah_selesai }}</td>
                                                <td colspan="3">{{ number_format($jadwal->progress_percent, 1) }}%</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('working.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('Kembali') }}
                        </a>
                        <a href="{{ route('jadwal-teknisi.show', $jadwal) }}" class="btn btn-outline-primary">
                            <i class="ti ti-calendar me-1"></i>{{ __('Lihat Jadwal') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
