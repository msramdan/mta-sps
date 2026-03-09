@extends('layouts.app')

@section('title', __('Revisi SPH'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('SPH') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('sph.index') }}">{{ __('SPH') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('sph.show', $sph) }}">{{ $sph->no_sph }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Revisi') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-3">
                                Perbarui data SPH. Data ke riwayat revisi hanya ditambahkan jika ada <strong>upload file baru</strong> atau <strong>catatan revisi</strong>.
                            </p>
                            <form action="{{ route('sph.store-revision', $sph) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="no_sph" class="form-label">{{ __('No. SPH') }}</label>
                                            <input type="text" class="form-control bg-light" value="{{ $sph->no_sph }}" readonly tabindex="-1">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="tanggal_sph" class="form-label">{{ __('Tanggal SPH') }} <span class="text-danger">*</span></label>
                                            <input type="date" name="tanggal_sph" id="tanggal_sph" class="form-control @error('tanggal_sph') is-invalid @enderror"
                                                value="{{ old('tanggal_sph', $sph->tanggal_sph?->format('Y-m-d')) }}" required>
                                            @error('tanggal_sph')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="kunjungan_sale_id" class="form-label">{{ __('Kunjungan (opsional)') }}</label>
                                            <select name="kunjungan_sale_id" id="kunjungan_sale_id" class="form-select @error('kunjungan_sale_id') is-invalid @enderror">
                                                <option value="">{{ __('-- Pilih --') }}</option>
                                                @foreach($kunjunganSales as $k)
                                                    <option value="{{ $k->id }}" {{ old('kunjungan_sale_id', $sph->kunjungan_sale_id) == $k->id ? 'selected' : '' }}>
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
                                            <label for="file" class="form-label">{{ __('File Baru') }} <small class="text-muted">(opsional)</small></label>
                                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror"
                                                accept=".pdf,.doc,.docx">
                                            @error('file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Kosongkan jika tidak ada perubahan. Format: PDF, DOC, DOCX. Maks 10MB.</div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="form-group">
                                            <label for="keterangan" class="form-label">{{ __('Keterangan') }}</label>
                                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $sph->keterangan) }}</textarea>
                                            @error('keterangan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="catatan_revisi" class="form-label">{{ __('Catatan Revisi') }} <small class="text-muted">(opsional)</small></label>
                                            <input type="text" name="catatan_revisi" id="catatan_revisi" class="form-control @error('catatan_revisi') is-invalid @enderror"
                                                value="{{ old('catatan_revisi') }}" placeholder="Contoh: Perbaikan harga">
                                            @error('catatan_revisi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Jika diisi, akan ditambahkan ke riwayat revisi.</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('sph.show', $sph) }}" class="btn btn-secondary">{{ __('Batal') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
