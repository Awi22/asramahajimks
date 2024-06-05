<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <!-- <a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_upload">Tambah</a> -->
            </div>
        </div>
    </div>
    <!--end::Toolbar-->


    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header justify-content-center gap-6 p-6">
                    <div class="row mb-0 w-100 d-flex flex-center">
                        <div class="mb-2 col-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Tgl Awal</label>
                            <div class="input-group input-group-sm">
                                <input id="tgl_awal" class="form-control form-control-sm border" />
                                <span class="input-group-text border">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-2 col-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Tgl Akhir</label>
                            <div class="input-group input-group-sm">
                                <input id="tgl_akhir" class="form-control form-control-sm border" />
                                <span class="input-group-text border">
                                    <i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-2 col-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Cabang</label>
                            <select name="perusahaan" id="perusahaan" class="form-select form-select-sm"></select>
                        </div>
                        <div class="mb-2 col-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Mekanik</label>
                            <select name="list_mekanik" id="list_mekanik" class="form-select form-select-sm"></select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" id="btn-lihat" class="btn btn-sm btn-primary">
                            Lihat
                        </button>
                        <button type="button" id="export" class="btn btn-sm btn-success">
                            Excel
                        </button>
                    </div>
                </div>
                <!-- begin:: table -->
                <div id="show"></div>
                <!-- end:: table -->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->
</div>