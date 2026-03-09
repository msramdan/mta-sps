<td>
    <a href="{{ route('roles.show', $model->id) }}" class="btn btn-light-success icon-btn b-r-4" type="button"
        title="View Details">
        <i class="ti ti-eye text-success"></i>
    </a>

    @can('role & permission edit')
        <a href="{{ route('roles.edit', $model->id) }}" class="btn btn-light-primary icon-btn b-r-4" type="button"
            title="Edit Role">
            <i class="ti ti-edit text-primary"></i>
        </a>
    @endcan

    {{-- Delete role disembunyikan - role tetap (fixed) --}}
</td>
