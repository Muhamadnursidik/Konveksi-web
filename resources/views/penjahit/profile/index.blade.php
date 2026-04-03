@include('layouts.penjahit.head-page')
@include('layouts.penjahit.sidebar')
@include('layouts.penjahit.navbar')

<main class="nxl-container">
    <div class="nxl-content">
        <!-- [ page-header ] start -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Akun</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('penjahit.profile') }}">Profile</a></li>
                    <li class="breadcrumb-item">{{ Auth::user()->name }}</li>
                </ul>
            </div>
        </div>
        <!-- [ page-header ] end -->
        <x-alert />

        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-4 col-xl-6">
                    <div class="card stretch stretch-full">
                        <div class="card-body">
                            <div class="mb-4 text-center">
                                <div class="wd-150 ht-150 mx-auto mb-3 position-relative">
                                    <div class="avatar-image wd-150 ht-150 border border-5 border-gray-3">
                                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/images/avatar/default.png') }}"
                                            alt="user" class="img-fluid">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <a href="javascript:void(0);" class="fs-14 fw-bold d-block">
                                        {{ Auth::user()->name }}</a>
                                    <a href="javascript:void(0);"
                                        class="fs-12 fw-normal text-muted d-block">{{ Auth::user()->email }}</a>
                                </div>

                                <div class="fs-12 fw-normal text-center d-flex flex-wrap gap-3 mb-4">
                                    <div class="flex-fill py-3 px-3 rounded-1 border border-dashed border-gray-5">
                                        <h6 class="fs-15 fw-bolder">{{ $totalJob }}</h6>
                                        <p class="fs-12 text-muted mb-0">Total Job Diproses</p>
                                    </div>
                                    <div class="flex-fill py-3 px-3 rounded-1 border border-dashed border-gray-5">
                                        <h6 class="fs-15 fw-bolder">{{ $totalSelesai }}</h6>
                                        <p class="fs-12 text-muted mb-0">Job Selesai</p>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-unstyled mb-4">
                                <li class="hstack justify-content-between mb-4">
                                    <span class="text-muted fw-medium hstack gap-3"><i
                                            class="feather-user"></i>Nama</span>
                                    <a href="javascript:void(0);" class="float-end">{{ Auth::user()->name }}</a>
                                </li>
                                <li class="hstack justify-content-between mb-4">
                                    <span class="text-muted fw-medium hstack gap-3"><i
                                            class="feather-mail"></i>Email</span>
                                    <a href="javascript:void(0);" class="float-end">{{ Auth::user()->email }}</a>
                                </li>
                                <li class="hstack justify-content-between mb-0">
                                    <span class="text-muted fw-medium hstack gap-3"><i
                                            class="feather-check-circle"></i>Status</span>
                                    <a href="javascript:void(0);" class="float-end">
                                        @if (Auth::user()->is_active)
                                            <span class="badge bg-soft-success text-success">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-soft-danger text-danger">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                            <div class="d-flex gap-1 text-center pt-2">
                                <a href="{{ route('penjahit.profile.edit', Auth::id()) }}"
                                    class="w-100 btn btn-outline-primary">
                                    <i class="feather-edit me-2"></i>
                                    <span>Edit Profile</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-6">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h6 class="mb-0">Riwayat Penjahitan</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="datatable-model" class="table table-bordered align-middle mb-0">
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
                                        @foreach ($jobs as $job)
                                            <tr>
                                                <td>{{ $job->jobProduksi->modelPakaian->nama_model }}</td>
                                                <td>{{ $job->jobProduksi->bahanBaku->nama_bahan }}</td>
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
    <footer class="footer mt-5">
        <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
            <span>Copyright ©</span>
            <script>
                document.write(new Date().getFullYear());
            </script>
        </p>
    </footer>
</main>
@include('layouts.penjahit.footer')
