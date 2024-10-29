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
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->


    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-header justify-content-start gap-6 p-6">
                    <div class="mb-2 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Area Kerja</label>
                        <select class="form-select form-select-sm" name="opt_area_kerja" id="opt_area_kerja">
                            <option value=""></option>
                        </select>
                    </div>
                    <div class="mb-2 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Tgl Awal</label>
                        <div class="input-group input-group-sm">
                            <input id="tgl_awal" class="form-control form-control-sm border" />
                            <span class="input-group-text border">
                                <i class="ki-duotone ki-calendar fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-2 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Tgl Akhir</label>
                        <div class="input-group input-group-sm">
                            <input id="tgl_akhir" class="form-control form-control-sm border" />
                            <span class="input-group-text border">
                                <i class="ki-duotone ki-calendar fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                    </div>
                    <div class="mt-8">
                        <button type="button" id="btn-export" class="btn btn-sm btn-success">
                            <i class="fa fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive">
                        <table id="table_laporan_kinerja" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Waktu Pekerjaan</th>
                                    <th>Nama</th>
                                    <th>Ranah Kerja</th>
                                    <th>Uraian Pekerjaan</th>
                                    <th>Kendala</th>
                                    <th>Absensi</th>
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