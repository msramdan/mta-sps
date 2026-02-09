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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            <div class="avatar avatar-xl">
                                                <img src="{{ $user->avatar }}" alt="Avatar" class="rounded img-fluid"
                                                    style="object-fit: cover; width: 350px; height: 200px;">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Name') }}</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Email') }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Role') }}</td>
                                        <td>{{ $user->getRoleNames()->toArray() !== [] ? $user->getRoleNames()[0] : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Email verified at') }}</td>
                                        <td>{{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Created at') }}</td>
                                        <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Updated at') }}</td>
                                        <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ route(name: 'users.index') }}" class="btn btn-secondary">{{ __(key: 'Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
