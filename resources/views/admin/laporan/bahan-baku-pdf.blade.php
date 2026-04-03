<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px }
        table { width: 100%; border-collapse: collapse }
        th, td { border: 1px solid #000; padding: 6px }
        th { background: #f2f2f2 }
        .text-end { text-align: right }
    </style>
</head>
<body>

<h3>Laporan Bahan Baku</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Bahan</th>
            <th>Warna</th>
            <th>Stok Awal (m)</th>
            <th>Terpakai (m)</th>
            <th>Sisa (m)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row['nama_bahan'] }}</td>
            <td>{{ $row['warna'] }}</td>
            <td class="text-end">{{ number_format($row['stok_awal'],2) }}</td>
            <td class="text-end">{{ number_format($row['total_terpakai'],2) }}</td>
            <td class="text-end">{{ number_format($row['sisa'],2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
