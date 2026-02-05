@extends('layouts.app')

@section('title', __(key: 'Profile'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __(key: 'Profile') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Profile') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <x-alert></x-alert>

            <div class="row">
                <div class="col-lg-3">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="avatar avatar-xxl mb-3">
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="img-fluid rounded-circle">
                                </div>
                                <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                                <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __(key: 'Profile Information') }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user-profile-information.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">{{ __(key: 'Name') }}</label>
                                        <input type="text" name="name" class="form-control @error('name', 'updateProfileInformation') is-invalid @enderror"
                                               id="name" value="{{ old('name') ?? auth()->user()->name }}" required>
                                        @error('name', 'updateProfileInformation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">{{ __(key: 'E-mail Address') }}</label>
                                        <input type="email" name="email" class="form-control @error('email', 'updateProfileInformation') is-invalid @enderror"
                                               id="email" value="{{ old('email') ?? auth()->user()->email }}" required>
                                        @error('email', 'updateProfileInformation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="avatar" class="form-label">{{ __(key: 'Avatar') }}</label>
                                        <input type="file" name="avatar" class="form-control @error('avatar', 'updateProfileInformation') is-invalid @enderror"
                                               id="avatar" accept="image/*">
                                        @error('avatar', 'updateProfileInformation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Max file size: 2MB. Allowed formats: JPG, PNG, GIF.</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">{{ __(key: 'Update Profile') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __(key: 'Change Password') }}</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user-password.update') }}">
                                @csrf
                                @method('put')

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="current_password" class="form-label">{{ __(key: 'Current Password') }}</label>
                                        <input type="password" name="current_password"
                                               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                               id="current_password" required>
                                        @error('current_password', 'updatePassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="password" class="form-label">{{ __(key: 'New Password') }}</label>
                                        <input type="password" name="password"
                                               class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                               id="password" required>
                                        @error('password', 'updatePassword')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="password_confirmation" class="form-label">{{ __(key: 'Confirm Password') }}</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">{{ __(key: 'Change Password') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('css')
    <style>
        .avatar-xxl {
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .avatar-xxl img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush
