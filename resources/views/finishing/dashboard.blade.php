@include('layouts.finishing.head-page')

<!--! [Start] Sidebar !-->
@include('layouts.finishing.sidebar')
<!--! [End] Sidebar !-->

<!--! [Start] Navbar !-->
@include('layouts.finishing.navbar')
<!--! [End] Navbar !-->

<main class="nxl-container">
    <div class="nxl-content">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard Finishing</li>
                </ul>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="row">

                <!-- JOB SIAP FINISHING -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $siapFinishing }}</h3>
                                    <p class="text-muted mt-1 mb-0">Menunggu finishing</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-warning text-warning">
                                    <i class="feather-package"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Job Siap Finishing</h6>
                        </div>
                    </div>
                </div>

                <!-- SELESAI HARI INI -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $selesaiHariIni }}</h3>
                                    <p class="text-muted mt-1 mb-0">Selesai hari ini</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-success text-success">
                                    <i class="feather-check-circle"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Selesai Hari Ini</h6>
                        </div>
                    </div>
                </div>

                <!-- TOTAL PACKING -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $totalPackingHariIni }}</h3>
                                    <p class="text-muted mt-1 mb-0">Packing hari ini</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                    <i class="feather-box"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Total Packing</h6>
                        </div>
                    </div>
                </div>

                <!-- TOTAL JOB -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $jobTerbaru->count() }}</h3>
                                    <p class="text-muted mt-1 mb-0">Job aktif</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-info text-info">
                                    <i class="feather-layers"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Job Aktif</h6>
                        </div>
                    </div>
                </div>

                <!-- TABLE JOB FINISHING -->
                <div class="col-xxl-12 mt-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Job Menunggu Finishing</h5>
                        </div>

                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Kategori</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jobTerbaru as $job)
                                            <tr>
                                                <td>{{ $job->modelPakaian->nama_model }}</td>
                                                <td>{{ $job->modelPakaian->kategori }}</td>
                                                <td>{{ $job->jumlah_target }} pcs</td>
                                                <td>
                                                    <span class="badge bg-warning">
                                                        Siap Finishing
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">
                                                    Tidak ada job finishing
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href="{{ route('finishing.job-finishing.index') }}"
                               class="btn btn-sm btn-primary">
                                Kerjakan Finishing
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

@include('layouts.finishing.footer')
