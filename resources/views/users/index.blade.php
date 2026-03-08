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
                            <a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">
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
            @can('user create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route(name: 'users.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __(key: 'Tambah') }}
                    </a>
                </div>
            @endcan

            <div class="row">
                <div class="col-12">
                    <div class="card ">
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __(key: 'Name') }}</th>
                                            <th>{{ __(key: 'Email') }}</th>
                                            <th>{{ __(key: 'No Wa') }}</th>
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
            columns: [
                {
                    data: 'avatar',
                    name: 'avatar',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        if (data) {
                            return `<div class="d-flex align-items-center">
                            <div class="h-30 w-30 d-flex-center rounded-circle overflow-hidden bg-transparent border">
                                <img alt="${full.nama || 'User'}" class="img-fluid" src="${data}" style="object-fit: cover; width: 100%; height: 100%;">
                            </div>
                            <p class="mb-0 ps-2">${full.name || 'Unknown'}</p>
                        </div>`;
                        } else {
                            return `<div class="d-flex align-items-center">
                            <div class="h-30 w-30 d-flex-center rounded-circle overflow-hidden bg-transparent border">
                                <i class="fas fa-user text-muted"></i>
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
                    data: 'no_wa',
                    name: 'no_wa'
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
            createdRow: function(row, data, dataIndex) {
                $(row).find('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    </script>
@endpush
