<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjahitan extends Model
{
    protected $table = 'penjahitan';

    protected $fillable = [
        'job_produksi_id',
        'pemotong_id',
        'penjahit_id',
        'foto_bukti',
        'status', // pending | approved
    ];

    public function jobProduksi()
    {
        return $this->belongsTo(JobProduksi::class);
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
