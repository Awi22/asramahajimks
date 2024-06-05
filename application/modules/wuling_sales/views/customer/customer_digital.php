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
                        <table id="table_customer_digital" class="table align-middle table-row-dashed fs-6 gy-5">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Model Tambah Customer -->
<div class="modal fade modal_customer" id="modal_tambah_customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Tambah Customer</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>

            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="add_customer">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-4 col-form-label">ID Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek" id="id_prospek" value="<?= $id_prospek ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Tanggal Suspect</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_suspect_tambah" id="tgl_suspect_tambah" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Kode Customer Digital</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="digital_customer" id="digital_customer" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Nama Customer</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="nama_customer" id="nama_customer" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Alamat</label>
                                <div class="input-group-sm col-sm-6">
                                    <textarea class="form-control" aria-label="With textarea" name="alamat_customer" id="alamat_customer"></textarea>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Provinsi</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm provinsi" name="opt_provinsi" id="opt_provinsi">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Kabupaten</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm kabupaten" name="opt_kabupaten" id="opt_kabupaten">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Kecamatan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm kecamatan" name="opt_kecamatan" id="opt_kecamatan">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Kelurahan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm kelurahan" name="opt_kelurahan" id="opt_kelurahan">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Kode Pos</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="kode_pos" id="kode_pos" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Telephone</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="tlpn" id="tlpn" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Model Diminati</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_model_diminati" id="opt_model_diminati">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Sumber Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_sumber_prospek" id="opt_sumber_prospek">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div id="form_aktivitas" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">Tanggal Aktivitas</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_aktivitas" id="tgl_aktivitas" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">Aktivitas</label>
                                    <div class="input-group-sm col-sm-6">
                                        <select class="form-select form-select-sm" name="opt_aktivitas" id="opt_aktivitas">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="form_egent" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">Nama Agent</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="nama_agent" id="nama_agent" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">No Telepon Agent</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="tlpn_agent" id="tlpn_agent" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5" style="display:none" id="form_sales_digital">
                                <label class="required col-sm-4 col-form-label">Nama Sales Digital</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_sales_digital" id="opt_sales_digital">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div id="form_stnk_norak" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">Nama STNK</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="nama_stnk_sumber" id="nama_stnk_sumber" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">No Rangka</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="norak_sumber_prospek" id="norak_sumber_prospek" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5" style="display:none" id="form_walk">
                                <label class="required col-sm-4 col-form-label">Tanggal Walk in</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_walk_in" id="tgl_walk_in" />
                                </div>
                            </div>
                            <div id="form_referensi" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">Nama Referensi</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="nama_refrensi" id="nama_refrensi" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-4 col-form-label">No Telepon Referensi</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="tlpn_refrensi" id="tlpn_refrensi" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Kunjungan Berikutnya</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="kunjungan_berikut_tambah" id="kunjungan_berikut_tambah" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-4 col-form-label">Keterangan</label>
                                <div class="input-group-sm col-sm-6">
                                    <textarea class="form-control" aria-label="With textarea" name="ket_tambah" id="ket_tambah"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end::modal-body -->

            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_customer" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>