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
        return view(view: 'simulators.index');
    }

    public function generateQris(Request $request): JsonResponse
    {
        $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'request_payload_qris' => 'required|array',
            'request_payload_qris.no_ref_merchant' => 'required|string',
            'request_payload_qris.amount' => 'required|array',
            'request_payload_qris.amount.value' => 'required|numeric|min:1000',
            'request_payload_qris.amount.currency' => 'required|string|in:IDR',
            'request_payload_qris.additional_info' => 'nullable|array',
            'request_payload_qris.additional_info.customer_name' => 'nullable|string|min:5|max:100',
            'request_payload_qris.additional_info.customer_email' => 'nullable|email',
            'request_payload_qris.additional_info.customer_phone' => ['nullable', 'string', 'regex:/^(08[0-9]{6,10}|62[0-9]{6,11})$/'],
        ], [
            'request_payload_qris.amount.value.min' => 'Nominal minimal 1000.',
            'request_payload_qris.additional_info.customer_name.min' => 'Nama pelanggan minimal 5 karakter.',
            'request_payload_qris.additional_info.customer_name.max' => 'Nama pelanggan maksimal 100 karakter.',
            'request_payload_qris.additional_info.customer_phone.regex' => 'Nomor telepon 8-13 karakter, diawali 08 atau 62.',
        ]);

        try {
            $merchant = Merchant::findOrFail($request->merchant_id);

            if (empty($merchant->token_qrin)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Merchant tidak memiliki token QRIN',
                    'data' => null
                ], 400);
            }

            $value = $request->input('request_payload_qris.amount.value');
            $formattedAmount = number_format((float) $value, 2, '.', '');

            $requestPayloadQris = [
                'no_ref_merchant' => $request->input('request_payload_qris.no_ref_merchant'),
                'amount' => [
                    'value' => $formattedAmount,
                    'currency' => 'IDR',
                ],
            ];

            $additionalInfo = $request->input('request_payload_qris.additional_info');
            if (! empty($additionalInfo)) {
                $filtered = array_filter([
                    'customer_name' => $additionalInfo['customer_name'] ?? null,
                    'customer_email' => $additionalInfo['customer_email'] ?? null,
                    'customer_phone' => $additionalInfo['customer_phone'] ?? null,
                ]);
                if (! empty($filtered)) {
                    $requestPayloadQris['additional_info'] = $filtered;
                }
            }

            $payload = [
                'token_qrin' => $merchant->token_qrin,
                'request_payload_qris' => $requestPayloadQris,
            ];

            $qrinUrl = config('services.qrin.base_url') . '/v1.0/generate-qris';
            $response = Http::timeout(30)->post($qrinUrl, $payload);
            $result = $response->json();

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'General Error: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

}
