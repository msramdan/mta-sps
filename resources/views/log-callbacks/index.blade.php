@extends('layouts.app')

@section('title', __('Log Callback'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Log Callback') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Log Callback') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('log-callbacks.index') }}" id="form-filter" class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label">{{ __('Tanggal Dari') }}</label>
                            <input type="date" name="date_from" id="date_from" class="form-control"
                                value="{{ request('date_from', $defaultDateFrom) }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('Tanggal Sampai') }}</label>
                            <input type="date" name="date_to" id="date_to" class="form-control"
                                value="{{ request('date_to', $defaultDateTo) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('Merchant') }}</label>
                            <select name="merchant_id" id="merchant_id" class="form-select">
                                <option value="">{{ __('Semua Merchant') }}</option>
                                @foreach ($merchants as $m)
                                    <option value="{{ $m->id }}" {{ request('merchant_id') == $m->id ? 'selected' : '' }}>
                                        {{ $m->nama_merchant }} ({{ $m->kode_merchant }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">{{ __('Semua') }}</option>
                                <option value="00" {{ request('status') === '00' ? 'selected' : '' }}>00</option>
                                <option value="06" {{ request('status') === '06' ? 'selected' : '' }}>06</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-filter"></i> {{ __('Filter') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('log callback delete')
                        <div class="card-body border-bottom py-2">
                            <button type="button" id="btn-bulk-delete-log" class="btn btn-danger btn-sm" data-url="{{ route('log-callbacks.bulk-destroy') }}" title="{{ __('Hapus data terpilih') }}">
                                <i class="ti ti-trash"></i> {{ __('Hapus terpilih') }}
                            </button>
                        </div>
                        @endcan
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px;">
                                                <input type="checkbox" id="log-select-all" class="form-check-input" title="{{ __('Pilih semua') }}">
                                            </th>
                                            <th>{{ __('Tanggal') }}</th>
                                            <th>{{ __('Transaksi ID') }}</th>
                                            <th>{{ __('Merchant') }}</th>
                                            <th>{{ __('Tanggal Callback') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Payload') }}</th>
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
        var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 50,
            ajax: {
                url: "{{ route('log-callbacks.index') }}",
                data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.merchant_id = $('#merchant_id').val();
                    d.status = $('#status').val();
                }
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, className: 'text-center' },
                { data: 'created_at', name: 'created_at' },
                { data: 'transaksi_id', name: 'transaksi_id' },
                { data: 'merchant_id', name: 'merchant_id' },
                { data: 'tanggal_callback', name: 'tanggal_callback' },
                { data: 'status_info', name: 'status_info', orderable: false, searchable: false },
                {
                    data: 'payload_callback',
                    name: 'payload_callback',
                    orderable: false,
                    render: function(data) {
                        if (!data) return '-';
                        return data.length > 80 ? data.substring(0, 80) + '...' : data;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'desc']]
        });

        $('#log-select-all').on('change', function() {
            var checked = this.checked;
            $('#data-table').find('.log-row-checkbox').each(function() {
                this.checked = checked;
            });
        });

        $(document).on('click', '#btn-bulk-delete-log', function() {
            var ids = [];
            $('#data-table').find('.log-row-checkbox:checked').each(function() {
                ids.push($(this).val());
            });
            if (ids.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Pilih minimal satu data untuk dihapus.'
                });
                return;
            }
            var url = $(this).data('url');
            Swal.fire({
                icon: 'warning',
                title: 'Yakin hapus?',
                text: 'Sebanyak ' + ids.length + ' log akan dihapus. Tindakan ini tidak dapat dibatalkan.',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33'
            }).then(function(result) {
                if (result.isConfirmed) {
                    var form = $('<form>').attr({ method: 'POST', action: url }).css('display', 'none');
                    form.append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }));
                    ids.forEach(function(id) {
                        form.append($('<input>').attr({ type: 'hidden', name: 'ids[]', value: id }));
                    });
                    $('body').append(form);
                    form.submit();
                }
            });
        });

        $(document).on('submit', '.form-delete-log-single', function(e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                icon: 'warning',
                title: 'Yakin hapus?',
                text: 'Log ini akan dihapus.',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33'
            }).then(function(result) {
                if (result.isConfirmed) form.submit();
            });
            return false;
        });
    </script>
@endpush
