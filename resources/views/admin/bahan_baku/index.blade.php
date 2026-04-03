@include('layouts.admin.head-page', ['title' => 'Bahan Baku'])

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
                                <h5 class="card-title">Data Bahan Baku</h5>

                                <div class="card-header-action">
                                    <a href="{{ route('admin.bahan-baku.create') }}" class="btn btn-sm btn-primary">
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
                                                <th>Foto Bahan</th>
                                                <th>Nama</th>
                                                <th>Warna</th>
                                                <th>Stok (Meter)</th>
                                                <th>Keterangan</th>
                                                <th class="text-end">Aksi</th>
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
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-semibold">{{ $row->nama_bahan }}</span>
                                                            <span class="fs-12 text-muted">
                                                                ID: {{ $row->id }}
                                                            </span>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <span class="badge bg-soft-primary text-primary">
                                                            {{ $row->warna }}
                                                        </span>
                                                    </td>

                                                    <td class="fw-bold">
                                                        <i class="feather-bar-chart-2 me-1"></i>
                                                        {{ $row->stok_meter }}
                                                    </td>

                                                    <td>
                                                        {{ $row->keterangan ?? '-' }}
                                                    </td>

                                                    <td class="text-end">
                                                        <div class="hstack gap-2 justify-content-end">

                                                            <a href="{{ route('admin.bahan-baku.edit', $row->id) }}"
                                                                class="avatar-text avatar-md">
                                                                <i class="feather-edit"></i>
                                                            </a>

                                                            <form
                                                                action="{{ route('admin.bahan-baku.destroy', $row->id) }}"
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
                                                    <td colspan="5" class="text-center text-muted py-4">
                                                        Data kosong
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Card Footer (Pagination kalau ada) --}}
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
        <footer class="footer" style="margin-top:200px">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
        </footer>
    </main>

    @include('layouts.admin.footer')
