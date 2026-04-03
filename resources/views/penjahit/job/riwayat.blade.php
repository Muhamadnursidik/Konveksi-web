@include('layouts.penjahit.head-page')

@include('layouts.penjahit.sidebar')
@include('layouts.penjahit.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Riwayat Job Jahit</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Penjahit</li>
                    <li class="breadcrumb-item active">Riwayat</li>
                </ul>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">Riwayat Job Dijahit</h5>
                        </div>

                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table id="datatable-model" class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Waktu Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jobs as $job)
                                            <tr>
                                                <td>{{ $job->jobProduksi->modelPakaian->nama_model }}</td>
                                                <td>{{ $job->jobProduksi->jumlah_target }}</td>
                                                <td>
                                                    <span class="badge bg-soft-success text-success">
                                                        Selesai Dijahit
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $job->updated_at->format('d M Y H:i') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    Belum ada riwayat jahit
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

@include('layouts.penjahit.footer')
