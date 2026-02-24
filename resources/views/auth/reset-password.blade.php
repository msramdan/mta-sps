@extends('layouts.auth')

@section('title', __('Reset Kata Sandi'))

@section('content')
    <div class="app-wrapper d-block">
        <div class="">
            <main class="w-100 p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="login-form-container">
                                <div class="form_container">
                                    <form class="app-form" method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                        <div class="mb-3 text-center">
                                            <img alt="#" src="{{ asset('frontend/logo.png') }}"
                                                style="width: 180px; margin-bottom:15px">
                                            <p class="f-s-12 text-secondary">Masukkan kata sandi baru (minimal 8 karakter).</p>
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
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Alamat Email</label>
                                            <input type="email" class="form-control form-control-sm bg-light"
                                                id="email" value="{{ old('email', $request->query('email')) }}" readonly
                                                aria-readonly="true">
                                            <input type="hidden" name="email" value="{{ old('email', $request->query('email')) }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Kata Sandi Baru <span class="text-muted">(min. 8 karakter)</span></label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Kata sandi baru" required autocomplete="new-password"
                                                    minlength="8">
                                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control" placeholder="Ulangi kata sandi baru" required
                                                autocomplete="new-password" minlength="8">
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100">Reset Kata Sandi</button>
                                        </div>
                                        <div class="text-center">
                                            <p class="mb-0">
                                                <a href="{{ route('login') }}" class="text-primary">Kembali ke halaman masuk</a>
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
            var togglePassword = document.getElementById('togglePassword');
            var passwordInput = document.getElementById('password');
            var togglePasswordIcon = document.getElementById('togglePasswordIcon');
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    togglePasswordIcon.classList.toggle('fa-eye-slash', type === 'text');
                    togglePasswordIcon.classList.toggle('fa-eye', type === 'password');
                });
            }
        });
    </script>
@endpush
