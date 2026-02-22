<td>
    <a href="{{ route('log-callbacks.show', $model->id) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
        title="Lihat Detail">
        <i class="ti ti-eye text-success"></i>
    </a>
    @can('log callback delete')
        <form action="{{ route('log-callbacks.destroy', $model->id) }}" method="post" class="d-inline form-delete-log-single">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
