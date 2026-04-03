<?php
namespace App\Http\Controllers\Pemotong;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;

class DashboardController extends Controller
{
    public function index()
    {
        $jobAktif = JobProduksi::whereIn('status', ['menunggu', 'proses'])->count();

        $jobSelesaiHariIni = JobProduksi::whereDate('updated_at', now())
            ->where('status', 'selesai')
            ->count();

        $totalTarget = JobProduksi::whereIn('status', ['menunggu', 'proses'])
            ->sum('jumlah_target');

        $totalHasilHariIni = JobProduksi::where('status', 'dipotong')
            ->count();

        $jobHariIni = JobProduksi::with('modelPakaian')
            ->whereIn('status', ['menunggu', 'proses'])
            ->limit(5)
            ->get();

        return view('pemotong.dashboard', compact(
            'jobAktif',
            'jobSelesaiHariIni',
            'totalTarget',
            'totalHasilHariIni',
            'jobHariIni'
        ));
    }

}
