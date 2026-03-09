<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SwitchCompanyController extends Controller
{
    /**
     * Ganti perusahaan aktif (session) untuk user yang login.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'company_id' => ['required', 'string', 'uuid'],
        ]);

        $user = $request->user();
        $companyIds = $user->companies()->pluck('id')->toArray();

        if (! in_array($request->company_id, $companyIds)) {
            return response()->json(['success' => false, 'message' => 'Perusahaan tidak valid.'], 403);
        }

        session(['session_company_id' => $request->company_id]);

        return response()->json(['success' => true]);
    }
}
