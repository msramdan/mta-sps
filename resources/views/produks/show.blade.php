@extends('layouts.app')

@section('title', __(key: 'Detail Produks'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Produks') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'produks.index') }}">{{ __(key: 'Produks') }}</a>
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
                    <td class="fw-bold">{{ __(key: 'Nama') }}</td>
                    <td>{{ $produk->nama }}</td>
                </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Created at') }}</td>
                                        <td>{{ $produk->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __(key: 'Updated at') }}</td>
                                        <td>{{ $produk->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                            <a href="{{ route(name: 'produks.index') }}" class="btn btn-secondary">{{ __(key: 'Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
