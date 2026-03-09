<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="sph_id" class="form-label">{{ __('SPH') }} <span class="text-danger">*</span></label>
            <select name="sph_id" id="sph_id" class="form-select @error('sph_id') is-invalid @enderror" required>
                <option value="">{{ __('-- Pilih SPH --') }}</option>
                @foreach($sphList as $s)
                    <option value="{{ $s->id }}" {{ (isset($spk) ? $spk->sph_id : old('sph_id')) == $s->id ? 'selected' : '' }}>
                        {{ $s->no_sph }} ({{ $s->tanggal_sph?->format('d/m/Y') }})
                    </option>
                @endforeach
            </select>
            <div class="form-text">SPK/PO mengacu pada SPH yang dipilih.</div>
            @error('sph_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="no_spk" class="form-label">{{ __('No. SPK/PO') }} <span class="text-danger">*</span></label>
            <input type="text" name="no_spk" id="no_spk" class="form-control bg-light @error('no_spk') is-invalid @enderror"
                value="{{ isset($spk) ? $spk->no_spk : (old('no_spk') ?? $generatedNoSpk ?? '') }}"
                readonly required tabindex="-1">
            @error('no_spk')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="nilai_kontrak" class="form-label">{{ __('Nilai Kontrak') }} <span class="text-danger">*</span></label>
            <input type="number" name="nilai_kontrak" id="nilai_kontrak" step="0.01" min="0"
                class="form-control @error('nilai_kontrak') is-invalid @enderror"
                value="{{ isset($spk) ? $spk->nilai_kontrak : old('nilai_kontrak', '0') }}" required>
            @error('nilai_kontrak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label class="form-label">{{ __('Include PPN') }}</label>
            <div class="form-check form-switch mt-2">
                <input type="checkbox" name="include_ppn" id="include_ppn" value="1" class="form-check-input"
                    {{ (isset($spk) ? $spk->include_ppn : old('include_ppn')) ? 'checked' : '' }}>
                <label for="include_ppn" class="form-check-label">Nilai kontrak sudah termasuk PPN</label>
            </div>
            @error('include_ppn')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="jumlah_alat" class="form-label">{{ __('Jumlah Alat') }} <span class="text-danger">*</span></label>
            <input type="number" name="jumlah_alat" id="jumlah_alat" min="0"
                class="form-control @error('jumlah_alat') is-invalid @enderror"
                value="{{ isset($spk) ? $spk->jumlah_alat : old('jumlah_alat', '0') }}" required>
            @error('jumlah_alat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="tanggal_spk" class="form-label">{{ __('Tanggal SPK') }} <span class="text-danger">*</span></label>
            <input type="date" name="tanggal_spk" id="tanggal_spk"
                class="form-control @error('tanggal_spk') is-invalid @enderror"
                value="{{ isset($spk) ? $spk->tanggal_spk?->format('Y-m-d') : old('tanggal_spk') }}" required>
            @error('tanggal_spk')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="tanggal_deadline" class="form-label">{{ __('Tanggal Deadline') }}</label>
            <input type="date" name="tanggal_deadline" id="tanggal_deadline"
                class="form-control @error('tanggal_deadline') is-invalid @enderror"
                value="{{ isset($spk) ? $spk->tanggal_deadline?->format('Y-m-d') : old('tanggal_deadline') }}">
            @error('tanggal_deadline')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="form-group">
            <label for="keterangan" class="form-label">{{ __('Keterangan') }}</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                class="form-control @error('keterangan') is-invalid @enderror">{{ isset($spk) ? $spk->keterangan : old('keterangan') }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
