<?php
namespace App\Helpers;

use App\Models\Notifikasi;
use App\Models\User;

class NotifHelper
{
    public static function user($userId, $judul, $pesan)
    {
        Notifikasi::create([
            'user_id' => $userId,
            'judul'   => $judul,
            'pesan'   => $pesan,
        ]);
    }

    public static function admin($judul, $pesan)
    {
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notifikasi::create([
                'user_id' => $admin->id,
                'judul'   => $judul,
                'pesan'   => $pesan,
            ]);
        }
    }

    public static function pemotong($judul, $pesan)
    {
        $users = \App\Models\User::where('role', 'pemotong')->get();

        foreach ($users as $user) {
            \App\Models\Notifikasi::create([
                'user_id' => $user->id,
                'judul'   => $judul,
                'pesan'   => $pesan,
            ]);
        }
    }

    public static function penjahit($judul, $pesan)
    {
        $users = \App\Models\User::where('role', 'penjahit')->get();

        foreach ($users as $user) {
            \App\Models\Notifikasi::create([
                'user_id' => $user->id,
                'judul'   => $judul,
                'pesan'   => $pesan,
            ]);
        }
    }

    public static function finishing($judul, $pesan)
    {
        $users = \App\Models\User::where('role', 'finishing')->get();

        foreach ($users as $user) {
            \App\Models\Notifikasi::create([
                'user_id' => $user->id,
                'judul'   => $judul,
                'pesan'   => $pesan,
            ]);
        }
    }
}
