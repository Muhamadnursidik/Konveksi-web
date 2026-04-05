<?php

namespace App\Http\Controllers\Api;

use App\Helpers\NotifHelper;
use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Finishing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinishingController extends Controller
{
    // GET /api/finishing/stats
    public function stats()
    {
        $userId = Auth::id();

        $jobMenunggu = JobProduksi::where('status', 'dijahit')
            ->whereDoesntHave('finishing')
            ->count();

        $selesaiHariIni = Finishing::where('finishing_id', $userId)
            ->whereDate('created_at', today())
            ->count();

        $packingHariIni = Finishing::with('jobProduksi')
            ->where('finishing_id', $userId)
            ->whereDate('created_at', today())
            ->get()
            ->sum(fn($f) => $f->jobProduksi->jumlah_target ?? 0);

        $jobAktif = Finishing::where('finishing_id', $userId)
            ->count();

        return response()->json([
            'job_menunggu'      => $jobMenunggu,
            'selesai_hari_ini'  => $selesaiHariIni,
            'packing_hari_ini'  => $packingHariIni,
            'job_aktif'         => $jobAktif,
        ]);
    }

    // GET /api/finishing/jobs
    public function jobs()
    {
        $jobs = JobProduksi::with([
                'modelPakaian',
                'bahanBaku',
                'penjahitan',
            ])
            ->where('status', 'dijahit')
            ->whereDoesntHave('finishing')
            ->latest()
            ->get()
            ->map(fn($j) => [
                'id'            => $j->id,
                'model_pakaian' => $j->modelPakaian->nama_model ?? '-',
                'kategori'      => $j->modelPakaian->kategori ?? '-',
                'bahan'         => $j->bahanBaku->nama_bahan ?? '-',
                'jumlah_target' => $j->jumlah_target,
                'status'        => $j->status,
            ]);

        return response()->json(['data' => $jobs]);
    }

    // POST /api/finishing/jobs/{id}/selesai
    public function selesai(Request $request, $id)
    {
        $job = JobProduksi::findOrFail($id);

        if ($job->status !== 'dijahit') {
            return response()->json([
                'success' => false,
                'message' => 'Job tidak bisa di-finishing'
            ], 403);
        }

        if ($job->finishing) {
            return response()->json([
                'success' => false,
                'message' => 'Job ini sudah di-finishing'
            ], 400);
        }

        if (!$job->penjahitan) {
            return response()->json([
                'success' => false,
                'message' => 'Data penjahitan belum ada'
            ], 400);
        }

        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
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
            'Job produksi #' . $job->id . ' siap di-ACC finishing'
        );

        return response()->json([
            'success' => true,
            'message' => 'Berhasil, Menunggu ACC admin',
        ]);
    }

    // GET /api/finishing/riwayat
    public function riwayat()
    {
        $riwayat = Finishing::with([
            'jobProduksi.modelPakaian',
            'jobProduksi.bahanBaku',
        ])
            ->where('finishing_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($f) => [
                'id'            => $f->id,
                'model_pakaian' => $f->jobProduksi->modelPakaian->nama_model ?? '-',
                'kategori'      => $f->jobProduksi->modelPakaian->kategori ?? '-',
                'bahan'         => $f->jobProduksi->bahanBaku->nama_bahan ?? '-',
                'jumlah_target' => $f->jobProduksi->jumlah_target,
                'status'        => $f->status,  // pending | selesai
                'foto_bukti'    => $f->foto_bukti
                                    ? url('storage-file/' . $f->foto_bukti)
                                    : null,
                'tanggal'       => $f->created_at->format('d M Y'),
            ]);

        return response()->json(['data' => $riwayat]);
    }
}
