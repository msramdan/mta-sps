@extends('layouts.auth')

@section('title', __('Verifikasi OTP'))

@section('content')
    <div class="app-wrapper d-block">
        <div class="">
            <main class="w-100 p-0">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="login-form-container">
                                <div class="form_container">
                                    <form class="app-form" method="POST" action="{{ route('login-otp.verify') }}">
                                        @csrf
                                        <div class="mb-3 text-center">
                                            <img alt="#" src="{{ asset('frontend/logo.png') }}"
                                                style="width: 180px; margin-bottom:15px">
                                            <h5 class="mb-2">Verifikasi OTP</h5>
                                            <p class="f-s-12 text-secondary">Kode OTP telah dikirim ke <strong>{{ $email }}</strong>. Masukkan kode tersebut di bawah ini.</p>
                                        </div>

                                        @if (session('success'))
                                            <div class="alert alert-success alert-dismissible show fade">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

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
                                            <label class="form-label" for="otp">Kode OTP (6 digit)</label>
                                            <input type="text" class="form-control form-control-lg text-center @error('otp') is-invalid @enderror"
                                                name="otp" id="otp" placeholder="000000" maxlength="6" pattern="[0-9]*"
                                                inputmode="numeric" autocomplete="one-time-code" required autofocus
                                                value="{{ old('otp') }}">
                                            @error('otp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Kode berlaku selama 5 menit.</div>
                                        </div>

                                        <div class="mb-1">
                                            <button type="submit" class="btn btn-primary w-100">{{ __('Verifikasi') }}</button>
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        <p class="mb-1">
                                            <form method="POST" action="{{ route('login-otp.resend') }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-primary">Kirim ulang OTP?</button>
                                            </form>
                                        </p>
                                        <p class="mb-3">
                                            <a href="{{ route('login') }}" class="text-primary">Kembali ke halaman login</a>
                                        </p>
                                    </div>
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
            const otpInput = document.getElementById('otp');
            if (otpInput) {
                otpInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/\D/g, '');
                });
            }
        });
    </script>
@endpush
