@extends('layouts.app')

@section('title', __(key: 'Create User'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'User') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a class="f-s-14 f-w-500" href="{{ route(name: 'users.index') }}">
                                {{ __(key: 'User') }}
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Create') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route(name: 'users.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('POST')

                                @include('users.include.form')

                                <a href="{{ route(name: 'users.index') }}" class="btn btn-secondary">{{ __(key: 'Back') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __(key: 'Save') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
