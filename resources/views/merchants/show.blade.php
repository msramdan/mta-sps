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
                                                            {{ str_repeat('•', 32) }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
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
                                                    <span>{{ $merchant->url_callback ?? '-' }}</span>
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
                                                    <span>
                                                        {{ $merchant->nobu_client_id ?? '-' }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Partner ID -->
                                            <tr>
                                                <td class="fw-bold">Partner ID</td>
                                                <td>
                                                    <span>
                                                        {{ $merchant->nobu_partner_id ?? '-' }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Client Secret -->
                                            <tr>
                                                <td class="fw-bold">Client Secret</td>
                                                <td>
                                                    @if($merchant->nobu_client_secret)
                                                    <div class="d-flex align-items-center">
                                                        <span id="clientSecretText" class="me-2">
                                                            {{ str_repeat('•', 32) }}
                                                        </span>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                                            onclick="toggleClientSecret()">
                                                            <i class="fas fa-eye"></i>
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
                                                    <span>{{ $merchant->nobu_merchant_id ?? '-' }}</span>
                                                </td>
                                            </tr>

                                            <!-- Sub Merchant ID -->
                                            <tr>
                                                <td class="fw-bold">Sub Merchant ID</td>
                                                <td>
                                                    <span>{{ $merchant->nobu_sub_merchant_id ?? '-' }}</span>
                                                </td>
                                            </tr>

                                            <!-- Store ID -->
                                            <tr>
                                                <td class="fw-bold">Store ID</td>
                                                <td>
                                                    <span>{{ $merchant->nobu_store_id ?? '-' }}</span>
                                                </td>
                                            </tr>

                                            <!-- Terminal ID (Hardcode) -->
                                            <tr>
                                                <td class="fw-bold">Terminal ID</td>
                                                <td>
                                                    <span>A01</span>
                                                    <span class="ms-2 badge bg-info">Hardcoded</span>
                                                </td>
                                            </tr>

                                            <!-- Private Key -->
                                            <tr>
                                                <td class="fw-bold">Private Key</td>
                                                <td>
                                                    @if($merchant->nobu_private_key)
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-grow-1 me-2">
                                                            <textarea class="form-control bg-light"
                                                                rows="4" readonly
                                                                style="font-size: 13px; resize: none; background-color: #f8f9fa !important;"
                                                                id="privateKeyText">{{ $merchant->nobu_private_key }}</textarea>
                                                            <small class="text-muted mt-1">
                                                                Key length: {{ strlen($merchant->nobu_private_key) }} characters
                                                            </small>
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

        const tokenQrinValue = "{{ $merchant->token_qrin }}";
        const clientSecretValue = "{{ $merchant->nobu_client_secret }}";

        function toggleTokenQrin() {
            const tokenQrinText = document.getElementById('tokenQrinText');
            const button = event.currentTarget;

            if (tokenQrinVisible) {
                tokenQrinText.textContent = '••••••••••••••••••••••••••••••••';
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
                clientSecretText.textContent = '••••••••••••••••••••••••••••••••';
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
