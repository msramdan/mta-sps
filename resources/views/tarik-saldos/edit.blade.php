@extends('layouts.app')

@section('title', __(key: 'Edit Tarik Saldo'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Tarik Saldo') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'tarik-saldos.index') }}">{{ __(key: 'Saldo') }}</a>
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
                            <form action="{{ route(name: 'tarik-saldos.update', parameters: $tarikSaldo->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                @include('tarik-saldos.include.form')

                                <a href="{{ route(name: 'tarik-saldos.index') }}" class="btn btn-secondary">{{ __(key: 'Kembali') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __(key: 'Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
