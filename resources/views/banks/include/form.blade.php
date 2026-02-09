<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="nama-bank">{{ __(key: 'Nama Bank') }}</label>
            <input type="text" name="nama_bank" id="nama-bank" class="form-control @error('nama_bank') is-invalid @enderror" value="{{ isset($bank) ? $bank->nama_bank : old(key: 'nama_bank') }}" placeholder="{{ __(key: 'Nama Bank') }}" required />
            @error('nama_bank')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>