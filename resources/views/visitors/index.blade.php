@extends('layouts.app')

@section('title', __('Visitor Sales'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Visitor Sales') }} / Kunjungan Sales</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Visitor Sales') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            @can('visitor create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('visitors.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> {{ __('Tambah') }}
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
                                            <th>Sales Marketing</th>
                                            <th>Nama RS</th>
                                            <th>PIC RS</th>
                                            <th>No. Telp PIC</th>
                                            <th>Tanggal Kunjungan</th>
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
        ajax: "{{ route('visitors.index') }}",
        columns: [
            { data: 'sales_name', name: 'user.name' },
            { data: 'nama_rs', name: 'nama_rs' },
            { data: 'pic_rs', name: 'pic_rs' },
            { data: 'no_telp_pic', name: 'no_telp_pic' },
            { data: 'tanggal_visit_formatted', name: 'tanggal_visit' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endpush
