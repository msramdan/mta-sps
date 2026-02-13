@extends('layouts.app')

@section('title', __(key: 'Simulator'))

@push('css')
{{-- https://github.com/tsayen/dom-to-image/issues/147 --}}
<style>
    .qris-merchant-design-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
        width: 100%;
        max-width: 360px;
        margin: 0 auto;
    }

    .header-qris-template .header-qris-template-left {
        width: 50%;
        background: #fff;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: start;
    }
    .header-qris-template .header-qris-template-right {
        width: 50%;
        background: #fff;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: end;
    }

    .qris-info-overview {
        text-align: center;
        overflow: hidden;
        position: relative;
        z-index: 5;
    }

    .nmid-section {
        background: transparent;
        padding: 8px;
        border-radius: 6px;
        display: inline-block;
    }

    .qris-footer-branding {
        padding-top: 0.5rem;
    }

    .pop-in {
        animation: pop-up 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) forwards;
    }

    .pop-out {
        animation: pop-out 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) forwards !important;
    }

    @keyframes pop-up {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes pop-out {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(0);
            opacity: 0;
        }
    }

    .icon-step-useqr {
        background: white;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        padding: 3px;
    }

    .screenshot-effect {
        position: absolute;
        width: 100%;
        height: 100%;
        background: #fff;
        display: none;
        z-index: 6;
        opacity: 0;
        left: 0px;
        animation: screenshot-effect-anim 3s cubic-bezier(0.250, 0.460, 0.450, 0.940) forwards;
    }

    .screenshot-effect canvas {
        width: 100%;
        height: 100%;
        transition: all 0.5s ease;
        transition-delay: 500ms;
        animation: fade-in 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) forwards;
    }

    @keyframes fade-in {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes screenshot-effect-anim {
        0% {
            opacity: 1;
            transform: scale(1)
        }
        5% {
            opacity: 0;
        }
        10% {
            opacity: 1;
            transform: scale(1)
        }
        20% {
            transform: scale(0.8)
        }
        61% {
            opacity: 1;
            transform: scale(0.8)
        }
        90% {
            opacity: 1;
            transform: scale(0.8)
        }
        100% {
            opacity: 0;
            transform: scale(0.8)
        }
    }

    #generateBtn {
        width: 100%;
        padding: 12px;
        font-weight: 600;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .loading-qris {
        position: absolute;
        box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
        width: 224px;
        height: 65px;
        background: rgba(255, 255, 255, 88%);
        z-index: 10;
        transform: translate(50%, 0);
        border-radius: 8px;
        top: -100px;
        transition: all 0.5s ease;
    }

    .loading-qris-content {
        display: flex;
    }

    .loading-qris-content-left img {
        width: 47px;
        margin-top: 5px;
        margin-left: 10px;
    }

    .loading-qris-content-right {
        padding-top: 20px;
    }
</style>
@endpush

@section('content')
    <main>
        <div class="container-fluid">
            <div class="row m-1">
                <div class="col-12 ">
                    <h4 class="main-title">{{ __(key: 'Simulator') }}</h4>
                    <ul class="app-line-breadcrumbs mb-3">
                        <li class="">
                            <a class="f-s-14 f-w-500" href="/">
                                <span>
                                    <i class="ph-duotone ph-newspaper f-s-16"></i> {{ __(key: 'Dashboard') }}
                                </span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="f-s-14 f-w-500" href="#">{{ __(key: 'Simulator') }}</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Generate QRIS') }}</h5>
                        </div>
                        <div class="card-body">
                            <form id="qrisForm">
                                @csrf

                                <div class="mb-3">
                                    <label for="merchant_id" class="form-label">{{ __('Merchant') }}</label>
                                    <select class="form-select" id="merchant_id" name="merchant_id" required>
                                        <option value="">{{ __('Pilih Merchant') }}</option>
                                        @foreach ($merchants as $merchant)
                                            <option value="{{ $merchant->id }}">{{ $merchant->nama_merchant }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="amount" class="form-label">{{ __('Nominal') }}</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                        placeholder="Masukkan nominal" min="1" step="0.01" required>
                                </div>

                                <button type="submit" class="btn btn-primary" id="generateBtn">
                                    <i class="ph-duotone ph-qr-code"></i> {{ __('Generate QRIS') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="ph-duotone ph-qr-code me-2"></i>{{ __('QRIS Payment') }}</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <div id="qrisResult" class="d-none">
                                <div class="card qris-merchant-design-wrapper">
                                    <div class="screenshot-effect"></div>
                                    <div class="loading-qris">
                                        <div class="loading-qris-content">
                                            <div class="loading-qris-content-left">
                                                <div class="spinner-border text-primary" role="status" style="width: 47px; height: 47px; margin-top: 5px; margin-left: 10px;">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="loading-qris-content-right">
                                                <h5 class="text-center">Loading QR Code</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="qris-merchant" style="width: 100%; height: 100%; overflow:visible !important; padding: 8px; position:relative; background: white;">
                                        <div class="qris-info-overview">
                                            <div class="qris-logo-top mb-2">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_QRIS.svg/1280px-Logo_QRIS.svg.png" alt="QRIS" style="width: 200px; display: block; margin: 0 auto;">
                                            </div>
                                            <div id="qrCodeContainer" style="display: inline-block; margin: 0.5rem 0;"></div>
                                            <div class="nmid-section mb-2">
                                                <p class="text-center mb-0" style="font-size: 0.95rem; font-weight: 600; color: #000;">NMID : <span id="nmid" style="font-weight: 700;">ID2026020900005</span></p>
                                            </div>
                                            <div class="qris-footer-branding pb-1">
                                                <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                                    <span style="font-size: 0.9rem; color: #6c757d; font-weight: 700;">QRIS by</span>
                                                    <img src="https://upload.wikimedia.org/wikipedia/commons/1/1f/Logo_Nobubank.png" alt="Nobu" style="height: 30px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="noResult" class="text-muted py-5">
                                <i class="ph-duotone ph-qr-code" style="font-size: 5rem; opacity: 0.3;"></i>
                                <p class="mt-3">{{ __('Generate QRIS untuk menampilkan') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.getElementById('qrisForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const merchantId = formData.get('merchant_id');
            const amount = formData.get('amount');
            const generateBtn = document.getElementById('generateBtn');

            // Disable button
            generateBtn.disabled = true;
            generateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating...';

            try {
                const response = await fetch('{{ route('simulators.generate-qris') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        merchant_id: merchantId,
                        amount: amount
                    })
                });

                const result = await response.json();

                if (result.success) {
                    // Hide no result message
                    document.getElementById('noResult').classList.add('d-none');

                    // Show result
                    document.getElementById('qrisResult').classList.remove('d-none');

                    // Generate QR Code
                    const qrContainer = document.getElementById('qrCodeContainer');
                    qrContainer.innerHTML = ''; // Clear previous QR

                    // Create QR Code using QRCodeJS
                    new QRCode(qrContainer, {
                        text: result.data.qris_content,
                        width: 200,
                        height: 200,
                    });

                    // Update details
                    document.getElementById('nmid').textContent = result.data.store_id || 'ID2026020900005';

                    // Show success alert with SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'QRIS berhasil di-generate!',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                } else {
                    // Show error alert with SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: result.message || 'Terjadi kesalahan saat generate QRIS',
                        confirmButtonText: 'OK'
                    });

                    // Show no result message
                    document.getElementById('qrisResult').classList.add('d-none');
                    document.getElementById('noResult').classList.remove('d-none');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat generate QRIS',
                    confirmButtonText: 'OK'
                });

                // Show no result message
                document.getElementById('qrisResult').classList.add('d-none');
                document.getElementById('noResult').classList.remove('d-none');
            } finally {
                // Re-enable button
                generateBtn.disabled = false;
                generateBtn.innerHTML = '<i class="ph-duotone ph-qr-code"></i> {{ __('Generate QRIS') }}';
            }
        });
    </script>
@endpush
