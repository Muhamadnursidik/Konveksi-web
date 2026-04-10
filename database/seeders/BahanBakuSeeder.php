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
                'foto' => 'data/kain drill.jpeg',
            ],
            [
                'nama_bahan' => 'Kain Katun',
                'warna' => 'Putih',
                'stok_meter' => 200.00,
                'keterangan' => 'Kaos dan pakaian harian',
                'foto' => 'data/kain katun.jpg',
            ],
            [
                'nama_bahan' => 'Kain Jeans',
                'warna' => 'Biru',
                'stok_meter' => 75.75,
                'keterangan' => 'Celana jeans',
                'foto' => 'data/kain jeans.jpeg',
            ],
            [
                'nama_bahan' => 'Kain Parasut',
                'warna' => 'Hijau Army',
                'stok_meter' => 60.00,
                'keterangan' => 'Jaket outdoor',
                'foto' => 'data/kain parasut.jpeg',
            ],
            [
                'nama_bahan' => 'Kain Fleece',
                'warna' => 'Abu-abu',
                'stok_meter' => 90.25,
                'keterangan' => 'Hoodie dan sweater',
                'foto' => 'data/Kain-Fleece.jpg',
            ],
        ];

        foreach ($data as $item) {
            BahanBaku::create($item);
        }
    }
}
