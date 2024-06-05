<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_customer">Tambah Customer</a>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-header justify-content-start gap-6 p-6">
                    <div class="row w-100">
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
                        <div class="mb-5 col-12 col-sm-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Status</label>
                            <select name="opt_status" id="opt_status" class="form-select form-select-sm">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="mb-5 col-12 col-sm-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Customer Source</label>
                            <select name="opt_source" id="opt_source" class="form-select form-select-sm" data-control="select2" data-placeholder="Pilih Customer Source" data-allow-clear="true">
                                <option value=""></option>
                                <option value="direct">Direct</option>
                                <option value="digital">Digital</option>
                                <option value="qrcode">QRCode</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_customer" class="table align-middle table-row-dashed fs-6 gy-5">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Model Tambah Customer -->
<div class="modal fade modal_customer" id="modal_tambah_customer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable mw-900px">
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
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_suspect_tambah" id="tgl_suspect_tambah" value="<?= date('Y-m-d') ?>" readonly />
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

<!-- Model Tambah Survai Proses Sales -->
<div class="modal fade " id="modal_survai_proses" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Form Survei Proses Sales</span></h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="" id="add_survai_proses">
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-8 col-form-label">
                                    Apakah sales consultant mengetahui sumber prospek?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_sumber_prospek_survai" id="opt_sumber_prospek_survai">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-8 col-form-label">
                                    Apakah sales consultant mengetahui no telp customer valid?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_telp_valid" id="opt_telp_valid">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-8 col-form-label">
                                    Apakah customer bertanya awal akan product/promo tertentu atau tidak?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_promo_product" id="opt_promo_product">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-8 col-form-label">
                                    Apakah sales consultant memberikan informasi kepada customer terkait kelengkapan dokumen jika pembelian nya secara kredit berdasarkan profesi / pekerjaan customer nya?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_info_dokumen" id="opt_info_dokumen">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_survai_proses" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>

            </div>
        </div>
    </div>
</div>

