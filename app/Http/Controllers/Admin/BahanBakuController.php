<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBaku;
use Illuminate\Http\Request;

class BahanBakuController extends Controller
{
    public function index()
    {
        return view('admin.bahan_baku.index', [
            'data' => BahanBaku::orderBy('id','desc')->get()
        ]);
    }

    public function create()
    {
        return view('admin.bahan_baku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan'  => 'required',
            'warna'       => 'required',
            'stok_meter'  => 'required|numeric',
            'keterangan'  => 'nullable',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $bahanBaku = BahanBaku::create($request->all());

        if ($request->hasFile('foto')) {
            $bahanBaku->foto = $request->file('foto')->store('bahan_baku', 'public');
            $bahanBaku->save();
        }

        return redirect()->route('admin.bahan-baku.index')->with('success', 'Bahan baku berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin.bahan_baku.edit', [
            'item' => BahanBaku::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan'  => 'required',
            'warna'       => 'required',
            'stok_meter'  => 'required|numeric',
            'keterangan'  => 'nullable',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $bahanBaku = BahanBaku::findOrFail($id)->update($request->all());

        if ($request->hasFile('foto')) {
            $bahanBaku->foto = $request->file('foto')->store('bahan_baku', 'public');
            $bahanBaku->save();
        }

        return redirect()->route('admin.bahan-baku.index')->with('success', 'Bahan baku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);

        if ($bahan->jobProduksi()->exists()) {
            return back()->with('error', 'Bahan baku tidak bisa dihapus karena masih digunakan di job produksi');
        }

        BahanBaku::destroy($id);
        return back()->with('success', 'Bahan baku berhasil dihapus');
    }
}
