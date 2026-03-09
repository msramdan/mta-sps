<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">{{ __('Nama Perusahaan') }} <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="{{ __('Nama perusahaan') }}"
                value="{{ isset($company) ? $company->name : old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
