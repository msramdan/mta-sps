<td>
    @can('transaksi view')
        <a href="{{ route('transaksis.show', $model->id) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
            title="Lihat Detail">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan

    @can('transaksi edit')
        <a href="{{ route('transaksis.edit', $model->id) }}" class="btn btn-light-primary icon-btn b-r-4" type="button"
            title="Edit">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan

    @can('transaksi delete')
        <form action="{{ route('transaksis.destroy', $model->id) }}" method="post" class="d-inline">
            @csrf
            @method('delete')

            <button type="submit" class="btn btn-light-danger icon-btn b-r-4" title="Hapus"
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
