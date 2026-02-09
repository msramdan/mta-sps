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
                                            <th style="width: 50px;"></th>
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
            order: [[1, 'asc']],
            createdRow: function(row, data, dataIndex) {
                // Set width untuk kolom pertama
                $('td:eq(0)', row).addClass('td-expand');
            }
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
