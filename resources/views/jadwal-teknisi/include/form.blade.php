<div class="row mb-2">
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="judul" class="form-label">{{ __('Judul Jadwal') }}</label>
            <input type="text" name="judul" id="judul"
                   class="form-control @error('judul') is-invalid @enderror"
                   value="{{ old('judul', $jadwal->judul ?? '') }}">
            @error('judul')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="form-group">
            <label for="tanggal_mulai" class="form-label">{{ __('Tanggal Mulai') }} <span class="text-danger">*</span></label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                   class="form-control @error('tanggal_mulai') is-invalid @enderror"
                   value="{{ old('tanggal_mulai', isset($jadwal) ? $jadwal->tanggal_mulai?->format('Y-m-d') : '') }}" required>
            @error('tanggal_mulai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="form-group">
            <label for="tanggal_selesai" class="form-label">{{ __('Tanggal Selesai') }}</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                   class="form-control @error('tanggal_selesai') is-invalid @enderror"
                   value="{{ old('tanggal_selesai', isset($jadwal) ? $jadwal->tanggal_selesai?->format('Y-m-d') : '') }}">
            @error('tanggal_selesai')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-group">
            <label for="teknisi_ids" class="form-label">{{ __('Teknisi') }} <span class="text-danger">*</span></label>
            <select name="teknisi_ids[]" id="teknisi_ids"
                    class="form-select @error('teknisi_ids') is-invalid @enderror" multiple required>
                @php
                    $selectedTeknisi = old('teknisi_ids', isset($jadwal) ? $jadwal->teknisi->pluck('id')->all() : []);
                @endphp
                @foreach($teknisi as $t)
                    <option value="{{ $t->id }}" {{ in_array($t->id, $selectedTeknisi, true) ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>
            <div class="form-text">Tekan Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu teknisi.</div>
            @error('teknisi_ids')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12 mb-3">
        <div class="form-group">
            <label for="keterangan" class="form-label">{{ __('Keterangan Jadwal') }}</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $jadwal->keterangan ?? '') }}</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-12 mb-2">
        <label class="form-label">{{ __('Estimasi Biaya') }}</label>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="biaya-table">
                <thead>
                    <tr>
                        <th style="width: 60%;">{{ __('Keterangan Biaya') }}</th>
                        <th style="width: 30%;">{{ __('Estimasi Total') }}</th>
                        <th style="width: 10%;">{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $oldBiaya = old('biaya', isset($jadwal) ? $jadwal->estimasiBiaya->map(fn ($b) => [
                            'keterangan_biaya' => $b->keterangan_biaya,
                            'estimasi_total' => $b->estimasi_total,
                        ])->toArray() : [[]]);
                    @endphp
                    @foreach($oldBiaya as $index => $row)
                        <tr>
                            <td>
                                <input type="text"
                                       name="biaya[{{ $index }}][keterangan_biaya]"
                                       class="form-control"
                                       value="{{ $row['keterangan_biaya'] ?? '' }}"
                                       placeholder="Contoh: Tiket pesawat PP">
                            </td>
                            <td>
                                <input type="number"
                                       step="0.01"
                                       min="0"
                                       name="biaya[{{ $index }}][estimasi_total]"
                                       class="form-control text-end"
                                       value="{{ $row['estimasi_total'] ?? '' }}"
                                       placeholder="0">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-light-danger icon-btn b-r-4 btn-remove-row">
                                    <i class="ti ti-trash text-danger"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-light-primary btn-sm" id="btn-add-biaya">
            <i class="ti ti-plus"></i> {{ __('Tambah Baris Biaya') }}
        </button>
    </div>
</div>

@push('js')
<script>
    (function() {
        const tableBody = document.querySelector('#biaya-table tbody');
        const addButton = document.getElementById('btn-add-biaya');

        function addRow(keterangan = '', total = '') {
            const index = tableBody.children.length;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <input type="text" name="biaya[${index}][keterangan_biaya]" class="form-control"
                           value="${keterangan}" placeholder="Contoh: Tiket pesawat PP">
                </td>
                <td>
                    <input type="number" step="0.01" min="0" name="biaya[${index}][estimasi_total]"
                           class="form-control text-end" value="${total}" placeholder="0">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-light-danger icon-btn b-r-4 btn-remove-row">
                        <i class="ti ti-trash text-danger"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        }

        addButton?.addEventListener('click', function () {
            addRow();
        });

        tableBody?.addEventListener('click', function (e) {
            if (e.target.closest('.btn-remove-row')) {
                const rows = tableBody.querySelectorAll('tr');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                }
            }
        });

        if (tableBody && tableBody.children.length === 0) {
            addRow();
        }
    })();
</script>
@endpush

