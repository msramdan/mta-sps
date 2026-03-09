<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="no_sph" class="form-label">{{ __('No. SPH') }} <span class="text-danger">*</span></label>
            <input type="text" name="no_sph" id="no_sph" class="form-control bg-light @error('no_sph') is-invalid @enderror"
                value="{{ isset($sph) ? $sph->no_sph : (old('no_sph') ?? $generatedNoSph ?? '') }}"
                readonly required tabindex="-1">
            @error('no_sph')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="kunjungan_sale_id" class="form-label">{{ __('Kunjungan (opsional)') }}</label>
            <select name="kunjungan_sale_id" id="kunjungan_sale_id" class="form-select @error('kunjungan_sale_id') is-invalid @enderror">
                <option value="">{{ __('-- Pilih --') }}</option>
                @foreach($kunjunganSales as $k)
                    <option value="{{ $k->id }}" {{ (isset($sph) ? $sph->kunjungan_sale_id : old('kunjungan_sale_id')) == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_rs }} ({{ $k->tanggal_visit?->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>
            @error('kunjungan_sale_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="tanggal_sph" class="form-label">{{ __('Tanggal SPH') }} <span class="text-danger">*</span></label>
            <input type="date" name="tanggal_sph" id="tanggal_sph" class="form-control @error('tanggal_sph') is-invalid @enderror"
                value="{{ isset($sph) ? $sph->tanggal_sph?->format('Y-m-d') : old('tanggal_sph') }}" required>
            @error('tanggal_sph')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="form-group">
            <label for="keterangan" class="form-label">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ isset($sph) ? $sph->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @if(!isset($sph))
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="file" class="form-label">{{ __('File Attachment') }} <small class="text-muted">(opsional - versi 1)</small></label>
            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror"
                accept=".pdf,.doc,.docx">
            @error('file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Format: PDF, DOC, DOCX. Maks 10MB.</div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="catatan_revisi" class="form-label">{{ __('Catatan Versi 1') }}</label>
            <input type="text" name="catatan_revisi" id="catatan_revisi" class="form-control @error('catatan_revisi') is-invalid @enderror"
                value="{{ old('catatan_revisi') }}" placeholder="Contoh: Draft awal">
            @error('catatan_revisi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @endif
</div>
