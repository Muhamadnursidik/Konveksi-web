@include('layouts.admin.head-page', ['title' => 'Model Pakaian'])

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
                        <li class="breadcrumb-item">Index</li>
                    </ul>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">

                            {{-- Card Header --}}
                            <div class="card-header">
                                <h5 class="card-title">Data Model Pakaian</h5>

                                <div class="card-header-action">
                                    <a href="{{ route('admin.model-pakaian.create') }}" class="btn btn-sm btn-primary">
                                        Tambah
                                    </a>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body custom-card-action p-0">
                                <x-alert />

                                <div class="table-responsive">
                                    <table id="datatable-model" class="table table-hover mb-0 align-middle">
                                        <thead>
                                            <tr>
                                                <th>Foto Model</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Ukuran</th>
                                                <th>Kebutuhan (m)</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $row)
                                                <tr>
                                                    {{-- Foto --}}
                                                    <td>
                                                        @if ($row->foto_model)
                                                            <div class="avatar-image avatar-lg rounded">
                                                                <img class="img-fluid"
                                                                    src="{{ asset('storage/' . $row->foto_model) }}"
                                                                    alt="Foto Model">
                                                            </div>
                                                        @else
                                                            <img id="preview-image"
                                                                src="{{ asset('assets/images/placeholder.png') }}"
                                                                class="avatar-image avatar-lg rounded" alt="">
                                                        @endif
                                                    </td>

                                                    {{-- Nama --}}
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-semibold">{{ $row->nama_model }}</span>
                                                            <span class="fs-12 text-muted">
                                                                ID: {{ $row->id }}
                                                            </span>
                                                        </div>
                                                    </td>

                                                    <td>{{ $row->kategori }}</td>
                                                    <td>{{ $row->ukuran }}</td>

                                                    {{-- Kebutuhan Bahan --}}

                                                    <td class="fw-bold">
                                                        {{ $row->kebutuhan_bahan }}
                                                    </td>

                                                    {{-- Aksi --}}
                                                    <td class="text-end">
                                                        <div class="hstack gap-2 justify-content-end">

                                                            <a href="{{ route('admin.model-pakaian.edit', $row->id) }}"
                                                                class="avatar-text avatar-md">
                                                                <i class="feather-edit"></i>
                                                            </a>

                                                            <form
                                                                action="{{ route('admin.model-pakaian.destroy', $row->id) }}"
                                                                method="POST" class="d-inline form-delete">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="avatar-text avatar-md bg-soft-danger text-danger border-0">
                                                                    <i class="feather-trash-2"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">
                                                        Data model pakaian kosong
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Pagination --}}
                            @if (method_exists($data, 'links'))
                                <div class="card-footer">
                                    {{ $data->links() }}
                                </div>
                            @endif

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
