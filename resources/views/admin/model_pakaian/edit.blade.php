@include('layouts.admin.head-page', ['title' => 'Edit Model Pakaian'])
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
                            <a href="{{ route('admin.model-pakaian.index') }}">Model Pakaian</a>
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

                            <form action="{{ route('admin.model-pakaian.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card-body personal-info">
                                    <x-alert />

                                    {{-- Header --}}
                                    <div class="mb-4">
                                        <h5 class="fw-bold mb-1">Edit Model Pakaian</h5>
                                        <span class="fs-12 text-muted">
                                            Perbarui data model pakaian
                                        </span>
                                    </div>

                                    {{-- foto model --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Foto Bahan</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="d-flex gap-4 align-items-center">
                                                <div class="wd-100 ht-100 position-relative overflow-hidden border rounded">
                                                    <img id="preview-image"
                                                         src="{{ $item->foto_model
                                                            ? asset('storage/'.$item->foto_model)
                                                            : asset('assets/images/placeholder.png') }}"
                                                         class="img-fluid h-100 w-100 rounded">
                                                    <input type="file" name="foto_model"
                                                           class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                                           onchange="previewImage(this)">
                                                </div>
                                                <div class="fs-11 text-muted">
                                                    Kosongkan jika tidak diganti
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Nama Model --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Nama Model</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="feather-tag"></i>
                                                </div>
                                                <input type="text" name="nama_model" class="form-control"
                                                    value="{{ old('nama_model', $item->nama_model) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Kategori --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Kategori</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="feather-grid"></i>
                                                </div>
                                                <input type="text" name="kategori" class="form-control"
                                                    value="{{ old('kategori', $item->kategori) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Ukuran --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Ukuran</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="ukuran" class="form-control" required>
                                                <option value="S" {{ old('ukuran', $item->ukuran) == 'S' ? 'selected' : '' }}>S</option>
                                                <option value="M" {{ old('ukuran', $item->ukuran) == 'M' ? 'selected' : '' }}>M</option>
                                                <option value="L" {{ old('ukuran', $item->ukuran) == 'L' ? 'selected' : '' }}>L</option>
                                                <option value="XL" {{ old('ukuran', $item->ukuran) == 'XL' ? 'selected' : '' }}>XL</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Kebutuhan Bahan --}}
                                    <div class="row mb-4 align-items-center">
                                        <div class="col-lg-4">
                                            <label class="fw-semibold">Kebutuhan Bahan (Meter)</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="input-group">
                                                <div class="input-group-text">
                                                    <i class="feather-package"></i>
                                                </div>
                                                <input type="text" step="0.01" name="kebutuhan_bahan"
                                                    class="form-control"
                                                    value="{{ old('kebutuhan_bahan', $item->kebutuhan_bahan) }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Footer --}}
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.model-pakaian.index') }}" class="btn btn-light">
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
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0">
                Copyright ©
                <script>document.write(new Date().getFullYear())</script>
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
