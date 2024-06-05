<?
//kondisi untuk background
if (empty($background_home)) {
	$background_home = $background_home_default;
}
if (empty($background_login)) {
	$background_login = $background_login_default;
}
?>
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
			<div class="d-flex flex-column flex-xl-row">
				<div class="flex-column flex-lg-row-auto w-100  mb-10">
					<div class="card mb-5 mb-xl-8">
						<div class="card-title border p-5">
							<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
								<li class="nav-item">
									<a class="nav-link text-active-primary py-5 me-6 active" href="<?= base_url('wuling_adm_setting') ?>">Background Images</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-active-primary py-5 me-6" href="#">Another Setting</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-active-primary py-5 me-6" href="#">Etc</a>
								</li>
							</ul>
						</div>
						<div class="card-body p-10 pt-5">

							<form action="<?= base_url('wuling_adm_setting/upload_background') ?>" id="formUpload" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
									<div class="col-sm-6 col-xxl-3">
										<div class="card card-flush h-xl-100">
											<div class="card-body text-center pb-5">
												<style>
													.image-input-placeholder {
														background-image: url('<?= base_url("public/assets/media/svg/avatars/blank.svg") ?>');
													}

													[data-bs-theme="dark"] .image-input-placeholder {
														background-image: url('<?= base_url("public/assets/media/svg/avatars/blank-dark.svg") ?>');
													}
												</style>

												<div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url(<?= base_url($background_login) ?>)">
													<div class="image-input-wrapper w-200px h-200px h-md-250px w-md-250px" style="background-image: url(<?= base_url($background_login) ?>)"></div>
													<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Ganti Login Background">
														<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
														<input type="file" name="background_file[]" accept=".png, .jpg, .jpeg, .webp" />
														<input type="hidden" name="avatar_remove" />
													</label>
													<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
														<i class="ki-outline ki-cross fs-3"></i>
													</span>
													<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
														<i class="ki-outline ki-cross fs-3"></i>
													</span>
												</div>
												<div class="d-flex align-items-end flex-stack mt-2">
													<div class="text-start">
														<span class="fw-bold text-gray-700 fs-6 d-block">Login Background</span>
													</div>
												</div>
											</div>
											<div class="card-footer d-flex flex-end p-4">
												<button type="submit" class="btn btn-sm btn-light-primary">Apply</button>
											</div>
										</div>
									</div>

									<div class="col-sm-6 col-xxl-3">
										<div class="card card-flush h-xl-100">

											<div class="card-body text-center pb-5">
												<style>
													.image-input-placeholder {
														background-image: url('<?= base_url("public/assets/media/svg/avatars/blank.svg") ?>');
													}

													[data-bs-theme="dark"] .image-input-placeholder {
														background-image: url('<?= base_url("public/assets/media/svg/avatars/blank-dark.svg") ?>');
													}
												</style>

												<div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url(<?= base_url($background_home) ?>)">
													<div class="image-input-wrapper w-200px h-200px h-md-250px w-md-250px" style="background-image: url(<?= base_url($background_home) ?>)"></div>
													<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Ganti Home Background">
														<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>
														<input type="file" name="background_file[]" accept=".png, .jpg, .jpeg, .webp" />
														<input type="hidden" name="avatar_remove" />
													</label>
													<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel Background">
														<i class="ki-outline ki-cross fs-3"></i>
													</span>
												</div>
												<div class="d-flex align-items-end flex-stack mt-2">
													<div class="text-start">
														<span class="fw-bold text-gray-700 fs-6 d-block">Home Background</span>
													</div>
												</div>
											</div>
											<div class="card-footer d-flex flex-end p-4">
												<button type="submit" class="btn btn-sm btn-light-primary">Apply</button>
											</div>
										</div>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Content-->
</div>
