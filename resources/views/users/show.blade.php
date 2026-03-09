@extends('layouts.app')

@section('title', __(key: 'Detail User'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'User') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'users.index') }}">
                                {{ __(key: 'User') }}
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <div class="mb-3">
                                <img src="{{ $user->avatar }}" alt="Avatar"
                                    class="rounded-3 img-fluid shadow-sm"
                                    style="object-fit: cover; width: 260px; height: 150px;">
                            </div>
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-1">{{ $user->email }}</p>
                            <span class="badge bg-primary mb-2">
                                {{ $user->getRoleNames()->toArray() !== [] ? $user->getRoleNames()[0] : '-' }}
                            </span>
                            <span class="badge bg-secondary">
                                {{ $user->no_wa ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mb-3">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header border-0 bg-transparent">
                            <h5 class="mb-0">{{ __(key: 'User Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __(key: 'Name') }}</div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __(key: 'Email') }}</div>
                                        <div class="fw-semibold">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">No. WhatsApp</div>
                                        <div class="fw-semibold">{{ $user->no_wa ?? '-' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __(key: 'Role') }}</div>
                                        <div class="fw-semibold">
                                            {{ $user->getRoleNames()->toArray() !== [] ? $user->getRoleNames()[0] : '-' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __('Perusahaan') }}</div>
                                        <div class="fw-semibold">
                                            @if ($user->companies->isNotEmpty())
                                                {{ $user->companies->pluck('name')->join(', ') }}
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header border-0 bg-transparent">
                            <h5 class="mb-0">{{ __(key: 'System Info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __(key: 'Email verified at') }}</div>
                                        <div class="fw-semibold">
                                            {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : '-' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __(key: 'Created at') }}</div>
                                        <div class="fw-semibold">{{ $user->created_at->format('Y-m-d H:i:s') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 h-100">
                                        <div class="text-muted small mb-1">{{ __(key: 'Updated at') }}</div>
                                        <div class="fw-semibold">{{ $user->updated_at->format('Y-m-d H:i:s') }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route(name: 'users.index') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-1"></i>{{ __(key: 'Kembali') }}
                                </a>
                                @can('user edit')
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                        <i class="ti ti-edit me-1"></i>{{ __(key: 'Edit User') }}
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
