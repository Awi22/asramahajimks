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
                <a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_kinerja_karyawan">Tambah</a>
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
                <div class="card-header justify-content-start gap-6 p-6">
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
                </div>
                <div class="card-body py-4">
                    <div class="table-responsive">
                        <table id="table_kinerja_karyawan" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Ranah Kerja</th>
                                    <th>Uraian Pekerjaan</th>
                                    <th>Kendala</th>
                                    <th>Absensi</th>
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
<!-- Model Tambah Karyawan -->
<div class="modal fade" id="modal_tambah_kinerja_karyawan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable mw-800px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700"><span class="judul-modal"></span></h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>

            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Kode Karyawan</label>
                            <div class="input-group-sm col-sm-8">
                                <input type="text" class="form-control form-control-sm" name="kode_karyawan" id="kode_karyawan" autocomplete="off" readonly disabled />
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Nama Karyawan</label>
                            <div class="input-group-sm col-sm-8">
                                <input type="text" class="form-control form-control-sm" name="nama_karyawan" id="nama_karyawan" autocomplete="off" readonly />
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Tanggal</label>
                            <div class="input-group-sm col-sm-8">
                                <i class="ki-duotone ki-calendar position-absolute ms-2 mb-1 mt-2 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                    <span class="path6"></span>
                                </i>
                                <input class="form-control form-control-sm ps-10" name="tgl_kinerja" id="tgl_kinerja" autocomplete="off" />
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Ranah Kerja</label>
                            <div class="input-group-sm col-sm-8">
                                <input type="text" class="form-control form-control-sm" placeholder="Lantai 1 dan 2" name="ranah_kerja" id="ranah_kerja" autocomplete="off" />
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Uraian Pekerjaan</label>
                            <div class="input-group-sm col-sm-8">
                                <textarea class="form-control" aria-label="With textarea" placeholder="Uraian Pekerjaan" name="uraian_pekerjaan" id="uraian_pekerjaan"></textarea>
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="col-sm-4 col-form-label">Kendala</label>
                            <div class="input-group-sm col-sm-8">
                                <input type="text" class="form-control form-control-sm" placeholder="Kendala" name="kendala" id="kendala" autocomplete="off" />
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="col-sm-4 col-form-label">Absensi</label>
                            <div class="input-group-sm col-sm-8">
                                <input type="text" class="form-control form-control-sm" placeholder="Absensi" name="absensi" id="absensi" autocomplete="off" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end::modal-body -->

            <!--begin::Modal footer-->
            <div class="modal-footer p-3">
                <button type="button" id="btn-simpan" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--start::MODALS-->