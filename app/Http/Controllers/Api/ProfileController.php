<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemotongan;
use App\Models\Penjahitan;
use App\Models\Finishing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // GET /api/profile
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Stats & riwayat berdasarkan role
        [$totalJob, $totalSelesai, $riwayat] = match($role) {
            'pemotong' => [
                Pemotongan::where('pemotong_id', $user->id)->count(),
                Pemotongan::where('pemotong_id', $user->id)->where('status', 'dipotong')->count(),
                Pemotongan::with('jobProduksi.modelPakaian', 'jobProduksi.bahanBaku')
                    ->where('pemotong_id', $user->id)
                    ->orderByDesc('updated_at')
                    ->get()
                    ->map(fn($p) => [
                        'model'   => $p->jobProduksi->modelPakaian->nama_model ?? '-',
                        'bahan'   => $p->jobProduksi->bahanBaku->nama_bahan ?? '-',
                        'target'  => $p->jobProduksi->jumlah_target ?? 0,
                        'status'  => 'Selesai Dipotong',
                        'tanggal' => $p->updated_at->format('d M Y H:i'),
                    ]),
            ],
            'penjahit' => [
                Penjahitan::where('penjahit_id', $user->id)->count(),
                Penjahitan::where('penjahit_id', $user->id)->where('status', 'dijahit')->count(),
                Penjahitan::with('jobProduksi.modelPakaian', 'jobProduksi.bahanBaku')
                    ->where('penjahit_id', $user->id)
                    ->orderByDesc('updated_at')
                    ->get()
                    ->map(fn($p) => [
                        'model'   => $p->jobProduksi->modelPakaian->nama_model ?? '-',
                        'bahan'   => $p->jobProduksi->bahanBaku->nama_bahan ?? '-',
                        'target'  => $p->jobProduksi->jumlah_target ?? 0,
                        'status'  => 'Selesai Dijahit',
                        'tanggal' => $p->updated_at->format('d M Y H:i'),
                    ]),
            ],
            'finishing' => [
                Finishing::where('finishing_id', $user->id)->count(),
                Finishing::where('finishing_id', $user->id)->where('status', 'selesai')->count(),
                Finishing::with('jobProduksi.modelPakaian', 'jobProduksi.bahanBaku')
                    ->where('finishing_id', $user->id)
                    ->orderByDesc('updated_at')
                    ->get()
                    ->map(fn($f) => [
                        'model'   => $f->jobProduksi->modelPakaian->nama_model ?? '-',
                        'bahan'   => $f->jobProduksi->bahanBaku->nama_bahan ?? '-',
                        'target'  => $f->jobProduksi->jumlah_target ?? 0,
                        'status'  => 'Selesai Finishing',
                        'tanggal' => $f->updated_at->format('d M Y H:i'),
                    ]),
            ],
            default => [0, 0, []],
        };

        return response()->json([
            'user' => [
                'id'        => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'role'      => $user->role,
                'is_active' => $user->is_active,
                'photo'     => $user->photo
                                ? url('storage-file/' . $user->photo)
                                : null,
            ],
            'stats' => [
                'total_job'     => $totalJob,
                'total_selesai' => $totalSelesai,
            ],
            'riwayat' => $riwayat,
        ]);
    }

    // PUT /api/profile
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:100',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:8',
        ]);

        $data = ['name' => $request->name];

        // Update foto
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $request->file('photo')->store('users', 'public');
        }

        // Update password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Update token service data
        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diupdate',
            'user' => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
                'photo' => $user->photo
                            ? url('storage-file/' . $user->photo)
                            : null,
            ],
        ]);
    }
}
