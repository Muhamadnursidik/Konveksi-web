<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenggunaanBahan extends Model
{
    protected $table = 'penggunaan_bahan';

    protected $fillable = [
        'job_produksi_id',
        'bahan_baku_id',
        'user_id',
        'jumlah_pakai'
    ];

    public function jobProduksi()
    {
        return $this->belongsTo(JobProduksi::class);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
