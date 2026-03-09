<td>
    @can('kunjungan sales view')
        <a href="{{ route('kunjungan-sales.show', $kunjunganSaleId) }}" class="btn btn-light-success icon-btn b-r-4" type="button" title="Lihat">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan
    @can('kunjungan sales edit')
        <a href="{{ route('kunjungan-sales.edit', $kunjunganSaleId) }}" class="btn btn-light-primary icon-btn b-r-4" type="button" title="Edit">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan
    @can('kunjungan sales delete')
        <form action="{{ route('kunjungan-sales.destroy', $kunjunganSaleId) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data kunjungan ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