<!-- Model Tambah Suspect -->
<div class="modal fade " id="modal_suspect" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Customer Suspect <br> Nb : Sebelum lanjut jangan lupa simpan data terlebih dahulu</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="stepper-label ">
                                <h5 class="stepper-title text-gray-700">
                                    Detail Customer
                                </h5>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <form action="" id="form_suspect">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">ID Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="hidden" class="form-control form-control-sm form-control-solid status_customer" name="status_customer" readonly />
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek_suspect" id="id_prospek_suspect" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">Kode Customer Digital</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="digital_customer_suspect" id="digital_customer_suspect" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tanggal Suspect</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_suspect" id="tgl_suspect" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Nama Customer</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="customer_suspect" id="customer_suspect" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Alamat</label>
                                <div class="input-group-sm col-sm-6">
                                    <textarea class="form-control" aria-label="With textarea" name="alamat_suspect" id="alamat_suspect"></textarea>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Provinsi</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_provinsi_suspect" id="opt_provinsi_suspect">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kabupaten</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_kabupaten_suspect" id="opt_kabupaten_suspect">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kecamatan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_kecamatan_suspect" id="opt_kecamatan_suspect">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kelurahan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_kelurahan_suspect" id="opt_kelurahan_suspect">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kode Pos</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="kode_pos_suspect" id="kode_pos_suspect" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Telephone</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="tlpn_suspect" id="tlpn_suspect" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Model Diminati</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_model_diminati_suspect" id="opt_model_diminati_suspect">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Sumber Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_sumber_prospek_suspect" id="opt_sumber_prospek_suspect">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div id="form_aktivitas_suspect" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">Tanggal Aktivitas</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_aktivitas_suspect" id="tgl_aktivitas_suspect" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">Aktivitas</label>
                                    <div class="input-group-sm col-sm-6">
                                        <select class="form-select form-select-sm" name="opt_aktivitas_suspect" id="opt_aktivitas_suspect">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="form_egent_suspect" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">Nama Agent</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="nama_agent_suspect" id="nama_agent_suspect" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">No Telepon Agent</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="tlpn_agent_suspect" id="tlpn_agent_suspect" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5" style="display:none" id="form_sales_digital_suspect">
                                <label class="required col-sm-5 col-form-label">Nama Sales Digital</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_sales_digital_suspect" id="opt_sales_digital_suspect">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div id="form_stnk_norak_suspect" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">Nama STNK</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="nama_stnk_sumber_suspect" id="nama_stnk_sumber_suspect" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">No Rangka</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="norak_sumber_prospek_suspect" id="norak_sumber_prospek_suspect" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5" style="display:none" id="form_walk_suspect">
                                <label class="required col-sm-5 col-form-label">Tanggal Walk in</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_walk_in_suspect" id="tgl_walk_in_suspect" />
                                </div>
                            </div>
                            <div id="form_referensi_suspect" style="display:none">
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">Nama Referensi</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="nama_refrensi_suspect" id="nama_refrensi_suspect" />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-5">
                                    <label class="required col-sm-5 col-form-label">No Telepon Referensi</label>
                                    <div class="input-group-sm col-sm-6">
                                        <input type="text" class="form-control form-control-sm" name="tlpn_refrensi_suspect" id="tlpn_refrensi_suspect" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kunjungan Berikutnya</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="kunjungan_berikut_suspect" id="kunjungan_berikut_suspect" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Keterangan</label>
                                <div class="input-group-sm col-sm-6">
                                    <textarea class="form-control" aria-label="With textarea" name="ket_suspect" id="ket_suspect"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <div class="stepper-label ">
                                <h5 class="stepper-title text-gray-700">
                                    Detail WSA
                                </h5>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <form action="" id="form_data_wsa">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">Jenis Kelamin</label>
                                <div class="form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin_wsa" id="male_wsa" value="Laki-Laki" />
                                    <label class="form-check-label">
                                        Laki - Laki
                                    </label>
                                </div>
                                <div class=" form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin_wsa" id="famale_wsa" value="Perempuan" />
                                    <label class="form-check-label">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Email</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="email" class="form-control form-control-sm" name="email_wsa" id="email_wsa" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Pilihan Cara Bayar</label>
                                <div class="form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="cara_bayar_wsa" id="cash" value="c" />
                                    <label class="form-check-label">
                                        Cash
                                    </label>
                                </div>
                                <div class=" form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="cara_bayar_wsa" id="kredit" value="k" />
                                    <label class="form-check-label">
                                        Kredit
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Model yang diminati alternatif</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="model_minat_wsa" id="model_minat_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Form</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="form_wsa" id="form_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Pekerjaan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="pekerjaan_wsa" id="pekerjaan_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Chanel</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="chanel_wsa" id="chanel_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Event National</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="event_wsa" id="event_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Penawaran Harga</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="penawaran_harga_wsa" id="penawaran_harga_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kebutuhan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="kebutuhan_wsa" id="kebutuhan_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Cabang SGMW</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="cabang_sgwm_wsa" id="cabang_sgwm_wsa">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-7 col-form-label">
                                    Apakah customer merespon contact/followup (min 3x followup)?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_fu_survai" id="opt_fu_survai">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-7 col-form-label">
                                    Apakah sales counter sudah membuat janji temu untuk presentasi product/test drive ?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_test_drive_survai" id="opt_test_drive_survai">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-7 col-form-label">
                                    Apakah customer menyebut tipe/fitur tertentu terhadap product?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_fitur_survai" id="opt_fitur_survai">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-7 col-form-label">
                                    Apakah customer menyebut estimasi pembelian?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_estimasi_survai" id="opt_estimasi_survai">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>

                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_suspect" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_test_drive_suspect" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Test Drive</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_fu_suspect" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Follow Up</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_lanjut_suspect" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Lanjut</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Model Customer Prospek -->
<div class="modal fade " id="modal_prospek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Customer Prospek <br> Nb : Sebelum lanjut jangan lupa simpan data terlebih dahulu</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <form action="" id="form_prospek">
                        <div class="col-md-8">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">ID Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="hidden" class="form-control form-control-sm form-control-solid status_customer" name="status_customer" readonly />
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek_prospek" id="id_prospek_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tanggal Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_prospek" id="tgl_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">Nama</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="nama_prospek" id="nama_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Media Motivator</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_media_motivator_prospek" id="opt_media_motivator_prospek">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Model yang diminati</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="opt_model_diminati_prospek" id="opt_model_diminati_prospek">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Stock Tersedia</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="stock_tersedia_prospek" id="stock_tersedia_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kebutuhan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="kebutuhan_prospek" id="kebutuhan_prospek">
                                        <option value=""></option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="col-sm-5 col-form-label">&nbsp;</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="kebutuhan_bulan" id="kebutuhan_bulan">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Mobil dipakai oleh</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="mobil_dipakai" id="mobil_dipakai" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Rute Sehari-hari</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="rute" id="rute" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Jumlah Anggota Keluarga</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="number" class="form-control form-control-sm" name="jml_anggota" id="jml_anggota" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Decision Maker</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="decision_maker" id="decision_maker" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kunjungan Berikutnya</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="kunjungan_berikut_prospek" id="kunjungan_berikut_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Keterangan</label>
                                <div class="input-group-sm col-sm-6">
                                    <textarea class="form-control" aria-label="With textarea" name="ket_prospek" id="ket_prospek"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_tes_drive_prosepk" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Test Drive</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_fu_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Follow Up</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_lanjut_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Lanjut</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Model Customer Hot Prospek -->
