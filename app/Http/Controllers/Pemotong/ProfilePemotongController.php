<?php
namespace App\Http\Controllers\Pemotong;

use App\Http\Controllers\Controller;
use App\Models\Pemotongan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilePemotongController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $totalJob = Pemotongan::where('pemotong_id', Auth::id())->count();
        $totalSelesai = Pemotongan::where('pemotong_id', Auth::id())
            ->where('status', 'dipotong')
            ->count();

        $jobs = Pemotongan::with([
            'jobProduksi.modelPakaian',
        ])
            ->where('pemotong_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('pemotong.profile.index', compact('jobs', 'totalJob', 'totalSelesai'));
    }

    public function edit($id)
    {
        $users = User::where('role', 'pemotong')->findOrFail($id);
        return view('pemotong.profile.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 'pemotong')->findOrFail($id);

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
            ->route('pemotong.profile')
            ->with('success', 'Profil pemotong berhasil diupdate');
    }
}
