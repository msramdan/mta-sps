<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $companyId = session('session_company_id');
        if (! $companyId) {
            Alert::warning('Peringatan', 'Pilih perusahaan terlebih dahulu.');
            return redirect()->route('dashboard');
        }

        $spkList = Spk::with(['penagihan', 'sph'])
            ->where('company_id', $companyId)
            ->orderByDesc('tanggal_spk')
            ->get();

        return view('laporan.index', compact('spkList'));
    }
}
