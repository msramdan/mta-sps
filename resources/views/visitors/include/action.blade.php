<td>
    @can('visitor view')
        <a href="{{ route('visitors.show', $visitorId) }}" class="btn btn-light-success icon-btn b-r-4" type="button" title="Lihat">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan
    @can('visitor edit')
        <a href="{{ route('visitors.edit', $visitorId) }}" class="btn btn-light-primary icon-btn b-r-4" type="button" title="Edit">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan
    @can('visitor delete')
        <form action="{{ route('visitors.destroy', $visitorId) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data kunjungan ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
