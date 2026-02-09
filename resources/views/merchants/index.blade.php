@extends('layouts.app')

@section('title', 'Merchants')

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">Merchants</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">Merchants</a>
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
                                            <th></th>
                                            <th>Nama Merchant</th>
                                            <th>Logo</th>
                                            <th>Status Aktif</th>
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

@push('css')
<style>
    tr.details td {
        background-color: #f8f9fa;
        border-top: 0;
    }

    tr.details .detail-content {
        padding: 20px;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }

    .detail-section {
        margin-bottom: 20px;
    }

    .detail-section h6 {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 8px;
        margin-bottom: 15px;
        color: #495057;
    }

    .detail-row {
        display: flex;
        margin-bottom: 8px;
    }

    .detail-label {
        flex: 0 0 200px;
        font-weight: 500;
        color: #6c757d;
    }

    .detail-value {
        flex: 1;
        color: #212529;
    }

    .td-expand {
        text-align: center;
        cursor: pointer;
    }

    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 5px;
        overflow: hidden;
    }

    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .expand-icon {
        transition: transform 0.3s;
    }

    .expanded .expand-icon {
        transform: rotate(90deg);
    }
</style>
@endpush

@push('js')
<script>
    function format(d) {
        return `
            <div class="detail-content">
                <div class="detail-section">
                    <h6>Kredensial API</h6>
                    <div class="detail-row">
                        <div class="detail-label">URL Callback:</div>
                        <div class="detail-value">${d.url_callback}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">API Key:</div>
                        <div class="detail-value">
                            <span id="apiKey-${d.id}">${'•'.repeat(32)}</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleApiKey('${d.id}', '${d.apikey}')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Secret Key:</div>
                        <div class="detail-value">
                            <span id="secretKey-${d.id}">${'•'.repeat(32)}</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="toggleSecretKey('${d.id}', '${d.secretkey}')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h6>Informasi Bank Penarikan</h6>
                    <div class="detail-row">
                        <div class="detail-label">Bank:</div>
                        <div class="detail-value">${d.bank ? d.bank.nama_bank : '-'}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Pemilik Rekening:</div>
                        <div class="detail-value">${d.pemilik_rekening}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Nomor Rekening:</div>
                        <div class="detail-value">${d.nomor_rekening}</div>
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
            columns: [
                {
                    className: 'td-expand',
                    orderable: false,
                    data: null,
                    defaultContent: '<i class="fas fa-chevron-right expand-icon"></i>',
                    width: '50px'
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
                    data: 'is_active',
                    name: 'is_active',
                    render: function(data) {
                        if (data === 'Yes') {
                            return '<span class="badge bg-success">Aktif</span>';
                        } else {
                            return '<span class="badge bg-danger">Tidak Aktif</span>';
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
            order: [[1, 'asc']]
        });

        // Add event listener for opening and closing details
        $('#data-table tbody').on('click', 'td.td-expand', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            var icon = $(this).find('.expand-icon');

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('expanded');
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('expanded');
                icon.removeClass('fa-chevron-right').addClass('fa-chevron-down');
            }
        });
    });

    // Fungsi untuk toggle show/hide API Key
    function toggleApiKey(id, apiKey) {
        const element = document.getElementById(`apiKey-${id}`);
        const button = event.currentTarget;
        const icon = button.querySelector('i');

        if (element.textContent.includes('•')) {
            // Show API Key
            element.textContent = apiKey;
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-outline-danger');
        } else {
            // Hide API Key
            element.textContent = '•'.repeat(32);
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            button.classList.remove('btn-outline-danger');
            button.classList.add('btn-outline-secondary');
        }
    }

    // Fungsi untuk toggle show/hide Secret Key
    function toggleSecretKey(id, secretKey) {
        const element = document.getElementById(`secretKey-${id}`);
        const button = event.currentTarget;
        const icon = button.querySelector('i');

        if (element.textContent.includes('•')) {
            // Show Secret Key
            element.textContent = secretKey;
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-outline-danger');
        } else {
            // Hide Secret Key
            element.textContent = '•'.repeat(32);
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            button.classList.remove('btn-outline-danger');
            button.classList.add('btn-outline-secondary');
        }
    }
</script>
@endpush
