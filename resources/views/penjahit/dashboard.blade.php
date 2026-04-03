@include('layouts.penjahit.head-page')

<!--! [Start] Navigation Manu !-->
@include('layouts.penjahit.sidebar')
<!--! [End]  Navigation Manu !-->

<!--! [Start] Header !-->
@include('layouts.penjahit.navbar')
<!--! [End] Header !-->
<!--! [Start] Main Content !-->
<main class="nxl-container">
    <div class="nxl-content">

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard Penjahit</li>
                </ul>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
            <div class="row">

                {{-- JOB MENUNGGU --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $jobMenunggu }}</h3>
                                    <p class="text-muted mt-1 mb-0">Menunggu dijahit</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-warning text-warning">
                                    <i class="feather-clock"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Job Menunggu</h6>
                        </div>
                    </div>
                </div>

                {{-- TARGET HARI INI --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $targetHariIni }}</h3>
                                    <p class="text-muted mt-1 mb-0">Target hari ini</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                    <i class="feather-target"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Target Jahit</h6>
                        </div>
                    </div>
                </div>

                {{-- SELESAI HARI INI --}}
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
                            <h6 class="fs-13 fw-semibold">Selesai</h6>
                        </div>
                    </div>
                </div>

                {{-- SPACER (BIAR GRID RAPI) --}}
                <div class="col-xxl-3 col-md-6"></div>

                {{-- JOB SIAP DIJAHIT --}}
                <div class="col-xxl-8 mt-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Job Siap Dijahit</h5>
                        </div>

                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($jobAktif as $job)
                                            <tr>
                                                <td>{{ $job->modelPakaian->nama_model }}</td>
                                                <td>{{ $job->jumlah_target }}</td>
                                                <td>
                                                    <span class="badge bg-warning">
                                                        Menunggu
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">
                                                    Tidak ada job jahit
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href="{{ route('penjahit.job-jahit.index') }}" class="btn btn-sm btn-primary">
                                Kerjakan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- RIWAYAT HARI INI --}}
                <div class="col-xxl-4 mt-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Riwayat Jahit Hari Ini</h5>
                        </div>

                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                @forelse($riwayatHariIni as $job)
                                    <li class="mb-3">
                                        <strong>{{ $job->modelPakaian->nama_model }}</strong><br>
                                        <small class="text-muted">{{ $job->jumlah_target }} pcs</small>
                                    </li>
                                @empty
                                    <li class="text-muted">Belum ada</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

<!--! [End] Main Content !-->

<!--! [End] Main Content !-->
@include('layouts.penjahit.footer')
