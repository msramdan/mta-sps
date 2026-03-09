@extends('layouts.app')

@section('title', __('Jadwal Teknisi'))

@push('css')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
<style>
/* Sabtu & Minggu - background merah */
#jadwal-calendar .fc-daygrid-day.fc-day-sat,
#jadwal-calendar .fc-daygrid-day.fc-day-sun,
#jadwal-calendar .fc-col-header-cell.fc-day-sat,
#jadwal-calendar .fc-col-header-cell.fc-day-sun {
    background-color: rgba(220, 53, 69, 0.15) !important;
}

/* Dark mode - FullCalendar */
body.dark #jadwal-calendar .fc {
    --fc-border-color: rgba(255, 255, 255, 0.12);
    --fc-button-bg-color: rgba(255, 255, 255, 0.08);
    --fc-button-border-color: rgba(255, 255, 255, 0.2);
    --fc-button-hover-bg-color: rgba(255, 255, 255, 0.15);
    --fc-button-hover-border-color: rgba(255, 255, 255, 0.3);
    --fc-button-active-bg-color: rgba(255, 255, 255, 0.2);
    --fc-today-bg-color: rgba(255, 193, 7, 0.15);
    --fc-page-bg-color: transparent;
    --fc-neutral-bg-color: rgba(255, 255, 255, 0.03);
}
body.dark #jadwal-calendar .fc-scrollgrid,
body.dark #jadwal-calendar .fc-theme-standard td,
body.dark #jadwal-calendar .fc-theme-standard th {
    border-color: rgba(255, 255, 255, 0.12) !important;
}
body.dark #jadwal-calendar .fc-col-header-cell,
body.dark #jadwal-calendar .fc-daygrid-day-number,
body.dark #jadwal-calendar .fc-event-title {
    color: rgba(var(--dark), 1) !important;
}
body.dark #jadwal-calendar .fc-daygrid-day.fc-day-sat,
body.dark #jadwal-calendar .fc-daygrid-day.fc-day-sun,
body.dark #jadwal-calendar .fc-col-header-cell.fc-day-sat,
body.dark #jadwal-calendar .fc-col-header-cell.fc-day-sun {
    background-color: rgba(220, 53, 69, 0.25) !important;
}
body.dark #view-calendar .card {
    background-color: rgba(var(--white), 0.03);
    border-color: rgba(255, 255, 255, 0.08);
}

/* Popup detail - dark mode */
body.dark .swal-dark-popup {
    background-color: #24272d !important;
}
body.dark .swal-dark-popup .swal2-html-container {
    color: rgba(234, 234, 236, 0.95) !important;
}

/* Mobile - layout rapi */
@media (max-width: 767.98px) {
    .jadwal-header-actions {
        flex-direction: column !important;
        align-items: stretch !important;
    }
    .jadwal-header-actions .btn-group {
        width: 100%;
    }
    .jadwal-header-actions .btn-group .btn {
        flex: 1;
    }
    .jadwal-header-actions .btn-primary {
        width: 100%;
    }
    #jadwal-calendar .fc-toolbar {
        flex-direction: column;
        gap: 0.5rem;
    }
    #jadwal-calendar .fc-toolbar-title {
        font-size: 1rem !important;
        text-align: center;
    }
    #jadwal-calendar .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    #jadwal-calendar .fc-button {
        padding: 0.35rem 0.5rem;
        font-size: 0.8rem;
    }
    #jadwal-calendar .fc-daygrid-day-number {
        font-size: 0.75rem;
        padding: 2px 4px;
    }
    #jadwal-calendar .fc-event-title {
        font-size: 0.65rem;
    }
    #jadwal-calendar .fc-scrollgrid-sync-table {
        font-size: 0.7rem;
    }
    #view-calendar .card-body {
        padding: 0.5rem;
    }
    .main-title { font-size: 1.1rem; }
    .app-line-breadcrumbs { font-size: 0.8rem; }
}
@media (max-width: 575.98px) {
    .row.m-1 { margin: 0.25rem !important; }
}
</style>
@endpush

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Jadwal Teknisi') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Jadwal Teknisi') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 jadwal-header-actions">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" id="btn-view-list" data-view="list">
                        <i class="ti ti-list me-1"></i>{{ __('Tabel') }}
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="btn-view-calendar" data-view="calendar">
                        <i class="ti ti-calendar me-1"></i>{{ __('Kalender') }}
                    </button>
                </div>
                @can('jadwal teknisi create')
                    <a href="{{ route('jadwal-teknisi.create') }}" class="btn btn-primary">
                        <i class="ti ti-plus"></i> {{ __('Tambah') }}
                    </a>
                @endcan
            </div>

            <div id="view-list" class="view-container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="app-datatable-default overflow-auto">
                                    <table class="display w-100 row-border-table table-responsive" id="data-table">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>SPK/PO</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>Teknisi</th>
                                                <th>Total Estimasi</th>
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

            <div id="view-calendar" class="view-container d-none">
                <div class="card">
                    <div class="card-body">
                        <div id="jadwal-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/locales/id.global.min.js"></script>
