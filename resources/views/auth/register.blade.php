@extends('layouts.auth')

@section('title', __('Daftar'))

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
                                    <form class="app-form p-3" method="POST" action="">
                                        @csrf
                                        <div class="mb-3 text-center">
                                            <img alt="#" src="{{ asset('logo.png') }}" style="width: 160px; margin-bottom:10px">
                                            <p class="f-s-12 text-secondary">Daftar sekarang dan mulailah mengelola bisnis
                                                Anda dengan
                                                lebih efisien.</p>
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible show fade">
                                                <div class="d-flex">
                                                    <ul class="ms-0 mb-0 flex-grow-1">
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <!-- Kelompok 1: Nama Perusahaan & Nama Pemilik -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nama Perusahaan <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="nama_perusahaan" type="text"
                                                    value="{{ old('nama_perusahaan') }}" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Nama Pemilik <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="nama_pemilik" type="text"
                                                    value="{{ old('nama_pemilik') }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Kelompok 2: No WhatsApp & Email -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">No WhatsApp <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="no_wa" placeholder="ex. 6281234567890"
                                                    type="number" value="{{ old('no_wa') }}" required
                                                    oninput="validateWhatsAppNumber(this)">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input class="form-control" name="email" type="email"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Kelompok 3: Password & Konfirmasi Password -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Password <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="password" type="password" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Konfirmasi Password <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" name="password_confirmation" type="password"
                                                    required>
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
                                                <a href="{{ route('login') }}" class="text-primary fw-bold">Login di
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
        function validateWhatsAppNumber(input) {
            input.value = input.value.replace(/\D/g, '');
            if (input.value.length > 0 && !input.value.startsWith('62')) {
                input.value = '62' + input.value.replace(/^62/, '');
            }
            if (input.value.length > 14) {
                input.value = input.value.substring(0, 14);
            }
        }
    </script>
@endpush
