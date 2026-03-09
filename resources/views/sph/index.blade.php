@extends('layouts.app')

@section('title', __('SPH'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('SPH') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('SPH') }}</a></li>
                    </ul>
                </div>
            </div>
            @can('sph create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('sph.create') }}" class="btn btn-primary mb-3">
                        <i class="ti ti-plus"></i> {{ __('Tambah') }}
                    </a>
                </div>
            @endcan

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>No. SPH</th>
                                            <th>User Created</th>
                                            <th>Tanggal SPH</th>
                                            <th>Versi</th>
                                            <th>Action</th>
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
        ajax: "{{ route('sph.index') }}",
        columns: [
            { data: 'no_sph', name: 'no_sph' },
            { data: 'sales_name', name: 'user.name' },
            { data: 'tanggal_sph_formatted', name: 'tanggal_sph' },
            { data: 'latest_version', name: 'latest_version', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endpush
