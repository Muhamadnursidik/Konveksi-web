@include('layouts.penjahit.head-page')

@include('layouts.penjahit.sidebar')
@include('layouts.penjahit.navbar')

<main class="nxl-container">
    <div class="nxl-content">

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-header-left d-flex align-items-center">
                <div class="page-header-title">
                    <h5 class="m-b-10">Penjahit</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Job Jahit</li>
                </ul>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="main-content">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card stretch stretch-full">

                        <div class="card-header">
                            <h5 class="card-title">Job Menunggu Dijahit</h5>
                        </div>

                        <div class="card-body custom-card-action p-0">
                            <x-alert />

                            <div class="table-responsive">
                                <table id="datatable-model" class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Model</th>
                                            <th>Target</th>
                                            <th>Pemotong</th>
                                            <th>Status</th>
                                            <th>>Aksi</th>
                                        </tr>
                                    </thead>
                                    @include('penjahit.partials.table-body')
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalKerjakan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formKerjakan" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Kerjakan Job Jahit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="job_id">

                    <div class="mb-2">
                        <label>Model</label>
                        <input type="text" id="model" class="form-control" readonly>
                    </div>

                    <div class="mb-2">
                        <label>Target</label>
                        <input type="text" id="target" class="form-control" readonly>
                    </div>

                    <label>Foto Bukti</label>
                    <div class="d-flex align-items-center gap-2">
                        <div class="wd-50 ht-50 position-relative overflow-hidden border rounded flex-shrink-0">
                            <img class="preview-image img-fluid h-100 w-100 rounded"
                                src="{{ asset('assets/images/placeholder.png') }}">
                            <input type="file" name="foto_bukti"
                                class="foto-bukti-input position-absolute top-0 start-0 w-100 h-100 opacity-0"
                                accept="image/*" required>

                        </div>
                        <div class="fs-11 text-muted">
                            Upload Bukti Potong <br>
                            PNG / JPG / JPEG<br>
                            Max 2MB
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const modalEl = document.getElementById('modalKerjakan');
        const modal = new bootstrap.Modal(modalEl);

        // ===============================
        // EVENT DELEGATION (FIX AJAX)
        // ===============================
        document.addEventListener('click', function(e) {
            let btn = e.target.closest('.btn-kerjakan');
            if (!btn) return;

            document.getElementById('job_id').value = btn.dataset.id;
            document.getElementById('model').value = btn.dataset.model;
            document.getElementById('target').value = btn.dataset.target;

            modal.show();
        });

        // ===============================
        // SUBMIT AJAX
        // ===============================
        document.getElementById('formKerjakan').addEventListener('submit', function(e) {
            e.preventDefault();

            let id = document.getElementById('job_id').value;
            let formData = new FormData(this);

            fetch(`/penjahit/job-jahit/${id}/selesai`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(async res => {
                    let data;

                    try {
                        data = await res.json();
                    } catch (e) {
                        let text = await res.text();
                        console.log('RESPONSE ERROR:', text);
                        throw new Error('Response bukan JSON');
                    }

                    if (!res.ok) {
                        throw new Error(data.message || 'Server error');
                    }

                    return data;
                })
                .then(res => {
                    modal.hide();
                    loadTable();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message || 'Bukti berhasil dikirim',
                        timer: 2000,
                        showConfirmButton: false
                    });
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: err.message || 'Terjadi kesalahan'
                    });
                });
        });

        // ===============================
        // AJAX TABLE RELOAD
        // ===============================
        function loadTable() {
            fetch("{{ route('penjahit.job.table') }}")
                .then(res => res.text())
                .then(html => {
                    document.querySelector('#datatable-model tbody').innerHTML = html;
                });
        }

        // auto refresh tiap 15 detik
        const tableInterval = setInterval(loadTable, 10000);

    });
</script>

@include('layouts.penjahit.footer')
