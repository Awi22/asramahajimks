<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
			</div>
			<!--end::Page title-->
			<!--begin::Actions-->
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<!-- <a href="#" class="btn btn-sm fw-bold btn-primary btn-download-data-sales">Download Data</a> -->
				<button type="button" id="btn-download-data-sales" class="btn btn-sm btn-primary btn-download-data-sales">
					<span class="indicator-label">Download Data</span>
					<span class="indicator-progress">Downloading...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
			</div>
			<!--end::Actions-->
	</div>
	<!--end::Toolbar-->


	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<div id="kt_app_content_container" class="app-container container-fluid">
			<div class="card">
				<div class="card-header justify-content-start gap-6 p-6">
					<div class="mb-2 col-12 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700" for="opt_cabang">Cabang</label>
						<select name="opt_cabang" id="opt_cabang" class="form-select form-select-sm">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-12 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700" for="opt_status">Status</label>
						<select name="opt_status" id="opt_status" class="form-select form-select-sm">
							<option value=""></option>
							<option value="s">FORCE</option>
							<option value="c">COUNTER</option>
							<option value="f">FLEET</option>
						</select>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_sales" class="table align-middle table-row-dashed table fs-6 gy-5">
							<thead class="text-start text-gray-700 fw-bold fs-7 text-uppercase gs-0">
							</thead>
							<tbody class="text-gray-700">
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
<!-- start::modal_edit_sales -->
<div class="modal fade" id="modal_edit_sales" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header px-5 py-5">
				<h5 class="text-gray-700 m-0"><span class="judul-modal">Data Sales</span></h5>
				<div class="btn btn-sm btn-icon btn-active-color-primary fs-10" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="nik-edit">NIK</label>
							<div class=" mb-2 col-md-8">
								<input type="text" class="form-control form-control-solid form-control-sm" name="nik-edit" id="nik-edit" readonly />
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="fs-6 mb-2 col-md-4" for="btn-kode-sales-sgmw">Kode Sales SGMW</label>
							<div class="mb-2 col-md-8">
								<div class="input-group input-group-btn">
									<input type="text" class="input-group form-control form-control-solid form-control-sm" name="kode-sgmw-edit" id="kode-sgmw-edit" readonly />
									<button class="btn btn-icon btn-light-primary w-30px h-30px p-0 py-5" name="btn-kode-sales-sgmw" id="btn-kode-sales-sgmw" datsa-bs-toggle="modal" dasta-bs-target="#modal_kode_sales_sgmw" data-bs-stacked-modal="#modal_kode_sales_sgmw"><i class="fa fa-search"></i></button>
								</div>
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="nama-sales-edit">Nama Sales</label>
							<div class=" mb-2 col-md-8">
								<input type="text" class="form-control form-control-solid form-control-sm" name="nama-sales-edit" id="nama-sales-edit" readonly />
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="jabatan-edit">Jabatan Sales</label>
							<div class=" mb-2 col-md-8">
								<input type="text" class="form-control form-control-solid form-control-sm" name="jabatan-edit" id="jabatan-edit" readonly />
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="username-edit">Username</label>
							<div class=" mb-2 col-md-8">
								<input type="text" class="form-control form-control-solid form-control-sm" name="username-edit" id="username-edit" readonly />
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="opt-jenis-sales-edit">Jenis Sales</label>
							<div class=" mb-2 col-md-8">
								<select name="opt-jenis-sales-edit" id="opt-jenis-sales-edit" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Jenis Sales">
									<option value="s">FORCE</option>
									<option value="c">COUNTER</option>
									<option value="f">FLEET</option>
								</select>
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="opt-level-edit">Level Sales</label>
							<div class=" mb-2 col-md-8">
								<select name="opt-level-edit" id="opt-level-edit" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Jenis Sales">
									<option value="n">SALES</option>
									<option value="l">LEADER</option>
									<option value="s">SUPERVISOR</option>
									<option value="sm">SALES MANAGER</option>
								</select>
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="opt-status-edit">Status Aktif</label>
							<div class=" mb-2 col-md-8">
								<select name="opt-status-edit" id="opt-status-edit" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Jenis Sales">
									<option value="R">TIDAK AKTIF</option>
									<option value="A">AKTIF</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer flex-end m-0 p-0 px-5 py-5">
				<button type="button" id="btn-reset-password" class="btn btn-sm btn-warning">
					<span class="indicator-label">Reset Password</span>
					<span class="indicator-progress">Mereset...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
				<button type="button" id="btn-update-sales" class="btn btn-sm btn-primary">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Menyimpan...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_edit_sales -->
<!-- start:modal_kode_sales_sgmw -->
<div class="modal hide fade" id="modal_kode_sales_sgmw" tabindex="-1" aria-hidden="true" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header px-5 py-5">
				<h5 class="text-gray-700 m-0"><span class="judul-modal">Kode Sales SGMW</span></h5>
				<div class="btn btn-sm btn-icon btn-active-color-primary fs-10" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<div class="modal-body">
				<div class="table-responsivexx">
					<table id="table_sales_wsa" class="table align-middle table-row-dashed table fs-6 gy-5">
						<thead class="text-start text-gray-700 fw-bold fs-7 text-uppercase gs-0">
						</thead>
						<tbody class="text-gray-700 fs-7">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer flex-center m-0 p-0 px-5 py-5">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end:modal_kode_sales_sgmw -->

<!-- start::modal_cari_pegawai -->
<div class="modal fade" id="modal_cari_pegawai" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-900px">
		<div class="modal-content">
			<div class="modal-header p-5">
				<h3 class="text-gray-700">Pegawai</h3>
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<div class="modal-body">
				<table id="table_pegawai" class="table table-striped table-row-bordered gy-2 gs-2">
					<thead>
						<tr class="fw-semibold fs-6 text-gray-700">
							<th>NIK</th>
							<th>Cabang</th>
							<th>Nama Pegawai</th>
							<th>Jabatan</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_edit_sales -->
<!--end::MODALS-->
