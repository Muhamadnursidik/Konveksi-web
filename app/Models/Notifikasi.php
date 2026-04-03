<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'is_read',
    ];

    protected static function booted()
    {
        static::created(function ($notif) {
            $query = self::where('user_id', $notif->user_id);

            $total = $query->count();

            if ($total > 5) {
                $hapus = $total - 5;

                $query->orderBy('id')->limit($hapus)->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
