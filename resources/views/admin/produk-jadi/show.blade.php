@include('layouts.admin.head-page')
@include('layouts.admin.sidebar')
@include('layouts.admin.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Produk</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.produk-jadi') }}">Produk Jadi</a></li>
                    <li class="breadcrumb-item active">Detail Produk Jadi</li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <div class="row mb-4">
                <!-- LEFT : FOTO MODEL -->
                <div class="col-xxl-4 col-lg-6">
                    <div class="card stretch stretch-full h-100">
                        <div class="card-header">
                            <h6 class="card-title">Model Pakaian</h6>
                        </div>
                        <div class="card-body text-center d-flex flex-column">
                            <img src="{{ asset('storage/' . $data->jobProduksi->modelPakaian->foto_model) }}"
                                class="img-fluid rounded mb-3" alt="Model Pakaian" style="max-height: 300px; object-fit: cover;">

                            <h5 class="fw-semibold mb-1">
                                {{ $data->jobProduksi->modelPakaian->nama_model }}
                            </h5>

                            <p class="text-muted mb-0">
                                {{ $data->jobProduksi->modelPakaian->kategori }} |
                                Ukuran {{ $data->jobProduksi->modelPakaian->ukuran }}
                            </p>

                            <p class="text-muted mb-0">
                                {{ $data->jobProduksi->modelPakaian->keterangan ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT : DETAIL -->
                <div class="col-xxl-8">
                    <div class="card card-body general-info mb-3">
                        <div class="mb-4 d-flex align-items-center justify-content-between">
                            <h5 class="fw-bold mb-0">
                                <span class="d-block mb-2">Informasi Produk Jadi</span>
                                <span class="fs-12 fw-normal text-muted d-block">Ringkasan hasil produksi</span>
                            </h5>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 fw-medium">Status</div>
                            <div class="col-lg-9 hstack gap-2">
                                <span class="badge bg-soft-success text-success">SELESAI</span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 fw-medium">Tanggal Selesai</div>
                            <div class="col-lg-9 hstack gap-2">
                                <div class="avatar-text avatar-sm">
                                    <i class="feather-calendar"></i>
                                </div>
                                <span>{{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- BAHAN BAKU -->
                    <div class="card card-body general-info">
                        <div class="mb-4">
                            <h5 class="fw-bold mb-0">
                                <span class="d-block mb-2">Bahan Baku Digunakan</span>
                                <span class="fs-12 fw-normal text-muted d-block">Detail material produksi</span>
                            </h5>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 fw-medium">Nama Bahan</div>
                            <div class="col-lg-9">{{ $data->jobProduksi->bahanBaku->nama_bahan }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 fw-medium">Warna</div>
                            <div class="col-lg-9">{{ $data->jobProduksi->bahanBaku->warna }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 fw-medium">Stok Digunakan</div>
                            <div class="col-lg-9">{{ $data->jobProduksi->kebutuhan_bahan_total }} meter</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-3 fw-medium">Keterangan</div>
                            <div class="col-lg-9">
                                {{ $data->jobProduksi->bahanBaku->keterangan ?? '-' }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- JOB PRODUKSI -->
            <div class="card card-body general-info mb-3">
                <div class="mb-4">
                    <h5 class="fw-bold mb-0">
                        <span class="d-block mb-2">Detail Job Produksi</span>
                        <span class="fs-12 fw-normal text-muted d-block">Informasi proses produksi</span>
                    </h5>
                </div>

                <div class="row">
                    {{-- KIRI : DETAIL JOB (INI PUNYAMU, TIDAK DIUBAH) --}}
                    <div class="col-lg-5">
                        <div class="row mb-4">
                            <div class="col-lg-4 fw-medium">ID Job</div>
                            <div class="col-lg-8">#{{ $data->jobProduksi->id }}</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4 fw-medium">Target Produksi</div>
                            <div class="col-lg-8">{{ $data->jobProduksi->jumlah_target }} pcs</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4 fw-medium">Kebutuhan Bahan</div>
                            <div class="col-lg-8">{{ $data->jobProduksi->kebutuhan_bahan_total }} meter</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4 fw-medium">Status Produksi</div>
                            <div class="col-lg-8">
                                <span class="badge bg-soft-success text-success">
                                    {{ strtoupper($data->jobProduksi->status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Pemotong --}}
                        <div class="row mb-4">
                            <div class="col-lg-4 fw-medium">Pemotong</div>
                            <div class="col-lg-8 hstack gap-2">
                                @if ($data->jobProduksi->pemotongan?->pemotong)
                                    <div class="avatar-image avatar-sm">
                                        <img src="{{ asset('storage/' . $data->jobProduksi->pemotongan->pemotong->photo) }}"
                                            class="img-fluid">
                                    </div>
                                    <span>{{ $data->jobProduksi->pemotongan->pemotong->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        {{-- Penjahit --}}
                        <div class="row mb-4">
                            <div class="col-lg-4 fw-medium">Penjahit</div>
                            <div class="col-lg-8 hstack gap-2">
                                @if ($data->jobProduksi->penjahitan?->penjahit)
                                    <div class="avatar-image avatar-sm">
                                        <img src="{{ asset('storage/' . $data->jobProduksi->penjahitan->penjahit->photo) }}"
                                            class="img-fluid">
                                    </div>
                                    <span>{{ $data->jobProduksi->penjahitan->penjahit->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>

                        {{-- Finishing --}}
                        <div class="row mb-4">
                            <div class="col-lg-4 fw-medium">Finishing</div>
                            <div class="col-lg-8 hstack gap-2">
                                @if ($data->jobProduksi->finishing?->finishing)
                                    <div class="avatar-image avatar-sm">
                                        <img src="{{ asset('storage/' . $data->jobProduksi->finishing->finishing->photo) }}"
                                            class="img-fluid">
                                    </div>
                                    <span>{{ $data->jobProduksi->finishing->finishing->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- KANAN : FOTO BUKTI --}}
                    <div class="col-lg-4">
                        <h5 class="fw-bold mb-0">
                            <span class="d-block mb-2">Foto Bukti</span>
                        </h5>

                        {{-- Bukti Potong --}}
                        <div class="row mb-4 align-items-start">
                            <div class="col-lg-4 fw-medium">Pemotong</div>
                            <div class="col-lg-8 ps-3">
                                @if ($data->jobProduksi->pemotongan?->foto_bukti)
                                    <img src="{{ asset('storage/' . $data->jobProduksi->pemotongan->foto_bukti) }}"
                                        class="img-fluid rounded border" style="max-width:120px">
                                @else
                                    <div class="text-muted fs-12">Tidak ada foto</div>
                                @endif
                            </div>
                        </div>


                        {{-- Bukti Jahit --}}
                        <div class="row mb-4 align-items-start">
                            <div class="col-lg-4 fw-medium">Penjahit</div>
                            <div class="col-lg-8 ps-3">
                                @if ($data->jobProduksi->penjahitan?->foto_bukti)
                                    <img src="{{ asset('storage/' . $data->jobProduksi->penjahitan->foto_bukti) }}"
                                        class="img-fluid rounded border" style="max-width:120px">
                                @else
                                    <div class="text-muted fs-12">Tidak ada foto</div>
                                @endif
                            </div>
                        </div>


                        {{-- Bukti Finishing --}}
                        <div class="row mb-4 align-items-start">
                            <div class="col-lg-4 fw-medium">Finishing</div>
                            <div class="col-lg-8 ps-3">
                                @if ($data->jobProduksi->finishing?->foto_bukti)
                                    <img src="{{ asset('storage/' . $data->jobProduksi->finishing->foto_bukti) }}"
                                        class="img-fluid rounded border" style="max-width:120px">
                                @else
                                    <div class="text-muted fs-12">Tidak ada foto</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="footer mt-5">
        <p class="fs-11 text-muted text-uppercase mb-0">
            Copyright © {{ date('Y') }}
        </p>
    </footer>
</main>

@include('layouts.admin.footer')
