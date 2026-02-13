@extends('layouts.app')

@section('title', __(key: 'Simulator'))

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
                        <div class="card-header">
                            <h5>{{ __('QRIS Result') }}</h5>
                        </div>
                        <div class="card-body text-center">
                            <div id="qrisResult" class="d-none">
                                <div id="qrCodeContainer" class="mb-3"></div>
                                <div id="qrisDetails">
                                    <p><strong>Reference No:</strong> <span id="referenceNo"></span></p>
                                    <p><strong>Amount:</strong> <span id="qrisAmount"></span></p>
                                    <p><strong>Merchant:</strong> <span id="merchantName"></span></p>
                                </div>
                            </div>
                            <div id="noResult" class="text-muted">
                                <i class="ph-duotone ph-qr-code" style="font-size: 4rem;"></i>
                                <p>{{ __('Generate QRIS untuk menampilkan') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
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

                    QRCode.toCanvas(result.data.qris_content, {
                        width: 300,
                        margin: 2
                    }, function(error, canvas) {
                        if (error) {
                            console.error(error);
                            alert('Error generating QR code');
                        } else {
                            qrContainer.appendChild(canvas);
                        }
                    });

                    // Update details
                    document.getElementById('referenceNo').textContent = result.data.reference_no;
                    document.getElementById('qrisAmount').textContent = 'IDR ' + result.data.amount;
                    document.getElementById('merchantName').textContent = result.data.merchant_name;

                    // Show success alert
                    alert('QRIS berhasil di-generate!');
                } else {
                    // Show error alert
                    alert('Error: ' + result.message);

                    // Show no result message
                    document.getElementById('qrisResult').classList.add('d-none');
                    document.getElementById('noResult').classList.remove('d-none');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat generate QRIS');

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
