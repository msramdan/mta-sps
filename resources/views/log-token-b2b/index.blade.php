@extends('layouts.app')

@section('title', __('Log Token B2B'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Log Token B2B') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Log Token B2B') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('log-token-b2b.index') }}" id="form-filter" class="row g-3 align-items-end">
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
                                            <th>{{ __('Header') }}</th>
                                            <th>{{ __('Payload') }}</th>
                                            <th>{{ __('Response') }}</th>
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
                url: "{{ route('log-token-b2b.index') }}",
                data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                }
            },
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'header', name: 'header', orderable: false, searchable: true },
                { data: 'payload', name: 'payload', orderable: false, searchable: true },
                { data: 'response', name: 'response', orderable: false, searchable: true },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']]
        });
    </script>
@endpush