<script>
(function() {
    const eventsUrl = "{{ route('jadwal-teknisi.events') }}";
    const btnList = document.getElementById('btn-view-list');
    const btnCalendar = document.getElementById('btn-view-calendar');
    const viewList = document.getElementById('view-list');
    const viewCalendar = document.getElementById('view-calendar');
    let calendarInitialized = false;
    let calendarInstance = null;

    function switchView(view) {
        const isList = view === 'list';
        viewList.classList.toggle('d-none', !isList);
        viewCalendar.classList.toggle('d-none', isList);
        btnList.classList.toggle('active', isList);
        btnCalendar.classList.toggle('active', !isList);
        if (view === 'calendar' && !calendarInitialized) {
            initCalendar();
            calendarInitialized = true;
        }
    }

    function initCalendar() {
        const calendarEl = document.getElementById('jadwal-calendar');
        if (!calendarEl) return;
        calendarInstance = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu'
            },
            events: eventsUrl,
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                var p = info.event.extendedProps || {};
                var html = '<div class="text-start small">' +
                    '<p class="mb-1"><strong>Judul:</strong> ' + (p.judul || '-') + '</p>' +
                    '<p class="mb-1"><strong>SPK/PO:</strong> ' + (p.spk_no || '-') + '</p>' +
                    '<p class="mb-1"><strong>Tanggal Mulai:</strong> ' + (p.tanggal_mulai || '-') + '</p>' +
                    '<p class="mb-1"><strong>Tanggal Selesai:</strong> ' + (p.tanggal_selesai || '-') + '</p>' +
                    '<p class="mb-1"><strong>Teknisi:</strong> ' + (p.teknisi || '-') + '</p>' +
                    '<p class="mb-1"><strong>Total Estimasi:</strong> Rp ' + (p.total_estimasi || '0') + '</p>' +
                    '<p class="mb-0"><strong>Keterangan:</strong> ' + (p.keterangan || '-') + '</p>' +
                    '</div>';
                var isDark = document.body.classList.contains('dark');
                Swal.fire({
                    title: 'Detail Jadwal',
                    html: html,
                    width: Math.min(420, window.innerWidth - 32),
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Lihat Detail Lengkap',
                    cancelButtonText: 'Tutup',
                    customClass: isDark ? { popup: 'swal-dark-popup', title: 'text-white', htmlContainer: 'text-white' } : {}
                }).then(function(result) {
                    if (result.isConfirmed && info.event.url) {
                        window.location.href = info.event.url;
                    }
                });
            },
            height: 'auto'
        });
        calendarInstance.render();
    }

    btnList?.addEventListener('click', function() { switchView('list'); });
    btnCalendar?.addEventListener('click', function() { switchView('calendar'); });

    $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('jadwal-teknisi.index') }}",
        columns: [
            { data: 'judul', name: 'judul' },
            { data: 'spk_no', name: 'spk.no_spk' },
            { data: 'tanggal_mulai_formatted', name: 'tanggal_mulai' },
            { data: 'tanggal_selesai_formatted', name: 'tanggal_selesai' },
            { data: 'teknisi_names', name: 'teknisi.name', orderable: false },
            { data: 'total_estimasi', name: 'total_estimasi', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
})();
</script>
@endpush
