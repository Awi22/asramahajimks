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
			<!--begin::Card-->
			<div class="card">
				<!--begin::Card header-->
				<div class="card-header justify-content-center gap-6 p-6">
					<div class="mb-2 col-12 col-sm-3">
						<!-- <label class="form-label fw-bold fs-6 text-gray-700">Month</label> -->
						<select name="opt_month" id="opt_month" class="form-select form-select-sm">
							<option value=""></option>
							<!-- <option value="mtd">MTD</option>
							<option value="ytd">YTD</option> -->
						</select>
					</div>
					<div class="mb-2 col-12 col-sm-3">
						<!-- <label class="form-label fw-bold fs-6 text-gray-700">Range</label> -->
						<select name="opt_range" id="opt_range" class="form-select form-select-sm">
							<option value=""></option>
							<option value="mtd" selected>MTD</option>
							<option value="ytd">YTD</option>
						</select>
					</div>
				</div>
				<!--end::Card header-->

				<!--begin::Card body-->
				<div id="body-card-view-table" class="card-body">
					
				</div>
				<!--end::Card body-->
			</div>
			<!--end::Card-->
		</div>
		<!--end::Content-->
	</div>