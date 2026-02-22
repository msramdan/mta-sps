@extends('layouts.app')

@section('title', __(key: 'Tarik Saldo'))

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
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Tarik Saldo') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            @if(isset($summary) && $summary)
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <h6 class="text-muted mb-2"><i class="ti ti-building-store me-1"></i> {{ $summary->nama_merchant }}</h6>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Saldo Tersedia</small>
                            <div class="fw-bold text-primary fs-5">Rp {{ number_format($summary->balance, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Rekening Penarikan</small>
                            <div class="fw-bold small">{{ $summary->bank }}</div>
                            <div class="text-muted small">{{ $summary->nomor_rekening }} a.n. {{ $summary->pemilik_rekening }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Pengajuan Pending</small>
                            <div class="fw-bold">{{ $summary->pending_count }}</div>
                            <small class="text-muted">sedang diproses</small>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body py-3">
                            <small class="text-muted d-block mb-1">Total Sudah Ditarik</small>
                            <div class="fw-bold text-success">Rp {{ number_format($summary->total_ditarikan, 0, ',', '.') }}</div>
                            <small class="text-muted">{{ $summary->success_count }}x berhasil</small>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex justify-content-end">
                @can('pengajuan tarik saldo')
                    <button type="button" class="btn btn-primary mb-3 me-3" data-bs-toggle="modal" data-bs-target="#withdrawalModal">
                        <i class="fas fa-plus"></i>
                        {{ __(key: 'Ajukan Penarikan') }}
                    </button>
                @endcan
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
                                            <th>{{ __(key: 'Merchant') }}</th>
											<th>{{ __(key: 'Jumlah') }}</th>
											<th>{{ __(key: 'Biaya') }}</th>
											<th>{{ __(key: 'Diterima') }}</th>
									<th>{{ __(key: 'Rek. Tujuan') }}</th>
											<th>{{ __(key: 'Status') }}</th>
											<th>{{ __(key: 'Bukti Trf') }}</th>
                                            <th>{{ __(key: 'Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="withdrawalModal" tabindex="-1" aria-labelledby="withdrawalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawalModalLabel"><i class="ti ti-cash me-2"></i>Pengajuan Penarikan Saldo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="withdrawalForm">
                    @csrf
                    <div class="modal-body">
                        <!-- Informasi Saldo & Biaya -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="border rounded p-2 text-center">
                                    <small class="text-muted d-block">Saldo Tersedia</small>
                                    <h5 class="text-primary mb-0" id="merchant-balance">Rp 0</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-2 text-center">
                                    <small class="text-muted d-block">Biaya Admin</small>
                                    <h5 class="text-danger mb-0">Rp 7.500</h5>
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Penarikan -->
                        <div class="mb-3">
                            <label for="jumlah" class="form-label fw-bold">Jumlah Penarikan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="jumlah" id="jumlah"
                                    class="form-control"
                                    placeholder="0"
                                    min="200000"
                                    step="1000"
                                    required />
                            </div>
                            <div class="form-text" id="jumlah-error" style="color: #dc3545; display: none;"></div>
                            <small class="form-text text-muted">Minimal penarikan Rp 200.000</small>
                        </div>

                        <!-- Rekening Tujuan -->
                        <div class="border rounded p-3 mb-3">
                            <h6 class="mb-2"><i class="ti ti-building-bank me-2"></i>Rekening Tujuan</h6>
                            <div class="row g-2">
                                <div class="col-12">
                                    <small class="text-muted">Bank:</small>
                                    <div class="fw-bold" id="merchant-bank">-</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">No. Rekening:</small>
                                    <div class="fw-bold" id="merchant-rekening">-</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Atas Nama:</small>
                                    <div class="fw-bold" id="merchant-pemilik">-</div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Waktu -->
                        <div class="alert alert-warning mb-0 py-2">
                            <small>
                                <i class="ti ti-clock me-1"></i>
                                <strong>Waktu Proses:</strong> Maksimal 1x24 jam pada hari kerja
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="ti ti-check me-1"></i>Ajukan Penarikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @can('konfirmasi tarik saldo')
    <div class="modal fade" id="statusWithdrawalModal" tabindex="-1" aria-labelledby="statusWithdrawalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusWithdrawalModalLabel"><i class="ti ti-arrow-right me-2"></i>Ubah Status Penarikan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusWithdrawalForm">
                    @csrf
                    <input type="hidden" name="status" id="statusWithdrawalValue" value="">
                    <div class="modal-body">
                        <p class="text-muted small mb-3">Pilih status untuk pengajuan penarikan ini:</p>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-info flex-grow-1 btn-status-choice" data-status="process">
                                <i class="ti ti-loader me-1"></i> Diproses
                            </button>
                            <button type="button" class="btn btn-danger flex-grow-1 btn-status-choice" data-status="reject">
                                <i class="ti ti-x me-1"></i> Ditolak
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ti ti-x me-1"></i>Batal</button>
                        <button type="submit" class="btn btn-primary" id="statusSubmitBtn" disabled><i class="ti ti-check me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmWithdrawalModal" tabindex="-1" aria-labelledby="confirmWithdrawalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmWithdrawalModalLabel"><i class="ti ti-check me-2"></i>Konfirmasi Selesai (Upload Bukti + Catatan)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="confirmWithdrawalForm">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted small mb-3">Upload bukti transfer dan isi catatan. Setelah dikonfirmasi, status menjadi <strong>Berhasil</strong> dan saldo merchant akan dikurangi.</p>
                        <div class="mb-3">
                            <label for="confirm_bukti_trf" class="form-label">Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" name="bukti_trf" id="confirm_bukti_trf" class="form-control" accept="image/*" required>
                            <small class="form-text text-muted">JPG, PNG maks. 2MB</small>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_catatan" class="form-label">Catatan <span class="text-danger">*</span></label>
                            <textarea name="catatan" id="confirm_catatan" class="form-control" rows="3" maxlength="1000" placeholder="Catatan konfirmasi penarikan..." required></textarea>
                            <small class="form-text text-muted">Maks. 1000 karakter</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="ti ti-x me-1"></i>Batal</button>
                        <button type="submit" class="btn btn-primary" id="confirmSubmitBtn"><i class="ti ti-check me-1"></i>Konfirmasi & Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
@endsection

@push('js')
    <script>
        const dataTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route(name: 'tarik-saldos.index') }}",
            columns: [
                {
                    data: 'merchant',
                    name: 'merchant'
                },
				{
                    data: 'jumlah',
                    name: 'jumlah',
                    render: function(data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                },
				{
                    data: 'biaya',
                    name: 'biaya',
                    render: function(data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                },
				{
                    data: 'diterima',
                    name: 'diterima',
                    render: function(data) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                    }
                },
				{
                    data: null,
                    name: 'rekening_tujuan',
                    orderable: false,
                    render: function(data, type, row) {
                        return `<div class="small">
                            <div class="fw-bold">${row.bank || '-'}</div>
                            <div class="text-muted">${row.nomor_rekening || '-'}</div>
                            <div>${row.pemilik_rekening || '-'}</div>
                        </div>`;
                    }
                },
				{
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        switch(data) {
                            case 'pending':
                                return '<span class="badge bg-warning text-dark">Pending</span>';
                            case 'process':
                                return '<span class="badge bg-info">Diproses</span>';
                            case 'success':
                                return '<span class="badge bg-success">Berhasil</span>';
                            case 'reject':
                                return '<span class="badge bg-danger">Ditolak</span>';
                            default:
                                return '<span class="badge bg-secondary">' + data + '</span>';
                        }
                    }
                },
				{
                    data: 'bukti_trf',
                    name: 'bukti_trf',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data) {
                            return `<a href="${data}" target="_blank" class="btn btn-sm btn-primary">
                                <i class="ti ti-file"></i> Lihat
                            </a>`;
                        }
                        return '<span class="text-muted">-</span>';
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });

        // Load merchant data when modal opens
        $('#withdrawalModal').on('show.bs.modal', function (e) {
            loadMerchantData();
        });

        function loadMerchantData() {
            $.ajax({
                url: "{{ route('tarik-saldos.merchant-data') }}",
                type: 'GET',
                dataType: 'json',
                success: function(merchant) {
                    $('#merchant-balance').text('Rp ' + new Intl.NumberFormat('id-ID').format(merchant.balance || 0));
                    $('#merchant-bank').text(merchant.bank?.nama_bank || '-');
                    $('#merchant-rekening').text(merchant.nomor_rekening || '-');
                    $('#merchant-pemilik').text(merchant.pemilik_rekening || '-');
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.error || 'Data merchant tidak ditemukan',
                            confirmButtonColor: '#d33'
                        });
                        $('#withdrawalModal').modal('hide');
                    } else {
                        $('#merchant-balance').text('Rp 0');
                        $('#merchant-bank').text('-');
                        $('#merchant-rekening').text('-');
                        $('#merchant-pemilik').text('-');
                    }
                }
            });
        }

        // Handle form submission
        $('#withdrawalForm').on('submit', function(e) {
            e.preventDefault();

            const submitBtn = $('#submitBtn');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-1"></i>Memproses...');

            // Clear previous errors
            $('#jumlah-error').hide().text('');
            $('#jumlah').removeClass('is-invalid');

            $.ajax({
                url: "{{ route('tarik-saldos.store') }}",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    $('#withdrawalModal').modal('hide');
                    $('#withdrawalForm')[0].reset();
                    dataTable.ajax.reload();

                    // Show success message using SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pengajuan penarikan saldo berhasil dibuat. Penarikan akan diproses maksimal 1x24 jam.',
                        confirmButtonColor: '#3085d6'
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        if (errors.jumlah) {
                            $('#jumlah').addClass('is-invalid');
                            $('#jumlah-error').show().text(errors.jumlah[0]);
                        }
                    } else if (xhr.responseJSON?.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON.message,
                            confirmButtonColor: '#d33'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat memproses pengajuan.',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Reset form when modal is hidden
        $('#withdrawalModal').on('hidden.bs.modal', function () {
            $('#withdrawalForm')[0].reset();
            $('#jumlah-error').hide().text('');
            $('#jumlah').removeClass('is-invalid');
        });

        let statusWithdrawalId = null;
        $('#statusWithdrawalModal').on('hidden.bs.modal', function() {
            statusWithdrawalId = null;
            $('#statusWithdrawalValue').val('');
            $('#statusSubmitBtn').prop('disabled', true);
        });
        $(document).on('click', '.btn-status-withdrawal', function() {
            statusWithdrawalId = $(this).data('id');
            $('#statusWithdrawalModal').modal('show');
        });
        $(document).on('click', '.btn-status-choice', function() {
            var status = $(this).data('status');
            $('#statusWithdrawalValue').val(status);
            $('#statusSubmitBtn').prop('disabled', false);
        });
        $('#statusWithdrawalForm').on('submit', function(e) {
            e.preventDefault();
            if (!statusWithdrawalId) return;
            var submitBtn = $('#statusSubmitBtn');
            var originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-1"></i>Memproses...');
            $.ajax({
                url: "{{ route('tarik-saldos.index') }}/" + statusWithdrawalId + "/status",
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    $('#statusWithdrawalModal').modal('hide');
                    dataTable.ajax.reload();
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message || 'Status berhasil diubah.', confirmButtonColor: '#3085d6' });
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.', confirmButtonColor: '#d33' });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });

        let confirmWithdrawalId = null;
        $('#confirmWithdrawalModal').on('hidden.bs.modal', function() {
            confirmWithdrawalId = null;
            $('#confirmWithdrawalForm')[0].reset();
        });
        $(document).on('click', '.btn-confirm-withdrawal', function() {
            confirmWithdrawalId = $(this).data('id');
            $('#confirmWithdrawalModal').modal('show');
        });
        $('#confirmWithdrawalForm').on('submit', function(e) {
            e.preventDefault();
            if (!confirmWithdrawalId) return;
            const form = this;
            const formData = new FormData(form);
            const submitBtn = $('#confirmSubmitBtn');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-1"></i>Memproses...');
            $.ajax({
                url: "{{ route('tarik-saldos.index') }}/" + confirmWithdrawalId + "/confirm",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                success: function(response) {
                    $('#confirmWithdrawalModal').modal('hide');
                    dataTable.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message || 'Tarik saldo berhasil dikonfirmasi.',
                        confirmButtonColor: '#3085d6'
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat konfirmasi.',
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Handle cancel withdrawal button
        $(document).on('click', '.btn-cancel-withdrawal', function() {
            const withdrawalId = $(this).data('id');

            Swal.fire({
                title: 'Batalkan Pengajuan?',
                text: 'Apakah Anda yakin ingin membatalkan pengajuan penarikan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('tarik-saldos.index') }}/" + withdrawalId + "/cancel",
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            dataTable.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Pengajuan penarikan berhasil dibatalkan.',
                                confirmButtonColor: '#3085d6'
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan saat membatalkan pengajuan.',
                                confirmButtonColor: '#d33'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
