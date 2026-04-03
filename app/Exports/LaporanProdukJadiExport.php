<?php

namespace App\Exports;

use App\Models\ProdukJadi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanProdukJadiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $no = 1;

    public function collection()
    {
        return ProdukJadi::with([
            'jobProduksi.modelPakaian'
        ])
        ->orderBy('tanggal_selesai', 'desc')
        ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Selesai',
            'Model',
            'Kategori',
            'Ukuran',
            'Jumlah Produksi',
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->tanggal_selesai,
            optional($row->jobProduksi->modelPakaian)->nama_model,
            optional($row->jobProduksi->modelPakaian)->kategori,
            optional($row->jobProduksi->modelPakaian)->ukuran,
            $row->jobProduksi->jumlah_target ?? 0,
        ];
    }
}
