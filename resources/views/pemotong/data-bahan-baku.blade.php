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

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Pemotong</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('pemotong.data-bahan-baku.index') }}">
                            Data Bahan Baku
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <div class="row">

                <div class="col-xxl-12">
                    <div class="card stretch stretch-full">

                        <!-- CARD HEADER -->
                        <div class="card-header d-flex align-items-center gap-2">
                            <h5 class="card-title mb-0">Data Bahan Baku</h5>
                            <i class="feather-layers text-primary"></i>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body custom-card-action p-0">
                            <x-alert />

                            <div class="table-responsive">
                                <table id="datatable-model" class="table table-hover mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nama</th>
                                            <th>Warna</th>
                                            <th>Stok (Meter)</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $row)
                                            <tr>
                                                <td>
                                                    @if ($row->foto)
                                                        <div class="avatar-image avatar-lg rounded">
                                                            <img class="img-fluid"
                                                                src="{{ asset('storage/' . $row->foto) }}"
                                                                alt="">
                                                        </div>
                                                    @else
                                                        <img id="preview-image"
                                                            src="{{ asset('assets/images/placeholder.png') }}"
                                                            class="avatar-image avatar-lg rounded" alt="">
                                                    @endif
                                                </td>
                                                <td>
                                                    <i class="feather-box me-1 text-muted"></i>
                                                    {{ $row->nama_bahan }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-soft-primary text-primary">
                                                        {{ $row->warna }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="feather-bar-chart-2 me-1"></i>
                                                    {{ $row->stok_meter }}
                                                </td>
                                                <td>{{ $row->keterangan ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">
                                                    <i class="feather-inbox d-block mb-2 fs-4"></i>
                                                    Data bahan baku kosong
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

<!--! [End] Main Content !-->

<!--! [End] Main Content !-->
@include('layouts.pemotong.footer')
