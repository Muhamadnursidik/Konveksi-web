<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finishing extends Model
{
    protected $table = 'finishing';

    protected $fillable = [
        'job_produksi_id',
        'pemotong_id',
        'penjahit_id',
        'finishing_id',
        'foto_bukti',
        'status', // pending | acc
    ];

    public function jobProduksi()
    {
        return $this->belongsTo(JobProduksi::class);
    }

    public function finishing()
    {
        return $this->belongsTo(User::class, 'finishing_id');
    }

    public function penjahit()
    {
        return $this->belongsTo(User::class, 'penjahit_id');
    }

    public function pemotong()
    {
        return $this->belongsTo(User::class, 'pemotong_id');
    }
}
