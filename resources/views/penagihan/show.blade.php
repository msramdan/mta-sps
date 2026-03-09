@extends('layouts.app')

@section('title', __('Proses Penagihan - ') . $penagihan->spk->no_spk)

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Proses Penagihan') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('penagihan.index') }}">{{ __('Proses Penagihan') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ $penagihan->spk->no_spk }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9 mb-3">
                    {{-- Info SPK & SPH --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-file-info me-2"></i>{{ __('Info Kontrak') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('No. SPK/PO') }}</div>
                                        <a href="{{ route('spk.show', $penagihan->spk) }}" class="fw-semibold text-primary">{{ $penagihan->spk->no_spk }}</a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('No. SPH') }}</div>
                                        @if($penagihan->spk->sph)
                                            <a href="{{ route('sph.show', $penagihan->spk->sph) }}" class="fw-semibold text-primary">{{ $penagihan->spk->sph->no_sph }}</a>
                                        @else
                                            <span class="fw-semibold">-</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Nilai Kontrak') }}</div>
                                        <div class="fw-semibold">Rp {{ $penagihan->spk->nilai_kontrak_formatted }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status & Checklist Form --}}
                    @can('penagihan edit')
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="mb-0"><i class="ti ti-checklist me-2"></i>{{ __('Checklist Dokumen & Status') }}</h5>
                            @php
                                $badgeClass = match($penagihan->status) {
                                    'terbayar' => 'bg-success',
                                    'proses_penagihan' => 'bg-info',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} fs-6">{{ $penagihan->status_label }}</span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('penagihan.update', $penagihan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Status Pembayaran') }} <span class="text-danger">*</span></label>
                                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                            @foreach($statusList as $key => $label)
                                                <option value="{{ $key }}" {{ old('status', $penagihan->status) == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ __('Keterangan') }}</label>
                                        <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $penagihan->keterangan) }}" placeholder="Opsional">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ __('Dokumen Lengkap (centang jika sudah ada)') }}</label>
                                        <div class="border rounded-3 p-3">
                                            <div class="row g-2">
                                                @foreach($penagihan->dokumen as $d)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input type="checkbox" name="check[{{ $d->id }}]" value="1" id="check_{{ $d->id }}"
                                                                   class="form-check-input" {{ $d->is_checked ? 'checked' : '' }}>
                                                            <label for="check_{{ $d->id }}" class="form-check-label">{{ $d->label }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">{{ __('Pengeluaran Operational Khusus (Fee)') }}</label>
                                        <div class="border rounded-3 p-3">
                                            <div id="fee-rows">
                                                @foreach($penagihan->fee as $idx => $f)
                                                    <div class="row g-2 mb-2 fee-row align-items-center">
                                                        <div class="col-md-5">
                                                            <input type="text" name="fee[{{ $idx }}][keterangan]" class="form-control form-control-sm"
                                                                   value="{{ old("fee.{$idx}.keterangan", $f->keterangan) }}" placeholder="Contoh: Cashback, Uang saku">
                                                            <input type="hidden" name="fee[{{ $idx }}][id]" value="{{ $f->id }}">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type="number" name="fee[{{ $idx }}][nominal]" step="0.01" min="0"
                                                                   class="form-control form-control-sm fee-nominal" value="{{ old("fee.{$idx}.nominal", $f->nominal) }}" placeholder="0">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-sm btn-outline-danger fee-remove" title="{{ __('Hapus') }}"><i class="ti ti-trash"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" id="fee-add" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="ti ti-plus me-1"></i>{{ __('Tambah') }}
                                            </button>
                                            <div id="fee-total" class="mt-2 pt-2 border-top">
                                                @if($penagihan->fee->isNotEmpty())
                                                    <strong>{{ __('Total') }}:</strong> Rp <span class="fee-sum">{{ number_format($penagihan->total_fee, 2, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-device-floppy me-1"></i>{{ __('Simpan Checklist & Status') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-checklist me-2"></i>{{ __('Status') }}: {{ $penagihan->status_label }}</h5>
                        </div>
                        <div class="card-body">
                            @if($penagihan->keterangan)
                                <p class="mb-0"><strong>Keterangan:</strong> {{ $penagihan->keterangan }}</p>
                            @endif
                        </div>
                    </div>
                    @endcan

                    {{-- Pengeluaran Fee (View Only) --}}
                    @cannot('penagihan edit')
                    @if($penagihan->fee->isNotEmpty() && $penagihan->fee->sum('nominal') > 0)
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-cash me-2"></i>{{ __('Pengeluaran Operational Khusus (Fee)') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Keterangan') }}</th>
                                            <th class="text-end">{{ __('Nominal') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penagihan->fee->where('nominal', '>', 0) as $f)
                                            <tr>
                                                <td>{{ $f->keterangan ?? '-' }}</td>
                                                <td class="text-end">Rp {{ number_format($f->nominal, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-secondary fw-semibold">
                                        <tr>
                                            <td>{{ __('Total') }}</td>
                                            <td class="text-end">Rp {{ number_format($penagihan->total_fee, 2, ',', '.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endcan

                    {{-- Dokumen + Upload --}}
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h5 class="mb-0"><i class="ti ti-upload me-2"></i>{{ __('Dokumen Pendukung (Upload Opsional)') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 35%;">{{ __('Jenis Dokumen') }}</th>
                                            <th class="text-center" style="width: 15%;">{{ __('Checklist') }}</th>
                                            <th style="width: 30%;">{{ __('File') }}</th>
                                            <th style="width: 20%;">{{ __('Aksi') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($penagihan->dokumen as $d)
                                            <tr>
                                                <td class="fw-semibold">{{ $d->label }}</td>
                                                <td class="text-center">
                                                    @if($d->is_checked)
                                                        <i class="ti ti-circle-check text-success fs-4"></i>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($d->file_name)
                                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $d->file_name }}">
                                                            <i class="ti ti-file me-1"></i>{{ $d->file_name }}
                                                        </span>
                                                        @if($d->uploaded_at)
                                                            <br><small class="text-muted">{{ $d->uploaded_at->format('d/m/Y H:i') }}</small>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">{{ __('Belum diupload') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($d->file_path)
                                                        @can('penagihan view')
                                                            <a href="{{ route('penagihan.download', [$penagihan, $d]) }}" class="btn btn-sm btn-outline-primary me-1" target="_blank">
                                                                <i class="ti ti-download"></i>
                                                            </a>
                                                        @endcan
                                                    @endif
                                                    @can('penagihan edit')
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $d->id }}">
                                                            <i class="ti ti-upload"></i> {{ $d->file_path ? __('Ganti') : __('Upload') }}
                                                        </button>
                                                        @include('penagihan.partial.upload-modal', ['d' => $d])
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('penagihan.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i>{{ __('Kembali') }}
                        </a>
                        <a href="{{ route('spk.show', $penagihan->spk) }}" class="btn btn-outline-primary">
                            <i class="ti ti-file-invoice me-1"></i>{{ __('Lihat SPK') }}
                        </a>
                    </div>
                </div>

                {{-- Sidebar: Flow --}}
                <div class="col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-header border-0 bg-transparent py-3">
                            <h6 class="mb-0"><i class="ti ti-info-circle me-2"></i>{{ __('Alur Status') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">1</span>
                                    <div>
                                        <strong>Pending</strong>
                                        <p class="small text-muted mb-0">Belum ada aktivitas penagihan.</p>
                                    </div>
                                </div>
                                <div class="border-start border-2 ms-3" style="height: 12px;"></div>
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">2</span>
                                    <div>
                                        <strong>Proses Penagihan</strong>
                                        <p class="small text-muted mb-0">Sedang mengumpulkan dokumen & mengirim tagihan.</p>
                                    </div>
                                </div>
                                <div class="border-start border-2 ms-3" style="height: 12px;"></div>
                                <div class="d-flex align-items-start gap-2">
                                    <span class="badge bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">3</span>
                                    <div>
                                        <strong>Terbayar</strong>
                                        <p class="small text-muted mb-0">Pembayaran sudah diterima.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('fee-rows');
            const addBtn = document.getElementById('fee-add');
            if (!container || !addBtn) return;

            let idx = container.querySelectorAll('.fee-row').length;

            function updateNames() {
                container.querySelectorAll('.fee-row').forEach((row, i) => {
                    row.querySelector('[name*="[keterangan]"]').name = 'fee[' + i + '][keterangan]';
                    row.querySelector('[name*="[nominal]"]').name = 'fee[' + i + '][nominal]';
                    const idInput = row.querySelector('[name*="[id]"]');
                    if (idInput) idInput.name = 'fee[' + i + '][id]';
                });
                recalcTotal();
            }

            function recalcTotal() {
                let sum = 0;
                container.querySelectorAll('.fee-nominal').forEach(function(inp) {
                    sum += parseFloat(inp.value) || 0;
                });
                const el = document.querySelector('.fee-sum');
                if (el) {
                    el.textContent = sum.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                } else {
                    const total = document.getElementById('fee-total');
                    if (total && container.querySelectorAll('.fee-row').length > 0) {
                        total.innerHTML = '<strong>{{ __("Total") }}:</strong> Rp <span class="fee-sum">' + sum.toLocaleString('id-ID', {minimumFractionDigits: 2}) + '</span>';
                    }
                }
            }

            container.addEventListener('input', function(e) {
                if (e.target.classList.contains('fee-nominal')) recalcTotal();
            });

            addBtn.addEventListener('click', function() {
                const row = document.createElement('div');
                row.className = 'row g-2 mb-2 fee-row align-items-center';
                row.innerHTML = '<div class="col-md-5"><input type="text" name="fee[' + idx + '][keterangan]" class="form-control form-control-sm" placeholder="Contoh: Cashback, Uang saku"></div><div class="col-md-5"><input type="number" name="fee[' + idx + '][nominal]" step="0.01" min="0" class="form-control form-control-sm fee-nominal" placeholder="0" value="0"></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-outline-danger fee-remove" title="{{ __("Hapus") }}"><i class="ti ti-trash"></i></button></div>';
                container.appendChild(row);
                idx++;
                updateNames();
                row.querySelector('.fee-remove').addEventListener('click', function() {
                    row.remove();
                    updateNames();
                });
            });

            container.querySelectorAll('.fee-remove').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    this.closest('.fee-row').remove();
                    updateNames();
                });
            });
        });
    </script>
    @endpush
@endsection
