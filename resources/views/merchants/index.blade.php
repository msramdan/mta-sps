@extends('layouts.app')

@section('title', 'Merchant')

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
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">Merchant</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                @can('merchant create')
                    <a href="{{ route('merchants.create') }}" class="btn btn-primary mb-3 me-3">
                        <i class="fas fa-plus"></i>
                        Tambah
                    </a>
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
                                            <th style="width: 20px;"></th>
                                            <th>Kode Merchant</th>
                                            <th>Nama Merchant</th>
                                            <th>Logo</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
@endsection

@push('js')
    <script>
        function format(d) {
            return `
        <div class="detail-content p-2">
            <div class="row g-2">
                <!-- Kredensial API Section -->
                <div class="col-md-6">
                    <div class="detail-section p-2 rounded border">
                        <h6 class="fw-bold mb-2 pb-1 border-bottom text-primary small">
                            <i class="fas fa-key me-1"></i>Kredensial API
                        </h6>

                        <div class="detail-row mb-2">
                            <label class="detail-label text-muted small mb-1">URL Callback</label>
                            <div class="detail-value">
                                <input type="text" class="form-control form-control-sm"
                                       value="${d.url_callback || '-'}" readonly>
                            </div>
                        </div>

                        <div class="detail-row mb-2">
                            <label class="detail-label text-muted small mb-1">Token QRIN</label>
                            <div class="detail-value d-flex align-items-center">
                                <input type="password" id="token_qrin-${d.id}"
                                       class="form-control form-control-sm flex-grow-1"
                                       value="${d.token_qrin ? '•'.repeat(32) : '-'}"
                                       readonly
                                       style="font-family: monospace;">
                                <button type="button" class="btn btn-sm btn-outline-secondary ms-1 toggle-btn"
                                        onclick="toggletoken_qrin('${d.id}', '${d.token_qrin || ''}')"
                                        style="min-width: 32px; padding: 2px 6px;"
                                        title="Show/Hide">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi Bank Section -->
<div class="col-md-6">
    <div class="detail-section p-2 rounded border">
        <h6 class="fw-bold mb-2 pb-1 border-bottom text-primary small">
            <i class="fas fa-university me-1"></i>Informasi Bank Penarikan
        </h6>

        <div class="row g-2">
            <div class="col-md-6">
                <div class="detail-row mb-2">
                    <label class="detail-label text-muted small mb-1">Bank</label>
                    <div class="detail-value">
                        <input type="text" class="form-control form-control-sm"
                               value="${d.bank ? d.bank.nama_bank : '-'}" readonly>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="detail-row mb-2">
                    <label class="detail-label text-muted small mb-1">No. Rekening</label>
                    <div class="detail-value d-flex align-items-center">
                        <input type="text" class="form-control form-control-sm"
                               value="${d.nomor_rekening || '-'}" readonly
                               style="font-family: monospace;">
                        ${d.nomor_rekening ? `
                            <button type="button" class="btn btn-sm btn-outline-primary ms-1"
                                    onclick="copyToClipboard('${d.nomor_rekening}')">
                                <i class="fas fa-copy"></i>
                            </button>
                            ` : ''}
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="detail-row">
                    <label class="detail-label text-muted small mb-1">Pemilik</label>
                    <div class="detail-value">
                        <input type="text" class="form-control form-control-sm"
                               value="${d.pemilik_rekening || '-'}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    `;
        }

        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('merchants.index') }}",
                columns: [{
                        className: 'td-expand',
                        orderable: false,
                        data: null,
                        defaultContent: '<i class="fas fa-chevron-right expand-icon"></i>',
                        width: '20px'
                    },
                    {
                        data: 'kode_merchant',
                        name: 'kode_merchant',
                        render: function(data) {
                            return `<span class="badge bg-primary">${data}</span>`;
                        }
                    },
                    {
                        data: 'nama_merchant',
                        name: 'nama_merchant'
                    },
                    {
                        data: 'logo',
                        name: 'logo',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<img src="${data}" alt="Logo" style="width:100px" />`;
                        }
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            switch (data) {
                                case 'approved':
                                    return '<span class="badge bg-success">Approved</span>';

                                case 'pending':
                                    return '<span class="badge bg-warning text-dark">Pending</span>';

                                case 'rejected':
                                    return '<span class="badge bg-danger">Rejected</span>';

                                case 'suspended':
                                    return '<span class="badge bg-secondary">Suspended</span>';

                                default:
                                    return '<span class="badge bg-light text-dark">Unknown</span>';
                            }
                        }
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                createdRow: function(row, data, dataIndex) {
                    // Set width untuk kolom pertama
                    $('td:eq(0)', row).addClass('td-expand');
                }
            });

            // Add event listener for opening and closing details
            $('#data-table tbody').on('click', 'td.td-expand', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var icon = $(this).find('.expand-icon');

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('expanded');
                    tr.removeClass('details');
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
                } else {
                    // Open this row - row child akan muncul DI BAWAH row
                    row.child(format(row.data())).show();
                    tr.addClass('expanded');
                    tr.addClass('details');
                    icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');

                    // Scroll ke row yang dibuka (opsional)
                    $('html, body').animate({
                        scrollTop: tr.offset().top - 100
                    }, 300);
                }
            });
        });

        // Fungsi untuk toggle show/hide API Key
        function toggletoken_qrin(id, token_qrin) {
            const element = document.getElementById(`token_qrin-${id}`);
            const button = event.currentTarget;
            const icon = button.querySelector('i');

            if (element.type === 'password') {
                // Show API Key
                element.type = 'text';
                element.value = token_qrin || '-';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-outline-danger');
                button.title = 'Hide';
            } else {
                // Hide API Key
                element.type = 'password';
                element.value = token_qrin ? '•'.repeat(32) : '-';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                button.classList.remove('btn-outline-danger');
                button.classList.add('btn-outline-secondary');
                button.title = 'Show';
            }
        }
    </script>

    <style>
        /* Hover effect untuk tombol */
        .toggle-btn:hover {
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }
    </style>
@endpush
