@extends('layouts.app')

@section('title', 'Detail Merchant')

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">Merchant</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route('merchants.index') }}">Merchant</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">Detail</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!-- 1. Informasi Merchant -->
                                <div class="col-12 mb-4">
                                    <h5 class="mb-3 border-bottom pb-2">Informasi Merchant</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <td class="fw-bold" style="width: 30%">Nama Merchant</td>
                                                <td>{{ $merchant->nama_merchant }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Logo</td>
                                                <td>
                                                    <img src="{{ $merchant->logo }}" alt="Logo"
                                                        class="rounded img-fluid"
                                                        style="object-fit: cover; width: 150px;" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Status Aktif</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $merchant->is_active == 'Yes' ? 'success' : 'danger' }}">
                                                        {{ $merchant->is_active == 'Yes' ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Dibuat</td>
                                                <td>{{ $merchant->created_at->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Diperbarui</td>
                                                <td>{{ $merchant->updated_at->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- 2. Kredensial API -->
                                <div class="col-12 mb-4">
                                    <h5 class="mb-3 border-bottom pb-2">Kredensial API</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <td class="fw-bold" style="width: 30%">URL Callback</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ $merchant->url_callback }}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">API Key</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span id="apiKeyText" class="me-2">
                                                            {{ str_repeat('•', 32) }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                            onclick="toggleApiKey()">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <input type="hidden" id="apiKeyValue"
                                                            value="{{ $merchant->apikey }}">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Secret Key</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span id="secretKeyText" class="me-2">
                                                            {{ str_repeat('•', 32) }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                            onclick="toggleSecretKey()">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <input type="hidden" id="secretKeyValue"
                                                            value="{{ $merchant->secretkey }}">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- 3. Informasi Bank Penarikan -->
                                <div class="col-12 mb-4">
                                    <h5 class="mb-3 border-bottom pb-2">Informasi Bank Penarikan</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <td class="fw-bold" style="width: 30%">Bank</td>
                                                <td>{{ $merchant->bank ? $merchant->bank->nama_bank : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Pemilik Rekening</td>
                                                <td>{{ $merchant->pemilik_rekening }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Nomor Rekening</td>
                                                <td>{{ $merchant->nomor_rekening }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('merchants.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        let apiKeyVisible = false;
        let secretKeyVisible = false;

        function toggleApiKey() {
            const apiKeyText = document.getElementById('apiKeyText');
            const apiKeyValue = document.getElementById('apiKeyValue').value;
            const button = event.currentTarget;

            if (apiKeyVisible) {
                // Hide API Key
                apiKeyText.textContent = '••••••••••••••••••••••••••••••••';
                button.innerHTML = '<i class="fas fa-eye"></i>';
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
            } else {
                // Show API Key
                apiKeyText.textContent = apiKeyValue;
                button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-outline-danger');
            }

            apiKeyVisible = !apiKeyVisible;
        }

        function toggleSecretKey() {
            const secretKeyText = document.getElementById('secretKeyText');
            const secretKeyValue = document.getElementById('secretKeyValue').value;
            const button = event.currentTarget;

            if (secretKeyVisible) {
                // Hide Secret Key
                secretKeyText.textContent = '••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••••';
                button.innerHTML = '<i class="fas fa-eye"></i>';
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
            } else {
                // Show Secret Key
                secretKeyText.textContent = secretKeyValue;
                button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-outline-danger');
            }

            secretKeyVisible = !secretKeyVisible;
        }

        // Fungsi untuk menyalin ke clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Berhasil disalin ke clipboard!');
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
            });
        }
    </script>
@endpush
