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
                                            <label class="form-label">Kode OTP (6 digit)</label>
                                            <div class="otp-inputs d-flex justify-content-center gap-2 mb-2">
                                                @php $oldOtp = str_split((string) old('otp', '')); @endphp
                                                @for ($i = 0; $i < 6; $i++)
                                                    <input type="text" class="form-control form-control-lg text-center otp-digit @error('otp') is-invalid @enderror"
                                                        maxlength="1" pattern="[0-9]*" inputmode="numeric"
                                                        data-index="{{ $i }}" autocomplete="off"
                                                        value="{{ $oldOtp[$i] ?? '' }}"
                                                        {{ $i === 0 ? 'autofocus' : '' }}>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="otp" id="otp" value="{{ old('otp') }}">
                                            <div class="form-text">Kode berlaku selama 5 menit.</div>
                                        </div>

                                        <div class="mb-3">
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

@push('css')
    <style>
        .otp-inputs .otp-digit {
            width: 48px;
            height: 52px;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .otp-inputs .otp-digit.is-invalid {
            background-image: none;
            border-color: #dc3545;
        }
    </style>
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const digits = document.querySelectorAll('.otp-digit');
            const hiddenInput = document.getElementById('otp');

            function updateHidden() {
                hiddenInput.value = Array.from(digits).map(d => d.value).join('');
            }

            document.querySelector('.form_container form').addEventListener('submit', function() {
                updateHidden();
            });

            digits.forEach((digit, i) => {
                digit.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 1);
                    updateHidden();
                    if (this.value && i < 5) digits[i + 1].focus();
                });

                digit.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && i > 0) {
                        digits[i - 1].focus();
                    }
                });

                digit.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasted = (e.clipboardData?.getData('text') || '').replace(/\D/g, '').slice(0, 6);
                    pasted.split('').forEach((char, j) => {
                        if (digits[i + j]) digits[i + j].value = char;
                    });
                    updateHidden();
                    digits[Math.min(i + pasted.length, 5)].focus();
                });
            });
        });
    </script>
@endpush
