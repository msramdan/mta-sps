@extends('layouts.app')

@section('title', __('Edit Jadwal Teknisi'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Jadwal Teknisi') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('jadwal-teknisi.index') }}">{{ __('Jadwal Teknisi') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Edit') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('jadwal-teknisi.update', $jadwal->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('jadwal-teknisi.include.form', ['jadwal' => $jadwal])
                                <a href="{{ route('jadwal-teknisi.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

