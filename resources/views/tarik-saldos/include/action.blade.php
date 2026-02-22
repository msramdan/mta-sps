<td>
    @can('tarik saldo view')
        <a href="{{ route('tarik-saldos.show', $model->id) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
            title="Lihat Detail">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan

    @if(($model->status ?? '') === 'pending')
        @can('konfirmasi tarik saldo')
            <button type="button" class="btn btn-light-info icon-btn b-r-4 btn-status-withdrawal" data-id="{{ $model->id }}" title="Proses / Tolak">
                <i class="ti ti-arrow-right text-info"></i>
            </button>
        @endcan
    @endif

    @if(($model->status ?? '') === 'process')
        @can('konfirmasi tarik saldo')
            <button type="button" class="btn btn-light-primary icon-btn b-r-4 btn-confirm-withdrawal" data-id="{{ $model->id }}" title="Konfirmasi Selesai (Upload Bukti + Catatan)">
                <i class="ti ti-check text-primary"></i>
            </button>
        @endcan
    @endif

    @if(($model->status ?? '') === 'pending')
        @can('batalkan tarik saldo')
            <button type="button" class="btn btn-light-danger icon-btn b-r-4 btn-cancel-withdrawal" data-id="{{ $model->id }}" title="Batalkan Pengajuan">
                <i class="ti ti-x text-danger"></i>
            </button>
        @endcan
    @endif
</td>
