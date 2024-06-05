<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3">
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?=$judul?></h1>
			</div>
			<!-- <div class="d-flex align-items-center gap-2 gap-lg-3">
				<a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_customer">Tambah</a>
			</div> -->
		</div>
	</div>
	<!--end::Toolbar-->


	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<div id="kt_app_content_container" class="app-container container-fluid">
			<div class="card">
				<!-- <div class="card-header justify-content-start gap-6 p-6">
					<div class="mb-2 col-12 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">Cabang</label>
						<select name="opt_cabang" id="opt_cabang" class="form-select form-select-sm">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-12 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">Status</label>
						<select name="opt_status" id="opt_status" class="form-select form-select-sm">
							<option value=""></option>
							<option value="on">AKTIF</option>
							<option value="off">NON AKTIF</option>	
						</select>
					</div>
				</div> -->
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_customer" class="table align-middle table-row-dashed fs-6 gy-5">
							<thead class="text-center text-gray-700 fw-bold fs-7 text-uppercase gs-0">
							</thead>
							<tbody class="text-gray-700 gy-9">
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Content-->
</div>


<!--start::MODALS-->
<!-- start::modal_tambah_customer -->
<div class="modal fade" id="modal_tambah_customer" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-900px">
		<div class="modal-content">
			<div class="modal-header p-5">
				<h3 class="text-gray-700">Simpan Customer</h3>
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<!-- start::modal-body -->
			<div class="modal-body">
				<form action="" id="add_customer">
					<div class="row"> 
						<div class="col-md-6">
							<div class="fv-row mb-5">
                                <label class="required fs-6 mb-1">ID Prospek</label>
								<input type="text" class="form-control form-control-sm form-control-solid" name="id_prospek" id="id_prospek" readonly />
								<input type="hidden"  name="id_customer_qr" id="id_customer_qr" readonly />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="required fs-6 mb-1">Tanggal Suspect</label>
								<div class="input-group input-group-sm" >
									<span class="input-group-text border">
										<i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
									</span>
									<input type="text" class="form-control form-control-sm form-control-solid" name="tgl_suspect_tambah" id="tgl_suspect_tambah" value="<?= date('Y-m-d') ?>" readonly />
								</div>
                            </div>
							
                            <div class="fv-row mb-5">
                                <label class="required fs-6 mb-1">Nama Customer</label>
								<input type="text" class="form-control form-control-sm" name="nama_customer" id="nama_customer" />
                            </div>
							<div class="fv-row mb-5">
                                <label class="required fs-6 mb-1">Telephone</label>
								<input type="text" class="form-control form-control-sm" name="tlpn" id="tlpn" />
                            </div>
                            <div class="fv-row mb-5">
                                <label class="required fs-6 mb-1">Alamat</label>
								<textarea class="form-control resize-none" aria-label="With textarea" name="alamat_customer" id="alamat_customer"></textarea>
                            </div>
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Provinsi</label>
								<select class="form-select form-select-sm provinsi" name="opt_provinsi" id="opt_provinsi">
									<option value=""></option>
								</select>
							</div>
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Kabupaten</label>
								<select class="form-select form-select-sm kabupaten" name="opt_kabupaten" id="opt_kabupaten">
									<option value=""></option>
								</select>
							</div>
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Kecamatan</label>
								<select class="form-select form-select-sm kecamatan" name="opt_kecamatan" id="opt_kecamatan">
									<option value=""></option>
								</select>
							</div>
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Kelurahan</label>
								<select class="form-select form-select-sm kelurahan" name="opt_kelurahan" id="opt_kelurahan">
									<option value=""></option>
								</select>
							</div>
							<div class="fv-row mb-5">
                                <label class="required fs-6 mb-1">Kode POS</label>
								<input type="text" class="form-control form-control-sm" name="kode_pos" id="kode_pos" />
                            </div>
						
						</div>
						<div class="col-md-6 mt-10 mt-md-0">
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Model Diminati</label>
								<select class="form-select form-select-sm" name="opt_model_diminati" id="opt_model_diminati">
									<option value=""></option>
								</select>
							</div>
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Sumber Prospek</label>
								<select class="form-select form-select-sm" name="opt_sumber_prospek" id="opt_sumber_prospek">
									<option value=""></option>
								</select>
							</div>
							<div id="form_aktivitas" style="display:none">
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">Tanggal Aktivitas</label>
									<input type="text" class="form-control form-control-sm form-control-solid" name="tgl_aktivitas" id="tgl_aktivitas" />
								</div>
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">Aktivitas</label>
									<select class="form-select form-select-sm" name="opt_aktivitas" id="opt_aktivitas">
										<option value=""></option>
									</select>
								</div>
							</div>
							<div id="form_agent" style="display:none">
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">Nama Agent</label>
									<input type="text" class="form-control form-control-sm" name="nama_agent" id="nama_agent" />
								</div>
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">No Telepon Agent</label>
									<input type="text" class="form-control form-control-sm" name="tlpn_agent" id="tlpn_agent" />
								</div>
							</div>
							<div class="fv-row mb-5" style="display:none" id="form_sales_digital">
								<label class="required fs-6 mb-1" >Nama Sales Digital</label>
								<select class="form-select form-select-sm" name="opt_sales_digital" id="opt_sales_digital">
									<option value=""></option>
								</select>
							</div>
							<div id="form_stnk_norak" style="display:none">
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">Nama STNK</label>
									<input type="text" class="form-control form-control-sm" name="nama_stnk_sumber" id="nama_stnk_sumber" />
								</div>
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">No Rangka</label>
									<input type="text" class="form-control form-control-sm" name="norak_sumber_prospek" id="norak_sumber_prospek" />
								</div>
							</div>
							<div id="form_walk" style="display:none">
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">Tanggal Walk In</label>
									<div class="input-group input-group-sm" >
										<span class="input-group-text border">
											<i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
										</span>
										<input type="text" class="form-control form-control-sm form-control-solid" name="tgl_walk_in" id="tgl_walk_in" />
									</div>
								</div>
							</div>
							<div id="form_referensi" style="display:none">
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">Nama Referensi</label>
									<input type="text" class="form-control form-control-sm" name="nama_refrensi" id="nama_refrensi" />
								</div>
								<div class="fv-row mb-5">
									<label class="required fs-6 mb-1">No Telepon Referensi</label>
									<input type="text" class="form-control form-control-sm" name="tlpn_refrensi" id="tlpn_refrensi" />
								</div>
							</div>
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Kunjungan Berikutnya</label>
								<div class="input-group input-group-sm" >
									<span class="input-group-text border">
										<i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
									</span>
									<input type="text" class="form-control form-control-sm form-control-solid" name="kunjungan_berikut_tambah" id="kunjungan_berikut_tambah" />
								</div>
							</div>
							<div class="fv-row mb-5">
                                <label class="fs-6 mb-1">Keterangan</label>
								<textarea class="form-control resize-none" aria-label="With textarea" name="ket_tambah" id="ket_tambah"></textarea>
                            </div>
						</div>
					</div>
				</form>
			</div>
			<!-- end::modal-body -->
			<!--begin::Modal footer-->
			<div class="modal-footer flex-end">
				<!-- <button type="button" id="btn-simpan" class="btn btn-sm btn-primary btn-c">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Menyimpan... 
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button> -->
				<button type="button" class="btn btn-sm btn-primary" data-bs-stacked-modal="#modal_survai_proses">
					Lanjut
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_tambah_customer -->

