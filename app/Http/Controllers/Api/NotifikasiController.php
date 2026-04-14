<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // GET /api/notifikasi
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(20)
            ->get()
            ->map(fn($n) => [
                'id'         => $n->id,
                'judul'      => $n->judul,
                'pesan'      => $n->pesan,
                'is_read'    => (bool) $n->is_read,
                'created_at' => $n->created_at->diffForHumans(),
            ]);

        $unread = Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json([
            'data'   => $notifikasi,
            'unread' => $unread,
        ]);
    }

    // POST /api/notifikasi/{id}/read
    public function read($id)
    {
        Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // POST /api/notifikasi/read-all
    public function readAll()
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