<div class="modal fade " id="modal_hot_prospek" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Customer Hot Prospek <br> Nb : Sebelum lanjut jangan lupa simpan data terlebih dahulu</h3>
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
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek_hot_prospek" id="id_prospek_hot_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">Nama</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="nama_hot_prospek" id="nama_hot_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tanggal Hot Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_hot_prospek" id="tgl_hot_prospek" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Jenis kelamin</label>
                                <div class="form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="male" value="Laki-Laki" />
                                    <label class="form-check-label">
                                        Laki - Laki
                                    </label>
                                </div>
                                <div class=" form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" id="famale" value="Perempuan" />
                                    <label class="form-check-label">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Email</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="email" id="email" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Pilihan cara Bayar</label>
                                <div class="form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="cara_bayar" id="cash_hot_prospek" value="c" />
                                    <label class="form-check-label">
                                        Cash
                                    </label>
                                </div>
                                <div class=" form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="cara_bayar" id="kredit_hot_prospek" value="k" />
                                    <label class="form-check-label">
                                        Kredit
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Kunjungan Berikutnya</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="kungjungan_berikut_hot_prospek" id="kungjungan_berikut_hot_prospek" readonly />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_hot_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_test_drive_hot_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Test Drive</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_fu_hot_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Follow Up</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_lanjut_hot_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Lanjut</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Model Customer SPK -->
<div class="modal fade " id="modal_spk" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Customer SPK <br> Nb : Sebelum lanjut jangan lupa simpan data terlebih dahulu</h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <form action="" id="form_spk">
                        <div class="col-md-10">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">ID Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek_spk" id="id_prospek_spk" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">Nama</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="nama_customer_spk" id="nama_customer_spk" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">No Handphone/WA</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="handpone_spk" id="handpone_spk" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tanggal SPK</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_spk" id="tgl_spk" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Form SPK</label>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="form_spk[]" id="form_spk_1" value="1" />
                                    <label class="form-check-label">
                                        KTP
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="form_spk[]" id="form_spk_2" value="2" />
                                    <label class="form-check-label">
                                        NPWP
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="form_spk[]" id="form_spk_3" value="3" />
                                    <label class="form-check-label">
                                        KK
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="form_spk[]" id="form_spk_4" value="4" />
                                    <label class="form-check-label">
                                        Slip Gaji
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="form_spk[]" id="form_spk_5" value="5" />
                                    <label class="form-check-label">
                                        Rekening Listrik
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="form_spk[]" id="form_spk_6" value="6" />
                                    <label class="form-check-label">
                                        PBB / Sertifikat Tanah
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="form_spk[]" id="form_spk_7" value="7" />
                                    <label class="form-check-label">
                                        SITU/SIUP
                                    </label>
                                </div>
                            </div>
                            <div class=" form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Nama STNK</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="nama_stnk" id="nama_stnk" />
                                </div>
                            </div>

                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Motif Beli</label>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="motif_beli[]" id="motif_beli_1" value="1" />
                                    <label class="form-check-label">
                                        Performance (Mesin,Transmisi)
                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="motif_beli[]" id="motif_beli_2" value="2" />
                                    <label class="form-check-label">
                                        Apperance (Exterior, Interior)

                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="motif_beli[]" id="motif_beli_3" value="3" />
                                    <label class="form-check-label">
                                        Content (Audio, Kenyamanan, Suspensi)

                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="motif_beli[]" id="motif_beli_4" value="4" />
                                    <label class="form-check-label">
                                        Economy (budget, konsumsi bahan bakar)

                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="motif_beli[]" id="motif_beli_5" value="5" />
                                    <label class="form-check-label">
                                        Reliability (ketahanan, kualitas kendaraan)

                                    </label>
                                </div>
                                <div class="form-check form-check-custom form-check-solid col-sm-12" style="padding-left:320px;padding-top:3px">
                                    <input type="checkbox" class="form-check-input" name="motif_beli[]" id="motif_beli_6" value="6" />
                                    <label class="form-check-label">
                                        Safety (Keamanan pasif dan aktif)

                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">No. SPK</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="no_spk" id="no_spk">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Diskon</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="diskon" id="diskon" placeholder="0" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Pengajuan Diskon</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="pengajuan_diskon" id="pengajuan_diskon" placeholder="0" />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tanda Jadi</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="tanda_jadi" id="tanda_jadi" placeholder="0" />
                                    <label class="form-check-label">
                                        <i id="setting_tanda_jadi"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tunai / Transfer</label>
                                <div class="form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="tt" id="tunai" value="t" />
                                    <label class=" form-check-label">
                                        Tunai
                                    </label>
                                </div>
                                <div class=" form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="tt" id="transfer" value="tf" />
                                    <label class=" form-check-label">
                                        Transfer
                                    </label>
                                </div>
                            </div>
                            <div class=" form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Leasing</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="leasing" id="leasing">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Bukti Pembayaran SPK / Foto SPK</label>
                                <div class="input-group-sm col-sm-6">
                                    <div class="image-input image-input-outline" data-kt-image-input="true">
                                        <div class="image-input-wrapper w-125px h-125px" id="backgoud_image"></div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" id="upload_foto" data-bs-toggle="tooltip" title="Change avatar">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="file" name="payment_foto" id="payment_foto" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="payment_foto_remove" />
                                        </label>

                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
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
                        </div>
                    </form>
                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_followup_spk" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Follow Up</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_edit_prospek" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Edit Prospek</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <button type="button" id="btn_simpan_spk" class="btn btn-sm btn-primary">
                    <span class="indicator-label">SPK</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Model Test Drive -->
