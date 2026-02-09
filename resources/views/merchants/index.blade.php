@extends('layouts.app')

@section('title', __(key: 'Merchants'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Merchants') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Merchants') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                {{-- @can('merchant create') --}}
                    <a href="{{ route(name: 'merchants.create') }}" class="btn btn-primary mb-3 me-3">
                        <i class="fas fa-plus"></i>
                        {{ __(key: 'Tambah') }}
                    </a>
                {{-- @endcan --}}

                
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __(key: 'Nama Merchant') }}</th>
											<th>{{ __(key: 'Logo') }}</th>
											<th>{{ __(key: 'Url Callback') }}</th>
											<th>{{ __(key: 'Apikey') }}</th>
											<th>{{ __(key: 'Secretkey') }}</th>
											<th>{{ __(key: 'Bank') }}</th>
											<th>{{ __(key: 'Pemilik Rekening') }}</th>
											<th>{{ __(key: 'Nomor Rekening') }}</th>
											<th>{{ __(key: 'Is Active') }}</th>
                                            <th>{{ __(key: 'Action') }}</th>
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
            ajax: "{{ route(name: 'merchants.index') }}",
            columns: [
                {
                    data: 'nama_merchant',
                    name: 'nama_merchant',
                },
				{
                    data: 'logo',
                    name: 'logo',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return `<div class="avatar">
                            <img src="${data}" alt="Logo"  />
                        </div>`;
                        }
                    },
				{
                    data: 'url_callback',
                    name: 'url_callback',
                },
				{
                    data: 'apikey',
                    name: 'apikey',
                },
				{
                    data: 'secretkey',
                    name: 'secretkey',
                },
				{
                    data: 'bank',
                    name: 'bank.nama_bank'
                },
				{
                    data: 'pemilik_rekening',
                    name: 'pemilik_rekening',
                },
				{
                    data: 'nomor_rekening',
                    name: 'nomor_rekening',
                },
				{
                    data: 'is_active',
                    name: 'is_active',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
