@extends('layouts.app')

@section('title', __('Tambah Kunjungan'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Kunjungan Sales') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('kunjungan-sales.index') }}">{{ __('Kunjungan Sales') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Tambah') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('kunjungan-sales.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('kunjungan-sales.include.form')
                                <a href="{{ route('kunjungan-sales.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
