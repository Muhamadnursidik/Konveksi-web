@include('layouts.pemotong.head-page')

@include('layouts.pemotong.sidebar')
@include('layouts.pemotong.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Riwayat Job Potong</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Pemotong</li>
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
                            <h5 class="card-title">Riwayat Job Dipotong</h5>
                        </div>

                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table id="datatable-model" class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Bahan Baku</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Waktu Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jobs as $job)
                                            <tr>
                                                <td>{{ $job->jobProduksi->modelPakaian->nama_model }}</td>
                                                <td>{{ $job->jobProduksi->bahanBaku->nama_bahan }}</td>
                                                <td>{{ $job->jobProduksi->jumlah_target }}</td>
                                                <td>
                                                    <span class="badge bg-soft-success text-success">
                                                        Selesai Dipotong
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $job->updated_at->format('d M Y H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
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

@include('layouts.pemotong.footer')
