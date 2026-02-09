@extends('layouts.app')

@section('title', __(key: 'Edit Banks'))

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
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Edit') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route(name: 'banks.update', parameters: $bank->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('banks.include.form')

                                <a href="{{ route(name: 'banks.index') }}" class="btn btn-secondary">{{ __(key: 'Kembali') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __(key: 'Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
