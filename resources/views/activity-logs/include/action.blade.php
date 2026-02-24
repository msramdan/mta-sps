<td>
    <a href="{{ route('activity-logs.show', $model) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
        title="Lihat Detail">
        <i class="ti ti-eye text-success"></i>
    </a>
    @can('activity log delete')
        <form action="{{ route('activity-logs.destroy', $model) }}" method="post" class="d-inline form-delete-log-single">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
