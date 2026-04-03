<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; }
        th { background:#eee; }
    </style>
</head>
<body>

<h3>Laporan Produksi</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Model</th>
            <th>Bahan</th>
            <th>Target</th>
            <th>Kebutuhan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $row->created_at->format('d-m-Y') }}</td>
                <td>{{ $row->modelPakaian->nama_model }}</td>
                <td>{{ $row->bahanBaku->nama_bahan }}</td>
                <td>{{ $row->jumlah_target }}</td>
                <td>{{ $row->kebutuhan_bahan_total }}</td>
                <td>{{ strtoupper($row->status) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
