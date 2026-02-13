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
                                            <th>{{ __('Tanggal') }}</th>
                                            <th>{{ __('Merchant') }}</th>
                                            <th>{{ __('Pelanggan') }}</th>
                                            <th>{{ __('Biaya') }}</th>
                                            <th>{{ __('Dibayar') }}</th>
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
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transaksis.index') }}",
            columns: [{
                    data: 'no_referensi',
                    name: 'no_referensi'
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
                    data: 'biaya',
                    name: 'biaya'
                },
                {
                    data: 'jumlah_dibayar',
                    name: 'jumlah_dibayar'
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
                [1, 'desc']
            ]
        });
    </script>
@endpush
