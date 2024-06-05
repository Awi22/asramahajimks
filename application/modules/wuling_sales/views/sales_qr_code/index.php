<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3">
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?=$judul?></h1>
			</div>
			<!-- <div class="d-flex align-items-center gap-2 gap-lg-3">
				<a href="#" class="btn btn-sm fw-bold btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modal_tambah_user">Tambah</a>
			</div> -->
		</div>
	</div>
	<!--end::Toolbar-->


	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container zzcontainer-fluid container-xxl">
			<div class="row gy-5 g-xl-10">
				<div class="col-md-8 mb-md-10 order-2 order-md-1">
					<div class="card mb-4 h-md-100">
						<div class="card-header flex-nowrap px-6 py-6 min-h-10px">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label fw-bold text-gray-900">Detail Sales</span>
							</h3>
						</div>
						<div class="card-body mt-6 xp-6">
							<!-- <div id="kt_charts_widget_5" class="min-h-auto"></div> -->
							<div class="row mb-7">
								<label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
								<div class="col-lg-8">
									<span class="fw-bold fs-6 text-gray-800 txt-nama-lengkap">Loading...</span>
								</div>
							</div>
							<div class="row mb-7">
								<label class="col-lg-4 fw-semibold text-muted">Cabang</label>
								<div class="col-lg-8 fv-row">
									<span class="fw-semibold text-gray-800 fs-6 txt-cabang">Loading...</span>
								</div>
							</div>
							<div class="row mb-7">
								<label class="col-lg-4 fw-semibold text-muted">No HP 
								</label>
								<div class="col-lg-8 d-flex align-items-center">
									<span class="fw-bold fs-6 text-gray-800 me-2 txt-handphone">Loading...</span>
								</div>
							</div>
							<div class="row mb-7">
								<label class="col-lg-4 fw-semibold text-muted">Jabatan</label>
								<div class="col-lg-8">
									<a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary txt-jabatan">Loading...</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4 mb-5 mb-md-10 order-1 order-md-2">
					<div class="card h-md-100" dir="ltr">
						<div class="card-body d-flex flex-column flex-center">
							<div class="mb-2">
								<div class="p-0 text-center">
									<img src="" class="theme-light-show w-325px img-qr-code" alt="" />
								</div>
							</div>
							<div class="text-center mb-1">
								<a class="btn btn-sm btn-primary me-2 btn-copy">Copy</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>

