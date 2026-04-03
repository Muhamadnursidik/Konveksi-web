<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemotongan extends Model
{
    protected $table = 'pemotongan';

    protected $fillable = [
        'job_produksi_id',
        'pemotong_id',
        'foto_bukti',
        'status', // pending | approved
    ];

    public function jobProduksi()
    {
        return $this->belongsTo(JobProduksi::class);
    }

    public function pemotong()
    {
        return $this->belongsTo(User::class, 'pemotong_id');
    }
}
