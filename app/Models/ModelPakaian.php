<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelPakaian extends Model
{
    protected $table = 'model_pakaian';

    protected $fillable = [
        'nama_model',
        'kategori',
        'ukuran',
        'kebutuhan_bahan',
        'foto_model'
    ];

    public function jobProduksi()
    {
        return $this->hasMany(JobProduksi::class);
    }

    public function produkJadi()
    {
        return $this->hasMany(ProdukJadi::class);
    }
}
