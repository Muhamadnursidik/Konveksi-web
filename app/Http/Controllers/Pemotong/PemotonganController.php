<?php

namespace App\Http\Controllers\Pemotong;

use App\Http\Controllers\Controller;
use App\Models\JobProduksi;
use App\Models\Pemotongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PemotonganController extends Controller
{
    public function index()
    {
        $jobs = JobProduksi::whereDoesntHave('pemotongan')
            ->where('status', 'menunggu')
            ->get();

        return view('pemotong.index', compact('jobs'));
    }

    public function store(Request $request, JobProduksi $job)
    {
        $request->validate([
            'foto_bukti' => 'required|image|max:2048',
        ]);

        $path = $request->file('foto_bukti')->store('pemotongan');

        Pemotongan::create([
            'job_produksi_id' => $job->id,
            'pemotong_id'     => Auth::id(),
            'foto_bukti'      => $path,
            'status'          => 'pending',
        ]);

        return back()->with('success','Pemotongan dikirim, menunggu ACC admin');
    }
}
