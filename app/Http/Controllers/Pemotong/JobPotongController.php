<?php
namespace App\Http\Controllers\Pemotong;

use App\Helpers\NotifHelper;
use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Pemotongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobPotongController extends Controller
{
    public function index()
    {
        $jobs = JobProduksi::with('modelPakaian')
            ->where('status', 'menunggu')
            ->whereDoesntHave('pemotongan')
            ->orderBy('created_at')
            ->get();

        return view('pemotong.job.job-potong', compact('jobs'));
    }

    public function selesai(Request $request, JobProduksi $job)
    {
        if ($job->status !== 'menunggu') {
            abort(403, 'Job tidak bisa dipotong');
        }

        if ($job->pemotongan) {
            return back()->with('error', 'Job ini sudah dipotong');
        }

        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('foto_bukti')
            ->store('bukti/pemotongan', 'public');

        Pemotongan::create([
            'job_produksi_id' => $job->id,
            'pemotong_id'     => Auth::id(),
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
        $jobs = Pemotongan::with([
            'jobProduksi.modelPakaian',
        ])
            ->where('pemotong_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('pemotong.job.riwayat-potong', compact('jobs'));
    }

    public function table()
    {
        $jobs = JobProduksi::with('modelPakaian')
            ->where('status', 'menunggu')
            ->whereDoesntHave('pemotongan')
            ->orderBy('created_at')
            ->get();
        return view('pemotong.partials.table-body', compact('jobs'));
    }
}
