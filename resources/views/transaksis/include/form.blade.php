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

    <!-- Informasi Pembayaran: Total fee = 0,7% + Rp 500 (Nobu + QRIN) -->
    @php
        $bebanBiayaForm = old('beban_biaya', isset($transaksi) ? ($transaksi->beban_biaya ?? 'Merchant') : 'Merchant');
        $displayLainLabel = $bebanBiayaForm === 'Pelanggan' ? 'Jumlah Dibayar (Pelanggan Bayar)' : 'Jumlah Diterima';
        $displayLainValue = isset($transaksi)
            ? ($bebanBiayaForm === 'Pelanggan' ? number_format($transaksi->jumlah_dibayar ?? 0, 0, ',', '.') : number_format($transaksi->jumlah_diterima ?? 0, 0, ',', '.'))
            : '0';
    @endphp
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">Informasi Pembayaran</h5>
        <div class="form-text mb-3">Ketentuan: Nobu 0,7% + QRIN Rp 500. Charge to Merchant = total bayar dikurangi biaya. Charge to Pelanggan = merchant terima bersih, pelanggan bayar dihitung otomatis.</div>
        <div class="row">
            <div class="col-md-6 mb-3" id="wrap_input_dibayar" style="{{ $bebanBiayaForm === 'Pelanggan' ? 'display: none;' : '' }}">
                <div class="form-group">
                    <label for="jumlah_dibayar">Jumlah Dibayar (Pelanggan Bayar) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="jumlah_dibayar" id="jumlah_dibayar"
                            class="form-control @error('jumlah_dibayar') is-invalid @enderror"
                            value="{{ isset($transaksi) ? $transaksi->jumlah_dibayar : old('jumlah_dibayar') }}"
                            placeholder="0" min="0" step="0.01" />
                    </div>
                    @error('jumlah_dibayar')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div class="form-text small">Charge to Merchant: isi nominal yang dibayar pelanggan</div>
                </div>
            </div>

            <div class="col-md-6 mb-3" id="wrap_input_diterima" style="{{ $bebanBiayaForm === 'Pelanggan' ? '' : 'display: none;' }}">
                <div class="form-group">
                    <label for="jumlah_diterima">Jumlah Diterima (Merchant Terima Bersih) <span class="text-danger">*</span></label>
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
                    <div class="form-text small">Charge to Pelanggan: isi nominal yang ingin diterima merchant</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="biaya_display">Biaya (0,7% + Rp 500)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="biaya_display" class="form-control bg-light" readonly
                            value="{{ isset($transaksi) ? number_format($transaksi->biaya, 0, ',', '.') : '0' }}"
                            aria-label="Biaya (otomatis)" />
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3" id="wrap_display_lain">
                <div class="form-group">
                    <label for="display_lain" id="label_display_lain">{{ $displayLainLabel }}</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="display_lain" class="form-control bg-light" readonly
                            value="{{ $displayLainValue }}"
                            aria-label="{{ $displayLainLabel }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var FEE_PERCENT = 0.007;
    var FEE_FLAT = 500;

    function round2(v) { return Math.round(v * 100) / 100; }
    /** Bulatkan ke atas ke rupiah penuh (Charge to Pelanggan). */
    function ceilRupiah(v) { return Math.ceil(v); }

    function updateDisplay() {
        var bebanBiaya = document.getElementById('beban_biaya').value;
        var biaya, jumlahDibayar, jumlahDiterima;
        var biayaDisplay = document.getElementById('biaya_display');
        var displayLain = document.getElementById('display_lain');

        if (bebanBiaya === 'Merchant') {
            jumlahDibayar = parseFloat(document.getElementById('jumlah_dibayar').value) || 0;
            biaya = round2(jumlahDibayar * FEE_PERCENT + FEE_FLAT);
            jumlahDiterima = round2(jumlahDibayar - biaya);
            if (jumlahDiterima < 0) jumlahDiterima = 0;
            document.getElementById('label_display_lain').textContent = 'Jumlah Diterima';
            var fmt = new Intl.NumberFormat('id-ID');
            biayaDisplay.value = fmt.format(biaya);
            displayLain.value = fmt.format(jumlahDiterima);
        } else {
            jumlahDiterima = parseFloat(document.getElementById('jumlah_diterima').value) || 0;
            document.getElementById('label_display_lain').textContent = 'Jumlah Dibayar (Pelanggan Bayar)';
            if (!jumlahDiterima || jumlahDiterima <= 0) {
                biayaDisplay.value = '';
                displayLain.value = '';
            } else {
                jumlahDibayar = ceilRupiah((jumlahDiterima + FEE_FLAT) / (1 - FEE_PERCENT));
                biaya = round2(jumlahDibayar * FEE_PERCENT + FEE_FLAT);
                var fmt = new Intl.NumberFormat('id-ID');
                biayaDisplay.value = fmt.format(biaya);
                displayLain.value = fmt.format(jumlahDibayar);
            }
        }
    }

    function toggleInput() {
        var bebanBiaya = document.getElementById('beban_biaya').value;
        var wrapDibayar = document.getElementById('wrap_input_dibayar');
        var wrapDiterima = document.getElementById('wrap_input_diterima');
        var inputDibayar = document.getElementById('jumlah_dibayar');
        var inputDiterima = document.getElementById('jumlah_diterima');

        if (bebanBiaya === 'Merchant') {
            wrapDibayar.style.display = '';
            wrapDiterima.style.display = 'none';
            inputDibayar.removeAttribute('disabled');
            inputDibayar.setAttribute('required', 'required');
            inputDiterima.setAttribute('disabled', 'disabled');
            inputDiterima.removeAttribute('required');
        } else {
            wrapDibayar.style.display = 'none';
            wrapDiterima.style.display = '';
            inputDibayar.setAttribute('disabled', 'disabled');
            inputDibayar.removeAttribute('required');
            inputDiterima.removeAttribute('disabled');
            inputDiterima.setAttribute('required', 'required');
        }
        updateDisplay();
    }

    var sel = document.getElementById('beban_biaya');
    var inputDibayar = document.getElementById('jumlah_dibayar');
    var inputDiterima = document.getElementById('jumlah_diterima');
    if (sel) {
        sel.addEventListener('change', toggleInput);
        inputDibayar.addEventListener('input', updateDisplay);
        inputDiterima.addEventListener('input', updateDisplay);
        toggleInput();
    }
})();
</script>
@endpush
