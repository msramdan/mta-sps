<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="nama-merchant">{{ __(key: 'Nama Merchant') }}</label>
            <input type="text" name="nama_merchant" id="nama-merchant" class="form-control @error('nama_merchant') is-invalid @enderror" value="{{ isset($merchant) ? $merchant->nama_merchant : old(key: 'nama_merchant') }}" placeholder="{{ __(key: 'Nama Merchant') }}" required />
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
                        <img src="{{ $merchant?->logo ?? 'https://placehold.co/300?text=No+Image+Available' }}" alt="Logo" class="rounded img-fluid mt-1" style="object-fit: cover; width: 100%; height: 100px;" />
                    </div>
                    <div class="col-md-7">
                        <div class="form-group ms-3">
                            <label for="logo">{{ __(key: 'Logo') }}</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" id="logo" required>
                            @error('logo')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                            @isset($merchant)
                                <div id="logo-help-block" class="form-text">
                                    {{ __(key: 'Leave the logo blank if you don`t want to change it.') }}
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="url-callback">{{ __(key: 'Url Callback') }}</label>
            <input type="url" name="url_callback" id="url-callback" class="form-control @error('url_callback') is-invalid @enderror" value="{{ isset($merchant) ? $merchant->url_callback : old(key: 'url_callback') }}" placeholder="{{ __(key: 'Url Callback') }}" required />
            @error('url_callback')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="apikey">{{ __(key: 'Apikey') }}</label>
            <input type="text" name="apikey" id="apikey" class="form-control @error('apikey') is-invalid @enderror" value="{{ isset($merchant) ? $merchant->apikey : old(key: 'apikey') }}" placeholder="{{ __(key: 'Apikey') }}" required />
            @error('apikey')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="secretkey">{{ __(key: 'Secretkey') }}</label>
            <input type="text" name="secretkey" id="secretkey" class="form-control @error('secretkey') is-invalid @enderror" value="{{ isset($merchant) ? $merchant->secretkey : old(key: 'secretkey') }}" placeholder="{{ __(key: 'Secretkey') }}" required />
            @error('secretkey')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="bank-id">{{ __(key: 'Bank') }}</label>
            <select class="form-select @error('bank_id') is-invalid @enderror" name="bank_id" id="bank-id" class="form-control" required>
                <option value="" selected disabled>-- {{ __(key: 'Select bank') }} --</option>
                
                        @foreach ($banks as $bank)
                            <option value="{{ $bank?->id }}" {{ isset($merchant) && $merchant?->bank_id == $bank?->id ? 'selected' : (old(key: 'bank_id') == $bank?->id ? 'selected' : '') }}>
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
            <label for="pemilik-rekening">{{ __(key: 'Pemilik Rekening') }}</label>
            <input type="text" name="pemilik_rekening" id="pemilik-rekening" class="form-control @error('pemilik_rekening') is-invalid @enderror" value="{{ isset($merchant) ? $merchant->pemilik_rekening : old(key: 'pemilik_rekening') }}" placeholder="{{ __(key: 'Pemilik Rekening') }}" required />
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
            <input type="text" name="nomor_rekening" id="nomor-rekening" class="form-control @error('nomor_rekening') is-invalid @enderror" value="{{ isset($merchant) ? $merchant->nomor_rekening : old(key: 'nomor_rekening') }}" placeholder="{{ __(key: 'Nomor Rekening') }}" required />
            @error('nomor_rekening')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="is-active">{{ __(key: 'Is Active') }}</label>
            <select class="form-select @error('is_active') is-invalid @enderror" name="is_active" id="is-active" class="form-control" required>
                <option value="" selected disabled>-- {{ __(key: 'Select is active') }} --</option>
                <option value="Yes" {{ isset($merchant) && $merchant->is_active == 'Yes' ? 'selected' : (old(key: 'is_active') == 'Yes' ? 'selected' : '') }}>Yes</option>
		<option value="No" {{ isset($merchant) && $merchant->is_active == 'No' ? 'selected' : (old(key: 'is_active') == 'No' ? 'selected' : '') }}>No</option>			
            </select>
            @error('is_active')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>