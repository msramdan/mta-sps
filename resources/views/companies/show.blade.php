@extends('layouts.app')

@section('title', __('Detail Perusahaan'))

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
                            <a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-sm-3">{{ __('Nama') }}</dt>
                                <dd class="col-sm-9">{{ $company->name }}</dd>
                                <dt class="col-sm-3">{{ __('ID') }}</dt>
                                <dd class="col-sm-9"><code>{{ $company->id }}</code></dd>
                            </dl>
                            <a href="{{ route('companies.index') }}" class="btn btn-secondary mt-2">{{ __('Kembali') }}</a>
                            @can('company edit')
                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-primary mt-2">{{ __('Edit') }}</a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
