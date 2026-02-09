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
                                                <td class="fw-bold">Status Merchant</td>
                                                <td>
                                                    @php
                                                        $statusMap = [
                                                            'approved' => ['success', 'Disetujui'],
                                                            'pending' => ['warning', 'Menunggu'],
                                                            'rejected' => ['danger', 'Ditolak'],
                                                            'suspended' => ['secondary', 'Ditangguhkan'],
                                                        ];

                                                        [$badge, $label] = $statusMap[$merchant->status] ?? [
                                                            'light',
                                                            'Unknown',
                                                        ];
                                                    @endphp

                                                    <span class="badge bg-{{ $badge }}">
                                                        {{ $label }}
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
                                                <td>
                                                    <textarea class="form-control bg-light" rows="4" readonly
                                                        style="resize: none; background-color: #f8f9fa !important;">{{ $merchant->catatan }}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mt-4">
                                <a href="{{ route('merchants.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a> &nbsp;

                                @can('merchant review')
                                    <button type="button" class="btn btn-warning" onclick="showReviewModal()">
                                        <i class="fas fa-check-circle me-1"></i> Review
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Simple Modal without Bootstrap (Custom) -->
    @can('merchant review')
        <div id="reviewModal" class="modal-custom"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1050; padding-top: 100px;">
            <div class="modal-content-custom"
                style="background-color: white; margin: auto; padding: 20px; border-radius: 8px; width: 500px; max-width: 90%;">
                <div class="modal-header-custom"
                    style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #dee2e6; padding-bottom: 10px; margin-bottom: 20px;">
                    <h5 class="modal-title-custom">Review Merchant</h5>
                    <button type="button" class="btn-close-custom" onclick="closeReviewModal()"
                        style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">
                        &times;
                    </button>
                </div>

                <form id="reviewForm" action="{{ route('merchants.review', $merchant->id) }}" method="POST">
                    @csrf

                    <div class="modal-body-custom">
                        <div class="mb-3">
                            <label for="review_status" class="form-label">
                                Status Merchant <span class="text-danger">*</span>
                            </label>

                            <select class="form-control" name="status" id="review_status" required
                                style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">
                                <option value="" disabled>-- Pilih Status --</option>

                                <option value="pending" {{ $merchant->status === 'pending' ? 'selected' : '' }}>
                                    Pending (Menunggu Verifikasi)
                                </option>

                                <option value="approved" {{ $merchant->status === 'approved' ? 'selected' : '' }}>
                                    Approved (Disetujui)
                                </option>

                                <option value="rejected" {{ $merchant->status === 'rejected' ? 'selected' : '' }}>
                                    Rejected (Ditolak)
                                </option>

                                <option value="suspended" {{ $merchant->status === 'suspended' ? 'selected' : '' }}>
                                    Suspended (Ditangguhkan)
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="review_catatan" class="form-label">Catatan (Opsional)</label>
                            <textarea name="catatan" id="review_catatan" rows="4" class="form-control"
                                placeholder="Masukkan catatan review..."
                                style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;">{{ $merchant->catatan }}</textarea>
                            <div class="form-text">
                                Catatan ini akan menggantikan catatan sebelumnya.
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer-custom"
                        style="border-top: 1px solid #dee2e6; padding-top: 15px; margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" class="btn btn-secondary" onclick="closeReviewModal()">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Review</button>
                    </div>
                </form>
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

        // Custom Modal Functions
        function showReviewModal() {
            document.getElementById('reviewModal').style.display = 'block';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('reviewModal');
            if (event.target == modal) {
                closeReviewModal();
            }
        }
    </script>
@endpush

@push('css')
    <style>
        .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 0.375rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-secondary {
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-primary {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-warning {
            color: #000;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-outline-primary {
            color: #0d6efd;
            border-color: #0d6efd;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }

        .form-text {
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #6c757d;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
@endpush
