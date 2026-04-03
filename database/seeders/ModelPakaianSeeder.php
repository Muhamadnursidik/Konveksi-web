<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ModelPakaian;

class ModelPakaianSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_model' => 'Hoodie Hangat',
                'kategori' => 'Jaket',
                'ukuran' => 'L',
                'kebutuhan_bahan' => 1.5,
                'foto_model' => 'users/penjahit.jpg'
            ],
            [
                'nama_model' => 'Kaos Polos',
                'kategori' => 'Baju',
                'ukuran' => 'M',
                'kebutuhan_bahan' => 1.2,
                'foto_model' => 'users/penjahit.jpg'
            ],
            [
                'nama_model' => 'Jaket Outdoor',
                'kategori' => 'Jaket',
                'ukuran' => 'XL',
                'kebutuhan_bahan' => 2.0,
                'foto_model' => 'users/penjahit.jpg'
            ],
            [
                'nama_model' => 'Kemeja Formal',
                'kategori' => 'Baju',
                'ukuran' => 'L',
                'kebutuhan_bahan' => 1.8,
                'foto_model' => 'users/penjahit.jpg'
            ],
            [
                'nama_model' => 'Sweater Rajut',
                'kategori' => 'Sweater',
                'ukuran' => 'M',
                'kebutuhan_bahan' => 1.6,
                'foto_model' => 'users/penjahit.jpg'
            ],
        ];

        foreach ($data as $item) {
            ModelPakaian::create($item);
        }
    }
}
