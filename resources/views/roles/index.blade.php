@extends('layouts.app')

@section('title', __(key: 'Detail Role'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">Detail Role</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'roles.index') }}">Roles</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">Detail</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold" style="width: 200px;">{{ __(key: 'Name') }}</td>
                                        <td>{{ $role->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Permissions') }}</td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                @forelse ($role->permissions as $permission)
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-shield-alt me-1"></i>
                                                        {{ $permission->name }}
                                                    </span>
                                                @empty
                                                    <span class="text-muted">{{ __(key: 'No permissions assigned') }}</span>
                                                @endforelse
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Created at') }}</td>
                                        <td>
                                            <i class="far fa-calendar-alt me-1"></i>
                                            {{ $role->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Updated at') }}</td>
                                        <td>
                                            <i class="far fa-clock me-1"></i>
                                            {{ $role->updated_at->format('Y-m-d H:i:s') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route(name: 'roles.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    {{ __(key: 'Back') }}
                                </a>

                                <div class="btn-group">
                                    @can('role & permission edit')
                                    <a href="{{ route(name: 'roles.edit', parameters: $role->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-1"></i>
                                        {{ __(key: 'Edit') }}
                                    </a>
                                    @endcan

                                    @can('role & permission delete')
                                    <form action="{{ route(name: 'roles.destroy', parameters: $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>
                                            {{ __(key: 'Delete') }}
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
