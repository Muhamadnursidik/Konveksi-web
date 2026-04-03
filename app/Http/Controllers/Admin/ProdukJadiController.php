<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProdukJadi;

class ProdukJadiController extends Controller
{
    public function index()
    {
        $data = ProdukJadi::with([
            'jobProduksi.modelPakaian',
        ])->latest()->get();

        return view('admin.produk-jadi.index', compact('data'));
    }

    public function show(ProdukJadi $produkJadi)
    {
        $data = $produkJadi->load([
            'jobProduksi.modelPakaian',
            'jobProduksi.bahanBaku',
        ]);

        return view('admin.produk-jadi.show', compact('data'));
    }
}
