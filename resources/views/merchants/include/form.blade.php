<div class="row mb-2">
    <!-- 1. Informasi Merchant -->
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Informasi Merchant</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="nama-merchant">Nama Merchant <span class="text-danger">*</span></label>
                    <input type="text" name="nama_merchant" id="nama-merchant"
                        class="form-control @error('nama_merchant') is-invalid @enderror"
                        value="{{ isset($merchant) ? $merchant->nama_merchant : old('nama_merchant') }}"
                        placeholder="Nama Merchant" required />
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
                            <label for="logo">Logo <span class="text-danger">*</span></label>
                            <input type="file" name="logo"
                                class="form-control @error('logo') is-invalid @enderror" id="logo"
                                {{ !isset($merchant) ? 'required' : '' }}>
                            @error('logo')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                            @isset($merchant)
                                <div id="logo-help-block" class="form-text">
                                    Biarkan logo kosong jika tidak ingin mengubahnya.
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
                            <label for="ktp">File KTP <span class="text-danger">*</span></label>
                            <input type="file" name="ktp" accept="image/*,.pdf"
                                class="form-control @error('ktp') is-invalid @enderror" id="ktp"
                                {{ !isset($merchant) ? 'required' : '' }}>
                            @error('ktp')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                            @isset($merchant)
                                <div id="ktp-help-block" class="form-text">
                                    Biarkan KTP kosong jika tidak ingin mengubahnya.
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="is-active">Status Aktif <span class="text-danger">*</span></label>
                    <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="is-active"
                        class="form-control" required>
                        <option value="" selected disabled>-- Pilih Status Aktif --</option>
                        <option value="Yes"
                            {{ isset($merchant) && $merchant->is_active == 'Yes' ? 'selected' : (old('is_active') == 'Yes' ? 'selected' : '') }}>
                            Ya</option>
                        <option value="No"
                            {{ isset($merchant) && $merchant->is_active == 'No' ? 'selected' : (old('is_active') == 'No' ? 'selected' : '') }}>
                            Tidak</option>
                    </select>
                    @error('is_active')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
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
                    <label for="url-callback">URL Callback <span class="text-danger">*</span></label>
                    <input type="url" name="url_callback" id="url-callback"
                        class="form-control @error('url_callback') is-invalid @enderror"
                        value="{{ isset($merchant) ? $merchant->url_callback : old('url_callback') }}"
                        placeholder="URL Callback" required />
                    @error('url_callback')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="apikey">API Key <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="apikey" id="apikey"
                            class="form-control @error('apikey') is-invalid @enderror"
                            value="{{ isset($merchant) ? $merchant->apikey : old('apikey') }}" placeholder="API Key"
                            required readonly />
                        <button type="button" class="btn btn-outline-secondary" onclick="generateApiKey()">
                            <i class="fas fa-key"></i> Generate
                        </button>
                    </div>
                    @error('apikey')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="secretkey">Secret Key <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="secretkey" id="secretkey"
                            class="form-control @error('secretkey') is-invalid @enderror"
                            value="{{ isset($merchant) ? $merchant->secretkey : old('secretkey') }}"
                            placeholder="Secret Key" required readonly />
                        <button type="button" class="btn btn-outline-secondary" onclick="generateSecretKey()">
                            <i class="fas fa-key"></i> Generate
                        </button>
                    </div>
                    @error('secretkey')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Informasi Bank Penarikan -->
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Informasi Bank Penarikan</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="bank-id">Bank <span class="text-danger">*</span></label>
                    <select class="form-select @error('bank_id') is-invalid @enderror" name="bank_id" id="bank-id"
                        class="form-control" required>
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
                    <label for="pemilik-rekening">Pemilik Rekening <span class="text-danger">*</span></label>
                    <input type="text" name="pemilik_rekening" id="pemilik-rekening"
                        class="form-control @error('pemilik_rekening') is-invalid @enderror"
                        value="{{ isset($merchant) ? $merchant->pemilik_rekening : old('pemilik_rekening') }}"
                        placeholder="Pemilik Rekening" required />
                    @error('pemilik_rekening')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="form-text text-warning">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Pemilik Rekening harus sama dengan nama di KTP atau pengajuan anda akan ditolak.
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="nomor-rekening">Nomor Rekening <span class="text-danger">*</span></label>
                    <input type="text" name="nomor_rekening" id="nomor-rekening"
                        class="form-control @error('nomor_rekening') is-invalid @enderror"
                        value="{{ isset($merchant) ? $merchant->nomor_rekening : old('nomor_rekening') }}"
                        placeholder="Nomor Rekening" required />
                    @error('nomor_rekening')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Catatan (Opsional) -->
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Catatan</h5>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <textarea name="catatan" id="catatan" rows="4"
                        class="form-control @error('catatan') is-invalid @enderror"
                        placeholder="Masukkan catatan tambahan (opsional)">{{ isset($merchant) ? $merchant->catatan : old('catatan') }}</textarea>
                    @error('catatan')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="form-text">
                        Catatan ini bersifat opsional, dapat digunakan untuk mencatat informasi tambahan tentang merchant.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        function generateApiKey() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const length = 32;

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            document.getElementById('apikey').value = result;
        }

        function generateSecretKey() {
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let result = '';
            const length = 64;

            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }

            document.getElementById('secretkey').value = result;
        }

        // Generate both keys with one button if needed
        function generateBothKeys() {
            generateApiKey();
            generateSecretKey();
        }
    </script>
@endpush
