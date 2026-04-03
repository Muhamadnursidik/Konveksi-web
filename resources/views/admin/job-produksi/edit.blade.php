@include('layouts.admin.head-page', ['title' => 'Edit Job Produksi'])

<body>
    @include('layouts.admin.sidebar')
    @include('layouts.admin.navbar')

    <main class="nxl-container">
        <div class="nxl-content">

            {{-- Page Header --}}
            <div class="page-header">
                <div class="page-header-left d-flex align-items-center">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Master Data</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.job-produksi.index') }}">Job Produksi</a>
                        </li>
                        <li class="breadcrumb-item">Edit</li>
                    </ul>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">

                            <form action="{{ route('admin.job-produksi.update', $jobProduksi->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="card-body personal-info">

                                    {{-- Header --}}
                                    <div class="mb-4">
                                        <h5 class="fw-bold mb-0">
                                            <span class="d-block mb-1">Edit Job Produksi</span>
                                            <span class="fs-12 fw-normal text-muted">
                                                Perbarui data job produksi
                                            </span>
                                        </h5>
                                    </div>

                                    {{-- Model Pakaian --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Model Pakaian</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="feather-layers"></i>
                                                </div>
                                                <select name="model_pakaian_id" class="form-select" required>
                                                    @foreach ($modelPakaian as $m)
                                                        <option value="{{ $m->id }}"
                                                            @selected($jobProduksi->model_pakaian_id == $m->id)>
                                                            {{ $m->nama_model }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Bahan Baku --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Bahan Baku</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="feather-box"></i>
                                                </div>
                                                <select name="bahan_baku_id" class="form-select" required>
                                                    @foreach ($bahanBaku as $b)
                                                        <option value="{{ $b->id }}"
                                                            @selected($jobProduksi->bahan_baku_id == $b->id)>
                                                            {{ $b->nama_bahan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Target Produksi --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Target Produksi</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="feather-hash"></i>
                                                </div>
                                                <input type="number" name="jumlah_target" class="form-control"
                                                    value="{{ old('jumlah_target', $jobProduksi->jumlah_target) }}"
                                                    min="1" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Status Produksi</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="hidden" name="status" value="menunggu">
                                            <input type="text" class="form-control"
                                                value="{{ ucfirst($jobProduksi->status) }}" disabled>
                                        </div>
                                    </div>

                                </div>

                                {{-- Footer --}}
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.job-produksi.index') }}" class="btn btn-light">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="footer" style="margin-top:220px">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
        </footer>
    </main>

    @include('layouts.admin.footer')
