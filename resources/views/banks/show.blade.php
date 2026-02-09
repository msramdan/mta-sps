@extends('layouts.app')

@section('title', __(key: 'Detail Banks'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Banks') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'banks.index') }}">{{ __(key: 'Banks') }}</a>
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
                    <td class="fw-bold">{{ __(key: 'Nama Bank') }}</td>
                    <td>{{ $bank->nama_bank }}</td>
                </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Created at') }}</td>
                                        <td>{{ $bank->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Updated at') }}</td>
                                        <td>{{ $bank->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <a href="{{ route(name: 'banks.index') }}" class="btn btn-secondary">{{ __(key: 'Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
