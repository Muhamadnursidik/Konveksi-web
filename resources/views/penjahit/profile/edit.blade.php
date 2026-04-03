@include('layouts.penjahit.head-page')
@include('layouts.penjahit.sidebar')
@include('layouts.penjahit.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('penjahit.profile') }}">Penjahit</a>
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

                        <div class="card-header">
                            <h5 class="card-title">Edit Akun Penjahit</h5>
                        </div>

                        <form action="{{ route('penjahit.profile.update', $users->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body personal-info">
                                <x-alert />

                                {{-- Header --}}
                                <div class="mb-4">
                                    <h5 class="fw-bold mb-0">
                                        <span class="d-block mb-1">Informasi Akun</span>
                                        <span class="fs-12 fw-normal text-muted">
                                            Perbarui data akun penjahit
                                        </span>
                                    </h5>
                                </div>

                                {{-- Foto --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Foto</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="d-flex gap-4 align-items-center">
                                            <div class="wd-100 ht-100 position-relative overflow-hidden border rounded">
                                                <img id="preview-image"
                                                    src="{{ $users->photo ? asset('storage/' . $users->photo) : asset('assets/images/placeholder.png') }}"
                                                    class="img-fluid h-100 w-100 rounded">
                                                <input type="file" name="photo"
                                                    class="position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                                    onchange="previewImage(this)">
                                            </div>
                                            <div class="fs-11 text-muted">
                                                Upload foto baru (opsional)<br>
                                                PNG / JPG / JPEG<br>
                                                Max 2MB
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Nama --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Nama</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <i class="feather-user"></i>
                                            </div>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $users->name) }}" required>
                                        </div>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">Email</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <i class="feather-mail"></i>
                                            </div>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $users->email) }}" disabled>
                                            </div>
                                            <small class="form-text text-muted d-block mt-1">Alamat Email Tidak Bisa Diubah!!</small>
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="row mb-4 align-items-center">
                                    <div class="col-lg-4">
                                        <label class="fw-semibold">
                                            Password
                                            <span class="fs-11 text-muted">(opsional)</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <i class="feather-lock"></i>
                                            </div>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Kosongkan jika tidak diubah">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <a href="{{ route('penjahit.profile') }}" class="btn btn-light">
                                    Kembali
                                </a>
                                <button class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <footer class="footer" style="margin-top:200px">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
        </footer>
    </div>
</main>

@include('layouts.penjahit.footer')
