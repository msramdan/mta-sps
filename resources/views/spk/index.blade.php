@extends('layouts.app')

@section('title', __('SPK/PO'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('SPK (Surat Perintah Kerja) / PO') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('SPK/PO') }}</a></li>
                    </ul>
                </div>
            </div>
            @can('spk create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('spk.create') }}" class="btn btn-primary mb-3">
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
                                            <th>No. SPK/PO</th>
                                            <th>No. SPH</th>
                                            <th>Nilai Kontrak</th>
                                            <th>Include PPN</th>
                                            <th>Jumlah Alat</th>
                                            <th>Tanggal SPK</th>
                                            <th>Deadline</th>
                                            <th>User Created</th>
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
        ajax: "{{ route('spk.index') }}",
        columns: [
            { data: 'no_spk', name: 'no_spk' },
            { data: 'sph_no', name: 'sph.no_sph' },
            { data: 'nilai_kontrak_formatted', name: 'nilai_kontrak', orderable: false, searchable: false },
            { data: 'include_ppn_label', name: 'include_ppn', orderable: false, searchable: false },
            { data: 'jumlah_alat', name: 'jumlah_alat' },
            { data: 'tanggal_spk_formatted', name: 'tanggal_spk' },
            { data: 'tanggal_deadline_formatted', name: 'tanggal_deadline' },
            { data: 'creator_name', name: 'creator.name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
</script>
@endpush
