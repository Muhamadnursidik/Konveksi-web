<?php

namespace App\Http\Controllers\Penjahit;

use App\Http\Controllers\Controller;
use App\Models\Penjahitan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePenjahitController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalJob = Penjahitan::where('penjahit_id', Auth::id())->count();
        $totalSelesai = Penjahitan::where('penjahit_id', Auth::id())
            ->where('status', 'dijahit')
            ->count();

        $jobs = Penjahitan::with([
            'jobProduksi.modelPakaian',
        ])
            ->where('penjahit_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('penjahit.profile.index', compact('jobs', 'totalJob', 'totalSelesai'));
    }

    public function edit($id)
    {
        $users = User::where('role', 'penjahit')->findOrFail($id);
        return view('penjahit.profile.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'penjahit')->findOrFail($id);

        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ],
        [
            'name.required'     => 'Nama wajib diisi.',
            'name.string'       => 'Nama harus berupa teks.',
            'name.max'          => 'Nama maksimal 100 karakter.',

            'photo.image'       => 'File harus berupa gambar.',
            'photo.mimes'       => 'Foto harus berformat JPG atau PNG.',
            'photo.max'         => 'Ukuran foto maksimal 2MB.',
        ]
        );

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($data);

        return redirect()
            ->route('penjahit.profile')
            ->with('success', 'Profil penjahit berhasil diupdate');
    }
}
