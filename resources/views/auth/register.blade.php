@extends('layouts.auth')

@section('title', __('Daftar Merchant'))

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
                                    <form class="app-form p-3" method="POST" action="{{ route('web.register.merchant') }}">
                                        @csrf
                                        <div class="mb-3 text-center">
                                            <img alt="#" src="{{ asset('frontend/logo.png') }}"
                                                style="width: 180px; margin-bottom:15px">
                                            <p class="f-s-12 text-secondary">Daftarkan merchant Anda dan nikmati integrasi mudah untuk terima pembayaran digital dengan biaya kompetitif.</p>
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

                                        @if (session('error'))
                                            <div class="alert alert-danger alert-dismissible show fade">
                                                {{ session('error') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Nama Lengkap <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="nama_pemilik" type="text"
                                                    value="{{ old('nama_pemilik') }}" required
                                                    placeholder="Contoh: Muhammad Saeful Ramdan">
                                                <small class="text-muted">Harus sesuai dengan nama di KTP</small>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Nama Merchant/Perusahaan <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="nama_perusahaan" type="text"
                                                    value="{{ old('nama_perusahaan') }}" required
                                                    placeholder="Contoh: PT Tecanusa">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">No WhatsApp <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control @error('no_wa') is-invalid @enderror"
                                                       name="no_wa"
                                                       placeholder="Contoh: 6281234567890"
                                                       type="text"
                                                       value="{{ old('no_wa') }}"
                                                       required>
                                                @error('no_wa')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i>
                                                    Format harus diawali dengan 62 (contoh: 6281234567890)
                                                </small>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input class="form-control @error('email') is-invalid @enderror"
                                                       name="email"
                                                       type="email"
                                                       value="{{ old('email') }}"
                                                       required
                                                       placeholder="Masukkan email aktif">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Password <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control @error('password') is-invalid @enderror"
                                                       name="password"
                                                       type="password"
                                                       required
                                                       placeholder="Minimal 8 karakter">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Konfirmasi Password <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="password_confirmation" type="password"
                                                    required placeholder="Ulangi password">
                                            </div>
                                        </div>

                                        @if (config('app.show_captcha') === 'Yes')
                                            <div class="mb-3">
                                                {!! NoCaptcha::display() !!}
                                                {!! NoCaptcha::renderJs() !!}
                                            </div>
                                        @endif

                                        <div class="mb-3 mt-4">
                                            <button type="submit"
                                                class="btn btn-primary w-100 py-2 fw-bold">{{ __('Daftar Sekarang') }}</button>
                                        </div>
                                        <div class="text-center">
                                            <p class="mb-0">Sudah punya akun?
                                                <a href="{{ route('login') }}" class="text-primary fw-bold">Login di sini</a>
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
