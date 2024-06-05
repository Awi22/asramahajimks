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
								<th>Biaya Tahun Lalu</th>
								<th>Aksi</th>
							</tr>
							</thead>
							<tbody class="text-gray-700">
							</tbody>
							<tfoot class="text-gray-700 fw-bold">
								<tr>
									<th colspan="8" style="text-align:right"></th>
									<th></th>
								</tr>
							</tfoot>
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
				<div class="row"> <!-- row-->
				<!-- <div class="d-flex flex-column flex-xl-row flex-row-fluid" id="kt_modal_create_app_stepper"> -->
					<!-- <div class="flex-row-fluid w-100 w-md-50 me-md-10"> -->
					<div class="col-md-6">
						<div class="col">
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
					</div>

					<div class="col-md-6">
					<div class="fv-row mb-5">
 								<label class="fs-6 mb-1">Bulan</label>

								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-right">Januari</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="januari" id="januari">
									</div>
								</div>

								<div class=" form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-center">Februari</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="februari" id="februari">
									</div>
								</div>

								
								<div class=" form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-center">Maret</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="maret" id="maret">
									</div>
								</div>

								
								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-center">April</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="april" id= "april">
									</div>
								</div>
								
								<div class=" form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-center">Mei</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="mei" id="mei">
									</div>
								</div>
								
								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-center">Juni</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="juni" id="juni">
									</div>
								</div>
								
								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-center">Juli</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="juli" id="juli">
									</div>
								</div>

								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-right">Agustus</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="agustus" id="agustus">
									</div>
								</div>

								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-right">September</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="september" id="september">
									</div>
								</div>

								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-right">Oktober</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="oktober" id="oktober">
									</div>
								</div>

								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-right">November</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="november" id="november">
									</div>
								</div>

								<div class="form-months row mb-3">
									<div class="col-3">
									<span class="input-group-text d-block text-right">Desember</span>
									</div>
									<div class="col-9">
									<input type="text" class="form-control inputan_bulan" placeholder="" name="desember" id="desember">
									</div>
								</div>
							</div>

					</div>


				
				</div>
			</div>
			<!-- end::modal-body -->
			<!--begin::Modal footer-->
			<div class="modal-footer flex-center">
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

