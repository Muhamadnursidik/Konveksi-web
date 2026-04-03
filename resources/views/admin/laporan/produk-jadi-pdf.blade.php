<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Jadi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background: #f0f0f0;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

<h3 style="text-align:center;">LAPORAN PRODUK JADI</h3>

@php
    $total = $data->sum(fn($row) => $row->jobProduksi->jumlah_target);
@endphp

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Selesai</th>
            <th>Model</th>
            <th>Kategori</th>
            <th>Ukuran</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $row->tanggal_selesai }}</td>
                <td>{{ $row->jobProduksi->modelPakaian->nama_model }}</td>
                <td>{{ $row->jobProduksi->modelPakaian->kategori }}</td>
                <td>{{ $row->jobProduksi->modelPakaian->ukuran }}</td>
                <td class="text-right">
                    {{ number_format($row->jobProduksi->jumlah_target) }}
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="5" class="text-right">TOTAL</th>
            <th class="text-right">{{ number_format($total) }}</th>
        </tr>
    </tfoot>
</table>

</body>
</html>
