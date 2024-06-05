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
                <div class="card-header justify-content-start gap-6 p-6">
                    <div class="mb-5 col-12 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Tahun</label>
                        <select name="opt_tahun" id="opt_tahun" class="form-select form-select-sm">
                        </select>
                    </div>
                    <div class="mb-5 col-12 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Bulan</label>
                        <select name="opt_bulan" id="opt_bulan" class="form-select form-select-sm">
                        </select>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_test_drive" class="table align-middle table-row-dashed fs-6 gy-5">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade " id="modal_test_drive" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Formulir Test Drive</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <form action="" id="form_hot_prospek">
                        <div class="col-md-10">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">ID Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="hidden" class="form-control form-control-sm form-control-solid status_customer" name="status_customer" readonly />
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek" id="id_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">Nama</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="nama" id="nama" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Telepone</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="tlpn" id="tlpn" />
                                </div>
                            </div>

                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Alamat</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="alamat" id="alamat" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Pekerjaan Utama</label>
                                <div class="input-group-sm col-sm-6">
                                    <select name="pekerjaan_utama" id="pekerjaan_utama" class="form-select form-select-sm">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Pekerjaan Sampingan</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="pekerjaan_sampingan" id="pekerjaan_sampingan" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Email</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="email" id="email" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Lokasi Test Drive</label>
                                <div class="input-group-sm col-sm-6">
                                    <select name="tempat_test_drive" id="tempat_test_drive" class="form-select form-select-sm">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Model yg diminati</label>
                                <div class="input-group-sm col-sm-6">
                                    <select name="model_minati" id="model_minati" class="form-select form-select-sm">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Foto (SIM)</label>
                                <div class="input-group-sm col-sm-6">
                                    <div class="image-input image-input-outline" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px" id="backgoud_image_sim"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" id="upload_foto_sim" data-bs-toggle="tooltip" title="Change avatar">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="file" name="foto_sim" id="foto_sim" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="sim_foto_remove" />
                                        </label>

                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel SIM">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <label class="form-check-label">
                                        <i> Allowed JPG, GIF or PNG. Max size of 1024KB</i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Foto Test Drive ketika di dalam Cabin</label>
                                <div class="input-group-sm col-sm-6">
                                    <div class="image-input image-input-outline" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px" id="backgoud_image_cabin"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" id="upload_foto_cabin" data-bs-toggle="tooltip" title="Change avatar">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="file" name="foto_cabin" id="foto_cabin" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="cabin_foto_remove" />
                                        </label>

                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel Cabin">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <label class="form-check-label">
                                        <i> Allowed JPG, GIF or PNG. Max size of 1024KB</i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Rencana pembelian mobil</label>
                                <div class="input-group-sm col-sm-6">
                                    <select name="plan_beli" id="plan_beli" class="form-select form-select-sm">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_test_drive" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>