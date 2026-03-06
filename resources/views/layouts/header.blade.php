                <header class="header-main">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-8 col-sm-6 d-flex align-items-center header-left p-0">
                                <span class="header-toggle ">
                                    <i class="ph ph-squares-four"></i>
                                </span>
                            </div>

                            <div class="col-4 col-sm-6 d-flex align-items-center justify-content-end header-right p-0">
                                <ul class="d-flex align-items-center">
                                    <li class="header-dark">
                                        <div class="sun-logo head-icon bg-light-dark rounded-circle f-s-22 p-2">
                                            <i class="ph ph-moon-stars"></i>
                                        </div>
                                        <div class="moon-logo head-icon bg-light-dark rounded-circle f-s-22 p-2">
                                            <i class="ph ph-sun-dim"></i>
                                        </div>
                                    </li>

                                    @canany(['konfirmasi tarik saldo', 'merchant review'])
                                    @php
                                        $totalNotifications = 0;
                                        if(isset($pendingTarikSaldos)) $totalNotifications += $pendingTarikSaldos->count();
                                        if(isset($pendingMerchants)) $totalNotifications += $pendingMerchants->count();
                                    @endphp
                                    <li class="header-notification">
                                        <a aria-controls="notificationcanvasRight"
                                            class="d-block head-icon position-relative bg-light-dark rounded-circle f-s-22 p-2"
                                            data-bs-target="#notificationcanvasRight" data-bs-toggle="offcanvas"
                                            href="#" role="button">
                                            <i class="ph ph-bell"></i>
                                            @if($totalNotifications > 0)
                                            <span class="position-absolute badge rounded-pill bg-danger d-flex align-items-center justify-content-center" style="font-size: 9px; width: 16px; height: 16px; top: -2px; right: -2px;">{{ $totalNotifications }}</span>
                                            @endif
                                        </a>
                                        <div aria-labelledby="notificationcanvasRightLabel"
                                            class="offcanvas offcanvas-end header-notification-canvas"
                                            id="notificationcanvasRight" tabindex="-1">
                                            <div class="offcanvas-header pb-2">
                                                <h5 class="offcanvas-title" id="notificationcanvasRightLabel">
                                                    {{ __('Notification') }}</h5>
                                                <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas"
                                                    type="button"></button>
                                            </div>

                                            <!-- Tabs Navigation -->
                                            <div class="px-3 pb-2">
                                                <div class="nav nav-pills nav-fill gap-2 p-1 small rounded-3 notification-tabs-container" id="notificationTabs" role="tablist">
                                                    @can('konfirmasi tarik saldo')
                                                    <button class="nav-link active rounded-3 d-flex align-items-center justify-content-center gap-1 py-2" id="tarik-saldo-tab" data-bs-toggle="tab" data-bs-target="#tarik-saldo-content" type="button" role="tab">
                                                        <i class="ph ph-wallet"></i>
                                                        <span>Penarikan</span>
                                                        @if(isset($pendingTarikSaldos) && $pendingTarikSaldos->isNotEmpty())
                                                        <span class="badge bg-danger rounded-pill" style="font-size: 10px;">{{ $pendingTarikSaldos->count() }}</span>
                                                        @endif
                                                    </button>
                                                    @endcan
                                                    @can('merchant review')
                                                    <button class="nav-link @cannot('konfirmasi tarik saldo') active @endcannot rounded-3 d-flex align-items-center justify-content-center gap-1 py-2" id="merchant-tab" data-bs-toggle="tab" data-bs-target="#merchant-content" type="button" role="tab">
                                                        <i class="ph ph-storefront"></i>
                                                        <span>Merchant</span>
                                                        @if(isset($pendingMerchants) && $pendingMerchants->isNotEmpty())
                                                        <span class="badge bg-warning text-dark rounded-pill" style="font-size: 10px;">{{ $pendingMerchants->count() }}</span>
                                                        @endif
                                                    </button>
                                                    @endcan
                                                </div>
                                            </div>

                                            <div class="offcanvas-body app-scroll p-0">
                                                <div class="tab-content" id="notificationTabsContent">
                                                    <!-- Tab Penarikan Saldo -->
                                                    @can('konfirmasi tarik saldo')
                                                    <div class="tab-pane fade show active" id="tarik-saldo-content" role="tabpanel">
                                                        <div class="head-container">
                                                            @if(isset($pendingTarikSaldos) && $pendingTarikSaldos->isNotEmpty())
                                                                @foreach($pendingTarikSaldos as $item)
                                                                <a href="{{ route('tarik-saldos.show', $item->id) }}" class="d-block px-3 py-2 border-bottom text-decoration-none notification-item">
                                                                    <div class="d-flex align-items-start gap-2">
                                                                        <div class="flex-shrink-0">
                                                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light-primary" style="width: 36px; height: 36px;">
                                                                                <i class="ph ph-wallet text-primary"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="flex-grow-1 min-w-0">
                                                                            <div class="d-flex justify-content-between align-items-start">
                                                                                <span class="fw-semibold notification-title text-truncate d-block" style="max-width: 150px;">{{ $item->merchant->nama_merchant ?? '-' }}</span>
                                                                                <span class="badge bg-danger">Pending</span>
                                                                            </div>
                                                                            <div class="text-primary fw-semibold small">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</div>
                                                                            <small class="text-muted">{{ $item->created_at?->diffForHumans() }}</small>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                @endforeach
                                                                <div class="p-3">
                                                                    <a href="{{ route('tarik-saldos.index') }}" class="btn btn-outline-primary btn-sm w-100">
                                                                        <i class="ph ph-list me-1"></i> {{ __('Lihat Semua') }}
                                                                    </a>
                                                                </div>
                                                            @else
                                                            <div class="py-5 px-3 text-center">
                                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle notification-empty-icon mb-3" style="width: 60px; height: 60px;">
                                                                    <i class="ph-duotone ph-wallet f-s-28 text-muted"></i>
                                                                </div>
                                                                <p class="text-muted mb-3 small">{{ __('Tidak ada pengajuan penarikan pending') }}</p>
                                                                <a href="{{ route('tarik-saldos.index') }}" class="btn btn-outline-primary btn-sm">
                                                                    <i class="ph ph-list me-1"></i> {{ __('Lihat Semua') }}
                                                                </a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endcan

                                                    <!-- Tab Pengajuan Merchant -->
                                                    @can('merchant review')
                                                    <div class="tab-pane fade @cannot('konfirmasi tarik saldo') show active @endcannot" id="merchant-content" role="tabpanel">
                                                        <div class="head-container">
                                                            @if(isset($pendingMerchants) && $pendingMerchants->isNotEmpty())
                                                                @foreach($pendingMerchants as $merchant)
                                                                <a href="{{ route('merchants.show', $merchant->id) }}" class="d-block px-3 py-2 border-bottom text-decoration-none notification-item">
                                                                    <div class="d-flex align-items-start gap-2">
                                                                        <div class="flex-shrink-0">
                                                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light-warning" style="width: 36px; height: 36px;">
                                                                                <i class="ph ph-storefront text-warning"></i>
                                                                            </span>
                                                                        </div>
                                                                        <div class="flex-grow-1 min-w-0">
                                                                            <div class="d-flex justify-content-between align-items-start">
                                                                                <span class="fw-semibold notification-title text-truncate d-block" style="max-width: 150px;">{{ $merchant->nama_merchant }}</span>
                                                                                <span class="badge bg-warning text-dark">Review</span>
                                                                            </div>
                                                                            <div class="small text-muted">{{ $merchant->kode_merchant }}</div>
                                                                            <small class="text-muted">{{ $merchant->updated_at?->diffForHumans() }}</small>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                                @endforeach
                                                                <div class="p-3">
                                                                    <a href="{{ route('merchants.index') }}" class="btn btn-outline-primary btn-sm w-100">
                                                                        <i class="ph ph-list me-1"></i> {{ __('Lihat Semua') }}
                                                                    </a>
                                                                </div>
                                                            @else
                                                            <div class="py-5 px-3 text-center">
                                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle notification-empty-icon mb-3" style="width: 60px; height: 60px;">
                                                                    <i class="ph-duotone ph-storefront f-s-28 text-muted"></i>
                                                                </div>
                                                                <p class="text-muted mb-3 small">{{ __('Tidak ada pengajuan merchant pending') }}</p>
                                                                <a href="{{ route('merchants.index') }}" class="btn btn-outline-primary btn-sm">
                                                                    <i class="ph ph-list me-1"></i> {{ __('Lihat Semua') }}
                                                                </a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endcan
                                                </div>
                                            </div>

                                            <style>
                                                /* Light mode */
                                                .notification-tabs-container {
                                                    background-color: #f0f0f0;
                                                }
                                                .notification-item:hover {
                                                    background-color: #f8f9fa;
                                                }
                                                .notification-title {
                                                    color: #212529;
                                                }
                                                #notificationTabs .nav-link {
                                                    color: #6c757d;
                                                    font-weight: 500;
                                                    font-size: 13px;
                                                    transition: all 0.2s;
                                                    background-color: transparent;
                                                    border: none;
                                                }
                                                #notificationTabs .nav-link.active {
                                                    background-color: #ffffff !important;
                                                    color: #212529 !important;
                                                    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
                                                }
                                                #notificationTabs .nav-link:not(.active):hover {
                                                    color: #212529;
                                                    background-color: rgba(0,0,0,0.05);
                                                }

                                                /* Dark mode */
                                                [data-theme="dark"] .notification-tabs-container,
                                                .dark .notification-tabs-container {
                                                    background-color: #2d3035;
                                                }
                                                [data-theme="dark"] .notification-item:hover,
                                                .dark .notification-item:hover {
                                                    background-color: #2d3035;
                                                }
                                                [data-theme="dark"] .notification-title,
                                                .dark .notification-title {
                                                    color: #e9ecef;
                                                }
                                                [data-theme="dark"] #notificationTabs .nav-link,
                                                .dark #notificationTabs .nav-link {
                                                    color: #adb5bd;
                                                }
                                                [data-theme="dark"] #notificationTabs .nav-link.active,
                                                .dark #notificationTabs .nav-link.active {
                                                    background-color: #3d4147 !important;
                                                    color: #ffffff !important;
                                                    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
                                                }
                                                [data-theme="dark"] #notificationTabs .nav-link:not(.active):hover,
                                                .dark #notificationTabs .nav-link:not(.active):hover {
                                                    color: #ffffff;
                                                    background-color: rgba(255,255,255,0.05);
                                                }

                                                /* Empty state icon */
                                                .notification-empty-icon {
                                                    background-color: #f0f0f0;
                                                }
                                                [data-theme="dark"] .notification-empty-icon,
                                                .dark .notification-empty-icon {
                                                    background-color: #2d3035;
                                                }
                                            </style>
                                        </div>
                                    </li>
                                    @endcanany
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
