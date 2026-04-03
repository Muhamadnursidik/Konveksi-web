<?php

namespace App\Exports;

use App\Models\JobProduksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanProduksiExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = JobProduksi::with(['modelPakaian', 'bahanBaku']);

        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        return $query->get()->map(function ($row) {
            return [
                'Tanggal'     => $row->created_at->format('d-m-Y'),
                'Model'       => $row->modelPakaian->nama_model,
                'Kategori'    => $row->modelPakaian->kategori,
                'Bahan'       => $row->bahanBaku->nama_bahan,
                'Target'      => $row->jumlah_target,
                'Kebutuhan'   => $row->kebutuhan_bahan_total,
                'Status'      => strtoupper($row->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Model',
            'Kategori',
            'Bahan',
            'Target',
            'Kebutuhan (m)',
            'Status',
        ];
    }
}
