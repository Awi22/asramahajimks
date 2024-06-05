<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3">
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<!--begin::Page title-->
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?=$judul?></h1>
			</div>
			<!--end::Page title-->
			<!--begin::Actions-->
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<!-- <a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_coa">Tambah</a> -->
			</div>
			<!--end::Actions-->
		</div>
	</div>
	<!--end::Toolbar-->

	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<div id="kt_app_content_container" class="app-container container-fluid">
			<!--begin::Card-->
			<div class="card">
				<div class="card-header justify-content-start gap-6 p-6">
					<div class="mb-2 col-12 col-sm-3">
						<label class="fs-6 mb-1">Cabang</label>
						<select class="form-select form-select-sm" name="opt-cabang" id="opt-cabang">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-12 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">Status</label>
						<select name="opt-status" id="opt-status" class="form-select form-select-sm" data-placeholder="-- SEMUA STATUS --">
							<option value=""></option>
						</select>
					</div>
					<!-- <div class="mb-2 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">No PO</label>
						<input class="form-control form-control-sm form-control form-control-solid border" placeholder="No PO" name="no_po" id="no_po" readonly/>
					</div>
					<div class="mb-2 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">Tgl PO</label>
						<div class="input-group input-group-sm" >
							<input id="tgl_po" class="form-control form-control-sm form-control-solid border" readonly/>
							<span class="input-group-text border">
								<i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
							</span>
						</div>
					</div> -->
				</div>
				<div class="card-body p-6">
					<div class="table-responsive">
						<table id="table_pengajuan_biaya" class="table align-middle table-row-dashed fs-6 gy-5">
							<thead class="text-center text-gray-700 fw-bold fs-7 text-uppercase gs-0">
							</thead>
							<tbody class="text-gray-700 gy-9">
							</tbody>
						</table>
					</div>
				</div>
				<div class="card-footer d-flex flex-end p-6">
					<!-- <button type="button" id="btn-simpan-po" class="btn btn-sm btn-primary">
						<span class="indicator-label">Simpan</span>
						<span class="indicator-progress">Menyimpan...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
					</button> -->
				</div>
			</div>
			<!--end::Card-->
		</div>
	</div>
</div>



<!--start::MODALS-->
<!-- start::modal_detail -->
<div class="modal fade" id="modal_detail" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-top mw-1000px">
		<div class="modal-content">
			<div class="modal-header p-5">
				<h3 class="text-gray-700"><span class="judul-modal"></span></h3>
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table id="table_pengajuan_biaya_detail" class="table align-middle table-row-dashed fs-6 gy-5">
						<thead class="text-center text-gray-700 fw-bold fs-7 text-uppercase gs-0">
						</thead>
						<tbody class="text-gray-700 gy-9">
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer flex-center">
			</div>
		</div>
	</div>
</div>
<!-- end::modal_detail -->
<!--end::MODALS-->


