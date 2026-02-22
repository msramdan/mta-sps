<td>
    <a href="{{ route('log-query-payment-status.show', $model->id) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
        title="Lihat Detail">
        <i class="ti ti-eye text-success"></i>
    </a>
    @can('log query payment status delete')
        <form action="{{ route('log-query-payment-status.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin hapus log ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
