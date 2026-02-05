@extends('layouts.app')

@section('title', __(key: 'Users'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">Users</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="#">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">Users</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display app-data-table default-data-table" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __(key: 'Name') }}</th>
                                            <th>{{ __(key: 'Email') }}</th>
                                            <th>{{ __(key: 'Role') }}</th>
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
            ajax: "{{ route(name: 'users.index') }}",
            columns: [{
                    data: 'avatar',
                    name: 'avatar',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        if (data) {
                            return `<div class="d-flex align-items-center">
                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-info">
                                <img alt="${full.nama || 'User'}" class="img-fluid" src="${data}">
                            </div>
                            <p class="mb-0 ps-2">${full.name || 'Unknown'}</p>
                        </div>`;
                        } else {
                            return `<div class="d-flex align-items-center">
                            <div class="h-30 w-30 d-flex-center b-r-50 overflow-hidden text-bg-info">
                                <i class="fas fa-user"></i>
                            </div>
                            <p class="mb-0 ps-2">${full.name || 'Unknown'}</p>
                        </div>`;
                        }
                    }
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
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
