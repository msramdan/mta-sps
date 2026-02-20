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
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
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
            order: [[0, 'desc']]
        });
    </script>
@endpush
