<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="nama">{{ __(key: 'Nama') }}</label>
            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ isset($produk) ? $produk->nama : old(key: 'nama') }}" placeholder="{{ __(key: 'Nama') }}" required />
            @error('nama')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>