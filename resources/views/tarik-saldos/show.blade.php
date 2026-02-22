@extends('layouts.app')

@section('title', __(key: 'Detail Tarik Saldo'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Tarik Saldo') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500"
                                href="{{ route(name: 'tarik-saldos.index') }}">{{ __(key: 'Tarik Saldo') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Merchant') }}</td>
                                        <td>{{ $tarikSaldo->nama_merchant ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Jumlah') }}</td>
                                        <td>Rp {{ number_format($tarikSaldo->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Biaya') }}</td>
                                        <td>Rp {{ number_format($tarikSaldo->biaya, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Diterima') }}</td>
                                        <td>Rp {{ number_format($tarikSaldo->diterima, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Bank') }}</td>
                                        <td>{{ $tarikSaldo->nama_bank ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Pemilik Rekening') }}</td>
                                        <td>{{ $tarikSaldo->pemilik_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Nomor Rekening') }}</td>
                                        <td>{{ $tarikSaldo->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Status') }}</td>
                                        <td>
                                            @if ($tarikSaldo->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($tarikSaldo->status === 'process')
                                                <span class="badge bg-info">Diproses</span>
                                            @elseif($tarikSaldo->status === 'success')
                                                <span class="badge bg-success">Berhasil</span>
                                            @elseif($tarikSaldo->status === 'reject')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($tarikSaldo->status === 'cancel')
                                                <span class="badge bg-secondary">Dibatalkan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $tarikSaldo->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Bukti Trf') }}</td>
                                        <td>
                                            @if ($buktiTrfUrl ?? null)
                                                <a href="#" class="d-inline-block" data-bs-toggle="modal" data-bs-target="#buktiTrfModal" title="Lihat / Zoom">
                                                    <img src="{{ $buktiTrfUrl }}" alt="Bukti Trf"
                                                        class="rounded img-fluid border"
                                                        style="object-fit: cover; width: 200px; height: 120px; cursor: pointer;" />
                                                </a>
                                                <small class="d-block mt-1 text-muted">Klik gambar untuk zoom</small>
                                            @else
                                                <span class="text-muted">Belum ada bukti transfer</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if(isset($tarikSaldo->catatan) && $tarikSaldo->catatan)
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Catatan') }}</td>
                                        <td>{{ $tarikSaldo->catatan }}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Created at') }}</td>
                                        <td>{{ $tarikSaldo->created_at ? date('Y-m-d H:i:s', strtotime($tarikSaldo->created_at)) : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Updated at') }}</td>
                                        <td>{{ $tarikSaldo->updated_at ? date('Y-m-d H:i:s', strtotime($tarikSaldo->updated_at)) : '-' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <a href="{{ route(name: 'tarik-saldos.index') }}"
                                class="btn btn-secondary">{{ __(key: 'Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if($buktiTrfUrl ?? null)
    <div class="modal fade" id="buktiTrfModal" tabindex="-1" aria-labelledby="buktiTrfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header py-2">
                    <h5 class="modal-title" id="buktiTrfModalLabel">{{ __(key: 'Bukti Transfer') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center bg-dark">
                    <img src="{{ $buktiTrfUrl }}" alt="Bukti Transfer" class="img-fluid" style="max-height: 85vh; width: auto;" />
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
