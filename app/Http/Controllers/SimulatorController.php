<?php

namespace App\Http\Controllers;

use App\Models\{Simulator, Merchant};
use App\Http\Requests\Simulators\{StoreSimulatorRequest, UpdateSimulatorRequest};
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Routing\Controllers\{HasMiddleware, Middleware};

class SimulatorController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware(middleware: 'permission:simulator view', only: ['index', 'show']),
        ];
    }


    public function index(): View|JsonResponse
    {
        $merchants = Merchant::all();
        return view(view: 'simulators.index', data: compact('merchants'));
    }

    public function generateQris(Request $request): JsonResponse
    {
        $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'amount' => 'required|numeric|min:1',
        ]);

        try {
            // Get merchant
            $merchant = Merchant::findOrFail($request->merchant_id);

            // Check if merchant has token_qrin
            if (empty($merchant->token_qrin)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Merchant tidak memiliki token QRIN',
                    'data' => null
                ], 400);
            }

            // Generate random 12-digit partner reference number
            $partnerReferenceNo = $this->generatePartnerReferenceNo();

            // Format amount to 2 decimal places
            $formattedAmount = number_format($request->amount, 2, '.', '');

            // Prepare payload
            $payload = [
                'token_qrin' => $merchant->token_qrin,
                'request_payload_qris' => [
                    'partnerReferenceNo' => $partnerReferenceNo,
                    'amount' => [
                        'value' => $formattedAmount,
                        'currency' => 'IDR'
                    ],
                    'additionalInfo' => [
                        'validTime' => '9000',
                        'tip' => 'false',
                        'qrType' => '03'
                    ]
                ]
            ];

            // Get QRIN URL from config
            $qrinUrl = config('services.qrin.url');

            // Make request to QRIN API
            $response = Http::timeout(30)->post($qrinUrl, $payload);

            $result = $response->json();

            // Return the response from QRIN API
            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'General Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Generate random 12-digit partner reference number
     */
    private function generatePartnerReferenceNo(): string
    {
        return str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
    }

}
