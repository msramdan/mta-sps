@extends('layouts.auth')

@section('title', __('Masuk'))

@section('content')
    <div class="app-wrapper d-block">
        <div class="">
            <main class="w-100 p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="login-form-container">
                                <div class="form_container">
                                    <form class="app-form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3 text-center">
                                            <img alt="#" src="{{ asset('frontend/logo.png') }}"
                                                style="width: 180px; margin-bottom:15px">
                                            <p class="f-s-12 text-secondary">Mulai dengan aplikasi kami, cukup masuk dan
                                                nikmati pengalamannya.</p>
                                        </div>
                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible show fade">
                                                <div class="d-flex">
                                                    <ul class="ms-0 mb-0 flex-grow-1">
                                                        @foreach ($errors->all() as $error)
                                                            <li class="text-white fw-normal">
                                                                {{ $error }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @endif

                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible show fade">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label class="form-label" for="email">Alamat Email</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" id="email" autocomplete="email" placeholder="Email"
                                                value="{{ old('email') }}" required autofocus>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Kata Sandi</label>
                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Kata Sandi" name="password" id="password"
                                                    autocomplete="current-password" required>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    id="togglePassword">
                                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @if (config('app.show_captcha') === 'Yes')
                                            <div class="mb-3">
                                                {!! NoCaptcha::display() !!}
                                                {!! NoCaptcha::renderJs() !!}
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100">{{ __('Masuk') }}</button>
                                        </div>
                                        <div class="text-center">
                                            <p class="mb-0">Belum punya akun?
                                                <a href="{{ route('register') }}" class="text-primary">Daftar di
                                                    sini</a>
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

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                if (type === 'password') {
                    togglePasswordIcon.classList.remove('fa-eye-slash');
                    togglePasswordIcon.classList.add('fa-eye');
                } else {
                    togglePasswordIcon.classList.remove('fa-eye');
                    togglePasswordIcon.classList.add('fa-eye-slash');
                }
            });
        });
    </script>
@endpush
