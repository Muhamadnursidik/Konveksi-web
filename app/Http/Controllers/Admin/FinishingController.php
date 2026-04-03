<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinishingController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'finishing')->get();
        return view('admin.users.finishing.index', compact('users'));
    }

    public function create()
    {
        $users = User::where('role', 'finishing')->get();
        return view('admin.users.finishing.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'photo'    => 'nullable|image|mimes:jpg,png|max:2048',
        ],
        [
            'name.required'     => 'Nama wajib diisi.',
            'name.string'       => 'Nama harus berupa teks.',
            'name.max'          => 'Nama maksimal 100 karakter.',

            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',

            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',

            'photo.image'       => 'File harus berupa gambar.',
            'photo.mimes'       => 'Foto harus berformat JPG atau PNG.',
            'photo.max'         => 'Ukuran foto maksimal 2MB.',
        ]
        );

        $data['role'] = 'finishing';

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        User::create($data);

        return redirect()
            ->route('admin.finishing.index')
            ->with('success', 'finishing berhasil ditambahkan');
    }

    public function edit($id)
    {
        $users = User::where('role','finishing')->findOrFail($id);
        return view('admin.users.finishing.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role','finishing')->findOrFail($id);

        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
            'is_active' => 'required|in:0,1',
        ],
        [
            'name.required'  => 'Nama wajib diisi.',
            'name.string'    => 'Nama harus berupa teks.',
            'name.max'       => 'Nama maksimal 100 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email sudah terdaftar.',

            'photo.image'    => 'File harus berupa gambar.',
            'photo.mimes'    => 'Foto harus berformat JPG atau PNG.',
            'photo.max'      => 'Ukuran foto maksimal 2MB.',
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
            ->route('admin.finishing.index')
            ->with('success', 'finishing berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::where('role','finishing')->findOrFail($id);

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return back()->with('success', 'finishing berhasil dihapus');
    }
}
