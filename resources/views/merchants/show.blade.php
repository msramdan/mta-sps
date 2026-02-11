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

                                <!-- 2. QRIN & Callback -->
                                <div class="col-12 mb-4">
                                    <h5 class="mb-3 border-bottom pb-2">QRIN & Callback</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <td class="fw-bold" style="width: 30%">Token QRIN</td>
                                                <td>
                                                    @if($merchant->token_qrin)
                                                    <div class="d-flex align-items-center">
                                                        <span id="tokenQrinText" class="me-2">
                                                            {{ str_repeat('•', 20) }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2"
                                                            onclick="toggleTokenQrin()">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->token_qrin }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">URL Callback</td>
                                                <td>
                                                    @if($merchant->url_callback)
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ $merchant->url_callback }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->url_callback }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- 3. Konfigurasi Nobu -->
                                <div class="col-12 mb-4">
                                    <h5 class="mb-3 border-bottom pb-2">
                                        <i class="fas fa-credit-card me-1"></i> Konfigurasi Nobu
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <!-- Client ID -->
                                            <tr>
                                                <td class="fw-bold" style="width: 30%">Client ID</td>
                                                <td>
                                                    @if($merchant->nobu_client_id)
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2 font-monospace" style="font-size: 13px;">
                                                            {{ $merchant->nobu_client_id }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->nobu_client_id }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Partner ID -->
                                            <tr>
                                                <td class="fw-bold">Partner ID</td>
                                                <td>
                                                    @if($merchant->nobu_partner_id)
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2 font-monospace" style="font-size: 13px;">
                                                            {{ $merchant->nobu_partner_id }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->nobu_partner_id }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Client Secret -->
                                            <tr>
                                                <td class="fw-bold">Client Secret</td>
                                                <td>
                                                    @if($merchant->nobu_client_secret)
                                                    <div class="d-flex align-items-center">
                                                        <span id="clientSecretText" class="me-2">
                                                            {{ str_repeat('•', 36) }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary me-2"
                                                            onclick="toggleClientSecret()">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->nobu_client_secret }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Merchant ID -->
                                            <tr>
                                                <td class="fw-bold">Merchant ID</td>
                                                <td>
                                                    @if($merchant->nobu_merchant_id)
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ $merchant->nobu_merchant_id }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->nobu_merchant_id }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Sub Merchant ID -->
                                            <tr>
                                                <td class="fw-bold">Sub Merchant ID</td>
                                                <td>
                                                    @if($merchant->nobu_sub_merchant_id)
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ $merchant->nobu_sub_merchant_id }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->nobu_sub_merchant_id }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <!-- Store ID -->
                                            <tr>
                                                <td class="fw-bold">Store ID</td>
                                                <td>
                                                    @if($merchant->nobu_store_id)
                                                    <div class="d-flex align-items-center">
                                                        <span class="me-2">{{ $merchant->nobu_store_id }}</span>
                                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                            onclick="copyToClipboard('{{ $merchant->nobu_store_id }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>


                                            <!-- Private Key -->
                                            <tr>
                                                <td class="fw-bold">Private Key</td>
                                                <td>
                                                    @if($merchant->nobu_private_key)
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-grow-1 me-2">
                                                            <textarea class="form-control bg-light font-monospace"
                                                                rows="4" readonly
                                                                style="font-size: 11px; resize: none;"
                                                                id="privateKeyText">{{ $merchant->nobu_private_key }}</textarea>
                                                            <small class="text-muted mt-1">
                                                                Key length: {{ strlen($merchant->nobu_private_key) }} characters
                                                            </small>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="btn btn-sm btn-outline-primary mb-2"
                                                                onclick="copyPrivateKey()">
                                                                <i class="fas fa-copy"></i> Copy
                                                            </button>
                                                            <br>
                                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                                onclick="togglePrivateKey()">
                                                                <i class="fas fa-eye"></i> View
                                                            </button>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- 4. Informasi Bank Penarikan -->
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
                                                <td>{{ $merchant->pemilik_rekening ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bold">Nomor Rekening</td>
                                                <td>{{ $merchant->nomor_rekening ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- 5. Catatan Tambahan -->
                                <div class="col-12 mb-4">
                                    <h5 class="mb-3 border-bottom pb-2">Catatan</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <tr>
                                                <td>
                                                    <textarea class="form-control bg-light" rows="4" readonly
                                                        style="resize: none; background-color: #f8f9fa !important;">{{ $merchant->catatan ?? '' }}</textarea>
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

                                @can('merchant edit')
                                <a href="{{ route('merchants.edit', $merchant->id) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                @endcan

                                @can('merchant review')
                                    <button type="button" class="btn btn-info" onclick="showReviewModal()">
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
        let tokenQrinVisible = false;
        let clientSecretVisible = false;
        let privateKeyVisible = false;

        const tokenQrinValue = "{{ $merchant->token_qrin }}";
        const clientSecretValue = "{{ $merchant->nobu_client_secret }}";
        const privateKeyValue = "{{ $merchant->nobu_private_key }}";

        function toggleTokenQrin() {
            const tokenQrinText = document.getElementById('tokenQrinText');
            const button = event.currentTarget;

            if (tokenQrinVisible) {
                tokenQrinText.textContent = '•••••••••••••••••••••';
                button.innerHTML = '<i class="fas fa-eye"></i>';
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
            } else {
                tokenQrinText.textContent = tokenQrinValue;
                button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-outline-danger');
            }

            tokenQrinVisible = !tokenQrinVisible;
        }

        function toggleClientSecret() {
            const clientSecretText = document.getElementById('clientSecretText');
            const button = event.currentTarget;

            if (clientSecretVisible) {
                clientSecretText.textContent = '••••••••••••••••••••••••••••••••••••••';
                button.innerHTML = '<i class="fas fa-eye"></i>';
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
            } else {
                clientSecretText.textContent = clientSecretValue;
                button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-outline-danger');
            }

            clientSecretVisible = !clientSecretVisible;
        }

        function togglePrivateKey() {
            const privateKeyText = document.getElementById('privateKeyText');
            const button = event.currentTarget;

            if (privateKeyVisible) {
                privateKeyText.type = 'password';
                button.innerHTML = '<i class="fas fa-eye"></i> View';
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
            } else {
                privateKeyText.type = 'text';
                button.innerHTML = '<i class="fas fa-eye-slash"></i> Hide';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-outline-danger');
            }

            privateKeyVisible = !privateKeyVisible;
        }

        function copyPrivateKey() {
            copyToClipboard(privateKeyValue);
        }

        // Fungsi untuk menyalin ke clipboard dengan SweetAlert
        function copyToClipboard(text) {
            if (!text || text === '-') return;

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

        // Initialize private key as password
        document.addEventListener('DOMContentLoaded', function() {
            const privateKeyText = document.getElementById('privateKeyText');
            if (privateKeyText) {
                privateKeyText.type = 'password';
            }
        });
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

        .btn-info {
            color: #fff;
            background-color: #0dcaf0;
            border-color: #0dcaf0;
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

        .font-monospace {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .fst-italic {
            font-style: italic;
        }
    </style>
@endpush