<!-- modal_survei_proses -->
<div class="modal fade " id="modal_survai_proses" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                                    <select class="form-select form-select-sm" name="opt_sumber_prospek_survai" id="opt_sumber_prospek_survai" data-control="select2" data-hide-search="true">
                                        <option value="n">Tidak</option>
                                        <option value="y">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-8 col-form-label">Apakah sales consultant mengetahui no telp customer valid?</label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_telp_valid" id="opt_telp_valid" data-control="select2" data-hide-search="true">
										<option value="n">Tidak</option>
                                        <option value="y">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-8 col-form-label">
                                    Apakah customer bertanya awal akan product/promo tertentu atau tidak?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_promo_product" id="opt_promo_product" data-control="select2" data-hide-search="true">
										<option value="n">Tidak</option>
                                        <option value="y">Ya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row fv-row mb-5">
                                <label class="required col-sm-8 col-form-label">
                                    Apakah sales consultant memberikan informasi kepada customer terkait kelengkapan dokumen jika pembelian nya secara kredit berdasarkan profesi / pekerjaan customer nya?
                                </label>
                                <div class="input-group-sm col-sm-4">
                                    <select class="form-select form-select-sm" name="opt_info_dokumen" id="opt_info_dokumen" data-control="select2" data-hide-search="true">
										<option value="n">Tidak</option>
                                        <option value="y">Ya</option>
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
<<!-- end modal_survei_proses --> 
<!--end::MODALS-->

