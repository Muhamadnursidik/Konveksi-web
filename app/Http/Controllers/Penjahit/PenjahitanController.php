<?php

namespace App\Http\Controllers\Penjahit;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Penjahitan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenjahitanController extends Controller
{
    public function index()
    {
        $jobs = JobProduksi::whereHas('pemotongan', fn($q) =>
            $q->where('status','acc')
        )->whereDoesntHave('penjahitan')->get();

        return view('penjahit.index', compact('jobs'));
    }

    public function store(Request $request, JobProduksi $job)
    {
        $request->validate([
            'foto_bukti' => 'required|image|max:2048',
        ]);

        $path = $request->file('foto_bukti')->store('penjahitan');

        Penjahitan::create([
            'job_produksi_id' => $job->id,
            'pemotong_id'     => $job->pemotongan->pemotong_id,
            'penjahit_id'     => Auth::id(),
            'foto_bukti'      => $path,
            'status'          => 'pending',
        ]);

        return back()->with('success','Penjahitan dikirim, menunggu ACC admin');
    }
}
