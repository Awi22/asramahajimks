<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-sm fw-bold btn-success btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_upload">Upload Data Excel</a>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column">
                <div class="flex-column flex-column-auto w-100 mb-10 w-1 ">
                    <div class="card mb-5 mb-xl-8">

                        <div class="card-header justify-content-start gap-6 p-6">
                            <div class="mb-2 col-12 col-sm-3">
                                <label class="form-label fw-bold fs-6 text-gray-700" for="opt_class">Class Item</label>
                                <select name="opt_class" id="opt_class" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- PILIH CLASS ITEM --">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="mb-2 col-12 col-sm-3">
                                <label class="form-label fw-bold fs-6 text-gray-700" for="opt_tipe">Tipe Item</label>
                                <select name="opt_tipe" id="opt_tipe" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- PILIH TIPE ITEM --">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="mb-2 col-12 col-sm-3">
                                <label class="form-label fw-bold fs-6 text-gray-700" for="opt_kategori">Kategori Item</label>
                                <select name="opt_kategori" id="opt_kategori" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- PILIH KATEGORI ITEM --">
                                    <option value=""></option>
                                </select>
                            </div>
                            <!-- <div class="row mb-3 w-100 d-flex flex-center">
                                <div class="mb-2 col-3">
                                    <label class="form-label fw-bold fs-6 text-gray-700">Part Number</label>
                                    <input type="text" name="part_number" id="part_number" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2 col-3">
                                    <label class="form-label fw-bold fs-6 text-gray-700">Nama Part</label>
                                    <input type="text" name="part_alias" id="part_alias" class="form-control form-control-sm">
                                </div>
                            </div> -->
                            <!-- <div class="row mb-3 w-100 d-flex flex-center">
                                <div class="mb-2 col-3">
                                    <label class="form-label fw-bold fs-6 text-gray-700">Class Item</label>
                                    <select name="opt_class" id="opt_class" class="form-select form-select-sm"></select>
                                </div>
                                <div class="mb-2 col-3">
                                    <label class="form-label fw-bold fs-6 text-gray-700">Tipe</label>
                                    <select name="opt_tipe" id="opt_tipe" class="form-select form-select-sm"></select>
                                </div>
                                <div class="mb-2 col-3">
                                    <label class="form-label fw-bold fs-6 text-gray-700">Kategori</label>
                                    <select name="opt_kategori" id="opt_kategori" class="form-select form-select-sm"></select>
                                </div>
                            </div> -->
                        </div>

                        <div class="card-body p-5">
                            <div class="table-responsive">
                                <table id="table_item" class="table align-middle table-row-dashed table-bordered fs-6">
                                    <thead class="text-start text-gray-700 fw-bold fs-7 text-uppercase bg-light-secondary">
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
    </div>
    <!--end::Content-->
</div>

<!--start::MODALS-->
<!-- start::modal_upload -->
<div class="modal fade" id="modal_upload" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header px-5 py-5">
                <h5 class="text-gray-700 m-0"><span class="judul-modal">Upload Data</span></h5>
                <div class="btn btn-sm btn-icon btn-active-color-primary fs-10" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="fv-row mb-2 form-group row">
                            <label class="required fs-6 mb-2 col-md-4" for="uploadFile">File</label>
                            <div class="mb-2 col-md-8">
                                <input name="uploadFile" class="form-control form-control-sm mb-1" type="file" accept=".xls,.xlsx,.csv">
                                <div class="row mt-2">
                                    <a href="<?= base_url('public/upload/excel/sparepart/Master_item.xlsx') ?>" class="fw-bold text-end" download>Download Template</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer flex-end m-0 p-0 px-5 py-5">
                <button id="btn-simpan" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- end::modal_upload -->