@extends('layouts.app')

@section('title', __('Edit SPK/PO'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('SPK/PO') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('spk.index') }}">{{ __('SPK/PO') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Edit') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('spk.update', $spk) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('spk.include.form')
                                <a href="{{ route('spk.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
