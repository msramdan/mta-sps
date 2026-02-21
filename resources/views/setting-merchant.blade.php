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

                            @php
                                $readonly = in_array($merchant->status, ['approved', 'rejected', 'suspended']);
                            @endphp
                            <form action="{{ route('setting-merchant.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ $merchant->status }}" />

                                <style>
                                    .form-section { margin-bottom: 1.25rem; }
                                    .form-section-title { font-size: 1rem; font-weight: 600; border-bottom: 1px solid var(--bs-border-color); padding-bottom: 0.5rem; margin-bottom: 0.75rem; }
                                    .doc-preview { width: 100%; max-width: 100px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6; cursor: pointer; transition: opacity 0.2s; }
                                    .doc-preview:hover { opacity: 0.85; }
                                </style>

                                <!-- 1. Informasi Merchant -->
                                <div class="col-12 form-section">
                                    <h5 class="form-section-title"><i class="ti ti-building-store me-1"></i> Informasi Merchant</h5>
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <label for="nama-merchant" class="form-label">Nama Merchant <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_merchant" id="nama-merchant" class="form-control form-control-sm @error('nama_merchant') is-invalid @enderror"
                                                value="{{ $merchant->nama_merchant ?? old('nama_merchant') }}" placeholder="Nama Merchant" required {{ $readonly ? 'readonly' : '' }} />
                                            @error('nama_merchant') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="logo" class="form-label">Logo @if(!$merchant->logo)<span class="text-danger">*</span>@endif</label>
                                            <div class="d-flex align-items-start gap-2">
                                                <img src="{{ $merchant->logo ?? 'https://placehold.co/100x70?text=Logo' }}" alt="Logo" class="doc-preview flex-shrink-0" id="logo-preview" role="button" tabindex="0" data-preview-title="Logo" data-fallback="https://placehold.co/100x70?text=Logo" />
                                                <div class="flex-grow-1">
                                                    <input type="file" name="logo" id="logo" class="form-control form-control-sm @error('logo') is-invalid @enderror" accept=".jpg,.jpeg,.png" @if(!$merchant->logo && !$readonly) required @endif {{ $readonly ? 'disabled' : '' }} />
                                                    @error('logo') <span class="text-danger small">{{ $message }}</span> @enderror
                                                    @if($merchant->logo)<small class="form-text text-muted">Kosongkan jika tidak ubah.</small>@endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 2. Dokumen Merchant -->
                                <div class="col-12 form-section">
                                    <h5 class="form-section-title"><i class="ti ti-files me-1"></i> Dokumen Merchant</h5>
                                    <small class="text-muted d-block mb-2">Maks. 1 MB, format JPG/JPEG/PNG</small>
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">KTP @if(!$merchant->ktp)<span class="text-danger">*</span>@endif</label>
                                            <img src="{{ $merchant->ktp ? $merchant->ktp : 'https://placehold.co/100x70?text=KTP' }}" alt="KTP" class="doc-preview d-block mb-1" id="ktp-preview" role="button" tabindex="0" data-preview-title="KTP" data-fallback="https://placehold.co/100x70?text=KTP" />
                                            <input type="file" name="ktp" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('ktp') is-invalid @enderror" @if(!$merchant->ktp && !$readonly) required @endif {{ $readonly ? 'disabled' : '' }} />
                                            @error('ktp') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">KTP Lembar Verifikasi @if(!$merchant->ktp_lembar_verifikasi)<span class="text-danger">*</span>@endif</label>
                                            <img src="{{ $merchant->ktp_lembar_verifikasi ? $merchant->ktp_lembar_verifikasi : 'https://placehold.co/100x70?text=Verifikasi' }}" alt="KTP Verifikasi" class="doc-preview d-block mb-1" id="ktp-lembar-preview" role="button" tabindex="0" data-preview-title="KTP Lembar Verifikasi" data-fallback="https://placehold.co/100x70?text=Verifikasi" />
                                            <input type="file" name="ktp_lembar_verifikasi" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('ktp_lembar_verifikasi') is-invalid @enderror" @if(!$merchant->ktp_lembar_verifikasi && !$readonly) required @endif {{ $readonly ? 'disabled' : '' }} />
                                            @error('ktp_lembar_verifikasi') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">KTP + Photo Selfie @if(!$merchant->ktp_photo_selfie)<span class="text-danger">*</span>@endif</label>
                                            <img src="{{ $merchant->ktp_photo_selfie ? $merchant->ktp_photo_selfie : 'https://placehold.co/100x70?text=Selfie' }}" alt="Selfie" class="doc-preview d-block mb-1" id="ktp-selfie-preview" role="button" tabindex="0" data-preview-title="KTP + Photo Selfie" data-fallback="https://placehold.co/100x70?text=Selfie" />
                                            <input type="file" name="ktp_photo_selfie" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('ktp_photo_selfie') is-invalid @enderror" @if(!$merchant->ktp_photo_selfie && !$readonly) required @endif {{ $readonly ? 'disabled' : '' }} />
                                            @error('ktp_photo_selfie') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <label class="form-label">Photo Toko/Rumah Tampak Depan @if(!$merchant->photo_toko_tampak_depan)<span class="text-danger">*</span>@endif</label>
                                            <img src="{{ $merchant->photo_toko_tampak_depan ? $merchant->photo_toko_tampak_depan : 'https://placehold.co/100x70?text=Toko' }}" alt="Toko" class="doc-preview d-block mb-1" id="toko-preview" role="button" tabindex="0" data-preview-title="Photo Toko/Rumah Tampak Depan" data-fallback="https://placehold.co/100x70?text=Toko" />
                                            <input type="file" name="photo_toko_tampak_depan" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('photo_toko_tampak_depan') is-invalid @enderror" @if(!$merchant->photo_toko_tampak_depan && !$readonly) required @endif {{ $readonly ? 'disabled' : '' }} />
                                            @error('photo_toko_tampak_depan') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- 3. Beban Biaya & Kredensial API -->
                                <div class="col-12 form-section">
                                    <h5 class="form-section-title"><i class="ti ti-currency-dollar me-1"></i> Beban Biaya & Kredensial API</h5>
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <label for="beban-biaya" class="form-label">Beban Biaya <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-sm @error('beban_biaya') is-invalid @enderror" name="beban_biaya" id="beban-biaya" required {{ $readonly ? 'disabled' : '' }}>
                                                <option value="Merchant" {{ ($merchant->beban_biaya ?? old('beban_biaya')) === 'Merchant' ? 'selected' : '' }}>Merchant</option>
                                                <option value="Pelanggan" {{ ($merchant->beban_biaya ?? old('beban_biaya')) === 'Pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                                            </select>
                                            @error('beban_biaya') <span class="text-danger small">{{ $message }}</span> @enderror
                                            <small class="form-text text-muted">Merchant = biaya ditanggung merchant; Pelanggan = ditanggung pelanggan.</small>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="url-callback" class="form-label">URL Callback <span class="text-danger">*</span></label>
                                            <input type="url" name="url_callback" id="url-callback" class="form-control form-control-sm @error('url_callback') is-invalid @enderror"
                                                value="{{ $merchant->url_callback ?? old('url_callback') }}" placeholder="https://..." required {{ $readonly ? 'readonly' : '' }} />
                                            @error('url_callback') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="token_qrin" class="form-label">Token QRIN <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="token_qrin" id="token_qrin" class="form-control" value="{{ $merchant->token_qrin ?? old('token_qrin') }}" required minlength="1" readonly
                                                title="Klik tombol Generate untuk membuat Token QRIN" />
                                                <button type="button" class="btn btn-outline-secondary" onclick="generateTokenQrin()" {{ $readonly ? 'disabled' : '' }}><i class="ti ti-key"></i></button>
                                            </div>
                                            @error('token_qrin') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Informasi Bank Penarikan -->
                                <div class="col-12 form-section">
                                    <h5 class="form-section-title"><i class="ti ti-building-bank me-1"></i> Informasi Bank Penarikan</h5>
                                    @if($merchant->status == 'pending')
                                        <div class="alert alert-info py-2 px-3 small mb-2">
                                            <i class="ti ti-info-circle me-1"></i> Pastikan data rekening sesuai nama di KTP.
                                        </div>
                                    @endif
                                    <div class="row g-2">
                                        <div class="col-12 col-md-6">
                                            <label for="bank-id" class="form-label">Bank <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-sm @error('bank_id') is-invalid @enderror" name="bank_id" id="bank-id" required {{ $readonly ? 'disabled' : '' }}>
                                                <option value="" disabled>-- Pilih Bank --</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}" {{ ($merchant->bank_id == $bank->id || old('bank_id') == $bank->id) ? 'selected' : '' }}>{{ $bank->nama_bank }}</option>
                                                @endforeach
                                            </select>
                                            @error('bank_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="pemilik-rekening" class="form-label">Pemilik Rekening <span class="text-danger">*</span></label>
                                            <input type="text" name="pemilik_rekening" id="pemilik-rekening" class="form-control form-control-sm @error('pemilik_rekening') is-invalid @enderror"
                                                value="{{ $merchant->pemilik_rekening ?? old('pemilik_rekening') }}" placeholder="Sesuai KTP" required {{ $readonly ? 'readonly' : '' }} />
                                            @error('pemilik_rekening') <span class="text-danger small">{{ $message }}</span> @enderror
                                            <small class="form-text text-warning"><i class="ti ti-alert-triangle me-1"></i>Harus sama dengan nama di KTP.</small>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="nomor-rekening" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                                            <input type="text" name="nomor_rekening" id="nomor-rekening" class="form-control form-control-sm @error('nomor_rekening') is-invalid @enderror"
                                                value="{{ $merchant->nomor_rekening ?? old('nomor_rekening') }}" placeholder="Nomor rekening" required {{ $readonly ? 'readonly' : '' }} />
                                            @error('nomor_rekening') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="docPreviewModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header py-2">
                                                <h5 class="modal-title" id="docPreviewModalLabel"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0 text-center bg-dark">
                                                <img id="docPreviewImg" src="" alt="" class="img-fluid" style="max-height: 80vh; object-fit: contain;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @push('js')
                                <script>
                                function generateTokenQrin() {
                                    var c = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', r = '';
                                    for (var i = 0; i < 64; i++) r += c.charAt(Math.floor(Math.random() * c.length));
                                    document.getElementById('token_qrin').value = r;
                                }
                                var ALLOWED_TYPES = ['image/jpeg', 'image/jpg', 'image/png'];
                                var MAX_SIZE_MB = 1;
                                function validateBerkas(file) {
                                    if (!file) return null;
                                    if (!ALLOWED_TYPES.includes(file.type)) { alert('Format berkas harus JPG, JPEG, atau PNG.'); return false; }
                                    if (file.size > MAX_SIZE_MB * 1024 * 1024) { alert('Ukuran berkas maksimal ' + MAX_SIZE_MB + ' MB.'); return false; }
                                    return true;
                                }
                                function previewImg(input, imgId) {
                                    if (!input.files || !input.files[0]) return;
                                    if (!validateBerkas(input.files[0])) { input.value = ''; var el = document.getElementById(imgId); if (el && el.dataset.fallback) el.src = el.dataset.fallback; return; }
                                    var r = new FileReader();
                                    r.onload = function() { document.getElementById(imgId).src = r.result; };
                                    r.readAsDataURL(input.files[0]);
                                }
                                document.getElementById('logo')?.addEventListener('change', function() { previewImg(this, 'logo-preview'); });
                                document.querySelector('input[name="ktp"]')?.addEventListener('change', function() { previewImg(this, 'ktp-preview'); });
                                document.querySelector('input[name="ktp_lembar_verifikasi"]')?.addEventListener('change', function() { previewImg(this, 'ktp-lembar-preview'); });
                                document.querySelector('input[name="ktp_photo_selfie"]')?.addEventListener('change', function() { previewImg(this, 'ktp-selfie-preview'); });
                                document.querySelector('input[name="photo_toko_tampak_depan"]')?.addEventListener('change', function() { previewImg(this, 'toko-preview'); });
                                document.getElementById('token_qrin')?.closest('form')?.addEventListener('submit', function(e) {
                                    var t = document.getElementById('token_qrin');
                                    if (t && !t.value.trim()) { e.preventDefault(); alert('Klik tombol Generate untuk membuat Token QRIN terlebih dahulu.'); t.focus(); return false; }
                                });
                                document.querySelectorAll('.doc-preview[data-preview-title]').forEach(function(el) {
                                    el.addEventListener('click', function() {
                                        var src = this.src || this.currentSrc;
                                        if (src && src.indexOf('placehold.co') === -1) {
                                            document.getElementById('docPreviewModalLabel').textContent = this.getAttribute('data-preview-title') || 'Preview';
                                            document.getElementById('docPreviewImg').src = src;
                                            document.getElementById('docPreviewImg').alt = this.getAttribute('data-preview-title') || '';
                                            new bootstrap.Modal(document.getElementById('docPreviewModal')).show();
                                        }
                                    });
                                });
                                document.querySelectorAll('.doc-preview[data-preview-title]').forEach(function(el) {
                                    el.addEventListener('keydown', function(e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); } });
                                });
                                </script>
                                @endpush

                                @if($merchant->status == 'pending')
                                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-stretch align-items-sm-center gap-2 mt-3">
                                        <small class="text-muted"><i class="ti ti-bulb me-1"></i>Pastikan semua data benar sebelum kirim.</small>
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="ti ti-send me-1"></i> Kirim Pengajuan</button>
                                    </div>
                                @else
                                    <button type="submit" class="btn btn-primary btn-sm mt-3" disabled>{{ __(key: 'Update') }}</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
