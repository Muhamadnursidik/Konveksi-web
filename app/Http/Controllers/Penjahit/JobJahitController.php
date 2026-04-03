<?php

namespace App\Http\Controllers\Penjahit;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Penjahitan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotifHelper;

class JobJahitController extends Controller
{
    public function index()
    {
        $jobs = JobProduksi::with([
                'modelPakaian',
                'pemotongan.pemotong'
            ])
            ->where('status', 'dipotong')
            ->whereDoesntHave('penjahitan') // belum dijahit
            ->orderBy('updated_at')
            ->get();

        return view('penjahit.job.index', compact('jobs'));
    }

    public function selesai(Request $request, JobProduksi $job)
    {
        if ($job->status !== 'dipotong') {
            abort(403, 'Job tidak bisa dijahit');
        }

        if ($job->penjahitan) {
            return back()->with('error', 'Job ini sudah dijahit');
        }

        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ],
        [
            'foto_bukti.required' => 'Bukti jahit wajib diisi.',
            'foto_bukti.image'    => 'File harus berupa gambar.',
            'foto_bukti.mimes'    => 'Bukti jahit harus berformat JPG atau PNG.',
            'foto_bukti.max'      => 'Ukuran bukti jahit maksimal 2MB.',
        ]
        );

        $path = $request->file('foto_bukti')
            ->store('bukti/penjahitan', 'public');

        Penjahitan::create([
            'job_produksi_id' => $job->id,
            'pemotong_id'     => $job->pemotongan->pemotong_id,
            'penjahit_id'     => Auth::id(),
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
        $jobs = Penjahitan::with([
                'jobProduksi.modelPakaian'
            ])
            ->where('penjahit_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('penjahit.job.riwayat', compact('jobs'));
    }

    public function table()
    {
        $jobs = JobProduksi::with([
                'modelPakaian',
                'pemotongan.pemotong'
            ])
            ->where('status', 'dipotong')
            ->whereDoesntHave('penjahitan')
            ->orderBy('updated_at')
            ->get();

        return view('penjahit.partials.table-body', compact('jobs'));
    }
}
