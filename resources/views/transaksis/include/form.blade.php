<div class="row">
    <!-- Informasi Transaksi -->
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Informasi Transaksi</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="tanggal_transaksi">Tanggal Transaksi</label>
                    <input type="datetime-local" name="tanggal_transaksi" id="tanggal_transaksi"
                        class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                        value="{{ isset($transaksi) ? $transaksi->tanggal_transaksi?->format('Y-m-d\TH:i') : old('tanggal_transaksi', now()->format('Y-m-d\TH:i')) }}" />
                    @error('tanggal_transaksi')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-text">Kosongkan untuk otomatis menggunakan waktu saat ini</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="no_ref_merchant">No. Referensi Merchant <span class="text-danger">*</span></label>
                    <input type="text" name="no_ref_merchant" id="no_ref_merchant"
                        class="form-control @error('no_ref_merchant') is-invalid @enderror"
                        value="{{ isset($transaksi) ? $transaksi->no_ref_merchant : old('no_ref_merchant') }}"
                        placeholder="Referensi dari sistem merchant" maxlength="100" required />
                    @error('no_ref_merchant')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="beban_biaya">Beban Biaya <span class="text-danger">*</span></label>
                    <select name="beban_biaya" id="beban_biaya" class="form-control @error('beban_biaya') is-invalid @enderror"
                        required>
                        @php $bebanBiaya = old('beban_biaya', isset($transaksi) ? ($transaksi->beban_biaya ?? 'Merchant') : 'Merchant'); @endphp
                        <option value="Merchant" {{ $bebanBiaya === 'Merchant' ? 'selected' : '' }}>Merchant</option>
                        <option value="Pelanggan" {{ $bebanBiaya === 'Pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                    </select>
                    @error('beban_biaya')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-text">Merchant = biaya ditanggung merchant; Pelanggan = ditanggung pelanggan</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                        required>
                        <option value="">Pilih Status</option>
                        <option value="pending"
                            {{ (isset($transaksi) && $transaksi->status == 'pending') || old('status') == 'pending' ? 'selected' : '' }}>
                            Pending</option>
                        <option value="success"
                            {{ (isset($transaksi) && $transaksi->status == 'success') || old('status') == 'success' ? 'selected' : '' }}>
                            Success</option>
                        <option value="failed"
                            {{ (isset($transaksi) && $transaksi->status == 'failed') || old('status') == 'failed' ? 'selected' : '' }}>
                            Failed</option>
                        <option value="expired"
                            {{ (isset($transaksi) && $transaksi->status == 'expired') || old('status') == 'expired' ? 'selected' : '' }}>
                            Expired</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Pelanggan -->
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Informasi Pelanggan</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan"
                        class="form-control @error('nama_pelanggan') is-invalid @enderror"
                        value="{{ isset($transaksi) ? $transaksi->nama_pelanggan : old('nama_pelanggan') }}"
                        placeholder="Nama lengkap pelanggan" maxlength="150" />
                    @error('nama_pelanggan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="email_pelanggan">Email Pelanggan</label>
                    <input type="email" name="email_pelanggan" id="email_pelanggan"
                        class="form-control @error('email_pelanggan') is-invalid @enderror"
                        value="{{ isset($transaksi) ? $transaksi->email_pelanggan : old('email_pelanggan') }}"
                        placeholder="email@example.com" />
                    @error('email_pelanggan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="no_telpon_pelanggan">No. Telepon Pelanggan</label>
                    <input type="text" name="no_telpon_pelanggan" id="no_telpon_pelanggan"
                        class="form-control @error('no_telpon_pelanggan') is-invalid @enderror"
                        value="{{ isset($transaksi) ? $transaksi->no_telpon_pelanggan : old('no_telpon_pelanggan') }}"
                        placeholder="08xxxxxxxxxx" maxlength="20" />
                    @error('no_telpon_pelanggan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Pembayaran -->
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Informasi Pembayaran</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="biaya">Biaya <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="biaya" id="biaya"
                            class="form-control @error('biaya') is-invalid @enderror"
                            value="{{ isset($transaksi) ? $transaksi->biaya : old('biaya') }}"
                            placeholder="0" min="0" step="0.01" required />
                    </div>
                    @error('biaya')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="jumlah_dibayar">Jumlah Dibayar <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="jumlah_dibayar" id="jumlah_dibayar"
                            class="form-control @error('jumlah_dibayar') is-invalid @enderror"
                            value="{{ isset($transaksi) ? $transaksi->jumlah_dibayar : old('jumlah_dibayar') }}"
                            placeholder="0" min="0" step="0.01" required />
                    </div>
                    @error('jumlah_dibayar')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="jumlah_diterima">Jumlah Diterima</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="jumlah_diterima" id="jumlah_diterima"
                            class="form-control @error('jumlah_diterima') is-invalid @enderror"
                            value="{{ isset($transaksi) ? $transaksi->jumlah_diterima : old('jumlah_diterima') }}"
                            placeholder="0" min="0" step="0.01" />
                    </div>
                    @error('jumlah_diterima')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Payload & Callback -->
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Payload & Callback</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="payload_generate_qr">Payload Generate QR</label>
                    <textarea name="payload_generate_qr" id="payload_generate_qr" rows="5"
                        class="form-control @error('payload_generate_qr') is-invalid @enderror"
                        placeholder="JSON payload dari generate QR">{{ isset($transaksi) ? $transaksi->payload_generate_qr : old('payload_generate_qr') }}</textarea>
                    @error('payload_generate_qr')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="callback">Callback Response</label>
                    <textarea name="callback" id="callback" rows="5"
                        class="form-control @error('callback') is-invalid @enderror"
                        placeholder="JSON response callback">{{ isset($transaksi) ? $transaksi->callback : old('callback') }}</textarea>
                    @error('callback')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="tanggal_callback">Tanggal Callback</label>
                    <input type="datetime-local" name="tanggal_callback" id="tanggal_callback"
                        class="form-control @error('tanggal_callback') is-invalid @enderror"
                        value="{{ isset($transaksi) ? $transaksi->tanggal_callback?->format('Y-m-d\TH:i') : old('tanggal_callback') }}" />
                    @error('tanggal_callback')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
