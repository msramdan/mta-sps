@extends('layouts.app')

@section('title', __('Jadwal Teknisi'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Jadwal Teknisi') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Jadwal Teknisi') }}</a></li>
                    </ul>
                </div>
            </div>
            @can('jadwal teknisi create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('jadwal-teknisi.create') }}" class="btn btn-primary mb-3">
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
                                            <th>Judul</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Teknisi</th>
                                            <th>Total Estimasi</th>
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
        ajax: "{{ route('jadwal-teknisi.index') }}",
        columns: [
            { data: 'judul', name: 'judul' },
            { data: 'tanggal_mulai_formatted', name: 'tanggal_mulai' },
            { data: 'tanggal_selesai_formatted', name: 'tanggal_selesai' },
            { data: 'teknisi_names', name: 'teknisi.name', orderable: false },
            { data: 'total_estimasi', name: 'total_estimasi', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endpush

