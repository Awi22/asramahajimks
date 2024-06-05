<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3">
		<!--begin::Toolbar container-->
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?=$judul?></h1>
			</div>
			<!--end::Page title-->
			<!--begin::Actions-->
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_coa">Tambah</a>
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
				<div class="card-body">
					<table id="table_coa_budget" class="table align-middle table-row-dashed fs-6 gy-5">
						<thead>
							<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
								<th>No</th>
								<th>Kode Akun</th>
								<th>Nama Akun</th>
								<th>Departemen</th>
								<th>SM</th>
								<th>ASM</th>
								<th>GM</th>
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


<!--start::MODALS-->
<!-- start::modal_tambah_coa -->
<div class="modal fade" id="modal_tambah_coa" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-700px">
		<div class="modal-content">
			<div class="modal-header p-5">
				<h3 class="text-gray-700"><span class="judul-modal"></span></h3>
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<!-- start::modal-body -->
			<div class="modal-body">
				<div id="kt_app_content" class="app-content flex-column-fluid p-0">
					<div id="kt_app_content_container" class="app-container container-fluid">
						<table id="table_pilih_akun" class="table align-middle table-row-dashed fs-6 gy-5">
							<thead>
								<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
									<th>No</th>
									<th>Kode Akun</th>
									<th>Nama Akun</th>
									<th>Departemen</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody class="text-gray-700">
							</tbody>
						</table>
					</div>
				</div>
				<!--end::Content-->
			</div>
			<!-- end::modal-body -->
			<!--begin::Modal footer-->
			<div class="modal-footer flex-end">
				<button type="button" id="btn-simpan" class="btn btn-sm btn-primary">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Menyimpan... 
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_tambah_coa -->

<!-- start::modal_edit_coa -->
<div class="modal fade" id="modal_edit_coa" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header px-5 py-5">
				<h5 class="text-gray-700 m-0"><span class="judul-modal"></span></h5>
				<div class="btn btn-sm btn-icon btn-active-color-primary fs-10" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<div class="modal-body">
				<div class="row px-5">
					<div class="col">
						<div class="fv-row mb-2 form-group row">
							<!-- <div class="form-check form-check-custom form-check-solid form-switch">
								<label class="required fs-6 col-6" for="modal_nama_kategori">Service Manager</label>
								<input class="form-check-input me-3" name="email_notification_0" type="checkbox" value="0" checked='checked' />
								<input type="number" min=0 class="form-control form-control-sm w-70px" name="modal_nama_kategori" id="modal_nama_kategori" />
							</div> -->
							<div class="form-check form-check-custom  form-switch">
								<label class="required fs-6 col-6" for="modal_nama_kategori">Service Manager</label>
								<input id="sw_sm" class="form-check-input h-20px w-30px me-5" type="checkbox" value="1" />
								<div class="input-group input-group-sm w-100px" >
									<input type="number" min="0" value="0" class="form-control form-control-sm" name="persen_sm" id="persen_sm" disabled/>
									<span class="input-group-text border border-1">%</span>
								</div>
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<div class="form-check form-check-custom  form-switch">
								<label class="required fs-6 col-6" for="modal_nama_kategori">Area Service Manager</label>
								<input id="sw_asm" class="form-check-input h-20px w-30px me-5" type="checkbox" value="1" />
								<div class="input-group input-group-sm w-100px" >
									<input type="number" min="0" value="0" class="form-control form-control-sm" name="persen_asm" id="persen_asm" disabled/>
									<span class="input-group-text border border-1">%</span>
								</div>
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<div class="form-check form-check-custom  form-switch">
								<label class="required fs-6 col-6" for="modal_nama_kategori">General Manager</label>
								<input id="sw_gm" class="form-check-input h-20px w-30px me-5" type="checkbox" value="1" />
								<div class="input-group input-group-sm w-100px" >
									<input type="number" min="0" value="0" class="form-control form-control-sm" name="persen_gm" id="persen_gm" disabled/>
									<span class="input-group-text border border-1">%</span>
								</div>
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<div class="form-check form-check-custom  form-switch">
								<label class="required fs-6 col-6" for="modal_nama_kategori">Set Maximum Budget</label>
								<div class="input-group input-group-sm w-150px" >
									<span class="input-group-text border border-1">Rp</span>
									<input type="text" class="form-control form-control-sm" name="max_budget" id="max_budget" value="0" />
								</div>
							</div>
						</div>
						<!-- <div class="fv-row mb-2 form-group row">
							<div class="form-check form-check-custom  form-switch">
								<label class="required fs-6 col-6" for="modal_nama_kategori">Limit Over Budget</label>
								<div class="input-group input-group-sm w-100px" >
									<input type="number" min="0" value="0" class="form-control form-control-sm" name="modal_nama_kategori" id="modal_nama_kategori" />
									<span class="input-group-text border border-1">%</span>
								</div>
							</div>
						</div> -->
					</div>
				</div>
			</div>
			<div class="modal-footer flex-end m-0 p-0 px-5 py-5">
				<button  id="btn-simpan-approval" class="btn btn-sm btn-primary">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Menyimpan...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
					</span>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_edit_coa -->
<!--end::MODALS-->

