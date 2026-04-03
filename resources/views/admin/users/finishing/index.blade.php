@include('layouts.admin.head-page')

<body>
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
                        <h5 class="m-b-10">User</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.finishing.index') }}">Finishing</a></li>
                        <li class="breadcrumb-item">Index</li>
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
                                <h5 class="card-title">Data Akun Finishing</h5>

                                <div class="card-header-action">
                                    <a href="{{ route('admin.finishing.create') }}" class="btn btn-sm btn-primary">
                                        Tambah
                                    </a>
                                </div>
                            </div>

                            <div class="card-body custom-card-action p-0">
                                <x-alert />

                                <div class="table-responsive">
                                    <table id="datatable-model" class="table table-hover mb-0 align-middle">
                                        <thead>
                                            <tr>
                                                <th>Foto</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @forelse ($users as $row)
                                                <tr>
                                                    <td>
                                                        <div class="avatar-image">
                                                            @if ($row->photo)
                                                                <img src="{{ asset('storage/' . $row->photo) }}"
                                                                    class="img-fluid rounded-circle" width="40">
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <span class="d-block fw-semibold">
                                                            {{ $row->name }}
                                                        </span>
                                                    </td>

                                                    <td>{{ $row->email }}</td>

                                                    <td>
                                                        @if ($row->is_active)
                                                            <span class="badge bg-soft-success text-success">
                                                                Aktif
                                                            </span>
                                                        @else
                                                            <span class="badge bg-soft-danger text-danger">
                                                                Nonaktif
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td class="text-end">
                                                        <div class="hstack gap-2 justify-content-end">
                                                        <a href="{{ route('admin.finishing.edit', $row->id) }}"
                                                                class="avatar-text avatar-md">
                                                                <i class="feather-edit"></i>
                                                            </a>

                                                            <form
                                                                action="{{ route('admin.finishing.destroy', $row->id) }}"
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
                                                    <td colspan="5" class="text-center text-muted">
                                                        Data akun finishing masih kosong
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
    <!--! [End] Main Content !-->
    @include('layouts.admin.footer')
