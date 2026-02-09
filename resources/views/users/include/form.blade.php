<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="name" class="form-label">{{ __(key: 'Name') }}</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="{{ __(key: 'Name') }}" value="{{ isset($user) ? $user->name : old(key: 'name') }}" required
                autofocus>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="email" class="form-label">{{ __(key: 'Email') }}</label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror" placeholder="{{ __(key: 'Email') }}"
                value="{{ isset($user) ? $user->email : old(key: 'email') }}" required>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="password" class="form-label">{{ __(key: 'Password') }}</label>
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="{{ __(key: 'Password') }}"
                {{ empty($user) ? 'required' : '' }}>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            @isset($user)
                <div id="passwordHelpBlock" class="form-text">
                    {{ __(key: 'Leave the password & password confirmation blank if you don`t want to change them.') }}
                </div>
            @endisset
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="password-confirmation" class="form-label">{{ __(key: 'Password Confirmation') }}</label>
            <input type="password" name="password_confirmation" id="password-confirmation" class="form-control"
                placeholder="{{ __(key: 'Password Confirmation') }}" {{ empty($user) ? 'required' : '' }}>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="role" class="form-label">{{ __(key: 'Role') }}</label>
            <select class="form-select @error('role') is-invalid @enderror" name="role" id="role" required>
                <option value="" selected disabled>{{ __(key: '-- Select role --') }}</option>
                @foreach ($roles as $role)
                    @isset($user)
                        <option value="{{ $role->id }}"
                            {{ $user->getRoleNames()->toArray() !== [] && $user->getRoleNames()[0] == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}</option>
                    @else
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endisset
                @endforeach
            </select>
            @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="row g-0">
            <div class="col-md-5 text-center">
                <img src="{{ $user?->avatar ?? 'https://placehold.co/300?text=No+Image+Available' }}" alt="Avatar"
                    class="rounded img-fluid" style="object-fit: cover; width: 100%; height: 100px;" />
            </div>
            <div class="col-md-7">
                <div class="form-group ms-3">
                    <label for="avatar" class="form-label">{{ __(key: 'Avatar') }}</label>
                    <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                        id="avatar">
                    @error('avatar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    @isset($user)
                        <div id="avatar-help-block" class="form-text">
                            {{ __(key: 'Leave the avatar blank if you don`t want to change it.') }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <!-- Merchant Assignment Section -->
    @if(isset($merchants) && count($merchants) > 0)
    <div class="col-12 mb-4">
        <h5 class="mb-3 border-bottom pb-2">{{ __(key: 'Assign Merchant') }}</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="selectAllMerchants">
                    <label class="form-check-label fw-bold" for="selectAllMerchants">
                        {{ __(key: 'Select All Merchants') }}
                    </label>
                </div>

                <div class="row" id="merchantList">
                    @foreach($merchants as $merchant)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input merchant-checkbox"
                                   type="checkbox"
                                   name="merchants[]"
                                   value="{{ $merchant->id }}"
                                   id="merchant{{ $merchant->id }}"
                                   {{ (isset($assignedMerchantIds) && in_array($merchant->id, $assignedMerchantIds)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="merchant{{ $merchant->id }}">
                                {{ $merchant->nama_merchant }}
                                <span class="text-muted small">
                                    ({{ $merchant->is_active == 'Yes' ? __(key: 'Active') : __(key: 'Inactive') }})
                                </span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('js')
<script>
    // Select All Merchants functionality
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllMerchants');
        const merchantCheckboxes = document.querySelectorAll('.merchant-checkbox');

        if (selectAllCheckbox && merchantCheckboxes.length > 0) {
            // Initialize Select All checkbox state on page load
            const allChecked = Array.from(merchantCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(merchantCheckboxes).some(cb => cb.checked);

            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;

            // Select All event
            selectAllCheckbox.addEventListener('change', function() {
                merchantCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                this.indeterminate = false;
            });

            // Update Select All checkbox when individual checkboxes change
            merchantCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(merchantCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(merchantCheckboxes).some(cb => cb.checked);

                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                });
            });
        }
    });
</script>
@endpush
