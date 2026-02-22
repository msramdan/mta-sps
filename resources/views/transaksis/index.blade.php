@extends('layouts.app')

@section('title', __('Transaksi'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Transaksi') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Transaksi') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            @if(isset($summary) && $summary)
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Total Transaksi</small>
                            <div class="fw-bold fs-5" id="summary-total">{{ number_format($summary->total_transaksi, 0, ',', '.') }}</div>
                            <small class="text-muted" id="summary-period">{{ \Carbon\Carbon::parse($summary->tanggal_from)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($summary->tanggal_to)->translatedFormat('d M Y') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Transaksi Sukses</small>
                            <div class="fw-bold text-success fs-5" id="summary-success">{{ number_format($summary->total_success, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Total Dibayar</small>
                            <div class="fw-bold text-primary" id="summary-dibayar">Rp {{ number_format($summary->total_dibayar, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Total Biaya</small>
                            <div class="fw-bold" id="summary-biaya">Rp {{ number_format($summary->total_biaya, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body py-3">
                    <form id="filterForm" class="row g-2 align-items-end">
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label small mb-0">Tanggal Dari</label>
                            <input type="date" name="tanggal_from" id="tanggal_from" class="form-control form-control-sm" value="{{ $filterDefaults->tanggal_from ?? now()->startOfMonth()->format('Y-m-d') }}">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label small mb-0">Tanggal Sampai</label>
                            <input type="date" name="tanggal_to" id="tanggal_to" class="form-control form-control-sm" value="{{ $filterDefaults->tanggal_to ?? now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <label class="form-label small mb-0">Status</label>
                            <select name="status" id="status_filter" class="form-select form-select-sm">
                                <option value="" {{ ($filterDefaults->status ?? '') === '' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending" {{ ($filterDefaults->status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="success" {{ ($filterDefaults->status ?? '') === 'success' ? 'selected' : '' }}>Success</option>
                                <option value="failed" {{ ($filterDefaults->status ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="expired" {{ ($filterDefaults->status ?? '') === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <button type="submit" class="btn btn-primary btn-sm me-1"><i class="ti ti-filter me-1"></i>Filter</button>
                            <button type="button" id="resetFilter" class="btn btn-outline-secondary btn-sm">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                @can('transaksi create')
                    <a href="{{ route('transaksis.create') }}" class="btn btn-primary mb-3 me-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Tambah Transaksi') }}
                    </a>
                @endcan
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No. Referensi') }}</th>
                                            <th>{{ __('No. Ref. Merchant') }}</th>
                                            <th>{{ __('Tanggal') }}</th>
                                            <th>{{ __('Merchant') }}</th>
                                            <th>{{ __('Pelanggan') }}</th>
                                            <th>{{ __('Beban Biaya') }}</th>
                                            <th>{{ __('Biaya') }}</th>
                                            <th>{{ __('Dibayar') }}</th>
                                            <th>{{ __('Diterima') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        function getFilterParams() {
            return {
                tanggal_from: $('#tanggal_from').val(),
                tanggal_to: $('#tanggal_to').val(),
                status: $('#status_filter').val()
            };
        }
        function loadSummary() {
            @if(isset($summary) && $summary)
            var p = getFilterParams();
            $.get("{{ route('transaksis.summary') }}", p, function(res) {
                $('#summary-total').text(new Intl.NumberFormat('id-ID').format(res.total_transaksi));
                $('#summary-success').text(new Intl.NumberFormat('id-ID').format(res.total_success));
                $('#summary-dibayar').text('Rp ' + new Intl.NumberFormat('id-ID').format(res.total_dibayar));
                $('#summary-biaya').text('Rp ' + new Intl.NumberFormat('id-ID').format(res.total_biaya));
                if (p.tanggal_from && p.tanggal_to) {
                    var from = new Date(p.tanggal_from);
                    var to = new Date(p.tanggal_to);
                    $('#summary-period').text(from.toLocaleDateString('id-ID') + ' - ' + to.toLocaleDateString('id-ID'));
                }
            }).fail(function() {});
            @endif
        }
        var dataTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('transaksis.index') }}",
                data: function(d) {
                    $.extend(d, getFilterParams());
                }
            },
            columns: [
                {
                    data: 'no_referensi',
                    name: 'no_referensi'
                },
                {
                    data: 'no_ref_merchant',
                    name: 'no_ref_merchant'
                },
                {
                    data: 'tanggal_transaksi',
                    name: 'tanggal_transaksi',
                    render: function(data) {
                        return new Date(data).toLocaleString('id-ID');
                    }
                },
                {
                    data: 'merchant_id',
                    name: 'merchant.nama_merchant'
                },
                                {
                                    data: 'nama_pelanggan',
                                    name: 'nama_pelanggan'
                                },
                                {
                                    data: 'beban_biaya',
                                    name: 'beban_biaya'
                                },
                                {
                                    data: 'biaya',
                                    name: 'biaya'
                                },
                                {
                                    data: 'jumlah_dibayar',
                                    name: 'jumlah_dibayar'
                                },
                                {
                                    data: 'jumlah_diterima',
                                    name: 'jumlah_diterima'
                                },
                                {
                                    data: 'status',
                                    name: 'status'
                                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [2, 'desc']
            ]
        });
        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            dataTable.ajax.reload();
            loadSummary();
        });
        $('#resetFilter').on('click', function() {
            $('#tanggal_from').val('{{ now()->startOfMonth()->format("Y-m-d") }}');
            $('#tanggal_to').val('{{ now()->format("Y-m-d") }}');
            $('#status_filter').val('');
            dataTable.ajax.reload();
            loadSummary();
        });
    </script>
@endpush
