@extends('layouts.app')

@section('title', __(key: 'Tambah Tarik Saldo'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Tarik Saldo') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'tarik-saldos.index') }}">{{ __(key: 'Tarik Saldo') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Tambah') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="ti ti-cash me-2"></i>Form Penarikan Saldo</h5>
                        </div>
                        <div class="card-body">
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route(name: 'tarik-saldos.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                <div class="mb-4">
                                    <label for="jumlah" class="form-label fw-bold">Jumlah Penarikan</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="jumlah" id="jumlah"
                                            class="form-control @error('jumlah') is-invalid @enderror"
                                            value="{{ old(key: 'jumlah') }}"
                                            placeholder="0"
                                            min="10000"
                                            step="1000"
                                            required />
                                    </div>
                                    @error('jumlah')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                    <div class="form-text">Minimal penarikan Rp 10.000</div>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route(name: 'tarik-saldos.index') }}" class="btn btn-secondary">
                                        <i class="ti ti-arrow-left me-1"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ti ti-check me-1"></i>Ajukan Penarikan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Informasi Saldo -->
                    <div class="card mb-3 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="ti ti-wallet me-2"></i>Saldo Merchant</h6>
                        </div>
                        <div class="card-body text-center">
                            <h3 class="text-primary mb-0">Rp {{ number_format($merchant->balance ?? 0, 0, ',', '.') }}</h3>
                            <p class="text-muted small mb-0">Saldo Tersedia</p>
                        </div>
                    </div>

                    <!-- Informasi Biaya -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="ti ti-receipt me-2"></i>Biaya Admin</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <span>Biaya Admin:</span>
                                <span class="fw-bold">Rp {{ number_format($biaya ?? 2500, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Rekening Tujuan -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="ti ti-building-bank me-2"></i>Rekening Tujuan</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <small class="text-muted d-block">Bank</small>
                                <strong>{{ $merchant->bank->nama_bank ?? '-' }}</strong>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted d-block">Nomor Rekening</small>
                                <strong>{{ $merchant->nomor_rekening ?? '-' }}</strong>
                            </div>
                            <div>
                                <small class="text-muted d-block">Atas Nama</small>
                                <strong>{{ $merchant->pemilik_rekening ?? '-' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Waktu Proses -->
                    <div class="alert alert-warning">
                        <div class="d-flex align-items-start">
                            <i class="ti ti-clock fs-4 me-2"></i>
                            <div>
                                <strong>Waktu Pemrosesan</strong>
                                <p class="mb-0 small">Penarikan akan diproses maksimal 1x24 jam pada hari kerja.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
