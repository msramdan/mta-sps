<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="nama_rs" class="form-label">{{ __('Nama RS') }} <span class="text-danger">*</span></label>
            <input type="text" name="nama_rs" id="nama_rs" class="form-control @error('nama_rs') is-invalid @enderror"
                value="{{ isset($kunjungan_sale) ? $kunjungan_sale->nama_rs : old('nama_rs') }}" required>
            @error('nama_rs')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="pic_rs" class="form-label">{{ __('PIC RS / Contact Person') }} <span class="text-danger">*</span></label>
            <input type="text" name="pic_rs" id="pic_rs" class="form-control @error('pic_rs') is-invalid @enderror"
                value="{{ isset($kunjungan_sale) ? $kunjungan_sale->pic_rs : old('pic_rs') }}" required>
            @error('pic_rs')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="posisi_pic" class="form-label">{{ __('Jabatan PIC') }}</label>
            <input type="text" name="posisi_pic" id="posisi_pic" class="form-control @error('posisi_pic') is-invalid @enderror"
                value="{{ isset($kunjungan_sale) ? $kunjungan_sale->posisi_pic : old('posisi_pic') }}">
            @error('posisi_pic')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="no_telp_pic" class="form-label">{{ __('No. Telepon PIC') }} <span class="text-danger">*</span></label>
            <input type="text" name="no_telp_pic" id="no_telp_pic" class="form-control @error('no_telp_pic') is-invalid @enderror"
                value="{{ isset($kunjungan_sale) ? $kunjungan_sale->no_telp_pic : old('no_telp_pic') }}" required>
            @error('no_telp_pic')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="tanggal_visit" class="form-label">{{ __('Tanggal Kunjungan') }} <span class="text-danger">*</span></label>
            <input type="date" name="tanggal_visit" id="tanggal_visit" class="form-control @error('tanggal_visit') is-invalid @enderror"
                value="{{ isset($kunjungan_sale) ? $kunjungan_sale->tanggal_visit?->format('Y-m-d') : old('tanggal_visit') }}" required>
            @error('tanggal_visit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="form-group">
            <label for="keterangan" class="form-label">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ isset($kunjungan_sale) ? $kunjungan_sale->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="evidence" class="form-label">{{ __('Evidence') }} <small class="text-muted">(opsional)</small></label>
            <input type="file" name="evidence" id="evidence"
                class="form-control @error('evidence') is-invalid @enderror"
                accept="image/jpeg,image/jpg,image/png">
            @error('evidence')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Format: JPG, PNG, JPEG. Maks 5MB.</div>
            @if(isset($kunjungan_sale) && $kunjungan_sale->getRawOriginal('evidence'))
                <div class="mt-2">
                    <img src="{{ $kunjungan_sale->evidence }}" alt="Evidence" class="img-thumbnail" style="max-height: 120px;">
                    <div class="form-text">Foto saat ini. Kosongkan jika tidak ingin mengubah.</div>
                </div>
            @endif
        </div>
    </div>
</div>
