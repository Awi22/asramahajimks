<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3">
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
			</div>
			<div class="d-flex align-items-center gap-2 gap-lg-3">
			</div>
		</div>
	</div>
	<!--end::Toolbar-->


	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<div id="kt_app_content_container" class="app-container container-fluid">
			<div class="d-flex flex-column">
				<div class="flex-column flex-column-auto w-100 mb-10">
					<div class="card mb-5 mb-xl-8">
						<div class="card-body p-5">
							<div class="d-flex align-items-center justify-content-center w-100 mb-10" style="min-height:60vh">
								<img class="w-100" src="<?= base_url($background) ?>" class="mw-100 mh-300px theme-light-show" alt="" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Content-->
</div>