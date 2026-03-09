@extends('layouts.app')

@section('title', __('Tambah SPH'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('SPH') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('sph.index') }}">{{ __('SPH') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Tambah') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('sph.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('sph.include.form')
                                <a href="{{ route('sph.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
