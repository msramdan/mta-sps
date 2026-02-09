@extends('layouts.app')

@section('title', __(key: 'Detail Merchants'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Merchants') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'merchants.index') }}">{{ __(key: 'Merchants') }}</a>
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
                    <td class="fw-bold">{{ __(key: 'Nama Merchant') }}</td>
                    <td>{{ $merchant->nama_merchant }}</td>
                </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Logo') }}</td>
                                        <td>
                                            <img src="{{ $merchant->logo }}" alt="Logo" class="rounded img-fluid" style="object-fit: cover; width: 350px; height: 200px;" />
                                        </td>
                                    </tr>

<tr>
                    <td class="fw-bold">{{ __(key: 'Url Callback') }}</td>
                    <td>{{ $merchant->url_callback }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Apikey') }}</td>
                    <td>{{ $merchant->apikey }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Secretkey') }}</td>
                    <td>{{ $merchant->secretkey }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Bank') }}</td>
                    <td>{{ $merchant->bank ? $merchant->bank->nama_bank : '' }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Pemilik Rekening') }}</td>
                    <td>{{ $merchant->pemilik_rekening }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Nomor Rekening') }}</td>
                    <td>{{ $merchant->nomor_rekening }}</td>
                </tr>
<tr>
                    <td class="fw-bold">{{ __(key: 'Is Active') }}</td>
                    <td>{{ $merchant->is_active }}</td>
                </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Created at') }}</td>
                                        <td>{{ $merchant->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Updated at') }}</td>
                                        <td>{{ $merchant->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <a href="{{ route(name: 'merchants.index') }}" class="btn btn-secondary">{{ __(key: 'Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
