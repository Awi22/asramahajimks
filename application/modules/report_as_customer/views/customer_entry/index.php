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
					<div class="row w-100">

					
					<div class="mb-2 col-md-2">
						<label class="form-label fw-bold fs-6 text-gray-700">Cabang</label>
						<select name="opt_cabang" id="opt_cabang" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- SEMUA --" data-allow-clear="true">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-md-2">
						<label class="form-label fw-bold fs-6 text-gray-700">Varian</label>
						<select name="opt_varian" id="opt_varian" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- SEMUA --" data-allow-clear="true">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-md-2">
						<label class="form-label fw-bold fs-6 text-gray-700">Agama</label>
						<select name="opt_agama" id="opt_agama" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- SEMUA --" data-allow-clear="true">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-md-2">
						<label class="form-label fw-bold fs-6 text-gray-700">Tahun Mobil</label>
						<input type="text" class="form-control form-control-sm" id="opt_tahun" placeholder="-- SEMUA --">
						<!-- <select name="opt_tahun" id="opt_tahun" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- SEMUA --" data-allow-clear="true">
							<option value=""></option>
						</select> -->
					</div>
					<div class="mb-2 col-md-2">
						<label class="form-label fw-bold fs-6 text-gray-700">Insert Time</label>
						<input type="text" class="form-control form-control-sm" id="opt_insert_time" placeholder="-- SEMUA --">
						<!-- <select name="opt_insert_time" id="opt_insert_time" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- SEMUA --" data-allow-clear="true">
							<option value=""></option>
						</select> -->
					</div>
					<div class="mb-2 col-md-2 mt-8">
						<!-- <a href="#" class="btn btn-icon btn-dark"><i class="las la-wallet fs-2 me-2"></i></a> -->

						<!-- <button type="button" id="btn-ekspor" class="btn btn-icon btn-dark">
							Export Excel
						</button> -->
						<button type="button" id="btn-lihat" class="btn btn-sm btn-icon btn-primary"><i class="las la-list fs-2"></i></button>
						<button type="button" id="btn-ekspor" class="btn btn-sm btn-icon btn-primary"><span class="las la-file-excel fs-2"></span></button>
					</div>
					</div>
				</div>
				<!--end::Card header-->

				<!--begin::Card body-->
				<div class="card-body">
					<div class="table-responsive">
						<table id="table_customer" class="table align-middle table-row-dashed fs-6 gy-5">
							<thead class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
							<!-- <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
								<th>No</th>
								<th>Cabang</th>
								<th>Tahun</th>
								<th>Kategori</th>
								<th>Sub Kategori</th>
								<th>Coa Budget</th>
								<th>Nama Planning</th>
								<th>Biaya</th>
							</tr> -->
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


