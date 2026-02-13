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
											<th>{{ __(key: 'Bank') }}</th>
											<th>{{ __(key: 'Pemilik Rekening') }}</th>
											<th>{{ __(key: 'Nomor Rekening') }}</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawalModalLabel"><i class="ti ti-cash me-2"></i>Pengajuan Penarikan Saldo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="withdrawalForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="mb-4">
                                    <label for="jumlah" class="form-label fw-bold">Jumlah Penarikan</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="jumlah" id="jumlah"
                                            class="form-control"
                                            placeholder="0"
                                            min="10000"
                                            step="1000"
                                            required />
                                    </div>
                                    <div class="form-text" id="jumlah-error" style="color: #dc3545; display: none;"></div>
                                    <div class="form-text">Minimal penarikan Rp 10.000</div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <!-- Informasi Saldo -->
                                <div class="card mb-3 border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0"><i class="ti ti-wallet me-2"></i>Saldo Merchant</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <h3 class="text-primary mb-0" id="merchant-balance">Rp 0</h3>
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
                                            <span class="fw-bold">Rp 2.500</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <!-- Informasi Rekening Tujuan -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="ti ti-building-bank me-2"></i>Rekening Tujuan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <small class="text-muted d-block">Bank</small>
                                                <strong id="merchant-bank">-</strong>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <small class="text-muted d-block">Nomor Rekening</small>
                                                <strong id="merchant-rekening">-</strong>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted d-block">Atas Nama</small>
                                                <strong id="merchant-pemilik">-</strong>
                                            </div>
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
                    name: 'merchant.nama_merchant'
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
                    data: 'bank',
                    name: 'bank.nama_bank'
                },
				{
                    data: 'pemilik_rekening',
                    name: 'pemilik_rekening',
                },
				{
                    data: 'nomor_rekening',
                    name: 'nomor_rekening',
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
                            return `<div class="avatar">
                                <img src="${data}" alt="Bukti Trf"  />
                            </div>`;
                        }
                        return '-';
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
