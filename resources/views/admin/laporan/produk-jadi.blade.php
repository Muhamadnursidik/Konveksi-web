@include('layouts.admin.head-page')
@include('layouts.admin.sidebar')
@include('layouts.admin.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Laporan Produk Jadi</h5>
                </div>
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item">Laporan</li>
                    <li class="breadcrumb-item active">Produk Jadi</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            @php
                $totalProduksi = $data->count();
                $totalQty = $data->sum(fn($row) => $row->jobProduksi->jumlah_target);
            @endphp

            {{-- SUMMARY --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Produksi Selesai</small>
                            <h5 class="fw-bold mb-0">{{ $totalProduksi }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total Produk Jadi</small>
                            <h5 class="fw-bold mb-0">{{ number_format($totalQty) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Produk Jadi</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('laporan.produk-jadi.excel', request()->query()) }}"
                           class="btn btn-sm btn-outline-success">
                            <i class="feather icon-download"></i> Excel
                        </a>
                        <a href="{{ route('laporan.produk-jadi.pdf', request()->query()) }}"
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
                                    <th>Tanggal Selesai</th>
                                    <th>Model</th>
                                    <th>Kategori</th>
                                    <th>Ukuran</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $i => $row)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d-m-Y') }}</td>
                                        <td>{{ $row->jobProduksi->modelPakaian->nama_model }}</td>
                                        <td>{{ $row->jobProduksi->modelPakaian->kategori }}</td>
                                        <td>{{ $row->jobProduksi->modelPakaian->ukuran }}</td>
                                        <td class="text-end">
                                            {{ number_format($row->jobProduksi->jumlah_target) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-soft-success text-success">Selesai</span>
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
                                    <td colspan="5">TOTAL</td>
                                    <td class="text-end">{{ number_format($totalQty) }}</td>
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
