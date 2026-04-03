<?php
namespace App\Http\Controllers\Admin;

use App\Exports\LaporanProdukJadiExport;
use App\Exports\LaporanBahanBakuExport;
use App\Exports\LaporanProduksiExport;
use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use App\Models\JobProduksi;
use App\Models\ProdukJadi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * LAPORAN PRODUKSI
     */
    public function produksi(Request $request)
    {
        $query = JobProduksi::with(['modelPakaian', 'bahanBaku']);

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->get();

        return view('admin.laporan.produksi', compact('data'));
    }

    /**
     * LAPORAN BAHAN BAKU
     */
    public function bahanBaku(Request $request)
    {
        $data = BahanBaku::all()->map(function ($row) {

            $stok_saat_ini = $row->stok_meter;

            $total_terpakai = JobProduksi::where('bahan_baku_id', $row->id)
                ->sum('kebutuhan_bahan_total');

            $stok_awal = $stok_saat_ini + $total_terpakai;

            return (object) [
                'nama_bahan'     => $row->nama_bahan,
                'warna'          => $row->warna,
                'stok_awal'      => $stok_awal,
                'total_terpakai' => $total_terpakai,
                'sisa'           => $stok_saat_ini,
                'status'         => $stok_saat_ini > 0 ? 'Tersedia' : 'Habis',
            ];
        });

        return view('admin.laporan.bahan-baku', compact('data'));
    }

    /**
     * LAPORAN PRODUK JADI
     */
    public function produkJadi(Request $request)
    {
        $query = ProdukJadi::with('jobProduksi.modelPakaian');

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_selesai', [
                $request->tanggal_awal,
                $request->tanggal_akhir,
            ]);
        }

        $data = $query->latest()->get();

        return view('admin.laporan.produk-jadi', compact('data'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new LaporanProduksiExport($request),
            'laporan-produksi.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $query = JobProduksi::with(['modelPakaian', 'bahanBaku']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.laporan.produksi-pdf', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan-produksi.pdf');
    }

    public function exportBahanBakuExcel(Request $request)
    {
        return Excel::download(
            new LaporanBahanBakuExport($request),
            'laporan-bahan-baku.xlsx'
        );
    }

    public function exportBahanBakuPdf()
    {
        $data = BahanBaku::all()->map(function ($row) {
            $stok_saat_ini  = $row->stok_meter;
            $total_terpakai = JobProduksi::where('bahan_baku_id', $row->id)
                ->sum('kebutuhan_bahan_total');

            return [
                'nama_bahan'     => $row->nama_bahan,
                'warna'          => $row->warna,
                'stok_awal'      => $stok_saat_ini + $total_terpakai,
                'total_terpakai' => $total_terpakai,
                'sisa'           => $stok_saat_ini,
            ];
        });

        $pdf = Pdf::loadView('admin.laporan.bahan-baku-pdf', compact('data'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan-bahan-baku.pdf');
    }

    public function exportProdukJadiExcel(Request $request)
    {
        return Excel::download(
            new LaporanProdukJadiExport($request),
            'laporan-produk-jadi.xlsx'
        );
    }

    public function exportProdukJadiPdf(Request $request)
    {
        $data = ProdukJadi::with([
            'jobProduksi.modelPakaian',
        ])
            ->orderBy('tanggal_selesai', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.produk-jadi-pdf', compact('data'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-produk-jadi.pdf');
    }
}
