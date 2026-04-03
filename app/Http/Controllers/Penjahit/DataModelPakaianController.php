<?php

namespace App\Http\Controllers\Penjahit;

use App\Http\Controllers\Controller;
use App\Models\ModelPakaian;
use Illuminate\Http\Request;

class DataModelPakaianController extends Controller
{
        public function index()
    {
        return view('penjahit.data-model-pakaian', [
            'data' => ModelPakaian::orderBy('id', 'desc')->get(),
        ]);
    }
}
