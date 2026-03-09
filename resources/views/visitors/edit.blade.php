@extends('layouts.app')

@section('title', __('Edit Kunjungan'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Visitor Sales') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li><a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a class="f-s-14 f-w-500" href="{{ route('visitors.index') }}">{{ __('Visitor Sales') }}</a></li>
                        <li class="active"><a class="f-s-14 f-w-500" href="#">{{ __('Edit') }}</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('visitors.update', $visitor->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('visitors.include.form')
                                <a href="{{ route('visitors.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
