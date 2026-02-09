@extends('layouts.app')

@section('title', __(key: 'Banks'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Banks') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Banks') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                {{-- @can('bank create') --}}
                    <a href="{{ route(name: 'banks.create') }}" class="btn btn-primary mb-3 me-3">
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
                                            <th>{{ __(key: 'Nama Bank') }}</th>
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
            ajax: "{{ route(name: 'banks.index') }}",
            columns: [
                {
                    data: 'nama_bank',
                    name: 'nama_bank',
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
