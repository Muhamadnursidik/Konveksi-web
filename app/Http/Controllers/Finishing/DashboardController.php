<?php
namespace App\Http\Controllers\Finishing;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;

class DashboardController extends Controller
{

    public function index()
    {
        $siapFinishing = JobProduksi::where('status', 'dijahit')->count();

        $selesaiHariIni = JobProduksi::where('status', 'selesai')
            ->whereDate('updated_at', now())
            ->count();

        $totalPackingHariIni = JobProduksi::where('status', 'selesai')
            ->whereDate('updated_at', now())
            ->sum('jumlah_target');

        $jobTerbaru = JobProduksi::with('modelPakaian')
            ->where('status', 'dijahit')
            ->latest()
            ->take(5)
            ->get();

        return view('finishing.dashboard', compact(
            'siapFinishing',
            'selesaiHariIni',
            'totalPackingHariIni',
            'jobTerbaru'
        ));
    }

}
