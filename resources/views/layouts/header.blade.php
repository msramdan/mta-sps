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

                                    @can('konfirmasi tarik saldo')
                                    <li class="header-notification">
                                        <a aria-controls="notificationcanvasRight"
                                            class="d-block head-icon position-relative bg-light-dark rounded-circle f-s-22 p-2"
                                            data-bs-target="#notificationcanvasRight" data-bs-toggle="offcanvas"
                                            href="#" role="button">
                                            <i class="ph ph-bell"></i>
                                            @if(isset($pendingTarikSaldos) && $pendingTarikSaldos->isNotEmpty())
                                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">{{ $pendingTarikSaldos->count() }}</span>
                                            @endif
                                        </a>
                                        <div aria-labelledby="notificationcanvasRightLabel"
                                            class="offcanvas offcanvas-end header-notification-canvas"
                                            id="notificationcanvasRight" tabindex="-1">
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="notificationcanvasRightLabel">
                                                    {{ __('Notification') }}</h5>
                                                <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas"
                                                    type="button"></button>
                                            </div>
                                            <div class="offcanvas-body app-scroll p-0">
                                                <div class="head-container">
                                                    @if(isset($pendingTarikSaldos) && $pendingTarikSaldos->isNotEmpty())
                                                        @foreach($pendingTarikSaldos as $item)
                                                        <div class="notification-message head-box">
                                                            <div class="message-content-box flex-grow-1 pe-2">
                                                                <a class="f-s-15 text-dark mb-0 d-block" href="{{ route('tarik-saldos.show', $item->id) }}">
                                                                    <span class="f-w-500 text-dark">{{ $item->merchant->nama_merchant ?? '-' }}</span>
                                                                    {{ __('Pengajuan penarikan saldo') }}
                                                                    <span class="f-w-500 text-primary">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                                                </a>
                                                                <small class="text-muted">{{ $item->created_at?->format('d/m/Y H:i') }}</small>
                                                            </div>
                                                            <div class="text-end">
                                                                <a href="{{ route('tarik-saldos.show', $item->id) }}" class="btn btn-sm btn-light-primary">{{ __('Detail') }}</a>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        <div class="p-3 border-top">
                                                            <a href="{{ route('tarik-saldos.index') }}" class="btn btn-outline-primary btn-sm w-100">
                                                                <i class="ph ph-list me-1"></i> {{ __('Lihat Semua') }}
                                                            </a>
                                                        </div>
                                                    @else
                                                    <div class="py-4 px-3">
                                                        <div>
                                                            <i class="ph-duotone ph-bell-ringing f-s-50 text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ __('Tidak ada pengajuan pending') }}</h6>
                                                            <p class="text-dark mb-0">{{ __('Pengajuan penarikan saldo pending akan tampil di sini.') }}</p>
                                                        </div>
                                                        <div class="mt-3">
                                                            <a href="{{ route('tarik-saldos.index') }}" class="btn btn-outline-primary btn-sm w-100">
                                                                <i class="ph ph-list me-1"></i> {{ __('Lihat Semua') }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    @endcan
                                </ul>
                            </div>
                        </div>
                    </div>
                </header>
