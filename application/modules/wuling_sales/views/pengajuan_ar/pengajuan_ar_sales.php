<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel_pengajuan_ar" class="table align-middle table-row-dashed fs-6 gy-5">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model Pengajuan AR -->
<div class="modal fade " id="modal_pengajuan_ar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Pengajuan AR</span></h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row fv-row mb-5">
                            <label class="required  col-sm-5 col-form-label">Pengajuan AR</label>
                            <div class="input-group-sm col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="pengajuan_ar" id="pengajuan_ar" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_pengajuan_ar" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>