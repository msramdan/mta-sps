@extends('layouts.app')

@section('title', __(key: 'Detail Tarik Saldos'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Tarik Saldos') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'tarik-saldos.index') }}">{{ __(key: 'Tarik Saldos') }}</a>
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
                    <td>{{ $tarikSaldo->merchant ? $tarikSaldo->merchant->nama_merchant : '' }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Jumlah') }}</td>
                    <td>{{ $tarikSaldo->jumlah }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Biaya') }}</td>
                    <td>{{ $tarikSaldo->biaya }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Diterima') }}</td>
                    <td>{{ $tarikSaldo->diterima }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Bank') }}</td>
                    <td>{{ $tarikSaldo->bank ? $tarikSaldo->bank->nama_bank : '' }}</td>
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
                    <td>{{ $tarikSaldo->status }}</td>
                </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Bukti Trf') }}</td>
                                        <td>
                                            <img src="{{ $tarikSaldo->bukti_trf }}" alt="Bukti Trf" class="rounded img-fluid" style="object-fit: cover; width: 350px; height: 200px;" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Created at') }}</td>
                                        <td>{{ $tarikSaldo->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Updated at') }}</td>
                                        <td>{{ $tarikSaldo->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <a href="{{ route(name: 'tarik-saldos.index') }}" class="btn btn-secondary">{{ __(key: 'Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
