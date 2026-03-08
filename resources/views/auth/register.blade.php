@extends('layouts.auth')

@section('title', __('Register'))

@push('css')
    <link rel="stylesheet" href="{{ asset('mazer') }}/css/pages/auth.css">
@endpush

@section('content')
    <div class="app-wrapper d-block">
        <div class="">
            <main class="w-100 p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="login-form-container">
                                <div class="form_container">
                                    <form class="app-form p-3" method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="mb-3 text-center">
                                            <img alt="#" src="{{ asset('frontend/logo.png') }}"
                                                style="width: 180px; margin-bottom:15px">
                                            <p class="f-s-12 text-secondary">{{ __('Create your account') }}</p>
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible show fade">
                                                <div class="d-flex">
                                                    <ul class="ms-0 mb-0 flex-grow-1">
                                                        @foreach ($errors->all() as $error)
                                                            <li class="text-white fw-normal">{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                                                <input class="form-control @error('name') is-invalid @enderror"
                                                       name="name"
                                                       type="text"
                                                       value="{{ old('name') }}"
                                                       required
                                                       maxlength="255"
                                                       placeholder="{{ __('Name') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">{{ __('Email') }} <span class="text-danger">*</span></label>
                                                <input class="form-control @error('email') is-invalid @enderror"
                                                       name="email"
                                                       type="email"
                                                       value="{{ old('email') }}"
                                                       required
                                                       placeholder="{{ __('Email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">No. WhatsApp</label>
                                                <input class="form-control @error('no_wa') is-invalid @enderror"
                                                       name="no_wa"
                                                       type="text"
                                                       value="{{ old('no_wa') }}"
                                                       maxlength="13"
                                                       placeholder="08xxx atau 62xxx">
                                                @error('no_wa')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('Password') }} <span class="text-danger">*</span></label>
                                                <input class="form-control @error('password') is-invalid @enderror"
                                                       name="password"
                                                       type="password"
                                                       required
                                                       placeholder="{{ __('Password') }}">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="password_confirmation" type="password"
                                                    required placeholder="{{ __('Confirm Password') }}">
                                            </div>
                                        </div>

                                        @if (config('app.show_captcha') === 'Yes')
                                            <div class="mb-3">
                                                {!! NoCaptcha::display() !!}
                                                {!! NoCaptcha::renderJs() !!}
                                            </div>
                                        @endif

                                        <div class="mb-3 mt-4">
                                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">{{ __('Register') }}</button>
                                        </div>
                                        <div class="text-center">
                                            <p class="mb-0">{{ __('Already have an account?') }}
                                                <a href="{{ route('login') }}" class="text-primary fw-bold">{{ __('Login') }}</a>
                                            </p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
