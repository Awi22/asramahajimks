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
			<!-- <div class="d-flex align-items-center gap-2 gap-lg-3">
				<a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_coa">Tambah</a>
			</div> -->
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
						<select name="opt_cabang_datatable" id="opt_cabang_datatable" class="form-select form-select-sm">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-12 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">Tahun</label>
						<select name="opt_tahun_datatable" id="opt_tahun_datatable" class="form-select form-select-sm">
							<option value=""></option>
						</select>
					</div>
					<div class="mt-8">
						<!-- <button type="button" id="btn-ekspor" class="btn btn-sm btn-success">
							Eksport Excel
						</button> -->
					</div>
				</div>
				<!--end::Card header-->

				<!--begin::Card body-->
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_planning_budget" class="table align-middle table-row-dashed fs-6 gy-5">
							<thead>
							<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
								<th>No</th>
								<th>Cabang</th>
								<th>Tahun</th>
								<th>Kategori</th>
								<th>Sub Kategori</th>
								<th>Coa Budget</th>
								<th>Nama Planning</th>
								<th>Biaya</th>
								<th>Status Approve</th>
								<th>Aksi</th>
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
<!-- start::modal_tambah_coa -->
<div class="modal fade" id="modal_tambah_coa" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-1000px">
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
					<div class="col-md-6">
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Cabang</label>
							<select class="form-select form-select-sm" name="opt_cabang_modal" id="opt_cabang_modal">
								<option value=""></option>
							</select>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Kategori Planning</label>
							<select class="form-select form-select-sm" name="kategori_plan" id="kategori_plan">
								<option value=""></option>
							</select>
						</div>

						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Sub Kategori Planning</label>
							<select class="form-select form-select-sm" name="sub_kategori_plan" id="sub_kategori_plan">
								<option value=""></option>
							</select>
						</div>

						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Coa Budget</label>
							<select class="form-select form-select-sm" name="coa_budget" id="coa_budget">
								<option value=""></option>
							</select>
						</div>
						
						<div class="fv-row mb-5">
							<label class="fs-6 mb-1">Nama Planning</label>
							<input type="text" class="form-control form-control-sm form-control" placeholder="Nama Planning" name="nama_planning" id="nama_planning"/>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Tahun</label>
							<select class="form-select form-select-sm" name="opt_tahun_modal" id="opt_tahun_modal" required>
								<option value=""></option>
							</select>
						</div>
						<div class="fv-row mb-5">
							<label class="fs-6 mb-1">Set Biaya</label>
							
							<div class="form-check mt-2 mb-5 mx-12">
								<input class="form-check-input" type="radio" name="set_biaya" id="manual_perbulan" value="manual_perbulan" checked>
								<label class="form-check-label" for="biaya_manual">
									Manual Per Bulan
								</label>
							</div>
							
							<div class="form-check mb-5 mx-12">
								<input class="form-check-input" type="radio" name="set_biaya" id="average_pertahun" value="average_pertahun">
								<label class="form-check-label" for="biaya_otomatis">
									Average Manual per Tahun
								</label>
							</div>

							<div class="form-check mb-5 mx-12">
								<input class="form-check-input" type="radio" name="set_biaya" id="average_tahunlalu" value="average_tahunlalu">
								<label class="form-check-label" for="biaya_otomatis">
									Average Biaya per Tahun Lalu
								</label>
							</div>
						</div>
						<div class="fv-row mb-5">
							<label class="fs-6 mb-1">Jumlah Biaya</label>
							<input type="text" class="form-control form-control-sm form-control" placeholder="Jumlah Biaya" name="jumlah_biaya" id="jumlah_biaya" />
						</div>
					</div>

					<div class="col-md-6">
						<div class="fv-row mb-5">
							<div class="row mb-3">
								<div class="col-3">
									<label class="fs-6 mb-1">Bulan</label>
								</div>
								<div class="col-4">
									<label class="fs-6 mb-1">Average Tahun Lalu</label>
								</div>
								<div class="col-4">
									<label class="fs-6 mb-1">Nilai Budget</label>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Januari</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="januari">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-januari">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Februari</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="februari">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-februari">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Maret</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="maret">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-maret">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">April</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="april">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-april">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Mei</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="mei">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-mei">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Juni</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="juni">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-juni">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Juli</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="juli">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-juli">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Agustus</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="agustus">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-agustus">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">September</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="september">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-september">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Oktober</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="oktober">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-oktober">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">November</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="november">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-november">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-3">
									<span class="input-group-text h-35px">Desember</span>
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm form-months disabled_inputan_bulan" name="desember">
								</div>
								<div class="col-4">
									<input type="text" class="form-control form-control-sm inputan_bulan" name="input-desember">
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- end::modal-body -->
			<!--begin::Modal footer-->
			<div class="modal-footer flex-end">
				<button type="button" id="btn-update" class="btn btn-sm btn-primary">
					<span class="indicator-label">Update</span>
					<span class="indicator-progress">Mengupdate... 
					<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_tambah_coa -->

<!--end::MODALS-->

