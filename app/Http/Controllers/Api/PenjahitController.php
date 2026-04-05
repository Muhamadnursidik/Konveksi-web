<?php
namespace App\Http\Controllers\Api;

use App\Helpers\NotifHelper;
use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\ModelPakaian;
use App\Models\Penjahitan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjahitController extends Controller
{
    // GET /api/penjahit/stats
    public function stats()
    {
        $penjahitId = Auth::id();

        $jobMenunggu = JobProduksi::where('status', 'dipotong')
            ->whereDoesntHave('penjahitan')
            ->count();

        $targetHariIni = Penjahitan::with('jobProduksi')
            ->where('penjahit_id', $penjahitId)
            ->whereDate('created_at', today())
            ->get()
            ->sum(fn($p) => $p->jobProduksi->jumlah_target ?? 0);

        $selesaiHariIni = Penjahitan::where('penjahit_id', $penjahitId)
            ->whereDate('created_at', today())
            ->count();

        return response()->json([
            'job_menunggu'     => $jobMenunggu,
            'target_hari_ini'  => $targetHariIni,
            'selesai_hari_ini' => $selesaiHariIni,
        ]);
    }

    // GET /api/penjahit/jobs
    public function jobs()
    {
        $jobs = JobProduksi::with(['modelPakaian', 'bahanBaku', 'pemotongan'])
            ->where('status', 'dipotong')
            ->whereDoesntHave('penjahitan')
            ->orderBy('updated_at', 'asc')
            ->get()
            ->map(fn($j) => [
                'id'            => $j->id,
                'model_pakaian' => $j->modelPakaian->nama_model ?? '-',
                'bahan'         => $j->bahanBaku->nama_bahan ?? '-',
                'jumlah_target' => $j->jumlah_target,
                'status'        => $j->status,
            ]);

        return response()->json(['data' => $jobs]);
    }

    // POST /api/penjahit/jobs/{id}/selesai
    public function selesai(Request $request, $id)
    {
        $job = JobProduksi::findOrFail($id);

        if ($job->status !== 'dipotong') {
            return response()->json([
                'success' => false,
                'message' => 'Job tidak bisa dijahit',
            ], 403);
        }

        if ($job->penjahitan) {
            return response()->json([
                'success' => false,
                'message' => 'Job ini sudah dijahit',
            ], 400);
        }

        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('foto_bukti')
            ->store('bukti/penjahitan', 'public');

        Penjahitan::create([
            'job_produksi_id' => $job->id,
            'pemotong_id'     => $job->pemotongan?->pemotong_id,
            'penjahit_id'     => Auth::id(),
            'foto_bukti'      => $path,
            'status'          => 'pending',
        ]);

        NotifHelper::admin(
            'Job Diperbarui',
            'Job produksi #' . $job->id . ' siap di-ACC penjahitan'
        );

        return response()->json([
            'success' => true,
            'message' => 'Berhasil, Menunggu ACC admin',
        ]);
    }

    // GET /api/penjahit/riwayat
    public function riwayat()
    {
        $riwayat = Penjahitan::with([
            'jobProduksi.modelPakaian',
            'jobProduksi.bahanBaku',
        ])
            ->where('penjahit_id', Auth::id())
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($p) => [
                'id'            => $p->id,
                'model_pakaian' => $p->jobProduksi->modelPakaian->nama_model ?? '-',
                'bahan'         => $p->jobProduksi->bahanBaku->nama_bahan ?? '-',
                'jumlah_target' => $p->jobProduksi->jumlah_target,
                'status'        => $p->status, // pending | dijahit
                'foto_bukti'    => $p->foto_bukti
                    ? url('storage-file/' . $p->foto_bukti)
                    : null,
                'tanggal'       => $p->created_at->format('d M Y'),
            ]);

        return response()->json(['data' => $riwayat]);
    }

    public function modelPakaian()
    {
        $models = \App\Models\ModelPakaian::orderBy('nama_model')
            ->get()
            ->map(fn($m) => [
                'id'              => $m->id,
                'nama'            => $m->nama_model,
                'kategori'        => $m->kategori,
                'ukuran'          => $m->ukuran,
                'kebutuhan_bahan' => $m->kebutuhan_bahan,
                'foto'            => $m->foto_model
                    ? url('storage-file/' . $m->foto_model)
                    : null,
            ]);

        return response()->json(['data' => $models]);
    }
}
