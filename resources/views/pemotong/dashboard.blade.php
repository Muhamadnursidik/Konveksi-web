@include('layouts.pemotong.head-page')

<!--! [Start] Navigation Manu !-->
@include('layouts.pemotong.sidebar')
<!--! [End]  Navigation Manu !-->

<!--! [Start] Header !-->
@include('layouts.pemotong.navbar')
<!--! [End] Header !-->
<!--! [Start] Main Content !-->
<main class="nxl-container">
    <div class="nxl-content">

        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard Pemotong</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row">

                {{-- JOB AKTIF --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $jobAktif }}</h3>
                                    <p class="text-muted mt-1 mb-0">Menunggu & proses potong</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-warning text-warning">
                                    <i class="feather-scissors"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Job Aktif</h6>
                        </div>
                    </div>
                </div>


                {{-- SELESAI HARI INI --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $jobSelesaiHariIni }}</h3>
                                    <p class="text-muted mt-1 mb-0">Job selesai hari ini</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-success text-success">
                                    <i class="feather-check-circle"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Selesai Hari Ini</h6>
                        </div>
                    </div>
                </div>


                {{-- TOTAL TARGET --}}
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div>
                                    <h3 class="fw-light mb-0">{{ $totalTarget }}</h3>
                                    <p class="text-muted mt-1 mb-0">Target potong aktif</p>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                    <i class="feather-target"></i>
                                </div>
                            </div>
                            <h6 class="fs-13 fw-semibold">Total Target</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-12 mt-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Job Potong Aktif</h5>
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
                                        @forelse ($jobHariIni as $job)
                                            <tr>
                                                <td>{{ $job->modelPakaian->nama_model }}</td>
                                                <td>{{ $job->jumlah_target }}</td>
                                                <td>
                                                    <span class="badge bg-warning">
                                                        {{ ucfirst($job->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">
                                                    Tidak ada job potong
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <a href="{{ route('pemotong.job-potong.index') }}" class="btn btn-sm btn-primary">
                                Kerjakan
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
</main>
<!--! [End] Main Content !-->

<!--! [End] Main Content !-->
@include('layouts.pemotong.footer')
