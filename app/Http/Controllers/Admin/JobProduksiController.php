<?php
namespace App\Http\Controllers\Admin;

use App\Helpers\NotifHelper;
use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\JobProduksi;
use App\Models\ModelPakaian;
use App\Models\ProdukJadi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobProduksiController extends Controller
{
    public function index()
    {
        $data = JobProduksi::where('status', '!=', 'selesai')->
            with([
            'modelPakaian',
            'bahanBaku',
            'pemotongan.pemotong',
            'penjahitan.penjahit',
            'finishing.finishing',
        ])->latest('id')->get();

        return view('admin.job-produksi.index', compact('data'));
    }

    public function table()
    {
        $data = JobProduksi::where('status', '!=', 'selesai')
            ->with([
                'modelPakaian',
                'bahanBaku',
                'pemotongan.pemotong',
                'penjahitan.penjahit',
                'finishing.finishing',
            ])->latest('id')->get();

        return view('admin.job-produksi.partials.table-body', compact('data'));
    }

    public function create()
    {
        return view('admin.job-produksi.create', [
            'modelPakaian' => ModelPakaian::all(),
            'bahanBaku'    => BahanBaku::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_pakaian_id' => 'required|exists:model_pakaian,id',
            'bahan_baku_id'    => 'required|exists:bahan_baku,id',
            'jumlah_target'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $model = ModelPakaian::findOrFail($request->model_pakaian_id);
            $bahan = BahanBaku::findOrFail($request->bahan_baku_id);

            $kebutuhan = $model->kebutuhan_bahan * $request->jumlah_target;

            if ($bahan->stok_meter < $kebutuhan) {
                return redirect()->route('admin.job-produksi.create')->with('error', 'Stok bahan baku tidak mencukupi');
            }

            JobProduksi::create([
                'model_pakaian_id'      => $model->id,
                'bahan_baku_id'         => $bahan->id,
                'jumlah_target'         => $request->jumlah_target,
                'kebutuhan_bahan_total' => $kebutuhan,
                'status'                => 'menunggu',
            ]);

            NotifHelper::admin(
                'Job Baru',
                'Job produksi ' . $model->nama_model . ' dibuat (' . $request->jumlah_target . ' pcs)'
            );

            NotifHelper::pemotong(
                'Job Baru',
                'Ada job baru: ' . $model->nama_model . ' (' . $request->jumlah_target . ' pcs)'
            );

            $bahan->decrement('stok_meter', $kebutuhan);

            if ($bahan->stok_meter < 5) {
                NotifHelper::admin(
                    'Stok Menipis',
                    'Bahan ' . $bahan->nama_bahan . ' tersisa ' . $bahan->stok_meter . ' meter'
                );
            }
        });

        return redirect()->route('admin.job-produksi.index')
            ->with('success', 'Job produksi berhasil dibuat');
    }

    /**
     * ❌ EDIT TIDAK BOLEH UBAH STATUS
     */
    public function edit(JobProduksi $jobProduksi)
    {
        if ($jobProduksi->status !== 'menunggu') {
            return back()->with('error', 'Job sudah berjalan, tidak bisa diedit');
        }

        return view('admin.job-produksi.edit', [
            'jobProduksi'  => $jobProduksi,
            'modelPakaian' => ModelPakaian::all(),
            'bahanBaku'    => BahanBaku::all(),
        ]);
    }

    public function update(Request $request, JobProduksi $jobProduksi)
    {
        if ($jobProduksi->status !== 'menunggu') {
            return back()->with('error', 'Status hanya berubah lewat ACC');
        }

        $request->validate([
            'model_pakaian_id' => 'required|exists:model_pakaian,id',
            'bahan_baku_id'    => 'required|exists:bahan_baku,id',
            'jumlah_target'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $jobProduksi) {

            // balikin stok lama
            $jobProduksi->bahanBaku->increment(
                'stok_meter',
                $jobProduksi->kebutuhan_bahan_total
            );

            $model = ModelPakaian::findOrFail($request->model_pakaian_id);
            $bahan = BahanBaku::findOrFail($request->bahan_baku_id);

            $kebutuhanBaru = $model->kebutuhan_bahan * $request->jumlah_target;

            if ($bahan->stok_meter < $kebutuhanBaru) {
                abort(400, 'Stok bahan baku tidak mencukupi');
            }

            $bahan->decrement('stok_meter', $kebutuhanBaru);

            $jobProduksi->update([
                'model_pakaian_id'      => $model->id,
                'bahan_baku_id'         => $bahan->id,
                'jumlah_target'         => $request->jumlah_target,
                'kebutuhan_bahan_total' => $kebutuhanBaru,
            ]);

            NotifHelper::admin(
                'Job Diperbarui',
                'Job produksi #' . $jobProduksi->id . ' diperbarui'
            );
            NotifHelper::pemotong(
                'Job Diperbarui',
                'Job produksi #' . $jobProduksi->id . ' diperbarui'
            );
            NotifHelper::penjahit(
                'Job Diperbarui',
                'Job produksi #' . $jobProduksi->id . ' diperbarui'
            );
            NotifHelper::finishing(
                'Job Diperbarui',
                'Job produksi #' . $jobProduksi->id . ' diperbarui'
            );
        });

        return redirect()->route('admin.job-produksi.index')
            ->with('success', 'Job produksi diperbarui');
    }

    public function destroy(JobProduksi $jobProduksi)
    {
        if ($jobProduksi->status !== 'menunggu') {
            return back()->with('error', 'Job sedang berjalan');
        }

        DB::transaction(function () use ($jobProduksi) {
            $jobProduksi->bahanBaku->increment(
                'stok_meter',
                $jobProduksi->kebutuhan_bahan_total
            );
            $jobProduksi->delete();
        });

        NotifHelper::admin(
            'Job Dihapus',
            'Job #' . $jobProduksi->id . ' telah dihapus'
        );

        return back()->with('success', 'Job produksi dihapus');
    }

    public function accPemotongan(JobProduksi $job)
    {
        if (! $job->pemotongan || $job->pemotongan->status !== 'pending') {
            return back()->with('error', 'Pemotongan belum siap');
        }

        DB::transaction(function () use ($job) {
            $job->pemotongan->update(['status' => 'dipotong']);
            $job->update(['status' => 'dipotong']);
        });

        NotifHelper::admin(
            'Update Produksi',
            'Job #' . $job->id . ' masuk tahap Penjahitan'
        );

        NotifHelper::penjahit(
            'Job Baru',
            'Ada job baru: ' . $job->modelPakaian->nama_model . ' (' . $job->jumlah_target . ' pcs)'
        );

        return back()->with('success', 'Pemotongan di-ACC');
    }

    public function accPenjahitan(JobProduksi $job)
    {
        if (! $job->penjahitan || $job->penjahitan->status !== 'pending') {
            return back()->with('error', 'Penjahitan belum siap');
        }

        DB::transaction(function () use ($job) {
            $job->penjahitan->update(['status' => 'dijahit']);
            $job->update(['status' => 'dijahit']);
        });

        NotifHelper::admin(
            'Update Produksi',
            'Job #' . $job->id . ' masuk tahap Finishing'
        );
        NotifHelper::finishing(
            'Job Baru',
            'Ada job baru: ' . $job->modelPakaian->nama_model . ' (' . $job->jumlah_target . ' pcs)'
        );

        return back()->with('success', 'Penjahitan di-ACC');
    }

    public function accFinishing(JobProduksi $job)
    {
        if (! $job->finishing || $job->finishing->status !== 'pending') {
            return back()->with('error', 'Finishing belum siap');
        }

        DB::transaction(function () use ($job) {
            $job->finishing->update(['status' => 'selesai']);
            $job->update(['status' => 'selesai']);

            ProdukJadi::firstOrCreate([
                'job_produksi_id' => $job->id,
            ], [
                'tanggal_selesai' => now(),
            ]);

            NotifHelper::admin(
                'Produksi Selesai',
                'Job #' . $job->id . ' selesai dan masuk produk jadi'
            );
        });

        return back()->with('success', 'Finishing di-ACC, produk jadi dibuat');
    }

    // Tambahkan setelah accPemotongan()
    public function tolakPemotongan(Request $request, JobProduksi $job)
    {
        if (! $job->pemotongan || $job->pemotongan->status !== 'pending') {
            return back()->with('error', 'Pemotongan belum siap atau sudah diproses');
        }

        $request->validate([
            'catatan_tolak' => 'required|string|max:255',
        ]);

        // Simpan dulu sebelum didelete
        $pemotongId = $job->pemotongan->pemotong_id;

        DB::transaction(function () use ($job) {
            $job->pemotongan->delete();
            // job tetap 'menunggu', pemotong bisa submit ulang
        });

        NotifHelper::user(
            $pemotongId,
            'Pemotongan Ditolak',
            'Pemotongan job ' . $job->modelPakaian->nama_model . ' ditolak. Alasan: ' . $request->catatan_tolak . '. Harap perbaiki dan submit ulang.'
        );

        return back()->with('success', 'Pemotongan ditolak, pemotong akan dinotifikasi');
    }

    public function tolakPenjahitan(Request $request, JobProduksi $job)
    {
        if (! $job->penjahitan || $job->penjahitan->status !== 'pending') {
            return back()->with('error', 'Penjahitan belum siap atau sudah diproses');
        }

        $request->validate([
            'catatan_tolak' => 'required|string|max:255',
        ]);

        // Simpan dulu sebelum didelete
        $penjahitId = $job->penjahitan->penjahit_id;

        DB::transaction(function () use ($job) {
            $job->penjahitan->delete();
            $job->update(['status' => 'dipotong']); // balik ke tahap sebelumnya
        });

        NotifHelper::user(
            $penjahitId,
            'Penjahitan Ditolak',
            'Penjahitan job ' . $job->modelPakaian->nama_model . ' ditolak. Alasan: ' . $request->catatan_tolak . '. Harap perbaiki dan submit ulang.'
        );

        return back()->with('success', 'Penjahitan ditolak, penjahit akan dinotifikasi');
    }

    public function tolakFinishing(Request $request, JobProduksi $job)
    {
        if (! $job->finishing || $job->finishing->status !== 'pending') {
            return back()->with('error', 'Finishing belum siap atau sudah diproses');
        }

        $request->validate([
            'catatan_tolak' => 'required|string|max:255',
        ]);

        // Simpan dulu sebelum didelete
        $finishingId = $job->finishing->finishing_id;

        DB::transaction(function () use ($job) {
            $job->finishing->delete();
            $job->update(['status' => 'dijahit']); // balik ke tahap sebelumnya
        });

        NotifHelper::user(
            $finishingId,
            'Finishing Ditolak',
            'Finishing job ' . $job->modelPakaian->nama_model . ' ditolak. Alasan: ' . $request->catatan_tolak . '. Harap perbaiki dan submit ulang.'
        );

        return back()->with('success', 'Finishing ditolak, tim finishing akan dinotifikasi');
    }
}
