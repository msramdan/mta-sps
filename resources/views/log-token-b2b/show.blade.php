@extends('layouts.app')

@section('title', __('Detail Log Token B2B'))

@push('css')
<style>
    .log-detail pre { font-size: 0.8rem; max-height: 400px; overflow: auto; white-space: pre-wrap; word-break: break-all; }
</style>
@endpush

@php
    $prettyJson = function ($str) {
        if (empty($str)) return '';
        $d = json_decode($str);
        return $d ? json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : e($str);
    };
    $headerPretty = $prettyJson($logTokenB2b->header);
    $payloadPretty = $prettyJson($logTokenB2b->payload);
    $responsePretty = $prettyJson($logTokenB2b->response);
@endphp

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Detail Log Token B2B') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="/">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('log-token-b2b.index') }}">{{ __('Log Token B2B') }}</a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __('Detail') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row g-3 log-detail">
                <div class="col-12 col-md-6">
                    <div class="card border">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-info-circle me-1"></i> Informasi</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="fw-bold text-nowrap" style="width: 38%">ID</td>
                                    <td class="text-break">{{ $logTokenB2b->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal</td>
                                    <td>{{ $logTokenB2b->created_at?->format('d M Y H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card border h-100">
                        <div class="card-header py-2">
                            <h6 class="mb-0 fw-bold"><i class="ti ti-api me-1"></i> Header, Payload & Response</h6>
                        </div>
                        <div class="card-body p-3">
                            <p class="small fw-bold text-muted mb-1">Header</p>
                            <pre class="rounded border p-2 mb-2">{{ $headerPretty ?: '-' }}</pre>
                            <p class="small fw-bold text-muted mb-1">Payload</p>
                            <pre class="rounded border p-2 mb-2">{{ $payloadPretty ?: '-' }}</pre>
                            <p class="small fw-bold text-muted mb-1">Response</p>
                            <pre class="rounded border p-2 mb-0">{{ $responsePretty ?: '-' }}</pre>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <a href="{{ route('log-token-b2b.index') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> {{ __('Kembali') }}
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
