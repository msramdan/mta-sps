@extends('layouts.app')

@section('title', __('Tambah Perusahaan'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __('Perusahaan') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route('companies.index') }}">{{ __('Perusahaan') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Tambah') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('companies.store') }}" method="POST">
                                @csrf
                                @include('companies.include.form')
                                <a href="{{ route('companies.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
