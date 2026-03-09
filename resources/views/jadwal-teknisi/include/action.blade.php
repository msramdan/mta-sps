<td>
    @can('jadwal teknisi view')
        <a href="{{ route('jadwal-teknisi.show', $jadwalId) }}"
           class="btn btn-light-success icon-btn b-r-4"
           type="button"
           title="Lihat">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan
    @can('jadwal teknisi edit')
        <a href="{{ route('jadwal-teknisi.edit', $jadwalId) }}"
           class="btn btn-light-primary icon-btn b-r-4"
           type="button"
           title="Edit">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan
    @can('jadwal teknisi delete')
        <form action="{{ route('jadwal-teknisi.destroy', $jadwalId) }}" method="post" class="d-inline"
              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>

