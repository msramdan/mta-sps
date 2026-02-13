@extends('layouts.app')

@section('title', __(key: 'Edit Merchant'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Merchant') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Setting Merchant') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Alert Status Pengajuan Merchant -->
                            @if(in_array($merchant->status, ['pending', 'approved', 'rejected', 'suspended']))
                                @php
                                    $statusConfig = [
                                        'pending' => [
                                            'title' => 'Menunggu Persetujuan',
                                            'badge' => 'warning',
                                            'icon' => 'fas fa-clock',
                                            'alert' => 'warning',
                                            'message' => 'Pengajuan merchant Anda sedang dalam proses review oleh admin.'
                                        ],
                                        'approved' => [
                                            'title' => 'Disetujui',
                                            'badge' => 'success',
                                            'icon' => 'fas fa-check-circle',
                                            'alert' => 'success',
                                            'message' => 'Pengajuan merchant Anda telah disetujui. Anda dapat mulai menggunakan layanan kami.'
                                        ],
                                        'rejected' => [
                                            'title' => 'Ditolak',
                                            'badge' => 'danger',
                                            'icon' => 'fas fa-times-circle',
                                            'alert' => 'danger',
                                            'message' => 'Pengajuan merchant Anda ditolak oleh admin.'
                                        ],
                                        'suspended' => [
                                            'title' => 'Ditangguhkan',
                                            'badge' => 'danger',
                                            'icon' => 'fas fa-ban',
                                            'alert' => 'danger',
                                            'message' => 'Akun merchant Anda ditangguhkan sementara.'
                                        ]
                                    ];

                                    $config = $statusConfig[$merchant->status];
                                @endphp

                                <div class="alert alert-{{ $config['alert'] }} d-flex align-items-center mb-4" role="alert">
                                    <div class="flex-shrink-0">
                                        <i class="{{ $config['icon'] }} fa-2x me-3"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="alert-heading mb-1">Status Pengajuan Merchant:
                                            <span class="badge bg-{{ $config['badge'] }}">{{ $config['title'] }}</span>
                                        </h5>

                                        <p class="mb-0">
                                            <i class="fas fa-info-circle me-1"></i>
                                            {{ $config['message'] }}
                                            @if($merchant->catatan)
                                                <br><strong>
                                                    @if($merchant->status == 'rejected')
                                                        Alasan Penolakan:
                                                    @elseif($merchant->status == 'suspended')
                                                        Alasan Penangguhan:
                                                    @else
                                                        Catatan Admin:
                                                    @endif
                                                </strong> {{ $merchant->catatan }}
                                            @else
                                                @if($merchant->status == 'pending')
                                                    <br>Silakan lengkapi form data merchant di bawah ini untuk mempercepat proses verifikasi.
                                                @endif
                                            @endif
                                        </p>

                                        <!-- Instruksi khusus untuk status pending -->
                                        @if($merchant->status == 'pending')
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    <strong>Perhatian:</strong> Mohon pastikan semua data yang diisi benar dan lengkap.
                                                    Pastikan juga:
                                                    <ul class="mb-0 mt-1 ps-3">
                                                        <li>Nama pemilik rekening sama dengan nama di KTP</li>
                                                        <li>File KTP jelas dan dapat terbaca</li>
                                                        <li>Logo merchant sesuai dengan merek/perusahaan</li>
                                                        <li>URL callback valid dan dapat diakses</li>
                                                    </ul>
                                                </small>
                                            </div>
                                        @elseif($merchant->status == 'rejected')
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Untuk mengajukan kembali, silakan perbaiki data sesuai catatan di atas dan kirim ulang.
                                                </small>
                                            </div>
                                        @elseif($merchant->status == 'suspended')
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Anda tidak dapat melakukan transaksi selama akun dalam status ditangguhkan.
                                                </small>
                                            </div>
                                        @elseif($merchant->status == 'approved')
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    Merchant Anda aktif dan siap digunakan.
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route(name: 'merchants.update', parameters: $merchant->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-2">
                                    <!-- 1. Informasi Merchant -->
                                    <div class="col-12 mb-4">
                                        <h5 class="mb-3 border-bottom pb-2">Informasi Merchant</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="nama-merchant">Nama Merchant <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="nama_merchant" id="nama-merchant"
                                                        class="form-control @error('nama_merchant') is-invalid @enderror"
                                                        value="{{ isset($merchant) ? $merchant->nama_merchant : old('nama_merchant') }}"
                                                        placeholder="Nama Merchant"
                                                        @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) readonly @endif />
                                                    @error('nama_merchant')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <div class="row g-0">
                                                    <div class="col-md-5 text-center">
                                                        <img src="{{ $merchant?->logo ?? 'https://placehold.co/300?text=No+Image+Available' }}"
                                                            alt="Logo" class="rounded img-fluid mt-1"
                                                            style="object-fit: cover; width: 100%; height: 100px;" />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="form-group ms-3">
                                                            <label for="logo">Logo <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="file" name="logo"
                                                                class="form-control @error('logo') is-invalid @enderror"
                                                                id="logo"
                                                                {{ !isset($merchant) ? 'required' : '' }}
                                                                @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) disabled @endif>
                                                            @error('logo')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                            @isset($merchant)
                                                                <div id="logo-help-block" class="form-text">
                                                                    @if($merchant->status == 'pending')
                                                                        <i class="fas fa-info-circle text-warning me-1"></i>
                                                                        Unggah logo merchant/perusahaan Anda
                                                                    @else
                                                                        Biarkan logo kosong jika tidak ingin mengubahnya.
                                                                    @endif
                                                                </div>
                                                            @endisset
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tambahan Field KTP -->
                                            <div class="col-md-6 mb-3">
                                                <div class="row g-0">
                                                    <div class="col-md-5 text-center">
                                                        <img src="{{ isset($merchant) && $merchant->ktp ? $merchant->ktp : 'https://placehold.co/300?text=No+Image+Available' }}"
                                                            alt="KTP" class="rounded img-fluid mt-1"
                                                            style="object-fit: cover; width: 100%; height: 100px;" />
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="form-group ms-3">
                                                            <label for="ktp">File KTP <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="file" name="ktp" accept="image/*,.pdf"
                                                                class="form-control @error('ktp') is-invalid @enderror"
                                                                id="ktp"
                                                                {{ !isset($merchant) ? 'required' : '' }}
                                                                @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) disabled @endif>
                                                            @error('ktp')
                                                                <span class="text-danger">
                                                                    {{ $message }}
                                                                </span>
                                                            @enderror
                                                            @isset($merchant)
                                                                <div id="ktp-help-block" class="form-text">
                                                                    @if($merchant->status == 'pending')
                                                                        <i class="fas fa-info-circle text-warning me-1"></i>
                                                                        Unggah foto/scan KTP pemilik yang jelas dan dapat terbaca
                                                                    @else
                                                                        Biarkan KTP kosong jika tidak ingin mengubahnya.
                                                                    @endif
                                                                </div>
                                                            @endisset
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. Kredensial API -->
                                    <div class="col-12 mb-4">
                                        <h5 class="mb-3 border-bottom pb-2">Kredensial API</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="url-callback">URL Callback <span
                                                            class="text-danger">*</span></label>
                                                    <input type="url" name="url_callback" id="url-callback"
                                                        class="form-control @error('url_callback') is-invalid @enderror"
                                                        value="{{ isset($merchant) ? $merchant->url_callback : old('url_callback') }}"
                                                        placeholder="Contoh: https://domain-anda.com/callback"
                                                        @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) readonly @endif />
                                                    @error('url_callback')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                    @if($merchant->status == 'pending')
                                                        <div class="form-text">
                                                            <i class="fas fa-info-circle text-warning me-1"></i>
                                                            URL untuk menerima notifikasi transaksi dari sistem
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="token_qrin">Token QRIN <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" name="token_qrin" id="token_qrin"
                                                            class="form-control @error('token_qrin') is-invalid @enderror"
                                                            value="{{ isset($merchant) ? $merchant->token_qrin : old('token_qrin') }}"
                                                            placeholder="Token QRIS" required readonly />
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="generateTokenQrin()"
                                                            @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) disabled @endif>
                                                            <i class="fas fa-key"></i> Generate
                                                        </button>
                                                    </div>
                                                    @error('token_qrin')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                    @if($merchant->status == 'pending')
                                                        <div class="form-text">
                                                            <i class="fas fa-info-circle text-warning me-1"></i>
                                                            Klik Generate untuk membuat Token QRIS baru
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. Informasi Bank Penarikan -->
                                    <div class="col-12 mb-4">
                                        <h5 class="mb-3 border-bottom pb-2">Informasi Bank Penarikan</h5>
                                        @if($merchant->status == 'pending')
                                            <div class="alert alert-info mb-3">
                                                <i class="fas fa-university me-2"></i>
                                                <strong>Perhatian:</strong> Pastikan data rekening bank sesuai dengan nama di KTP.
                                                Penarikan dana hanya dapat dilakukan ke rekening ini.
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="bank-id">Bank <span class="text-danger">*</span></label>
                                                    <select class="form-select @error('bank_id') is-invalid @enderror"
                                                        name="bank_id" id="bank-id" class="form-control"
                                                        @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) disabled @endif>
                                                        <option value="" selected disabled>-- Pilih Bank --</option>
                                                        @foreach ($banks as $bank)
                                                            <option value="{{ $bank?->id }}"
                                                                {{ isset($merchant) && $merchant?->bank_id == $bank?->id ? 'selected' : (old('bank_id') == $bank?->id ? 'selected' : '') }}>
                                                                {{ $bank?->nama_bank }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('bank_id')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="pemilik-rekening">Pemilik Rekening <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="pemilik_rekening" id="pemilik-rekening"
                                                        class="form-control @error('pemilik_rekening') is-invalid @enderror"
                                                        value="{{ isset($merchant) ? $merchant->pemilik_rekening : old('pemilik_rekening') }}"
                                                        placeholder="Nama pemilik rekening sesuai KTP"
                                                        @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) readonly @endif />
                                                    @error('pemilik_rekening')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                    <div class="form-text text-warning">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Pemilik Rekening harus sama dengan nama di KTP atau pengajuan anda
                                                        akan ditolak.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="nomor-rekening">Nomor Rekening <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="nomor_rekening" id="nomor-rekening"
                                                        class="form-control @error('nomor_rekening') is-invalid @enderror"
                                                        value="{{ isset($merchant) ? $merchant->nomor_rekening : old('nomor_rekening') }}"
                                                        placeholder="Nomor rekening bank"
                                                        @if(in_array($merchant->status, ['approved', 'rejected', 'suspended'])) readonly @endif />
                                                    @error('nomor_rekening')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @push('js')
                                    <script>
                                        function generateTokenQrin() {
                                            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                                            let result = '';
                                            const length = 64;

                                            for (let i = 0; i < length; i++) {
                                                result += characters.charAt(Math.floor(Math.random() * characters.length));
                                            }

                                            document.getElementById('token_qrin').value = result;
                                        }
                                    </script>
                                @endpush

                                @if($merchant->status == 'pending')
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted">
                                                <i class="fas fa-lightbulb me-1"></i>
                                                Pastikan semua data sudah benar sebelum mengirimkan pengajuan
                                            </small>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-1"></i> Kirim Pengajuan
                                        </button>
                                    </div>
                                @else
                                    <button type="submit" class="btn btn-primary" disabled>
                                        {{ __(key: 'Update') }}
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
