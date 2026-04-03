<?php

namespace App\Exports;

use App\Models\BahanBaku;
use App\Models\JobProduksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanBahanBakuExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return BahanBaku::all()->map(function ($row) {
            $stok_saat_ini = $row->stok_meter;
            $total_terpakai = JobProduksi::where('bahan_baku_id', $row->id)
                ->sum('kebutuhan_bahan_total');

            return [
                'Bahan'          => $row->nama_bahan,
                'Warna'          => $row->warna,
                'Stok Awal (m)'  => $stok_saat_ini + $total_terpakai,
                'Terpakai (m)'   => $total_terpakai,
                'Sisa (m)'       => $stok_saat_ini,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Bahan',
            'Warna',
            'Stok Awal (m)',
            'Terpakai (m)',
            'Sisa (m)',
        ];
    }
}
