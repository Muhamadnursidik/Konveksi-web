<?php
namespace App\Http\Controllers\Pemotong;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;

class DataBahanBakuController extends Controller
{
    public function index()
    {
        return view('pemotong.data-bahan-baku', [
            'data' => BahanBaku::orderBy('id', 'desc')->get(),
        ]);
    }
}
