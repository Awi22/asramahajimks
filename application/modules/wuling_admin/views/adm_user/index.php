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
				<a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_user">Tambah</a>
			</div>
			<!--end::Actions-->
		</div>
		<!--end::Toolbar container-->
	</div>
	<!--end::Toolbar-->


	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-fluid">
			<!--begin::Card-->
			<div class="card">
				<!--begin::Card header-->
				<div class="card-header justify-content-start gap-6 p-6">
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
				</div>
				<!--end::Card header-->

				<!--begin::Card body-->
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_user" class="table align-middle table-row-dashed fs-6 gy-5">
							<thead>
							<tr class="text-start text-gray-700 fw-bold fs-7 text-uppercase gs-0">
								<th>Cabang</th>
								<th>Jabatan</th>
								<th>NIK</th>
								<th>Nama</th>
								<th>Username</th>
								<th>Role</th>
								<th class="text-center min-w-75px">Status</th>
								<th>Login Terakhir</th>
								<th class="text-center min-w-150px">Actions</th>
							</tr>
							</thead>
							<tbody class="text-gray-700">
							</tbody>
						</table>
					</div>
					<!--end::Table-->
				</div>
				<!--end::Card body-->
			</div>
			<!--end::Card-->
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>


<!--start::MODALS-->
<!-- start::modal_tambah_user -->
<div class="modal fade" id="modal_tambah_user" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-900px">
		<div class="modal-content">
			<div class="modal-header p-5">
				<h3 class="text-gray-700"><span class="judul-modal"></span></h3>
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<!-- start::modal-body -->
			<div class="modal-body">
				<div class="row"> <!-- row-->
				<!-- <div class="d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper"> -->
					<!-- <div class="flex-row-fluid w-100 w-md-50 me-md-10"> -->
					<div class="col-md-6">
						<div class="mb-2">
							<div class="stepper-label ">
								<h5 class="stepper-title text-gray-700">Detail User</h5>
							</div>
						</div>
						<div class="col">
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Cabang</label>
								<select class="form-select form-select-sm" name="user_opt_cabang" id="user_opt_cabang">
									<option value=""></option>
								</select>
							</div>
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">NIK</label>
								<div class="input-group input-group-sm mb-5">
									<input type="text" class="form-control form-control-sm" id="user_nik" readonly/>
									<button class="input-group-text btn-cari-pegawai"><i class="fa fa-search"></i></button>
								</div>
							</div>
							<div class="fv-row mb-5">
								<label class="fs-6 mb-1">Jabatan</label>
								<input type="text" class="form-control form-control-sm form-control-solid" placeholder="Jabatan" name="user_jabatan" id="user_jabatan" readonly/>
							</div>
							<div class="fv-row mb-5">
								<label class="fs-6 mb-1">Nama Lengkap</label>
								<input type="text" class="form-control form-control-sm form-control-solid" placeholder="Nama Lengkap" name="user_nama_lengkap" id="user_nama_lengkap" readonly/>
							</div>
							<div class="fv-row mb-5">
								<label class="fs-6 mb-1">Username</label>
								<input type="text" class="form-control form-control-sm form-control-solid" placeholder="Username" name="user_name" id="user_name" readonly/>
							</div>
							<!-- <div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Level</label>
								<select class="form-select form-select-sm" name="user_opt_level" id="user_opt_level">
									<option value=""></option>
								</select>
							</div> -->
							<div class="fv-row mb-5">
								<label class="required fs-6 mb-1">Role</label>
								<select class="form-select form-select-sm" name="user_opt_role" id="user_opt_role" required>
									<option value=""></option>
								</select>
							</div>
						</div>
					</div>
					<!-- <div class="flex-row-fluid mt-5 mt-md-0"> -->
					<div class="col-md-6 mt-10 mt-md-0">
						<div class="mb-6 mb-5">
							<div class="stepper-label ">
								<h5 class="stepper-title text-gray-700">Coverage 
									<span class="stepper-title text-gray-700 float-end">
									<label class="form-check form-switch form-check-custom form-check-solid">
										<input class="form-check-input h-20px w-30px sw-all" type="checkbox" />
									</label>
									</span>
								</h5>
							</div>
						</div>
						<div class="col">
							<div class="table-responsive table-coveragxe" id="xid-table-coverage">
								<table id="table_coverage" class="table table-striped table-row-bordered gy-5 gs-7">
									<thead class="">
										<th class="w-100 hidden h-1px p-0"></th>
										<th class="hidden h-1px p-0"></th>
									</thead>
								</table> 
							</div>
							<!-- <div class="table-responsive table-coveragxe-edit" id="xid-table-coverage-edit">
								<table id="table_coverage_edit" class="table table-striped table-row-bordered gs-7">
									<thead class="hidden h-0">
										<th class="w-100"></th>
										<th></th>
									</thead>
								</table> 
							</div>	 -->
						</div>
					</div>
				</div>
			</div>
			<!-- end::modal-body -->
			<!--begin::Modal footer-->
			<div class="modal-footer flex-end">
				<button type="button" id="btn-simpan" class="btn btn-sm btn-primary btn-c">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Menyimpan... 
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_tambah_user -->

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
<!-- end::modal_tambah_user -->
<!--end::MODALS-->

