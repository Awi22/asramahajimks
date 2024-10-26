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
                <a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_karyawan">Tambah</a>
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
                        <table id="table_karyawan" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Area Kerja</th>
                                    <th>Penempatan Tugas</th>
                                    <th>Status Aktif</th>
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
<div class="modal fade" id="modal_tambah_karyawan" tabindex="-1" aria-hidden="true">
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
                            <label class="required col-sm-4 col-form-label">Nama Lengkap</label>
                            <div class="input-group-sm col-sm-8">
                                <input type="text" class="form-control form-control-sm" placeholder="Nama Lengkap" name="nama_karyawan" id="nama_karyawan" autocomplete="off" />
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Jabatan</label>
                            <div class="input-group-sm col-sm-8">
                                <select class="form-select form-select-sm" data-placeholder="Pilih Jabatan" id="opt_id_jabatan" name="opt_id_jabatan">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Area Kerja</label>
                            <div class="input-group-sm col-sm-8">
                                <select class="form-select form-select-sm" data-placeholder="Pilih Area Kerja" id="opt_id_area_kerja" name="opt_id_area_kerja">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Penempatan Tugas</label>
                            <div class="input-group-sm col-sm-8">
                                <select class="form-select form-select-sm" data-placeholder="Pilih Penempatan Tugas" id="opt_id_penempatan_tugas" name="opt_id_penempatan_tugas">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Status Aktif</label>
                            <div class="input-group-sm col-sm-8">
                                <select class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Status Aktif" name="status_aktif" id="status_aktif">
                                    <option></option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Jenis Kelamin</label>
                            <div class="input-group-sm col-sm-8 d-flex">
                                <div class="form-check form-check-custom form-check me-9">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="male" value="L" />
                                    <label class="form-check-label">
                                        Laki - Laki
                                    </label>
                                </div>
                                <div class=" form-check form-check-custom form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="female" value="P" />
                                    <label class="form-check-label">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-5">
                            <label class="required col-sm-4 col-form-label">Agama</label>
                            <div class="input-group-sm col-sm-8">
                                <select class="form-select form-select-sm" data-placeholder="Pilih Agama" id="opt_id_agama" name="opt_id_agama">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="fw-bold fs-3 rotate collapsible mb-7 mt-7" data-bs-toggle="collapse" href="#modal_tambah_karyawan_lanjutan" role="button" aria-expanded="false" aria-controls="modal_tambah_karyawan_detail">
                            <h3 class="text-gray-700"><span>Detail Karyawan</span></h3>
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                        <div id="modal_tambah_karyawan_lanjutan" class="collapse show">
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-4 col-form-label">Email</label>
                                <div class="input-group-sm col-sm-8">
                                    <input type="text" class="form-control form-control-sm" placeholder="Email" name="email" id="email" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-4 col-form-label">Alamat</label>
                                <div class="input-group-sm col-sm-8">
                                    <textarea class="form-control" aria-label="With textarea" placeholder="Alamat" name="alamat" id="alamat"></textarea>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                <div class="input-group-sm col-sm-8">
                                    <input type="text" class="form-control form-control-sm" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                <div class="input-group-sm col-sm-8">
                                    <i class="ki-duotone ki-calendar position-absolute ms-2 mb-1 mt-2 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                    <input class="form-control form-control-sm ps-10" placeholder="<?= date('Y-m-d') ?>" name="tgl_lahir" id="tgl_lahir" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-4 col-form-label">Nomor Telepon</label>
                                <div class="input-group-sm col-sm-8">
                                    <input type="text" class="form-control form-control-sm" placeholder="Nomor Telepon" name="no_telepon" id="no_telepon" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-4 col-form-label">Handphone</label>
                                <div class="input-group-sm col-sm-8">
                                    <input type="text" class="form-control form-control-sm" placeholder="Handphone" name="handphone" id="handphone" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-4 col-form-label">Status Menikah</label>
                                <div class="input-group-sm col-sm-8">
                                    <select class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Status Menikah" name="status" id="status">
                                        <option></option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Bercerai">Bercerai</option>
                                    </select>
                                </div>
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