@include('layouts.admin.head-page', ['title' => 'Tambah Job Produksi'])
<body>
    {{-- Sidebar --}}
    @include('layouts.admin.sidebar')

    {{-- Navbar --}}
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
                        <li class="breadcrumb-item">Create</li>
                    </ul>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">

                            <form action="{{ route('admin.job-produksi.store') }}" method="POST">
                                @csrf

                                <div class="card-body personal-info">
                                    <x-alert />

                                    {{-- Header --}}
                                    <div class="mb-4 d-flex align-items-center justify-content-between">
                                        <h5 class="fw-bold mb-0">
                                            <span class="d-block mb-1">Tambah Job Produksi</span>
                                            <span class="fs-12 fw-normal text-muted">
                                                Pastikan data produksi sudah benar
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
                                                    <option value="">-- Pilih Model --</option>
                                                    @foreach ($modelPakaian as $m)
                                                        <option value="{{ $m->id }}"
                                                            {{ old('model_pakaian_id') == $m->id ? 'selected' : '' }}>
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
                                                    <option value="">-- Pilih Bahan --</option>
                                                    @foreach ($bahanBaku as $b)
                                                        <option value="{{ $b->id }}"
                                                            {{ old('bahan_baku_id') == $b->id ? 'selected' : '' }}>
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
                                                <input type="number"
                                                       name="jumlah_target"
                                                       class="form-control"
                                                       placeholder="Jumlah target"
                                                       value="{{ old('jumlah_target') }}"
                                                       min="1"
                                                       required>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Footer --}}
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.job-produksi.index') }}" class="btn btn-light">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Simpan
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
