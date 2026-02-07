@extends('layouts.app')

@section('title', __(key: 'Tambah Produks'))

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
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Tambah') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            

                            <form action="{{ route(name: 'produks.store') }}" method="POST">
                                @csrf
                                @method('POST')

                                @include('produks.include.form')

                                <a href="{{ route(name: 'produks.index') }}" class="btn btn-secondary">{{ __(key: 'Back') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __(key: 'Simpan') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
