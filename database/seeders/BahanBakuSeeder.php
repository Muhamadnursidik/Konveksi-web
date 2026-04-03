<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BahanBaku;

class BahanBakuSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_bahan' => 'Kain Drill',
                'warna' => 'Hitam',
                'stok_meter' => 120.50,
                'keterangan' => 'Untuk seragam kerja',
                'foto' => 'users/admin.jpg',
            ],
            [
                'nama_bahan' => 'Kain Katun',
                'warna' => 'Putih',
                'stok_meter' => 200.00,
                'keterangan' => 'Kaos dan pakaian harian',
                'foto' => 'users/admin.jpg',
            ],
            [
                'nama_bahan' => 'Kain Jeans',
                'warna' => 'Biru',
                'stok_meter' => 75.75,
                'keterangan' => 'Celana jeans',
                'foto' => 'users/admin.jpg',
            ],
            [
                'nama_bahan' => 'Kain Parasut',
                'warna' => 'Hijau Army',
                'stok_meter' => 60.00,
                'keterangan' => 'Jaket outdoor',
                'foto' => 'users/admin.jpg',
            ],
            [
                'nama_bahan' => 'Kain Fleece',
                'warna' => 'Abu-abu',
                'stok_meter' => 90.25,
                'keterangan' => 'Hoodie dan sweater',
                'foto' => 'users/admin.jpg',
            ],
        ];

        foreach ($data as $item) {
            BahanBaku::create($item);
        }
    }
}
