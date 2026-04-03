<?php

namespace App\Http\Controllers\Finishing;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Finishing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotifHelper;

class JobFinishingController extends Controller
{
    public function index()
    {
        $jobs = JobProduksi::with(['penjahitan.penjahit','penjahitan.pemotong'])
            ->where('status', 'dijahit')
            ->whereDoesntHave('finishing')
            ->latest()
            ->get();

        return view('finishing.job.index', compact('jobs'));
    }

    public function selesai(Request $request, JobProduksi $job)
    {
        if ($job->status !== 'dijahit') {
            abort(403, 'Job tidak bisa di finishing');
        }

        if (!$job->penjahitan) {
            return back()->with('error', 'Data penjahitan belum ada');
        }

        $request->validate([
            'foto_bukti' => 'required|image|max:2048',
        ]);

        $path = $request->file('foto_bukti')
            ->store('bukti/finishing', 'public');

        Finishing::create([
            'job_produksi_id' => $job->id,
            'pemotong_id'     => $job->penjahitan->pemotong_id,
            'penjahit_id'     => $job->penjahitan->penjahit_id,
            'finishing_id'    => Auth::id(),
            'foto_bukti'      => $path,
            'status'          => 'pending',
        ]);

        NotifHelper::admin(
            'Job Diperbarui',
            'Job produksi #' . $job->id . ' diperbarui'
        );

        return response()->json([
            'success' => true,
            'message' => 'Berhasil, Menunggu ACC admin',
        ]);
    }

    public function riwayat()
    {
        $jobs = Finishing::with([
            'jobProduksi.modelPakaian',
            'pemotong',
            'penjahit',
            'finishing'
        ])
        ->where('finishing_id', Auth::id())
        ->latest()
        ->get();

        return view('finishing.job.riwayat', compact('jobs'));
    }

    public function table()
    {
        $jobs = JobProduksi::with(['penjahitan.penjahit','penjahitan.pemotong'])
            ->where('status', 'dijahit')
            ->whereDoesntHave('finishing')
            ->latest()
            ->get();

        return view('finishing.partials.table-body', compact('jobs'));
    }
}
