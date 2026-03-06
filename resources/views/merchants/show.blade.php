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
                                <!-- COL KIRI: Merchant Info, Dokumen & QRIN -->
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
                                                    <td>{{ $merchant->kode_merchant }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Balance</td>
                                                    <td>
                                                        <span class="badge bg-success fs-6">
                                                            Rp {{ number_format($merchant->balance ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Status</td>
                                                    <td>
                                                        @php
                                                            $statusLabelMap = [
                                                                'pending' => 'Pending',
                                                                'waiting_review' => 'Menunggu Review',
                                                                'approved' => 'Disetujui',
                                                                'rejected' => 'Ditolak',
                                                                'suspended' => 'Ditangguhkan',
                                                            ];
                                                            $label = $statusLabelMap[$merchant->status] ?? 'Unknown';
                                                        @endphp
                                                        {{ $label }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Beban Biaya</td>
                                                    <td>{{ $merchant->beban_biaya === 'Pelanggan' ? 'Pelanggan' : 'Merchant' }}</td>
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

                                    <!-- 2. Dokumen Merchant -->
                                    <div class="card border mb-4">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-file-image me-1"></i> Dokumen Merchant
                                            </h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <div class="row g-3">
                                                <div class="col-6">
                                                    <div class="small text-muted mb-1">KTP</div>
                                                    @if ($merchant->ktp)
                                                        <div class="position-relative d-inline-block">
                                                            <img src="{{ $merchant->ktp }}" alt="KTP"
                                                                class="rounded border"
                                                                style="width: 140px; height: 90px; object-fit: cover;">
                                                            <a href="{{ $merchant->ktp }}" target="_blank"
                                                                class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-decoration-none"
                                                                style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                                                                <i class="fas fa-external-link-alt text-white"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="text-muted fst-italic">-</span>
                                                    @endif
                                                </div>

                                                <div class="col-6">
                                                    <div class="small text-muted mb-1">KTP Lembar Verifikasi</div>
                                                    @if ($merchant->ktp_lembar_verifikasi)
                                                        <div class="position-relative d-inline-block">
                                                            <img src="{{ $merchant->ktp_lembar_verifikasi }}" alt="KTP Verifikasi"
                                                                class="rounded border"
                                                                style="width: 140px; height: 90px; object-fit: cover;">
                                                            <a href="{{ $merchant->ktp_lembar_verifikasi }}" target="_blank"
                                                                class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-decoration-none"
                                                                style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                                                                <i class="fas fa-external-link-alt text-white"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="text-muted fst-italic">-</span>
                                                    @endif
                                                </div>

                                                <div class="col-6">
                                                    <div class="small text-muted mb-1">KTP + Photo Selfie</div>
                                                    @if ($merchant->ktp_photo_selfie)
                                                        <div class="position-relative d-inline-block">
                                                            <img src="{{ $merchant->ktp_photo_selfie }}" alt="Selfie"
                                                                class="rounded border"
                                                                style="width: 140px; height: 90px; object-fit: cover;">
                                                            <a href="{{ $merchant->ktp_photo_selfie }}" target="_blank"
                                                                class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-decoration-none"
                                                                style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                                                                <i class="fas fa-external-link-alt text-white"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="text-muted fst-italic">-</span>
                                                    @endif
                                                </div>

                                                <div class="col-6">
                                                    <div class="small text-muted mb-1">Photo Toko/Rumah Tampak Depan</div>
                                                    @if ($merchant->photo_toko_tampak_depan)
                                                        <div class="position-relative d-inline-block">
                                                            <img src="{{ $merchant->photo_toko_tampak_depan }}" alt="Toko"
                                                                class="rounded border"
                                                                style="width: 140px; height: 90px; object-fit: cover;">
                                                            <a href="{{ $merchant->photo_toko_tampak_depan }}" target="_blank"
                                                                class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center text-decoration-none"
                                                                style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                                                                <i class="fas fa-external-link-alt text-white"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span class="text-muted fst-italic">-</span>
                                                    @endif
                                                </div>
                                            </div>
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
                                                            <div class="d-flex align-items-center token-qrin-wrapper">
                                                                <span id="tokenQrinText" class="me-2 text-truncate"
                                                                    style="max-width: 200px;">
                                                                    {{ str_repeat('•', 32) }}
                                                                </span>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary flex-shrink-0 token-qrin-toggle"
                                                                    onclick="toggleTokenQrin(this)">
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
                                        <div class="card-header py-2 d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold">
                                                <i class="fas fa-credit-card me-1"></i> Konfigurasi Nobu
                                            </h6>
                                            @can('merchant edit')
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch" id="use-tecanusa-credential-show"
                                                    aria-checked="{{ $isUsingTecanusaCredential ? 'true' : 'false' }}"
                                                    {{ $isUsingTecanusaCredential ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="use-tecanusa-credential-show">Use Credential Tecanusa</label>
                                            </div>
                                            @endcan
                                        </div>
                                        <div class="card-body p-3 position-relative" id="nobu-config-body">
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
                                                    <div class="d-flex align-items-center p-2 client-secret-wrapper">
                                                        @if ($merchant->nobu_client_secret)
                                                            <span id="clientSecretText" class="flex-grow-1 text-truncate"
                                                                style="max-width: 300px;">
                                                                {{ str_repeat('•', 32) }}
                                                            </span>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-secondary flex-shrink-0 client-secret-toggle"
                                                                onclick="toggleClientSecret(this)">
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
                                    Pending (Belum Submit)
                                </option>

                                <option value="waiting_review" {{ $merchant->status === 'waiting_review' ? 'selected' : '' }}>
                                    Menunggu Review
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
        const merchantId = "{{ $merchant->id }}";

        // Use Credential Tecanusa Switch Handler
        @can('merchant edit')
        document.getElementById('use-tecanusa-credential-show')?.addEventListener('change', function(e) {
            const switchEl = this;
            const isChecked = switchEl.checked;
            const actionText = isChecked ? 'menggunakan Credential Tecanusa' : 'menghapus Credential Nobu';

            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda yakin ingin ${actionText}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    switchEl.disabled = true;
                    const bodyEl = document.getElementById('nobu-config-body');
                    bodyEl.insertAdjacentHTML('beforeend', '<div class="nobu-loading-overlay" id="nobu-loading"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');

                    if (isChecked) {
                        // Fetch Tecanusa credentials and update
                        fetch("{{ route('merchants.tecanusa-credential') }}")
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update merchant with credentials
                                    return fetch("{{ route('merchants.update-nobu', $merchant->id) }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify(data.data)
                                    });
                                } else {
                                    throw new Error(data.message || 'Kredensial tidak ditemukan');
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Berhasil', 'Credential Tecanusa berhasil diterapkan.', 'success')
                                        .then(() => location.reload());
                                } else {
                                    throw new Error(data.message || 'Gagal menyimpan');
                                }
                            })
                            .catch(error => {
                                switchEl.checked = false;
                                Swal.fire('Gagal', error.message, 'error');
                            })
                            .finally(() => {
                                switchEl.disabled = false;
                                document.getElementById('nobu-loading')?.remove();
                            });
                    } else {
                        // Clear credentials
                        fetch("{{ route('merchants.update-nobu', $merchant->id) }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                nobu_client_id: null,
                                nobu_partner_id: null,
                                nobu_client_secret: null,
                                nobu_merchant_id: null,
                                nobu_sub_merchant_id: null,
                                nobu_store_id: null,
                                nobu_private_key: null
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Berhasil', 'Credential Nobu berhasil dihapus.', 'success')
                                    .then(() => location.reload());
                            } else {
                                throw new Error(data.message || 'Gagal menghapus');
                            }
                        })
                        .catch(error => {
                            switchEl.checked = true;
                            Swal.fire('Gagal', error.message, 'error');
                        })
                        .finally(() => {
                            switchEl.disabled = false;
                            document.getElementById('nobu-loading')?.remove();
                        });
                    }
                } else {
                    // User cancelled, revert switch
                    switchEl.checked = !isChecked;
                }
            });
        });
        @endcan

        function toggleTokenQrin(buttonEl) {
            const tokenQrinText = document.getElementById('tokenQrinText');
            const button = buttonEl;

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

        function toggleClientSecret(buttonEl) {
            const clientSecretText = document.getElementById('clientSecretText');
            const button = buttonEl;

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
        .nobu-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 8px;
        }
        [data-theme="dark"] .nobu-loading-overlay,
        .dark .nobu-loading-overlay {
            background: rgba(30, 33, 36, 0.85);
        }

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

            .token-qrin-wrapper,
            .client-secret-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.4rem;
            }

            .token-qrin-toggle,
            .client-secret-toggle {
                width: auto;
            }

            .text-truncate {
                max-width: 150px !important;
            }
        }
    </style>
@endpush
