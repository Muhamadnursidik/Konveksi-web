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
                    <h5 class="m-b-10">Produk</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.produk-jadi') }}">Produk Jadi</a></li>
                </ul>
            </div>
        </div>
        <!-- [ page-header ] end -->

        <!-- [ Main Content ] start -->
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">
                                Produk Jadi
                                <span class="badge bg-success ms-2">
                                    Total: {{ $data->count() }}
                                </span>
                            </h5>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="datatable-model" class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Produk</th>
                                            <th>Bahan</th>
                                            <th>Jumlah</th>
                                            <th>Tanggal Selesai</th>
                                            <th>Status</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                {{-- Produk --}}
                                                <td class="project-name-td">
                                                    <div class="hstack gap-4">
                                                        <div class="avatar-image border-0">
                                                            <img src="{{ asset('storage/' . optional($item->jobProduksi?->modelPakaian)->foto_model) }}"
                                                                class="img-fluid" alt="Model">
                                                        </div>
                                                        <div>
                                                            <span class="d-block fw-semibold">
                                                                {{ $item->jobProduksi->modelPakaian->nama_model ?? '-' }}
                                                            </span>
                                                            <p class="fs-12 text-muted mt-1 mb-0">
                                                                {{ $item->jobProduksi->modelPakaian->kategori }} |
                                                                {{ $item->jobProduksi->modelPakaian->ukuran }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- Bahan --}}
                                                <td>
                                                    <span class="d-block">
                                                        {{ $item->jobProduksi->bahanBaku->nama_bahan }}
                                                    </span>
                                                    <small class="text-muted">
                                                        {{ $item->jobProduksi->bahanBaku->warna }}
                                                    </small>
                                                </td>

                                                {{-- Jumlah --}}
                                                <td>
                                                    {{ $item->jobProduksi->jumlah_target }}
                                                </td>

                                                {{-- Tanggal --}}
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                                </td>

                                                {{-- Status --}}
                                                <td>
                                                    <span class="badge bg-soft-success text-success">
                                                        Selesai
                                                    </span>
                                                </td>

                                                {{-- Aksi --}}
                                                <td class="text-end">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <a href="{{ route('admin.produk-jadi.show', $item) }}" class="avatar-text avatar-md">
                                                            <i class="feather feather-eye"></i>
                                                        </a>
                                                    </div>
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
    <!-- [ Footer ] start -->
    <footer class="footer mt-5">
        <p class="fs-11 text-muted text-uppercase mb-0">
            Copyright © {{ date('Y') }}
        </p>
    </footer
    <!-- [ Footer ] end -->
</main>
<!--! [End] Main Content !-->
@include('layouts.admin.footer')
