<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_jabatan">Tambah</a>
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->


    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-body py-4">
                    <div class="table-responsive">
                        <table id="table_jabatan" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Jabatan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--start::MODALS-->
<!-- start::modal_tambah_jabatan -->
<div class="modal fade" id="modal_tambah_jabatan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700"><span class="judul-modal"></span></h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <div class="modal-body p-5">
                <div class="row">
                    <div class="col">
                        <div class="fv-row mb-5">
                            <label class="fs-6 mb-1">Jabatan</label>
                            <input type="text" class="form-control form-control-sm mb-5" placeholder="Jabatan" name="nama_jabatan" id="nama_jabatan" autocomplete="off" />
                            <label class="fs-6 mb-1">Deskripsi</label>
                            <textarea class="form-control form-control-sm" placeholder="Deskripsi Jabatan" name="deskripsi" id="deskripsi" autocomplete="off"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer p-3">
                <button type="button" id="btn-simpan" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_tambah_jabatan -->

<!--end::MODALS-->