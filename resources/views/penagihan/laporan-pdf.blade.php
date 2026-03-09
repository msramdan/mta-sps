<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Progress Penjualan - {{ $spk->no_spk }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10pt; line-height: 1.4; }
        h1 { font-size: 14pt; margin-bottom: 4px; }
        h2 { font-size: 11pt; margin: 12px 0 6px; border-bottom: 1px solid #333; padding-bottom: 2px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 9pt; }
        th, td { border: 1px solid #666; padding: 4px 6px; text-align: left; vertical-align: top; }
        th { background: #e0e0e0; font-weight: bold; }
        .header { text-align: center; margin-bottom: 15px; }
        .no-data { color: #888; font-style: italic; }
        .section { margin-bottom: 15px; }
        .footer { margin-top: 20px; font-size: 8pt; color: #666; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN LENGKAP PROGRESS PENJUALAN</h1>
        <p>SPK/PO: {{ $spk->no_spk }} | Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    {{-- 1. Kunjungan Sales --}}
    <div class="section">
        <h2>1. Kunjungan Sales</h2>
        @if($kunjungan)
            <table>
                <tr><th width="25%">Nama RS</th><td>{{ $kunjungan->nama_rs }}</td></tr>
                <tr><th>PIC / Contact Person</th><td>{{ $kunjungan->pic_rs }}</td></tr>
                <tr><th>Jabatan PIC</th><td>{{ $kunjungan->posisi_pic ?? '-' }}</td></tr>
                <tr><th>No. Telepon PIC</th><td>{{ $kunjungan->no_telp_pic }}</td></tr>
                <tr><th>Tanggal Kunjungan</th><td>{{ $kunjungan->tanggal_visit?->format('d/m/Y') }}</td></tr>
                <tr><th>Sales Marketing</th><td>{{ $kunjungan->user?->name ?? '-' }}</td></tr>
                @if($kunjungan->keterangan)
                <tr><th>Keterangan</th><td>{{ $kunjungan->keterangan }}</td></tr>
                @endif
            </table>
        @else
            <p class="no-data">Belum tersedia / Belum ter input</p>
        @endif
    </div>

    {{-- 2. SPH (Surat Penawaran Harga) --}}
    <div class="section">
        <h2>2. SPH (Surat Penawaran Harga)</h2>
        @if($sph)
            <table>
                <tr><th width="25%">No. SPH</th><td>{{ $sph->no_sph }}</td></tr>
                <tr><th>Tanggal SPH</th><td>{{ $sph->tanggal_sph?->format('d/m/Y') }}</td></tr>
                <tr><th>Sales (Info)</th><td>{{ $sph->user?->name ?? '-' }}</td></tr>
                @if($sph->keterangan)
                <tr><th>Keterangan</th><td>{{ $sph->keterangan }}</td></tr>
                @endif
            </table>
            @if($sph->details->isNotEmpty())
                <p><strong>Riwayat Revisi SPH:</strong></p>
                <table>
                    <thead><tr><th>Versi</th><th>Catatan Revisi</th><th>Tanggal</th></tr></thead>
                    <tbody>
                        @foreach($sph->details as $d)
                        <tr>
                            <td>{{ $d->version }}</td>
                            <td>{{ $d->catatan_revisi ?? '-' }}</td>
                            <td>{{ $d->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <p class="no-data">Belum tersedia / Belum ter input</p>
        @endif
    </div>

    {{-- 3. SPK / PO --}}
    <div class="section">
        <h2>3. SPK (Surat Perintah Kerja) / PO (Purchase Order)</h2>
        <table>
            <tr><th width="25%">No. SPK/PO</th><td>{{ $spk->no_spk }}</td></tr>
            <tr><th>Nilai Kontrak</th><td>Rp {{ number_format($spk->nilai_kontrak, 2, ',', '.') }}</td></tr>
            <tr><th>Include PPN</th><td>{{ $spk->include_ppn ? 'Ya' : 'Tidak' }}</td></tr>
            <tr><th>Jumlah Alat</th><td>{{ $spk->jumlah_alat }}</td></tr>
            <tr><th>Tanggal SPK</th><td>{{ $spk->tanggal_spk?->format('d/m/Y') }}</td></tr>
            <tr><th>Tanggal Deadline</th><td>{{ $spk->tanggal_deadline?->format('d/m/Y') ?? '-' }}</td></tr>
            @if($spk->keterangan)
            <tr><th>Keterangan</th><td>{{ $spk->keterangan }}</td></tr>
            @endif
        </table>
    </div>

    {{-- 4. Jadwal Teknisi --}}
    <div class="section">
        <h2>4. Jadwal Kalibrasi / Teknisi</h2>
        @if($jadwalList->isNotEmpty())
            @foreach($jadwalList as $j)
            <table>
                <tr><th width="25%">Judul</th><td>{{ $j->judul ?? '-' }}</td></tr>
                <tr><th>Tanggal Mulai</th><td>{{ $j->tanggal_mulai?->format('d/m/Y') }}</td></tr>
                <tr><th>Tanggal Selesai</th><td>{{ $j->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td></tr>
                <tr><th>Teknisi</th><td>{{ $j->teknisi->pluck('name')->implode(', ') ?: '-' }}</td></tr>
                @if($j->keterangan)
                <tr><th>Keterangan</th><td>{{ $j->keterangan }}</td></tr>
                @endif
            </table>
            @if($j->estimasiBiaya->isNotEmpty())
                <p><strong>Estimasi Biaya Operasional:</strong></p>
                <table>
                    <thead><tr><th>Keterangan</th><th>Estimasi Total</th></tr></thead>
                    <tbody>
                        @foreach($j->estimasiBiaya as $b)
                        <tr>
                            <td>{{ $b->keterangan_biaya }}</td>
                            <td style="text-align:right;">Rp {{ number_format($b->estimasi_total, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                        <tr><th>Total Estimasi</th><th style="text-align:right;">Rp {{ number_format($j->total_estimasi, 2, ',', '.') }}</th></tr>
                    </tbody>
                </table>
            @endif
            @endforeach
        @else
            <p class="no-data">Belum tersedia / Belum ter input</p>
        @endif
    </div>

    {{-- 5. Working - Progress Pekerjaan --}}
    <div class="section">
        <h2>5. Working / Progress Pekerjaan Teknisi</h2>
        @php
            $hasWorking = $jadwalList->contains(fn($j) => $j->workingProgress->isNotEmpty());
        @endphp
        @if($hasWorking)
            @foreach($jadwalList as $j)
                @if($j->workingProgress->isNotEmpty())
                <p><strong>Jadwal: {{ $j->judul ?? $j->spk?->no_spk ?? 'Jadwal' }}</strong> (Target: {{ $j->total_alat }} alat)</p>
                <table>
                    <thead><tr><th>Tanggal</th><th>Jumlah Selesai</th><th>Progress</th><th>Keterangan</th></tr></thead>
                    <tbody>
                        @php $acc = 0; @endphp
                        @foreach($j->workingProgress as $w)
                            @php $acc += $w->jumlah_selesai; $pct = $j->total_alat > 0 ? round(($acc / $j->total_alat) * 100, 1) : 0; @endphp
                            <tr>
                                <td>{{ $w->tanggal?->format('d/m/Y') }}</td>
                                <td>{{ $w->jumlah_selesai }}</td>
                                <td>{{ min(100, $pct) }}%</td>
                                <td>{{ $w->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                        <tr><th colspan="2">Total Selesai</th><th colspan="2">{{ $acc }} / {{ $j->total_alat }} alat</th></tr>
                    </tbody>
                </table>
                @endif
            @endforeach
        @else
            <p class="no-data">Belum tersedia / Belum ter input</p>
        @endif
    </div>

    {{-- 6. Proses Penagihan --}}
    <div class="section">
        <h2>6. Proses Penagihan</h2>
        <table>
            <tr><th width="25%">Status Pembayaran</th><td>{{ $penagihan->status_label }}</td></tr>
            @if($penagihan->keterangan)
            <tr><th>Keterangan</th><td>{{ $penagihan->keterangan }}</td></tr>
            @endif
        </table>
        @if($penagihan->dokumen->isNotEmpty())
            <p><strong>Checklist Dokumen Tagihan:</strong></p>
            <table>
                <thead><tr><th>Jenis Dokumen</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($penagihan->dokumen as $d)
                    <tr>
                        <td>{{ $d->label }}</td>
                        <td>{{ $d->is_checked ? 'Lengkap' : 'Belum' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if($penagihan->fee->where('nominal', '>', 0)->isNotEmpty())
            <p><strong>Pengeluaran Operational Khusus (Fee):</strong></p>
            <table>
                <thead><tr><th>Keterangan</th><th>Nominal</th></tr></thead>
                <tbody>
                    @foreach($penagihan->fee->where('nominal', '>', 0) as $f)
                    <tr>
                        <td>{{ $f->keterangan ?? '-' }}</td>
                        <td style="text-align:right;">Rp {{ number_format($f->nominal, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    <tr><th>Total Fee</th><th style="text-align:right;">Rp {{ number_format($penagihan->total_fee, 2, ',', '.') }}</th></tr>
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak otomatis dari sistem Marketrax - Progress Penjualan</p>
    </div>
</body>
</html>
