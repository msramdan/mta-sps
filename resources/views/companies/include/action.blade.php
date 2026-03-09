<td>
    @can('company view')
        <a href="{{ route('companies.show', $model->id) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
            title="Lihat">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan

    @can('company edit')
        <a href="{{ route('companies.edit', $model->id) }}" class="btn btn-light-primary icon-btn b-r-4" type="button"
            title="Edit">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan

    @can('company delete')
        <form action="{{ route('companies.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus perusahaan ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
