<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    protected $table = 'bahan_baku';

    protected $fillable = [
        'nama_bahan',
        'warna',
        'stok_meter',
        'keterangan',
        'foto'
    ];

    public function penggunaanBahan()
    {
        return $this->hasMany(PenggunaanBahan::class);
    }

    public function jobProduksi()
    {
        return $this->hasMany(JobProduksi::class);
    }
}
