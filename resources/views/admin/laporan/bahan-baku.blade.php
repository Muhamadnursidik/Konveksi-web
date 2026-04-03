@include('layouts.admin.head-page')
@include('layouts.admin.sidebar')
@include('layouts.admin.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Laporan Bahan Baku</h5>
                </div>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Bahan Baku</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            @php
                $totalJenis = $data->count();
                $totalStok = $data->sum('stok_awal');
                $totalTerpakai = $data->sum('total_terpakai');
                $totalSisa = $totalStok - $totalTerpakai;
            @endphp

            {{-- SUMMARY --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Jenis Bahan</small>
                            <h5 class="fw-bold mb-0">{{ $totalJenis }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Stok Awal (m)</small>
                            <h5 class="fw-bold mb-0">{{ number_format($totalStok, 2) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Terpakai (m)</small>
                            <h5 class="fw-bold mb-0">{{ number_format($totalTerpakai, 2) }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Sisa Stok (m)</small>
                            <h5 class="fw-bold mb-0">{{ number_format($totalSisa, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Bahan Baku</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('laporan.bahan-baku.excel', request()->query()) }}"
                            class="btn btn-sm btn-outline-success">
                            <i class="feather icon-download"></i> Excel
                        </a>
                        <a href="{{ route('laporan.bahan-baku.pdf', request()->query()) }}"
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
                                    <th>Bahan</th>
                                    <th>Warna</th>
                                    <th>Stok Awal (m)</th>
                                    <th>Terpakai (m)</th>
                                    <th>Sisa (m)</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $i => $row)
                                    @php
                                        $sisa = $row->stok_awal - $row->total_terpakai;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>{{ $row->nama_bahan }}</td>
                                        <td>{{ $row->warna }}</td>
                                        <td class="text-end">{{ number_format($row->stok_awal, 2) }}</td>
                                        <td class="text-end">{{ number_format($row->total_terpakai, 2) }}</td>
                                        <td class="text-end">{{ number_format($sisa, 2) }}</td>
                                        <td class="text-center">
                                            @if ($sisa <= 0)
                                                <span class="badge bg-soft-danger text-danger">Habis</span>
                                            @elseif ($sisa < 5)
                                                <span class="badge bg-soft-warning text-warning">Menipis</span>
                                            @else
                                                <span class="badge bg-soft-success text-success">Aman</span>
                                            @endif
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
                                    <td colspan="3">TOTAL</td>
                                    <td class="text-end">{{ number_format($totalStok, 2) }}</td>
                                    <td class="text-end">{{ number_format($totalTerpakai, 2) }}</td>
                                    <td class="text-end">{{ number_format($totalSisa, 2) }}</td>
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
            <script>document.write(new Date().getFullYear());</script>
        </p>
    </footer>
</main>

@include('layouts.admin.footer')
