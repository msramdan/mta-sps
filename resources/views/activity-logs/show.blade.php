@extends('layouts.app')

@section('title', __('Detail Activity Log'))

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12">
                    <h4 class="main-title">{{ __('Detail Activity Log') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('dashboard') }}">
                                <span><i class="ph-duotone ph-newspaper f-s-16"></i> {{ __('Dashboard') }}</span>
                            </a>
                        </li>
                        <li>
                            <a class="f-s-14 f-w-500" href="{{ route('activity-logs.index') }}">{{ __('Activity Log') }}</a>
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
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('Informasi Activity') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('Deskripsi') }}</label>
                                    <p class="mb-0">{{ $activityLog->description }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('Tanggal') }}</label>
                                    <p class="mb-0">{{ $activityLog->created_at?->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('User') }}</label>
                                    <p class="mb-0">{{ $activityLog->causer ? $activityLog->causer->name . ' (' . $activityLog->causer->email . ')' : '-' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('Subject') }}</label>
                                    <p class="mb-0">{{ $activityLog->subject_type ? class_basename($activityLog->subject_type) . ' #' . $activityLog->subject_id : '-' }}</p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('Event') }}</label>
                                    <p class="mb-0">
                                        @if($activityLog->event)
                                            <span class="badge bg-info">{{ $activityLog->event }}</span>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">{{ __('Log Name') }}</label>
                                    <p class="mb-0">{{ $activityLog->log_name ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="form-label fw-bold">{{ __('Data (Before / After) - Format JSON') }}</label>
                                <pre class="bg-light p-3 rounded border" style="max-height: 400px; overflow: auto; font-size: 12px;"><code>{{ $propertiesFormatted }}</code></pre>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
