@extends('layouts.app')

@section('title', __('Activity Log'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Activity Log') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Activity Log') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('activity-logs.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label">{{ __('Tanggal Dari') }}</label>
                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from', $defaultDateFrom) }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('Tanggal Sampai') }}</label>
                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to', $defaultDateTo) }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('Log Name') }}</label>
                            <select name="log_name" class="form-select">
                                <option value="">{{ __('Semua') }}</option>
                                @foreach ($logNames as $name)
                                    <option value="{{ $name }}" {{ request('log_name') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('Deskripsi') }}</label>
                            <input type="text" name="description" class="form-control" placeholder="Cari deskripsi" value="{{ request('description') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-filter"></i> {{ __('Filter') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('activity log delete')
                        <div class="card-body border-bottom py-2">
                            <button type="button" id="btn-bulk-delete-log" class="btn btn-danger btn-sm" data-url="{{ route('activity-logs.bulk-destroy') }}" title="{{ __('Hapus data terpilih') }}">
                                <i class="ti ti-trash"></i> {{ __('Hapus terpilih') }}
                            </button>
                            <button type="button" id="btn-truncate-log" class="btn btn-outline-danger btn-sm ms-1" data-url="{{ route('activity-logs.truncate') }}" data-name="Activity Log" title="{{ __('Kosongkan semua data log') }}">
                                <i class="ti ti-trash-off"></i> {{ __('Truncate data') }}
                            </button>
                        </div>
                        @endcan
                        <div class="card-body p-0">
                            <div class="app-datatable-default overflow-auto">
                                <table class="display w-100 row-border-table table-responsive" id="data-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px;">
                                                <input type="checkbox" id="log-select-all" class="form-check-input" title="{{ __('Pilih semua') }}">
                                            </th>
                                            <th>{{ __('Tanggal') }}</th>
                                            <th>{{ __('Deskripsi') }}</th>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('Subject') }}</th>
                                            <th>{{ __('Event') }}</th>
                                            <th>{{ __('Log Name') }}</th>
                                            <th>{{ __('Action') }}</th>
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

@push('scripts')
<script>
    var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('activity-logs.index') }}",
            data: function(d) {
                d.date_from = $('input[name="date_from"]').val();
                d.date_to = $('input[name="date_to"]').val();
                d.log_name = $('select[name="log_name"]').val();
                d.description = $('input[name="description"]').val();
            }
        },
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false, className: 'text-center' },
            { data: 'created_at', name: 'created_at' },
            { data: 'description', name: 'description' },
            { data: 'causer_id', name: 'causer_id', orderable: false },
            { data: 'subject_type', name: 'subject_type' },
            { data: 'event', name: 'event', orderable: false },
            { data: 'log_name', name: 'log_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'desc']]
    });

    $('#log-select-all').on('change', function() {
        var checked = this.checked;
        $('#data-table').find('.log-row-checkbox').each(function() {
            this.checked = checked;
        });
    });

    $(document).on('click', '#btn-bulk-delete-log', function() {
        var ids = [];
        $('#data-table').find('.log-row-checkbox:checked').each(function() {
            ids.push($(this).val());
        });
        if (ids.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Pilih minimal satu data untuk dihapus.'
            });
            return;
        }
        var url = $(this).data('url');
        Swal.fire({
            icon: 'warning',
            title: 'Yakin hapus?',
            text: 'Sebanyak ' + ids.length + ' log akan dihapus. Tindakan ini tidak dapat dibatalkan.',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33'
        }).then(function(result) {
            if (result.isConfirmed) {
                var form = $('<form>').attr({ method: 'POST', action: url }).css('display', 'none');
                form.append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }));
                ids.forEach(function(id) {
                    form.append($('<input>').attr({ type: 'hidden', name: 'ids[]', value: id }));
                });
                $('body').append(form);
                form.submit();
            }
        });
    });

    $(document).on('click', '#btn-truncate-log', function() {
        var url = $(this).data('url');
        var name = $(this).data('name');
        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi',
            text: 'Apakah anda benar ingin hapus/mengosongkan data log ' + name + '? Semua data akan terhapus dan tidak dapat dikembalikan.',
            showCancelButton: true,
            confirmButtonText: 'Ya, kosongkan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33'
        }).then(function(result) {
            if (result.isConfirmed) {
                var form = $('<form>').attr({ method: 'POST', action: url }).css('display', 'none');
                form.append($('<input>').attr({ type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }));
                $('body').append(form);
                form.submit();
            }
        });
    });

    $(document).on('submit', '.form-delete-log-single', function(e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            icon: 'warning',
            title: 'Yakin hapus?',
            text: 'Log ini akan dihapus.',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33'
        }).then(function(result) {
            if (result.isConfirmed) form.submit();
        });
        return false;
    });
</script>
@endpush
