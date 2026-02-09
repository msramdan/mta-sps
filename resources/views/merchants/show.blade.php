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
                                                <td class="fw-bold">KTP</td>
                                                <td>
                                                    @if ($merchant->ktp && $merchant->ktp != '')
                                                        <img src="{{ $merchant->ktp }}" alt="KTP"
                                                            class="rounded img-fluid"
                                                            style="object-fit: cover; width: 150px; max-height: 200px;" />
                                                        <div class="mt-2">
                                                            <a href="{{ $merchant->ktp }}" target="_blank"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-external-link-alt me-1"></i> Lihat Full
                                                                Size
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="text-muted fst-italic">Belum ada KTP</span>
                                                    @endif
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
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->url_callback }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
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
                                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2"
                                                            onclick="toggleApiKey()">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->apikey }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
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
                                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2"
                                                            onclick="toggleSecretKey()">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->secretkey }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
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

                                <!-- 4. Catatan Tambahan -->
                                <div class="col-12 mb-4">
                                    <h5 class="mb-3 border-bottom pb-2">Catatan</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <td class="fw-bold" style="width: 30%">Catatan</td>
                                                <td>
                                                    <textarea class="form-control bg-light" rows="4" readonly>{{ $merchant->catatan }}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('merchants.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>

                                <div>
                                    @can('merchant review')
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#reviewModal">
                                            <i class="fas fa-check-circle me-1"></i> Review
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Review -->
    @can('merchant review')
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('merchants.review', $merchant->id) }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewModalLabel">Review Merchant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="review_is_active" class="form-label">Status Aktif <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="is_active" id="review_is_active" required>
                                    <option value="" disabled>-- Pilih Status --</option>
                                    <option value="Yes" {{ $merchant->is_active == 'Yes' ? 'selected' : '' }}>Ya (Aktif)
                                    </option>
                                    <option value="No" {{ $merchant->is_active == 'No' ? 'selected' : '' }}>Tidak
                                        (Nonaktif)</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="review_catatan" class="form-label">Catatan (Opsional)</label>
                                <textarea name="catatan" id="review_catatan" rows="4" class="form-control"
                                    placeholder="Masukkan catatan review...">{{ $merchant->catatan }}</textarea>
                                <div class="form-text">
                                    Catatan ini akan menggantikan catatan sebelumnya.
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('js')
    <script>
        let apiKeyVisible = false;
        let secretKeyVisible = false;
        const apiKeyValue = "{{ $merchant->apikey }}";
        const secretKeyValue = "{{ $merchant->secretkey }}";

        function toggleApiKey() {
            const apiKeyText = document.getElementById('apiKeyText');
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

        // Fungsi untuk menyalin ke clipboard dengan SweetAlert
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Teks berhasil disalin ke clipboard',
                    timer: 2000,
                    showConfirmButton: false
                });
            }).catch(err => {
                console.error('Gagal menyalin: ', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal menyalin teks ke clipboard',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        }
    </script>
@endpush
