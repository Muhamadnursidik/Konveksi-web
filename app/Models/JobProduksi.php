<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class JobProduksi extends Model
{
    protected $table = 'job_produksi';

    protected $fillable = [
        'model_pakaian_id',
        'bahan_baku_id',
        'jumlah_target',
        'kebutuhan_bahan_total',
        'status',
        'pemotong_id',
        'penjahit_id',
        'finishing_id',
    ];

    public function modelPakaian()
    {
        return $this->belongsTo(ModelPakaian::class);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    public function penggunaanBahan()
    {
        return $this->hasMany(PenggunaanBahan::class);
    }

    public function pemotongan()
    {
        return $this->hasOne(Pemotongan::class);
    }

    public function penjahitan()
    {
        return $this->hasOne(Penjahitan::class);
    }

    public function finishing()
    {
        return $this->hasOne(Finishing::class);
    }

    public function pemotong()
    {
        return $this->belongsTo(User::class, 'pemotong_id');
    }

    public function penjahit()
    {
        return $this->belongsTo(User::class, 'penjahit_id');
    }

    public function finishingUser()
    {
        return $this->belongsTo(User::class, 'finishing_id');
    }

    public function produkJadi()
    {
        return $this->hasOne(ProdukJadi::class);
    }
}
