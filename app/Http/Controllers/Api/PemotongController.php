<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotifHelper;
use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Pemotongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemotongController extends Controller
{
    // GET /api/pemotong/jobs
    public function jobs()
    {
        $jobs = JobProduksi::with(['modelPakaian', 'bahanBaku'])
            ->where('status', 'menunggu')
            ->whereDoesntHave('pemotongan') // ✅ sama dengan web
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($j) => [
                'id'                    => $j->id,
                'model_pakaian'         => $j->modelPakaian->nama_model ?? '-',
                'bahan'                 => $j->bahanBaku->nama_bahan ?? '-',
                'jumlah_target'         => $j->jumlah_target,
                'kebutuhan_bahan_total' => $j->kebutuhan_bahan_total,
                'status'                => $j->status,
            ]);

        return response()->json(['data' => $jobs]);
    }

    // POST /api/pemotong/jobs/{id}/selesai
    public function selesai(Request $request, $id)
    {
        $job = JobProduksi::findOrFail($id);

        if ($job->status !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Job tidak bisa dipotong'
            ], 403);
        }

        if ($job->pemotongan) {
            return response()->json([
                'success' => false,
                'message' => 'Job ini sudah dipotong'
            ], 400);
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
            'Job produksi #' . $job->id . ' siap di-ACC pemotongan'
        );

        return response()->json([
            'success' => true,
            'message' => 'Berhasil, Menunggu ACC admin',
        ]);
    }

    // GET /api/pemotong/riwayat
    public function riwayat()
    {
        $riwayat = Pemotongan::with([
            'jobProduksi.modelPakaian',
            'jobProduksi.bahanBaku',
        ])
            ->where('pemotong_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($p) => [
                'id'            => $p->id,
                'model_pakaian' => $p->jobProduksi->modelPakaian->nama_model ?? '-',
                'bahan'         => $p->jobProduksi->bahanBaku->nama_bahan ?? '-',
                'jumlah_target' => $p->jobProduksi->jumlah_target,
                'status'        => $p->status,  // pending | dipotong
                'foto_bukti'    => $p->foto_bukti
                                    ? asset('storage/' . $p->foto_bukti)
                                    : null,
                'tanggal'       => $p->created_at->format('d M Y'),
            ]);

        return response()->json(['data' => $riwayat]);
    }
}