<div class="modal fade " id="modal_test_drive" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Customer Test Drive</span></h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <form action="" id="form_test_drive">
                        <div class="col-md-10">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">ID Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek_test_drive" id="id_prospek_test_drive" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">Nama Customer</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="nama_test_drive" id="nama_test_drive" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">No Hp</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="no_hp_test_drive" id="no_hp_test_drive" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Model</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="model_test_drive" id="model_test_drive">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Varian</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="varian_test_drive" id="varian_test_drive">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tgl Test Drive</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="tgl_test_drive" id="tgl_test_drive" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tempat Test Drive</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="tempat_test_drive" id="tempat_test_drive">
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

<!-- Model Customer Follow Up -->
<div class="modal fade " id="modal_fu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-900px">
        <div class="modal-content">
            <div class="modal-header p-5">
                <h3 class="text-gray-700">Customer Follow Up</span></h3>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="bi bi-x fs-1"></i>
                </div>
            </div>
            <!-- start::modal-body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10">
                        <form action="" id="form_data_followup">
                            <div class="form-group row fv-row mb-5">
                                <label class="required  col-sm-5 col-form-label">ID Prospek</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek_fu" id="id_prospek_fu" readonly />
                                </div>
                            </div>
                            <!-- <div class="form-group row fv-row mb-5">
                            <label class="required  col-sm-5 col-form-label">Nama</label>
                            <div class="input-group-sm col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="nama_fu" id="nama_fu" readonly />
                            </div>
                        </div> -->
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tanggal Followup</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_fu" id="tgl_fu" value="<?= date('Y-m-d') ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Hasil</label>
                                <div class="form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="hasil" id="bad" value="n" />
                                    <label class="form-check-label">
                                        <i class="bi bi-hand-thumbs-down red"></i> Bad
                                    </label>
                                </div>
                                <div class=" form-check form-check-custom form-check-solid me-10 col-sm-2">
                                    <input class="form-check-input" type="radio" name="hasil" id="good" value="y" />
                                    <label class="form-check-label">
                                        <i class="bi bi-hand-thumbs-up blue"></i> Good
                                    </label>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Status</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="status_fu" id="status_fu">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Buy Plan</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="buy_plan_fu" id="buy_plan_fu">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5" id="remaks_wsa" style="display: none;">
                                <label class="required col-sm-5 col-form-label">Remaks</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="remaks_fu" id="remaks_fu">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Next Follow Up</label>
                                <div class="input-group-sm col-sm-6">
                                    <select class="form-select form-select-sm" name="next_fu" id="next_fu">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Keterangan</label>
                                <div class="input-group-sm col-sm-6">
                                    <textarea class="form-control" aria-label="With textarea" name="ket_fu" id="ket_fu"></textarea>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-5 col-form-label">Tgl Selanjutnya</label>
                                <div class="input-group-sm col-sm-6">
                                    <input type="text" class="form-control form-control-sm" name="tgl_selanjutnya_fu" id="tgl_selanjutnya_fu" readonly />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end::modal-body -->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <button type="button" id="btn_simpan_fu" class="btn btn-sm btn-primary">
                    <span class="indicator-label">Simpan</span>
                    <span class="indicator-progress">Menyimpan...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
    </div>
</div>