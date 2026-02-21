<style>
    .form-section { margin-bottom: 1.25rem; }
    .form-section-title { font-size: 1rem; font-weight: 600; border-bottom: 1px solid var(--bs-border-color); padding-bottom: 0.5rem; margin-bottom: 0.75rem; }
    .doc-preview { width: 100%; max-width: 120px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6; cursor: pointer; transition: opacity 0.2s; }
    .doc-preview:hover { opacity: 0.85; }
    @media (max-width: 576px) {
        .form-section-title { font-size: 0.95rem; }
        .doc-preview { max-width: 100px; height: 70px; }
    }
</style>
<div class="row mb-2">
    <!-- 1. Informasi Merchant -->
    <div class="col-12 form-section">
        <h5 class="form-section-title"><i class="ti ti-building-store me-1"></i> Informasi Merchant</h5>
        <div class="row g-2">
            <div class="col-12 col-md-6">
                <label for="nama-merchant" class="form-label">Nama Merchant <span class="text-danger">*</span></label>
                <input type="text" name="nama_merchant" id="nama-merchant" class="form-control form-control-sm @error('nama_merchant') is-invalid @enderror"
                    value="{{ isset($merchant) ? $merchant->nama_merchant : old('nama_merchant') }}" placeholder="Nama Merchant" required />
                @error('nama_merchant') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="logo" class="form-label">Logo <span class="text-danger">*</span></label>
                <div class="d-flex align-items-start gap-2">
                    <img src="{{ $merchant?->logo ?? 'https://placehold.co/120x80?text=Logo' }}" alt="Logo" class="doc-preview flex-shrink-0" id="logo-preview" role="button" tabindex="0" data-preview-title="Logo" data-fallback="https://placehold.co/120x80?text=Logo" />
                    <div class="flex-grow-1">
                        <input type="file" name="logo" id="logo" class="form-control form-control-sm @error('logo') is-invalid @enderror" accept=".jpg,.jpeg,.png" {{ !isset($merchant) ? 'required' : '' }} />
                        @error('logo') <span class="text-danger small">{{ $message }}</span> @enderror
                        @isset($merchant) <small class="form-text text-muted">Kosongkan jika tidak ubah.</small> @endisset
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm @error('status') is-invalid @enderror" name="status" id="status" required>
                    <option value="">-- Pilih --</option>
                    <option value="pending" {{ (isset($merchant) ? $merchant->status : old('status')) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ (isset($merchant) ? $merchant->status : old('status')) === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ (isset($merchant) ? $merchant->status : old('status')) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="suspended" {{ (isset($merchant) ? $merchant->status : old('status')) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
                @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <!-- 2. Dokumen Merchant -->
    <div class="col-12 form-section">
        <h5 class="form-section-title"><i class="ti ti-files me-1"></i> Dokumen Merchant</h5>
        <small class="text-muted d-block mb-2">Maks. 1 MB, format JPG/JPEG/PNG</small>
        <div class="row g-2">
            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label">KTP <span class="text-danger">*</span></label>
                <div class="d-flex flex-column gap-1">
                    <img src="{{ isset($merchant) && $merchant->ktp ? $merchant->ktp : 'https://placehold.co/120x80?text=KTP' }}" alt="KTP" class="doc-preview align-self-start" id="ktp-preview" role="button" tabindex="0" data-preview-title="KTP" data-fallback="https://placehold.co/120x80?text=KTP" />
                    <input type="file" name="ktp" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('ktp') is-invalid @enderror" {{ !isset($merchant) ? 'required' : '' }} />
                    @error('ktp') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label">KTP Lembar Verifikasi</label>
                <div class="d-flex flex-column gap-1">
                    <img src="{{ isset($merchant) && $merchant->ktp_lembar_verifikasi ? $merchant->ktp_lembar_verifikasi : 'https://placehold.co/120x80?text=KTP+Verifikasi' }}" alt="KTP Verifikasi" class="doc-preview align-self-start" id="ktp-lembar-preview" role="button" tabindex="0" data-preview-title="KTP Lembar Verifikasi" data-fallback="https://placehold.co/120x80?text=KTP+Verifikasi" />
                    <input type="file" name="ktp_lembar_verifikasi" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('ktp_lembar_verifikasi') is-invalid @enderror" />
                    @error('ktp_lembar_verifikasi') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label">KTP + Photo Selfie</label>
                <div class="d-flex flex-column gap-1">
                    <img src="{{ isset($merchant) && $merchant->ktp_photo_selfie ? $merchant->ktp_photo_selfie : 'https://placehold.co/120x80?text=Selfie' }}" alt="Selfie" class="doc-preview align-self-start" id="ktp-selfie-preview" role="button" tabindex="0" data-preview-title="KTP + Photo Selfie" data-fallback="https://placehold.co/120x80?text=Selfie" />
                    <input type="file" name="ktp_photo_selfie" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('ktp_photo_selfie') is-invalid @enderror" />
                    @error('ktp_photo_selfie') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <label class="form-label">Photo Toko/Rumah Tampak Depan</label>
                <div class="d-flex flex-column gap-1">
                    <img src="{{ isset($merchant) && $merchant->photo_toko_tampak_depan ? $merchant->photo_toko_tampak_depan : 'https://placehold.co/120x80?text=Toko' }}" alt="Toko" class="doc-preview align-self-start" id="toko-preview" role="button" tabindex="0" data-preview-title="Photo Toko/Rumah Tampak Depan" data-fallback="https://placehold.co/120x80?text=Toko" />
                    <input type="file" name="photo_toko_tampak_depan" accept=".jpg,.jpeg,.png" class="form-control form-control-sm @error('photo_toko_tampak_depan') is-invalid @enderror" />
                    @error('photo_toko_tampak_depan') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Beban Biaya & Kredensial API -->
    <div class="col-12 form-section">
        <h5 class="form-section-title"><i class="ti ti-currency-dollar me-1"></i> Beban Biaya & Kredensial API</h5>
        <div class="row g-2">
            <div class="col-12 col-md-6">
                <label for="beban-biaya" class="form-label">Beban Biaya <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm @error('beban_biaya') is-invalid @enderror" name="beban_biaya" id="beban-biaya" required>
                    @php $bebanBiaya = old('beban_biaya', isset($merchant) ? ($merchant->beban_biaya ?? 'Merchant') : 'Merchant'); @endphp
                    <option value="Merchant" {{ $bebanBiaya === 'Merchant' ? 'selected' : '' }}>Merchant</option>
                    <option value="Pelanggan" {{ $bebanBiaya === 'Pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                </select>
                @error('beban_biaya') <span class="text-danger small">{{ $message }}</span> @enderror
                <small class="form-text text-muted">Merchant = biaya ditanggung merchant; Pelanggan = ditanggung pelanggan.</small>
            </div>
            <div class="col-12 col-md-6">
                <label for="url-callback" class="form-label">URL Callback <span class="text-danger">*</span></label>
                <input type="url" name="url_callback" id="url-callback" class="form-control form-control-sm @error('url_callback') is-invalid @enderror"
                    value="{{ isset($merchant) ? $merchant->url_callback : old('url_callback') }}" placeholder="https://..." required />
                @error('url_callback') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="token_qrin" class="form-label">Token QRIN <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm">
                    <input type="text" name="token_qrin" id="token_qrin" class="form-control @error('token_qrin') is-invalid @enderror"
                        value="{{ isset($merchant) ? $merchant->token_qrin : old('token_qrin') }}" placeholder="Token" required minlength="1"
                        title="Klik tombol Generate untuk membuat Token QRIN" />
                    <button type="button" class="btn btn-outline-secondary" onclick="generateTokenQrin()"><i class="ti ti-key"></i></button>
                </div>
                @error('token_qrin') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <!-- 4. Informasi Bank Penarikan -->
    <div class="col-12 form-section">
        <h5 class="form-section-title"><i class="ti ti-building-bank me-1"></i> Informasi Bank Penarikan</h5>
        <div class="row g-2">
            <div class="col-12 col-md-6">
                <label for="bank-id" class="form-label">Bank <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm @error('bank_id') is-invalid @enderror" name="bank_id" id="bank-id" required>
                    <option value="" disabled>-- Pilih Bank --</option>
                    @foreach ($banks as $bank)
                        <option value="{{ $bank?->id }}" {{ (isset($merchant) && $merchant?->bank_id == $bank?->id) || old('bank_id') == $bank?->id ? 'selected' : '' }}>{{ $bank?->nama_bank }}</option>
                    @endforeach
                </select>
                @error('bank_id') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-12 col-md-6">
                <label for="pemilik-rekening" class="form-label">Pemilik Rekening <span class="text-danger">*</span></label>
                <input type="text" name="pemilik_rekening" id="pemilik-rekening" class="form-control form-control-sm @error('pemilik_rekening') is-invalid @enderror"
                    value="{{ isset($merchant) ? $merchant->pemilik_rekening : old('pemilik_rekening') }}" placeholder="Sesuai KTP" required />
                @error('pemilik_rekening') <span class="text-danger small">{{ $message }}</span> @enderror
                <small class="form-text text-warning"><i class="ti ti-alert-triangle me-1"></i>Harus sama dengan nama di KTP.</small>
            </div>
            <div class="col-12 col-md-6">
                <label for="nomor-rekening" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
                <input type="text" name="nomor_rekening" id="nomor-rekening" class="form-control form-control-sm @error('nomor_rekening') is-invalid @enderror"
                    value="{{ isset($merchant) ? $merchant->nomor_rekening : old('nomor_rekening') }}" placeholder="Nomor rekening" required />
                @error('nomor_rekening') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-12">
                <label for="catatan" class="form-label">Catatan (opsional)</label>
                <textarea name="catatan" id="catatan" rows="2" class="form-control form-control-sm @error('catatan') is-invalid @enderror" placeholder="Catatan tambahan">{{ isset($merchant) ? $merchant->catatan : old('catatan') }}</textarea>
                @error('catatan') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
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
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let r = '';
    for (let i = 0; i < 64; i++) r += chars.charAt(Math.floor(Math.random() * chars.length));
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
    if (!validateBerkas(input.files[0])) { input.value = ''; if (imgId) document.getElementById(imgId).src = document.getElementById(imgId).dataset.fallback || ''; return; }
    const r = new FileReader();
    r.onload = function() { document.getElementById(imgId).src = r.result; };
    r.readAsDataURL(input.files[0]);
}
document.getElementById('logo')?.addEventListener('change', function() { previewImg(this, 'logo-preview'); });
document.getElementById('ktp')?.addEventListener('change', function() { previewImg(this, 'ktp-preview'); });
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
        if (src && !src.includes('placehold.co')) {
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
