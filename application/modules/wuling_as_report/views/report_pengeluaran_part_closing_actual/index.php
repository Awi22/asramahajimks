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
                <div class="card-header justify-content-start gap-6 p-6">
                    <div class="mb-2 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Jenis Part</label>
                        <select name="filter" id="filter" class="form-select form-select-sm">
                            <option value="">Pilih Filter</option>
                            <option value="reguler">Stok Reguler</option>
                            <option value="pud">Stok Konsinyasi</option>
                        </select>
                    </div>
                    <div class="mb-2 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select form-select-sm">
                            <option value="">Pilih Filter</option>
                        </select>
                    </div>
                    <div class="mb-2 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select form-select-sm">
                            <option value="">Pilih Filter</option>
                        </select>
                    </div>
                    <div class="mt-8">
                        <button type="button" id="btn-lihat" class="btn btn-sm btn-primary">
                            Lihat
                        </button>
                        <button type="button" id="btn-excel" class="btn btn-sm btn-success">
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