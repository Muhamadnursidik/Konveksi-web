@include('layouts.admin.head-page')

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
                    <h5 class="m-b-10">Produksi</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.job-produksi.index') }}">Job Produksi</a>
                    </li>
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

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Data Produksi</h5>
                            <a href="{{ route('admin.job-produksi.create') }}" class="btn btn-primary btn-sm">
                                Tambah Produksi
                            </a>
                        </div>

                        <div class="card-body p-0">
                            <x-alert />

                            <div class="table-responsive">
                                <table id="datatable-model" class="table table-hover align-middle"
                                    id="jobProduksiTable">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Bahan</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Pemotong</th>
                                            <th>Bukti Potong</th>
                                            <th>Penjahit</th>
                                            <th>Bukti Jahit</th>
                                            <th>Finishing</th>
                                            <th>Bukti Finishing</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    @include('admin.job-produksi.partials.table-body')
                                </table>
                                <!-- [ Main Content ] end -->
                            </div>
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

<!-- MODAL BUKTI (HARUS DI LUAR CONTAINER) -->
<div class="modal fade" id="modalBukti" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBuktiTitle">Bukti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalBuktiImg" src="" class="img-fluid rounded" alt="Bukti">
            </div>
        </div>
    </div>
</div>

<script>
    const modalBukti = document.getElementById('modalBukti');
    modalBukti.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const img = button.getAttribute('data-img');
        const title = button.getAttribute('data-title');

        modalBukti.querySelector('#modalBuktiImg').src = img;
        modalBukti.querySelector('#modalBuktiTitle').textContent = title;
    });

    setInterval(() => {
        fetch("{{ route('admin.job-produksi.table') }}")
            .then(res => res.text())
            .then(html => {
                document.querySelector('#datatable-model tbody').innerHTML = html;
            });
    }, 10000);

    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('button[data-bs-target="#modalBukti"]')) {
            const imgSrc = e.target.getAttribute('data-img');
            const title = e.target.getAttribute('data-title');

            const modalImg = document.querySelector('#modalBukti img');
            const modalTitle = document.querySelector('#modalBukti .modal-title');

            modalImg.src = imgSrc;
            modalTitle.textContent = title;
        }
    });
</script>
@include('layouts.admin.footer')
