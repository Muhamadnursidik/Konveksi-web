<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Pemotongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PemotongController extends Controller
{
    // GET /api/pemotong/jobs
    // Job yang menunggu & belum ada pemotong
public function jobs()
{
    $jobs = JobProduksi::with(['modelPakaian', 'bahanBaku'])
        ->where('status', 'menunggu')
        ->whereDoesntHave('pemotongan') // ✅ yang sudah ada pemotongan pending tidak tampil
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
    // Upload bukti & klaim job
    public function selesai(Request $request, $id)
    {
        $request->validate([
            'foto_bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $job = JobProduksi::findOrFail($id);

        // Pastikan job masih menunggu
        if ($job->status !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Job sudah tidak tersedia'
            ], 400);
        }

        // Pastikan belum diklaim
        if ($job->pemotong_id !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Job sudah diambil pemotong lain'
            ], 400);
        }

        // Simpan foto
        $path = $request->file('foto_bukti')
            ->store('bukti/pemotongan', 'public');

        // Buat record pemotongan
        Pemotongan::create([
            'job_produksi_id' => $job->id,
            'pemotong_id'     => Auth::id(),
            'foto_bukti'      => $path,
            'status'          => 'pending',
        ]);

        // Update job: klaim ke pemotong ini & ubah status
        $job->update([
            'pemotong_id' => Auth::id(),
            'status'      => 'dipotong',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil dikirim, menunggu ACC admin'
        ]);
    }

    // GET /api/pemotong/riwayat
    // Riwayat pekerjaan pemotong yang login
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
