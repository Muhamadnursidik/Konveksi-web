@include('layouts.admin.head-page')
@include('layouts.admin.sidebar')
@include('layouts.admin.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Laporan Produksi</h5>
                </div>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Produksi</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            @php
                $totalJob = $data->count();
                $totalTarget = $data->sum('jumlah_target');
                $totalBahan = $data->sum('kebutuhan_bahan_total');
            @endphp

            {{-- SUMMARY --}}
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Job Produksi</small>
                            <h5 class="fw-bold mb-0">{{ $totalJob }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Target Produksi</small>
                            <h5 class="fw-bold mb-0">{{ number_format($totalTarget) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Bahan Terpakai (m)</small>
                            <h5 class="fw-bold mb-0">{{ number_format($totalBahan, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Produksi</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('laporan.produksi.excel', request()->query()) }}"
                            class="btn btn-sm btn-outline-success">
                            <i class="feather icon-download"></i> Excel
                        </a>
                        <a href="{{ route('laporan.produksi.pdf', request()->query()) }}"
                            class="btn btn-sm btn-outline-danger">
                            <i class="feather icon-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="datatable-model" class="table table-bordered table-sm mb-0 excel-table">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Model</th>
                                    <th>Bahan</th>
                                    <th>Target</th>
                                    <th>Kebutuhan (m)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $i => $row)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>{{ $row->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            {{ $row->modelPakaian->nama_model }}
                                            <div class="text-muted fs-12">
                                                {{ $row->modelPakaian->ukuran }} | {{ $row->modelPakaian->kategori }}
                                            </div>
                                        </td>
                                        <td>
                                            {{ $row->bahanBaku->nama_bahan }}
                                            <div class="text-muted fs-12">
                                                {{ $row->bahanBaku->warna }}
                                            </div>
                                        </td>
                                        <td class="text-end">{{ number_format($row->jumlah_target) }}</td>
                                        <td class="text-end">{{ number_format($row->kebutuhan_bahan_total, 2) }}</td>
                                        <td class="text-center">
                                            <span
                                                @php $statusMap = [
                                                        'menunggu' => [
                                                            'class' => 'badge bg-soft-secondary text-secondary',
                                                            'label' => 'Menunggu',
                                                        ],
                                                        'dipotong' => [
                                                            'class' => 'badge bg-soft-warning text-warning',
                                                            'label' => 'Dipotong',
                                                        ],
                                                        'dijahit' => [
                                                            'class' => 'badge bg-soft-info text-info',
                                                            'label' => 'Dijahit',
                                                        ],
                                                        'finishing' => [
                                                            'class' => 'badge bg-soft-primary text-primary',
                                                            'label' => 'Finishing',
                                                        ],
                                                        'selesai' => [
                                                            'class' => 'badge bg-soft-success text-success',
                                                            'label' => 'Selesai',
                                                        ],
                                                    ];
                                                    $status = $statusMap[$row->status] ?? null; @endphp
                                                <span
                                                class="{{ $status['class'] ?? 'badge bg-soft-secondary text-secondary' }}">
                                                {{ $status['label'] ?? strtoupper($row->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            Tidak ada data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tfoot class="fw-bold bg-light">
                                <tr>
                                    <td colspan="4">TOTAL</td>
                                    <td class="text-end">{{ number_format($totalTarget) }}</td>
                                    <td class="text-end">{{ number_format($totalBahan, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-4">
        <p class="fs-11 text-muted fw-medium text-uppercase mb-0">
            Copyright ©
            <script>
                document.write(new Date().getFullYear());
            </script>
        </p>
    </footer>
</main>

@include('layouts.admin.footer')
