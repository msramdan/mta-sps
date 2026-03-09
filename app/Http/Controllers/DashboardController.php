<?php

namespace App\Http\Controllers;

use App\Models\JadwalTeknisi;
use App\Models\KunjunganSale;
use App\Models\Penagihan;
use App\Models\Spk;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(): View
    {
        $companyId = session('session_company_id');

        $data = [
            'companyId' => $companyId,
            'companyName' => null,
            'summary' => null,
            'chartStatus' => null,
            'chartSpkBulanan' => null,
            'recentSpk' => collect(),
            'upcomingJadwal' => collect(),
            'recentKunjungan' => collect(),
        ];

        if ($companyId) {
            $data['companyName'] = \App\Models\Company::find($companyId)?->name;

            $data['summary'] = $this->getSummary($companyId);
            $data['chartStatus'] = $this->getChartStatusPembayaran($companyId);
            $data['chartSpkBulanan'] = $this->getChartSpkBulanan($companyId);
            $data['recentSpk'] = Spk::with('sph')
                ->where('company_id', $companyId)
                ->orderByDesc('tanggal_spk')
                ->limit(5)
                ->get();
            $data['upcomingJadwal'] = JadwalTeknisi::with(['spk:id,no_spk', 'teknisi:id,name'])
                ->where('company_id', $companyId)
                ->where('tanggal_mulai', '>=', now()->toDateString())
                ->orderBy('tanggal_mulai')
                ->limit(5)
                ->get();
            $data['recentKunjungan'] = KunjunganSale::with('user:id,name')
                ->where('company_id', $companyId)
                ->orderByDesc('tanggal_visit')
                ->limit(5)
                ->get();
        }

        return view('dashboard', $data);
    }

    protected function getSummary(string $companyId): array
    {
        $totalNilaiKontrak = (float) Spk::where('company_id', $companyId)->sum('nilai_kontrak');
        $jumlahSpk = Spk::where('company_id', $companyId)->count();

        $totalTerbayar = (float) Spk::where('company_id', $companyId)
            ->whereHas('penagihan', fn ($q) => $q->where('status', 'terbayar'))
            ->sum('nilai_kontrak');

        $piutang = $totalNilaiKontrak - $totalTerbayar;
        if ($piutang < 0) {
            $piutang = 0;
        }

        return [
            'total_nilai_kontrak' => $totalNilaiKontrak,
            'jumlah_spk' => $jumlahSpk,
            'total_terbayar' => $totalTerbayar,
            'piutang' => $piutang,
        ];
    }

    protected function getChartStatusPembayaran(string $companyId): array
    {
        $query = Spk::where('spk.company_id', $companyId)
            ->leftJoin('penagihan', 'spk.id', '=', 'penagihan.spk_id')
            ->select(
                DB::raw("COALESCE(penagihan.status, 'pending') as status"),
                DB::raw('SUM(spk.nilai_kontrak) as total')
            )
            ->groupBy('status');

        $byStatus = [
            'pending' => 0,
            'proses_penagihan' => 0,
            'terbayar' => 0,
        ];

        foreach ($query->get() as $row) {
            $status = $row->status ?? 'pending';
            if (array_key_exists($status, $byStatus)) {
                $byStatus[$status] = (float) $row->total;
            }
        }

        return [
            'labels' => [
                'Pending' => $byStatus['pending'],
                'Proses Penagihan' => $byStatus['proses_penagihan'],
                'Terbayar' => $byStatus['terbayar'],
            ],
            'colors' => ['#6c757d', '#0dcaf0', '#198754'],
        ];
    }

    protected function getChartSpkBulanan(string $companyId): array
    {
        $data = Spk::where('company_id', $companyId)
            ->select(
                DB::raw('YEAR(tanggal_spk) as tahun'),
                DB::raw('MONTH(tanggal_spk) as bulan'),
                DB::raw('SUM(nilai_kontrak) as total')
            )
            ->whereNotNull('tanggal_spk')
            ->groupBy('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->limit(12)
            ->get()
            ->reverse()
            ->values();

        $labels = [];
        $values = [];
        $bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        foreach ($data as $row) {
            $labels[] = $bulan[(int) $row->bulan] . ' ' . $row->tahun;
            $values[] = (float) $row->total;
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }
}
