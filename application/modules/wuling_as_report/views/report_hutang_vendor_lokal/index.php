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
                            <label class="form-label fw-bold fs-6 text-gray-700">Status</label>
                            <select name="status" id="status" class="form-select form-select-sm">
                                <option value="0">Outstanding</option>
                                <option value="1">Done</option>
                            </select>
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
                <!-- <div id="show"></div> -->
                <div class="table-responsive mb-5 mt-5">
                    <table class="table table-sm borderRightBottom" id="datatable" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>No PO</th>
                                <th>No WO</th>
                                <th>No Pengeluaran</th>
                                <th>No BKU</th>
                                <th>Nama Vendor</th>
                                <th>Harga</th>
                                <th>PPN</th>
                                <th>Total</th>
                                <th>Nilai Hutang</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="7" class="text-start">Total</td>
                                <td id="total-harga">0</td>
                                <td id="total-ppn">0</td>
                                <td id="total">0</td>
                                <td class="total-hutang">0</td>
                            </tr>
                            <tr>
                                <td colspan="10" class="borderLeftTop">Total Hutang</td>
                                <td class="center borderLeftTop total-hutang">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- end:: table -->
            </div>
            <!--end::Card-->
        </div>
    </div>
    <!--end::Content-->
</div>