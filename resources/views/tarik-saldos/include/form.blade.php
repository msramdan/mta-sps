<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="jumlah">{{ __(key: 'Jumlah') }}</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ isset($tarikSaldo) ? $tarikSaldo->jumlah : old(key: 'jumlah') }}" placeholder="{{ __(key: 'Jumlah') }}" required />
            @error('jumlah')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="biaya">{{ __(key: 'Biaya') }}</label>
            <input type="number" name="biaya" id="biaya" class="form-control @error('biaya') is-invalid @enderror" value="{{ isset($tarikSaldo) ? $tarikSaldo->biaya : old(key: 'biaya') }}" placeholder="{{ __(key: 'Biaya') }}" required />
            @error('biaya')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="diterima">{{ __(key: 'Diterima') }}</label>
            <input type="number" name="diterima" id="diterima" class="form-control @error('diterima') is-invalid @enderror" value="{{ isset($tarikSaldo) ? $tarikSaldo->diterima : old(key: 'diterima') }}" placeholder="{{ __(key: 'Diterima') }}" required />
            @error('diterima')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="pemilik-rekening">{{ __(key: 'Pemilik Rekening') }}</label>
            <input type="text" name="pemilik_rekening" id="pemilik-rekening" class="form-control @error('pemilik_rekening') is-invalid @enderror" value="{{ isset($tarikSaldo) ? $tarikSaldo->pemilik_rekening : old(key: 'pemilik_rekening') }}" placeholder="{{ __(key: 'Pemilik Rekening') }}" required />
            @error('pemilik_rekening')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="nomor-rekening">{{ __(key: 'Nomor Rekening') }}</label>
            <input type="text" name="nomor_rekening" id="nomor-rekening" class="form-control @error('nomor_rekening') is-invalid @enderror" value="{{ isset($tarikSaldo) ? $tarikSaldo->nomor_rekening : old(key: 'nomor_rekening') }}" placeholder="{{ __(key: 'Nomor Rekening') }}" required />
            @error('nomor_rekening')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="status">{{ __(key: 'Status') }}</label>
            <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" class="form-control" required>
                <option value="" selected disabled>-- {{ __(key: 'Select status') }} --</option>
                <option value="pending" {{ isset($tarikSaldo) && $tarikSaldo->status == 'pending' ? 'selected' : (old(key: 'status') == 'pending' ? 'selected' : '') }}>pending</option>
		<option value="process" {{ isset($tarikSaldo) && $tarikSaldo->status == 'process' ? 'selected' : (old(key: 'status') == 'process' ? 'selected' : '') }}>process</option>
		<option value="success" {{ isset($tarikSaldo) && $tarikSaldo->status == 'success' ? 'selected' : (old(key: 'status') == 'success' ? 'selected' : '') }}>success</option>
		<option value="reject" {{ isset($tarikSaldo) && $tarikSaldo->status == 'reject' ? 'selected' : (old(key: 'status') == 'reject' ? 'selected' : '') }}>reject</option>
            </select>
            @error('status')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
            <div class="col-md-6 mb-3">
                <div class="row g-0">
                    <div class="col-md-5 text-center">
                        <img src="{{ $tarikSaldo?->bukti_trf ?? 'https://placehold.co/300?text=No+Image+Available' }}" alt="Bukti Trf" class="rounded img-fluid mt-1" style="object-fit: cover; width: 100%; height: 100px;" />
                    </div>
                    <div class="col-md-7">
                        <div class="form-group ms-3">
                            <label for="bukti-trf">{{ __(key: 'Bukti Trf') }}</label>
                            <input type="file" name="bukti_trf" class="form-control @error('bukti_trf') is-invalid @enderror" id="bukti-trf" required>
                            @error('bukti_trf')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                            @isset($tarikSaldo)
                                <div id="bukti-trf-help-block" class="form-text">
                                    {{ __(key: 'Leave the bukti trf blank if you don`t want to change it.') }}
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
</div>
