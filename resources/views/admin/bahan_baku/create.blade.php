@include('layouts.admin.head-page', ['title' => 'Tambah Bahan Baku'])
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
                            <a href="{{ route('admin.bahan-baku.index') }}">Bahan Baku</a>
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

                            <form action="{{ route('admin.bahan-baku.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="card-body personal-info">

                                    {{-- Header --}}
                                    <div class="mb-4 d-flex align-items-center justify-content-between">
                                        <h5 class="fw-bold mb-0">
                                            <span class="d-block mb-1">Tambah Bahan Baku</span>
                                            <span class="fs-12 fw-normal text-muted">
                                                Pastikan data benar sebelum disimpan
                                            </span>
                                        </h5>
                                    </div>

                                    {{-- Foto Bahan --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Foto Bahan</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="d-flex gap-4 align-items-center">
                                                <div
                                                    class="wd-100 ht-100 position-relative overflow-hidden border rounded">
                                                    <img id="preview-image"
                                                        src="{{ asset('assets/images/placeholder.png') }}"
                                                        class="img-fluid h-100 w-100 rounded" alt="">
                                                    <input type="file" name="foto"
                                                        class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                                        onchange="previewImage(this)">
                                                </div>
                                                <div class="fs-11 text-muted">
                                                    PNG / JPG / JPEG<br>
                                                    Max 2MB
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Nama Bahan --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Nama Bahan</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-box"></i></div>
                                                <input type="text" name="nama_bahan" class="form-control" placeholder="Nama Bahan"
                                                    value="{{ old('nama_bahan') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Warna --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Warna</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-droplet"></i></div>
                                            <input type="text" name="warna" class="form-control" placeholder="Warna"
                                                value="{{ old('warna') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Stok --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Stok (Meter)</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="feather-package"></i></div>
                                            <input type="number" name="stok_meter" class="form-control" placeholder="Stok (Meter)"
                                                value="{{ old('stok_meter') }}" min="0" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Keterangan --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Keterangan</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Isi Keterangan (opsional)">{{ old('keterangan') }}</textarea>
                                        </div>
                                    </div>

                                </div>

                                {{-- Footer --}}
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.bahan-baku.index') }}" class="btn btn-light">
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
</body>
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-image').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</html>
