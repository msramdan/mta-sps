<div class="modal fade" id="uploadModal{{ $d->id }}" tabindex="-1" aria-labelledby="uploadModalLabel{{ $d->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel{{ $d->id }}">{{ __('Upload') }}: {{ $d->label }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('penagihan.upload', [$penagihan, $d->jenis_dokumen]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_{{ $d->id }}" class="form-label">{{ __('Pilih File') }} <span class="text-danger">*</span></label>
                        <input type="file" name="file" id="file_{{ $d->id }}" class="form-control @error('file') is-invalid @enderror"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required>
                        <div class="form-text">PDF, DOC, DOCX, XLS, XLSX, JPG, PNG. Maks 10MB.</div>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Batal') }}</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-upload me-1"></i>{{ __('Upload') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
