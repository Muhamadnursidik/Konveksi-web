@include('layouts.admin.head-page')

<!--! [Start] Navigation Manu !-->
@include('layouts.admin.sidebar')
<!--! [End]  Navigation Manu !-->

<!--! [Start] Header !-->
@include('layouts.admin.navbar')
<!--! [End] Header !-->
<!--! [Start] Main Content !-->
<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Dashboard</li>
                </ul>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between mb-4">
                                <div class="d-flex gap-4 align-items-center">
                                    <div class="avatar-text avatar-lg bg-soft-primary text-primary">
                                        <i class="feather-layers"></i>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bold text-dark">{{ $totalJob }}</div>
                                        <h3 class="fs-13 fw-semibold">Total Job Produksi</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-soft-warning text-warning">
                                    <i class="feather-refresh-cw"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $jobAktif }}</div>
                                    <h3 class="fs-13 fw-semibold">Job Berjalan</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-soft-success text-success">
                                    <i class="feather-check-circle"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ $jobSelesai }}</div>
                                    <h3 class="fs-13 fw-semibold">Job Selesai</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-md-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="avatar-text avatar-lg bg-soft-info text-info">
                                    <i class="feather-package"></i>
                                </div>
                                <div>
                                    <div class="fs-4 fw-bold text-dark">{{ number_format($totalTarget) }}</div>
                                    <h3 class="fs-13 fw-semibold">Target Produksi</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [Payment Records] start -->
                <div class="col-xxl-8">
                    <div class="card stretch stretch-full">

                        {{-- CARD HEADER --}}
                        <div class="card-header">
                            <h5 class="card-title">Progress Produksi</h5>
                            <div class="card-header-action">
                                <div class="card-header-btn">
                                    <div data-bs-toggle="tooltip" title="Refresh">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-warning"
                                            data-bs-toggle="refresh"></a>
                                    </div>
                                    <div data-bs-toggle="tooltip" title="Maximize/Minimize">
                                        <a href="javascript:void(0);" class="avatar-text avatar-xs bg-success"
                                            data-bs-toggle="expand"></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CARD BODY (CHART) --}}
                        <div class="card-body custom-card-action p-0">
                            <div id="chart-produksi"></div>
                        </div>

                        {{-- CARD FOOTER (DETAIL PROGRESS) --}}
                        <div class="card-footer">
                            <div class="row g-4">

                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Menunggu</div>
                                        <h6 class="fw-bold text-dark">{{ $jobMenunggu }}</h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-secondary"
                                                style="width: {{ $persenMenunggu }}%"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Dipotong</div>
                                        <h6 class="fw-bold text-dark">{{ $jobDiproses }}</h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-info" style="width: {{ $persenPotong }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Dijahit</div>
                                        <h6 class="fw-bold text-dark">{{ $jobDijahit }}</h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-warning" style="width: {{ $persenJahit }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="p-3 border border-dashed rounded">
                                        <div class="fs-12 text-muted mb-1">Selesai</div>
                                        <h6 class="fw-bold text-dark">{{ $jobSelesai }}</h6>
                                        <div class="progress mt-2 ht-3">
                                            <div class="progress-bar bg-success" style="width: {{ $persenSelesai }}%">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- [Payment Records] end -->
                <!--! BEGIN: [Team Progress] !-->
                <div class="col-xxl-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">User Terbaru</h5>
                        </div>

                        <div class="card-body custom-card-action">
                            @foreach ($users as $user)
                                <div class="hstack justify-content-between border border-dashed rounded-3 p-3 mb-3">
                                    <div class="hstack gap-3">
                                        <div>
                                            <img src="{{ asset('storage/' . $user->photo) }}"
                                                class="img-fluid rounded-circle" width="40">
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                            <div class="fs-11 text-muted">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                    <span class="badge bg-soft-success text-success">Aktif</span>
                                </div>
                            @endforeach
                        </div>

                        <a href="#" class="card-footer fs-11 fw-bold text-uppercase text-center">
                            Lihat Semua User
                        </a>
                    </div>
                </div>

                <!--! END: [Team Progress] !-->
                <!-- [Latest Leads] start -->
                <div class="col-xxl-15">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Job Produksi Berjalan</h5>
                        </div>

                        <div class="card-body custom-card-action p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jobTerbaru as $job)
                                            <tr>
                                                <td>{{ $job->modelPakaian->nama_model }}</td>
                                                <td>{{ $job->jumlah_target }}</td>
                                                <td>
                                                    <span
                                                        class="badge
                                                                @if ($job->status == 'menunggu') badge bg-soft-secondary text-secondary
                                                                @elseif($job->status == 'dipotong') badge bg-soft-info text-info
                                                                @elseif($job->status == 'dijahit') badge bg-soft-warning text-warning
                                                                @elseif($job->status == 'finishing') badge bg-soft-primary text-primary
                                                                @elseif($job->status == 'selesai') badge bg-soft-success text-success
                                                                @else badge bg-soft-success @endif">
                                                        {{ ucfirst($job->status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $job->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer text-center fs-11">
                            <a href="{{ route('admin.job-produksi.index') }}"
                                class="card-footer fs-11 fw-bold text-uppercase text-center">
                                Lihat Semua Job Produksi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- [Latest Leads] end -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
    <!-- [ Footer ] start -->
    <footer class="footer">
        <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
            <span>Copyright ©</span>
            <script>
                document.write(new Date().getFullYear());
            </script>
        </p>
    </footer>
    <!-- [ Footer ] end -->
</main>
<!--! [End] Main Content !-->
@include('layouts.admin.footer')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        new ApexCharts(document.querySelector("#chart-produksi"), {
            chart: {
                type: 'bar',
                height: 400
            },
            series: [{
                name: 'Jumlah Job',
                data: [
                    {{ $jobMenunggu }},
                    {{ $jobDiproses }},
                    {{ $jobDijahit }},
                    {{ $jobSelesai }}
                ]
            }],
            xaxis: {
                categories: [
                    'Menunggu',
                    'Dipotong',
                    'Dijahit',
                    'Selesai'
                ]
            }
        }).render();
    });
</script>
