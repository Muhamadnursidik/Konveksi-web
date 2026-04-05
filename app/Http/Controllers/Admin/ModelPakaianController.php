<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModelPakaian;
use Illuminate\Http\Request;

class ModelPakaianController extends Controller
{
    public function index()
    {
        return view('admin.model_pakaian.index', [
            'data' => ModelPakaian::orderBy('id', 'desc')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.model_pakaian.create');
    }

    public function store(Request $request)
    {
        $kebutuhan = str_replace(',', '.', $request->kebutuhan_bahan);

        $request->merge([
            'kebutuhan_bahan' => $kebutuhan,
        ]);

        $request->validate([
            'nama_model'      => 'required',
            'kategori'        => 'required',
            'ukuran'          => 'required',
            'kebutuhan_bahan' => 'required|numeric',
            'foto_model'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $modelPakaian = ModelPakaian::create($request->all());

        if ($request->hasFile('foto_model')) {
            $modelPakaian->foto_model = $request->file('foto_model')->store('model_pakaian', 'public');
            $modelPakaian->save();
        }

        return redirect()
            ->route('admin.model-pakaian.index')
            ->with('success', 'Model pakaian berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('admin.model_pakaian.edit', [
            'item' => ModelPakaian::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_model'      => 'required',
            'kategori'        => 'required',
            'ukuran'          => 'required',
            'kebutuhan_bahan' => 'required|numeric',
            'foto_model'      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $modelPakaian = ModelPakaian::findOrFail($id);
        $modelPakaian->update($request->all());

        if ($request->hasFile('foto_model')) {
            $modelPakaian->foto_model = $request->file('foto_model')->store('model_pakaian', 'public');
            $modelPakaian->save();
        }

        return redirect()
            ->route('admin.model-pakaian.index')
            ->with('success', 'Model pakaian berhasil diperbarui');
    }

    public function destroy($id)
    {
        $model = ModelPakaian::findOrFail($id);

        if ($model->jobProduksi()->exists()) {
            return back()->with('error', 'Model pakaian tidak bisa dihapus karena masih digunakan di job produksi');
        }

        ModelPakaian::destroy($id);

        return redirect()
            ->route('admin.model-pakaian.index')
            ->with('success', 'Model pakaian berhasil dihapus');
    }
}
