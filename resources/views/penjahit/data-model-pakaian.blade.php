@include('layouts.penjahit.head-page')

@include('layouts.penjahit.sidebar')
@include('layouts.penjahit.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Penjahit</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('penjahit.data-model-pakaian.index') }}">
                            Data Model Pakaian
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
                            <h5 class="card-title mb-0">Data Model Pakaian</h5>
                            <i class="feather-tag text-primary"></i>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body custom-card-action p-0">
                            <x-alert />

                            <div class="table-responsive">
                                <table id="datatable-model"
                                    class="table table-hover mb-0 align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nama Model</th>
                                            <th>Kategori</th>
                                            <th>Ukuran</th>
                                            <th>Warna</th>
                                            <th>Kebutuhan (m)</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($data as $row)
                                            <tr>
                                                <td>
                                                    <i class="feather-box me-1 text-muted"></i>
                                                    {{ $row->nama_model }}
                                                </td>
                                                <td>
                                                    <span>
                                                        {{ $row->kategori }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $row->ukuran }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-soft-primary text-primary">
                                                        {{ $row->warna }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="feather-bar-chart-2 me-1"></i>
                                                    {{ $row->kebutuhan_bahan }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5"
                                                    class="text-center text-muted py-4">
                                                    <i class="feather-inbox d-block mb-2 fs-4"></i>
                                                    Data model pakaian kosong
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
