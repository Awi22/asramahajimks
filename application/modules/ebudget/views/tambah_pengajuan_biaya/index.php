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
				<!-- <a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" id="btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_coa">Tambah</a> -->
				<button type="button" id="btn-tambah" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_tambah_coa">
					<span class="indicator-label">Tambah</span>
				</button>
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
					<div class="mb-2 col-sm-3">
						<label class="required fs-6 mb-1">Cabang</label>
						<select class="form-select form-select-sm" name="opt_cabang" id="opt_cabang">
							<option value=""></option>
						</select>
					</div>
					<div class="mb-2 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">No PO</label>
						<input class="form-control form-control-sm form-control form-control-solid border" placeholder="No PO" name="no_po" id="no_po" readonly/>
					</div>
					<div class="mb-2 col-sm-3">
						<label class="form-label fw-bold fs-6 text-gray-700">Tgl PO</label>
						<!-- <input type="text" class="form-control form-control-sm" placeholder="Tgl PO" name="tgl_po" id="tgl_po" readonly/> -->
						<div class="input-group input-group-sm" >
							<input id="tgl_po" class="form-control form-control-sm form-control-solid border" readonly/>
							<span class="input-group-text border">
								<i class="ki-duotone ki-calendar fs-2"><span class="path1"></span><span class="path2"></span></i>
							</span>
						</div>
					</div>
					
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
					<div class="row d-flex flex-end">
						<div class="input-group input-group-sm w-200px">
							<span class="p-2 fw-bold fs-7 text-gray-600 me-2 text-uppercase">Total</span>
							<input class="text-gray-600 text-end fw-bold form-control form-control-sm form-control form-control-solid border" placeholder="Total Budget" name="total_budget" id="total_budget" readonly/>
						</div>
					</div>
				</div>
				<div class="card-footer d-flex flex-end p-6">
					<button type="button" id="btn-simpan-po" class="btn btn-sm btn-primary">
						<span class="indicator-label">Generate PO</span>
						<span class="indicator-progress">Generate PO...
							<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
					</button>
				</div>
			</div>
			<!--end::Card-->
		</div>
	</div>
	<!--end::Content-->
</div>


<!--start::MODALS-->
<!-- start::modal_tambah_coa -->
<div class="modal fade" id="modal_tambah_coa" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
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
					<div class="col">
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Diajukan Oleh</label>
							<input type="text" class="form-control form-control-sm form-control" placeholder="Diajukan Oleh" name="diajukan_oleh" id="diajukan_oleh"/>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Coa Budget</label>
							<select class="form-select form-select-sm" name="opt_coa_budget" id="opt_coa_budget" data-control="select2" data-placeholder="-- PILIH COA BUDGET --">
								<option value=""></option>
							</select>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Sisa Budget Bulan Berjalan</label>
							<div class="input-group input-group-sm">
								<span class="input-group-text">Rp</span>
								<input type="numeric" class="form-control form-control-sm border-1 text-end" name="sisa_budget_bulan" id="sisa_budget_bulan" readonly/>
							</div>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Sisa Budget Tahun Berjalan</label>
							<div class="input-group input-group-sm">
								<span class="input-group-text">Rp</span>
								<input type="numeric" class="form-control form-control-sm text-end" placeholder="Sisa budget tahun berjalan" name="sisa_budget_tahun" id="sisa_budget_tahun" readonly/>
							</div>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Qty</label>
							<input type="number" min="0" class="form-control form-control-sm text-end" placeholder="Qty" name="qty" id="qty" oninput="hitung_pengajuan();"/>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Pengajuan</label>
							<div class="input-group input-group-sm">
								<span class="input-group-text">Rp</span>
								<input type="text" class="form-control form-control-sm text-end" placeholder="Pengajuan" name="pengajuan" id="pengajuan" oninput="hitung_pengajuan();"/>
							</div>
						</div>
						<div class="fv-row mb-5">
							<label class="required fs-6 mb-1">Total</label>
							<div class="input-group input-group-sm">
								<span class="input-group-text">Rp</span>
								<input type="text" class="form-control form-control-sm text-end" placeholder="Total" name="total" value="0" id="total" readonly/>
							</div>
						</div>
						<div class="fv-row mb-5">
							<label class="fs-6 mb-1">Keterangan</label>
							<textarea class="form-control form-control-sm form-control resize-none" placeholder="Keterangan" name="keterangan" id="keterangan" rows="2"></textarea>
						</div>
					</div>
				</div>
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
<!--end::MODALS-->

