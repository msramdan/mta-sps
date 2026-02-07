<div class="row mb-4">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name" class="form-label">{{ __(key: 'Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="{{ __(key: 'Name') }}" value="{{ isset($role) ? $role->name : old(key: 'name') }}" autofocus required>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <label class="form-label mb-2">{{ __(key: 'Permissions') }}</label>
        @error('permissions')
            <div class="alert alert-danger mb-3">
                {{ $message }}
            </div>
        @enderror
    </div>

    @foreach(config(key: 'permission.permissions') as $permission)
        <div class="col-md-3 mb-3">
            <div class="card border h-100">
                <div class="card-content">
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-3">{{ ucwords(string: $permission['group']) }}</h6>
                        @foreach ($permission['access'] as $access)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="{{ str()->slug($access) }}"
                                    name="permissions[]" value="{{ $access }}"
                                    {{ isset($role) && $role->hasPermissionTo($access) ? 'checked' : '' }}/>
                                <label class="form-check-label" for="{{ str()->slug($access) }}">
                                    {{ ucwords(string: __(key: $access)) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
