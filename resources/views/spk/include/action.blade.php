<td>
    @can('spk view')
        <a href="{{ route('spk.show', $spkId) }}" class="btn btn-light-success icon-btn b-r-4" type="button" title="Lihat">
            <i class="ti ti-eye text-success"></i>
        </a>
    @endcan
    @can('spk edit')
        <a href="{{ route('spk.edit', $spkId) }}" class="btn btn-light-primary icon-btn b-r-4" type="button" title="Edit">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan
    @can('spk delete')
        <form action="{{ route('spk.destroy', $spkId) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus SPK/PO ini?')">
            @csrf
            @method('delete')
            <button class="btn btn-light-danger icon-btn b-r-4" type="submit" title="Hapus">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
