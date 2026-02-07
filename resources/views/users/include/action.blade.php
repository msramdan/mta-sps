<td>
    <a href="{{ route('users.show', $model->id) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
        title="View Details">
        <i class="ti ti-eye text-success"></i>
    </a>

    @can('user edit')
        <a href="{{ route('users.edit', $model->id) }}" class="btn btn-light-primary icon-btn b-r-4" type="button"
            title="Edit User">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan

    @can('user delete')
        <form action="{{ route('users.destroy', $model->id) }}" method="post" class="d-inline">
            @csrf
            @method('delete')

            <button type="submit" class="btn btn-light-danger icon-btn b-r-4" title="Delete"
                onclick="return confirm('Are you sure to delete this record?')">
                <i class="ti ti-trash text-danger"></i>
            </button>
        </form>
    @endcan
</td>
