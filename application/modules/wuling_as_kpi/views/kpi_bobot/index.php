<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3">
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
			</div>
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_kategori">Tambah</a>
				<!-- <button href="#" type="button" name="btn-tambah" id="btn-tambah" class="btn btn-sm fw-bold btn-primary" >Tambah Kategori</button> -->
			</div>
		</div>
	</div>
	<!--end::Toolbar-->


	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<div id="kt_app_content_container" class="app-container container-fluid">
			<div class="d-flex flex-column">
				<div class="flex-column flex-column-auto w-100 mb-10 w-1 ">
					<div class="card mb-5 mb-xl-8">
						<div class="card-header justify-content-start gap-6 p-6">
							<div class="mb-2 col-12 col-sm-3">
								<label class="form-label fw-bold fs-6 text-gray-700">Kategori</label>
								<select name="opt_kategori" id="opt_kategori" class="form-select form-select-sm" data-placeholder="-- SEMUA KATEGORI --">
									<option value=""></option>
								</select>
							</div>
						</div>
						<!--end::Card header-->
						<div class="card-body p-5">
							<div class="table-responsive">
								<table id="table_kategori" class="table align-middle table-row-dashed table-bordered fs-6">
									<thead class="text-start text-gray-700 fw-bold fs-7 text-uppercase bg-light-secondary">
									</thead>
									<tbody class="text-gray-700">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Content-->
</div>


<!--start::MODALS-->
<!-- start::modal_tambah_kategori -->
<div class="modal fade" id="modal_tambah_kategori" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header px-5 py-5">
				<h5 class="text-gray-700 m-0"><span class="judul-modal"></span></h5>
				<div class="btn btn-sm btn-icon btn-active-color-primary fs-10" data-bs-dismiss="modal">
					<i class="bi bi-x fs-1"></i>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col">
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="modal_opt_kategori">Kategori</label>
							<div class=" mb-2 col-md-8">
								<select name="modal_opt_kategori" id="modal_opt_kategori" class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="-- PILIH KATEGORI --">
									<option value=""></option>
								</select>
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="modal_nama_kategori">Nama Kategori</label>
							<div class=" mb-2 col-md-8">
								<input type="text" class="form-control form-control-sm" name="modal_nama_kategori" id="modal_nama_kategori" />
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="modal_bobot_dua">Bobot 2</label>
							<div class=" mb-2 col-md-8">
								<input type="number" min=0 value=0 class="form-control form-control-sm" name="modal_bobot_dua" id="modal_bobot_dua" />
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="modal_bobot_tiga">Bobot 3</label>
							<div class=" mb-2 col-md-8">
								<input type="number" min=0 value=0 class="form-control form-control-sm" name="modal_bobot_tiga" id="modal_bobot_tiga" />
							</div>
						</div>
						<div class="fv-row mb-2 form-group row">
							<label class="required fs-6 mb-2 col-md-4" for="modal_bobot_empat">Bobot 4</label>
							<div class=" mb-2 col-md-8">
								<input type="number" min=0 value=0 class="form-control form-control-sm" name="modal_bobot_empat" id="modal_bobot_empat" />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer flex-end m-0 p-0 px-5 py-5">
				<button  id="btn-simpan-kategori" class="btn btn-sm btn-primary">
					<span class="indicator-label">Simpan</span>
					<span class="indicator-progress">Menyimpan...
						<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
					</span>
				</button>
			</div>
		</div>
	</div>
</div>
<!-- end::modal_tambah_kategori -->
