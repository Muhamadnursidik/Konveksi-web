<?php

namespace App\Http\Controllers\Penjahit;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $jobMenunggu = JobProduksi::where('status', 'dipotong')->count();

        $targetHariIni = JobProduksi::where('status', 'dipotong')
            ->sum('jumlah_target');

        $selesaiHariIni = JobProduksi::where('status', 'dijahit')
            ->whereDate('updated_at', $today)
            ->sum('jumlah_target');

        $jobAktif = JobProduksi::with('modelPakaian')
            ->where('status', 'dipotong')
            ->limit(5)
            ->get();

        $riwayatHariIni = JobProduksi::with('modelPakaian')
            ->where('status', 'dijahit')
            ->whereDate('updated_at', $today)
            ->latest()
            ->limit(5)
            ->get();

        return view('penjahit.dashboard', compact(
            'jobMenunggu',
            'targetHariIni',
            'selesaiHariIni',
            'jobAktif',
            'riwayatHariIni'
        ));
    }
}
