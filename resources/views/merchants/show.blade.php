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
                                <!-- COL KIRI: Merchant Info & QRIN -->
                                <div class="col-lg-6 col-md-12">
                                    <!-- 1. Informasi Merchant -->
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-store me-1"></i> Informasi Merchant
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Nama Merchant</td>
                                                    <td>{{ $merchant->nama_merchant }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Kode Merchant</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $merchant->kode_merchant }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Balance</td>
                                                    <td>
                                                        <span class="badge bg-success fs-6">Rp {{ number_format($merchant->balance ?? 0, 0, ',', '.') }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Logo</td>
                                                    <td>
                                                        @if ($merchant->logo)
                                                            <div class="d-flex align-items-center">
                                                                <div class="position-relative">
                                                                    <img src="{{ $merchant->logo }}" alt="Logo"
                                                                        class="rounded" style="width: 150px" />
                                                                    <a href="{{ $merchant->logo }}" target="_blank"
                                                                        class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                                        style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s; text-decoration: none;"
                                                                        onmouseover="this.style.opacity='1'"
                                                                        onmouseout="this.style.opacity='0'">
                                                                        <i class="fas fa-external-link-alt text-white"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">KTP</td>
                                                    <td>
                                                        @if ($merchant->ktp && $merchant->ktp != '')
                                                            <div class="d-flex align-items-center">
                                                                <div class="position-relative">
                                                                    <img src="{{ $merchant->ktp }}" alt="KTP"
                                                                        class="rounded" style="width: 150px" />
                                                                    <a href="{{ $merchant->ktp }}" target="_blank"
                                                                        class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                                        style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s; text-decoration: none;"
                                                                        onmouseover="this.style.opacity='1'"
                                                                        onmouseout="this.style.opacity='0'">
                                                                        <i class="fas fa-external-link-alt text-white"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <span class="text-muted fst-italic">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Status</td>
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
                                                        <span
                                                            class="badge bg-{{ $badge }}">{{ $label }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Dibuat</td>
                                                    <td><small
                                                            class="text-muted">{{ $merchant->created_at->format('d M Y H:i') }}</small>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Diperbarui</td>
                                                    <td><small
                                                            class="text-muted">{{ $merchant->updated_at->format('d M Y H:i') }}</small>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 2. QRIN & Callback -->
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-qrcode me-1"></i> QRIN & Callback
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Token QRIN</td>
                                                    <td>
                                                        @if ($merchant->token_qrin)
                                                            <div class="d-flex align-items-center">
                                                                <span id="tokenQrinText" class="me-2 text-truncate"
                                                                    style="max-width: 200px;">
                                                                    {{ str_repeat('•', 32) }}
                                                                </span>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary flex-shrink-0"
                                                                    onclick="toggleTokenQrin()">
                                                                    <i class="fas fa-eye"></i>
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
                                                        <span class="d-block text-truncate" style="max-width: 250px;">
                                                            {{ $merchant->url_callback ?? '-' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- 3. Informasi Bank -->
                                    <div class="card border">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-university me-1"></i> Informasi Bank
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="fw-bold" style="width: 40%">Bank</td>
                                                    <td>{{ $merchant->bank ? $merchant->bank->nama_bank : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Pemilik</td>
                                                    <td>{{ $merchant->pemilik_rekening ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">No. Rekening</td>
                                                    <td>{{ $merchant->nomor_rekening ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- COL KANAN: Konfigurasi Nobu -->
                                <div class="col-lg-6 col-md-12">
                                    <!-- 4. Konfigurasi Nobu -->
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-credit-card me-1"></i> Konfigurasi Nobu
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row g-3">
                                                <!-- Client ID -->
                                                <div class="col-md-6">
                                                    <label class="small fw-bold text-muted mb-1">Client ID</label>
                                                    <div class="p-2">
                                                        <small
                                                            class="text-break d-block">{{ $merchant->nobu_client_id ?? '-' }}</small>
                                                    </div>
                                                </div>

                                                <!-- Partner ID -->
                                                <div class="col-md-6">
                                                    <label class="small fw-bold text-muted mb-1">Partner ID</label>
                                                    <div class="p-2">
                                                        <small
                                                            class="text-break d-block">{{ $merchant->nobu_partner_id ?? '-' }}</small>
                                                    </div>
                                                </div>

                                                <!-- Client Secret -->
                                                <div class="col-md-12">
                                                    <label class="small fw-bold text-muted mb-1">Client Secret</label>
                                                    <div class="d-flex align-items-center p-2">
                                                        @if ($merchant->nobu_client_secret)
                                                            <span id="clientSecretText" class="flex-grow-1 text-truncate"
                                                                style="max-width: 300px;">
                                                                {{ str_repeat('•', 32) }}
                                                            </span>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary flex-shrink-0"
                                                                onclick="toggleClientSecret()">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <!-- Merchant ID -->
                                                <div class="col-md-6">
                                                    <label class="small fw-bold text-muted mb-1">Merchant ID</label>
                                                    <div class="p-2">
                                                        <small
                                                            class="d-block">{{ $merchant->nobu_merchant_id ?? '-' }}</small>
                                                    </div>
                                                </div>

                                                <!-- Sub Merchant ID -->
                                                <div class="col-md-6">
                                                    <label class="small fw-bold text-muted mb-1">Sub Merchant ID</label>
                                                    <div class="p-2">
                                                        <small
                                                            class="d-block">{{ $merchant->nobu_sub_merchant_id ?? '-' }}</small>
                                                    </div>
                                                </div>

                                                <!-- Store ID -->
                                                <div class="col-md-6">
                                                    <label class="small fw-bold text-muted mb-1">Store ID</label>
                                                    <div class="p-2">
                                                        <small
                                                            class="d-block">{{ $merchant->nobu_store_id ?? '-' }}</small>
                                                    </div>
                                                </div>

                                                <!-- Terminal ID REMOVED -->

                                                <!-- Private Key -->
                                                <div class="col-12">
                                                    <label class="small fw-bold text-muted mb-1">Private Key</label>
                                                    <div class="p-2">
                                                        @if ($merchant->nobu_private_key)
                                                            <textarea class="form-control border" rows="4" readonly style="font-size: 12px; resize: none;"
                                                                id="privateKeyText">{{ $merchant->nobu_private_key }}</textarea>
                                                            <div class="text-end mt-1">
                                                                <small class="text-muted">
                                                                    {{ strlen($merchant->nobu_private_key) }} chars
                                                                </small>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 5. Catatan -->
                                    <div class="card border">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-sticky-note me-1"></i> Catatan
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="p-2">
                                                <p class="mb-0" style="min-height: 60px;">
                                                    {{ $merchant->catatan ?: 'Tidak ada catatan' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ACTION BUTTONS -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <a href="{{ route('merchants.index') }}" class="btn btn-secondary g-2">
                                                <i class="fas fa-arrow-left me-1"></i> Kembali
                                            </a>
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

        const tokenQrinValue = "{{ $merchant->token_qrin }}";
        const clientSecretValue = "{{ $merchant->nobu_client_secret }}";

        function toggleTokenQrin() {
            const tokenQrinText = document.getElementById('tokenQrinText');
            const button = event.currentTarget;

            if (tokenQrinVisible) {
                tokenQrinText.textContent = '••••••••••••••••••••••••••••••••';
                tokenQrinText.style.maxWidth = '200px';
                button.innerHTML = '<i class="fas fa-eye"></i>';
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
            } else {
                // Potong token jika terlalu panjang
                const displayText = tokenQrinValue.length > 50 ?
                    tokenQrinValue.substring(0, 50) + '...' :
                    tokenQrinValue;
                tokenQrinText.textContent = displayText;
                tokenQrinText.style.maxWidth = 'none';
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
                clientSecretText.textContent = '••••••••••••••••••••••••••••••••';
                clientSecretText.style.maxWidth = '300px';
                button.innerHTML = '<i class="fas fa-eye"></i>';
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
            } else {
                clientSecretText.textContent = clientSecretValue;
                clientSecretText.style.maxWidth = 'none';
                button.innerHTML = '<i class="fas fa-eye-slash"></i>';
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-outline-danger');
            }

            clientSecretVisible = !clientSecretVisible;
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
        .card {
            height: 100%;
            box-shadow: none !important;
        }

        .card-header {
            background-color: transparent !important;
        }

        .table-sm.table-borderless td {
            padding: 0.3rem 0;
            border: none;
        }

        .text-break {
            word-break: break-word;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .position-relative:hover a {
            opacity: 1 !important;
        }

        /* Make both columns equal height */
        .row>.col-lg-6 {
            display: flex;
            flex-direction: column;
        }

        .row>.col-lg-6>.card {
            flex: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .col-lg-6 {
                margin-bottom: 1.5rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }

            .d-flex.justify-content-between>div {
                width: 100%;
                text-align: center;
            }

            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .text-truncate {
                max-width: 150px !important;
            }
        }
    </style>
@endpush
