<td>
    @can('sph view')
        <a href="{{ route('sph.show', $sphId) }}" class="btn btn-light-success icon-btn b-r-4" type="button" title="Lihat">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan
    @can('sph edit')
        <a href="{{ route('sph.revision', $sphId) }}" class="btn btn-light-primary icon-btn b-r-4" type="button" title="Revisi">
            <i class="ti ti-upload text-primary"></i>
        </a>
    @endcan
    @can('sph delete')
        <form action="{{ route('sph.destroy', $sphId) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus SPH ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
