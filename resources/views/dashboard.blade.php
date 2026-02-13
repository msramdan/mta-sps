@extends('layouts.app')

@section('title', __(key: 'Dashboard'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __(key: 'Dashboard') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Greeting Card -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h2 class="mb-2">
                                        <i class="ti ti-hand-stop me-2 text-primary"></i>
                                        @php
                                            $hour = date('H');
                                            $greeting = 'Selamat Datang';
                                            if ($hour >= 5 && $hour < 11) {
                                                $greeting = 'Selamat Pagi';
                                            } elseif ($hour >= 11 && $hour < 15) {
                                                $greeting = 'Selamat Siang';
                                            } elseif ($hour >= 15 && $hour < 18) {
                                                $greeting = 'Selamat Sore';
                                            } elseif ($hour >= 18 || $hour < 5) {
                                                $greeting = 'Selamat Malam';
                                            }
                                        @endphp
                                        {{ $greeting }}, <span class="text-primary">{{ auth()->user()->name }}</span>!
                                    </h2>
                                    <p class="mb-0">
                                        Selamat beraktivitas di <strong>QRIN Payment Gateway</strong>. Semoga hari Anda menyenangkan!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
