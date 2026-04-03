<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $totalJob     = JobProduksi::count();
        $jobAktif     = JobProduksi::where('status', '!=', 'selesai')->count();
        $jobSelesai   = JobProduksi::where('status', 'selesai')->count();
        $totalTarget  = JobProduksi::sum('jumlah_target');
        $users        = User::latest()->limit(5)->get();
        $jobs         = JobProduksi::latest()->limit(10)->get();
        $jobMenunggu  = JobProduksi::where('status', 'menunggu')->count();
        $jobDiproses  = JobProduksi::where('status', 'dipotong')->count();
        $jobDijahit   = JobProduksi::where('status', 'dijahit')->count();
        $jobSelesai   = JobProduksi::where('status', 'selesai')->count();

        $jobTerbaru = JobProduksi::with('modelPakaian')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalJob',
            'jobAktif',
            'jobSelesai',
            'totalTarget',
            'jobTerbaru',
            'users',
            'jobs',
            'jobMenunggu',
            'jobDiproses',
            'jobDijahit',
            'jobSelesai'
        ) + [
            'persenMenunggu' => $totalJob ? ($jobMenunggu / $totalJob) * 100 : 0,
            'persenPotong' => $totalJob ? ($jobDiproses / $totalJob) * 100 : 0,
            'persenJahit' => $totalJob ? ($jobDijahit / $totalJob) * 100 : 0,
            'persenSelesai' => $totalJob ? ($jobSelesai / $totalJob) * 100 : 0,
        ]
        );
    }

}
