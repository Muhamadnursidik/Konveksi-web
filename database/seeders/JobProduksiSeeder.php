<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobProduksi;

class JobProduksiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'model_pakaian_id' => 1,
                'bahan_baku_id' => 1,
                'jumlah_target' => 50,
                'kebutuhan_bahan_total' => 120,
                'status' => 'menunggu', // habis finishing
            ],
            [
                'model_pakaian_id' => 2,
                'bahan_baku_id' => 2,
                'jumlah_target' => 30,
                'kebutuhan_bahan_total' => 75,
                'status' => 'menunggu',
            ],
            [
                'model_pakaian_id' => 3,
                'bahan_baku_id' => 1,
                'jumlah_target' => 40,
                'kebutuhan_bahan_total' => 100,
                'status' => 'menunggu',
            ],
            [
                'model_pakaian_id' => 1,
                'bahan_baku_id' => 3,
                'jumlah_target' => 25,
                'kebutuhan_bahan_total' => 60,
                'status' => 'menunggu',
            ],
            [
                'model_pakaian_id' => 2,
                'bahan_baku_id' => 2,
                'jumlah_target' => 60,
                'kebutuhan_bahan_total' => 150,
                'status' => 'menunggu',
            ],
        ];

        foreach ($data as $item) {
            JobProduksi::create($item);
        }
    }
}
