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
									<a class="nav-link text-active-primary py-5 me-6 active" href="<?=base_url('wuling_adm_setting')?>">Settings</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-active-primary py-5 me-6" href="#">Another Setting</a>
								</li>
								<li class="nav-item">
									<a class="nav-link text-active-primary py-5 me-6" href="#">Etc</a>
								</li>
							</ul>
						</div>

						
						
						<div class="card-body p-5">
							<div class="row">
								<!-- <div class="card card-flush h-lg-100"> -->
								<div class="card card-flush col-md-6 border-0">
									<div class="card-header mt-0">
										<div class="card-title flex-column">
											<!-- <h3 class="fw-bold mb-1">Wallpaper Dashboard</h3> -->
											<div class="fs-6 fw-semibold text-gray-500">Wallpaper Dashboard</div>
										</div>
									</div>
									<div class="card-body p-2">
										<div class="d-flex flex-wrap">
											<div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
												<div class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
													<!-- <span class="fs-2qx fw-bold">237</span> -->
													<!-- <span class="fs-6 fw-semibold text-gray-500">Total Tasks</span> -->
													<!--begin::Image input placeholder-->
													<style>
														.image-input-placeholder {
															background-image: url('svg/avatars/blank.svg');
														}

														[data-bs-theme="dark"] .image-input-placeholder {
															background-image: url('svg/avatars/blank-dark.svg');
														}
													</style>
													<!--end::Image input placeholder-->

													<!--begin::Image input-->
													<div id="images" class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(<?=base_url('public/assets/media/svg/avatars/blank.svg')?>)">
														<!--begin::Image preview wrapper-->
														<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?=base_url('public/assets/media/avatars/300-1.jpg')?>)"></div>
														<!--end::Image preview wrapper-->

														<!--begin::Edit button-->
														<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="change"
														data-bs-toggle="tooltip"
														data-bs-dismiss="click"
														title="Ganti Wallpaper">
															<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

															<!--begin::Inputs-->
															<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
															<input type="hidden" name="avatar_remove" />
															<!--end::Inputs-->
														</label>
														<!--end::Edit button-->

														<!--begin::Cancel button-->
														<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="cancel"
														data-bs-toggle="tooltip"
														data-bs-dismiss="click"
														title="Cancel avatar">
															<i class="ki-outline ki-cross fs-3"></i>
														</span>
														<!--end::Cancel button-->

														<!--begin::Remove button-->
														<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="remove"
														data-bs-toggle="tooltip"
														data-bs-dismiss="click"
														title="Remove avatar">
															<i class="ki-outline ki-cross fs-3"></i>
														</span>
														<!--end::Remove button-->
													</div>
													<!--end::Image input-->
												</div>
												<canvas id="project_overview_chart" width="175" height="175" style="display: block; box-sizing: border-box; height: 175px; width: 175px;"></canvas>
											</div>
											
											
											<!-- <div id="btn" class="btn btn-primary" style="opacity:0.2;cursor:default">Select image...</div> -->
											<!-- <div id="loading" style="font-size:12px">Loading file manager...</div> -->

										 


											<div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
												<!--begin::Form-->
												<form class="form" action="#" method="post">
													<!--begin::Input group-->
													<div class="form-group row">
														<!--begin::Label-->
														<!-- <label class="col-lg-2 col-form-label text-lg-right">Upload Files:</label> -->
														<!--end::Label-->

														<!--begin::Col-->
														<div class="col-lg-10">
															<!--begin::Dropzone-->
															<div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_2">
																<!--begin::Controls-->
																<div class="dropzone-panel mb-lg-0 mb-2">
																<div id="btn" class="btn btn-sm btn-primary">Select image...</div>
																<div id="loading" class="fs-8" >Loading file manager...</div>
																	<!-- <a class="dropzone-select btn btn-sm btn-primary me-2">Attach filsses</a> -->
																	<!-- <a class="dropzone-upload btn btn-sm btn-light-primary me-2">Upload All</a> -->
																	<!-- <a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a> -->
																</div>
																<!--end::Controls-->

																<!--begin::Items-->
																<div class="dropzone-items wm-200px">
																	<div class="dropzone-item" style="display:none">
																		<!--begin::File-->
																		<div class="dropzone-file">
																			<div class="dropzone-filename" title="some_image_file_name.jpg">
																				<span data-dz-name>some_image_file_name.jpg</span>
																				<strong>(<span data-dz-size>340kb</span>)</strong>
																			</div>

																			<div class="dropzone-error" data-dz-errormessage></div>
																		</div>
																		<!--end::File-->

																		<!--begin::Progress-->
																		<div class="dropzone-progress">
																			<div class="progress">
																				<div
																					class="progress-bar bg-primary"
																					role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
																				</div>
																			</div>
																		</div>
																		<!--end::Progress-->

																		<!--begin::Toolbar-->
																		<div class="dropzone-toolbar">
																			<span class="dropzone-start"><i class="bi bi-play-fill fs-3"></i></span>
																			<span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="bi bi-x fs-3"></i></span>
																			<span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
																		</div>
																		<!--end::Toolbar-->
																	</div>
																</div>
																<!--end::Items-->
															</div>
															<!--end::Dropzone-->

															<!--begin::Hint-->
															<span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
															<!--end::Hint-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Labels-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Card body-->
								</div>
								<div class="card card-flush col-md-6 border-0">
									<div class="card-header mt-0">
										<div class="card-title flex-column">
											<!-- <h3 class="fw-bold mb-1">Wallpaper Dashboard</h3> -->
											<div class="fs-6 fw-semibold text-gray-500">Wallpaper Dashboard</div>
										</div>
									</div>
									<div class="card-body p-2">
										<div class="d-flex flex-wrap">
											<div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
												<div class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
													<!-- <span class="fs-2qx fw-bold">237</span> -->
													<!-- <span class="fs-6 fw-semibold text-gray-500">Total Tasks</span> -->
													<!--begin::Image input placeholder-->
													<style>
														.image-input-placeholder {
															background-image: url('svg/avatars/blank.svg');
														}

														[data-bs-theme="dark"] .image-input-placeholder {
															background-image: url('svg/avatars/blank-dark.svg');
														}
													</style>
													<!--end::Image input placeholder-->

													<!--begin::Image input-->
													<div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url(<?=base_url('public/assets/media/svg/avatars/blank.svg')?>)">
														<!--begin::Image preview wrapper-->
														<div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?=base_url('public/assets/media/avatars/300-1.jpg')?>)"></div>
														<!--end::Image preview wrapper-->

														<!--begin::Edit button-->
														<label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="change"
														data-bs-toggle="tooltip"
														data-bs-dismiss="click"
														title="Ganti Wallpaper">
															<i class="ki-duotone ki-pencil fs-6"><span class="path1"></span><span class="path2"></span></i>

															<!--begin::Inputs-->
															<input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
															<input type="hidden" name="avatar_remove" />
															<!--end::Inputs-->
														</label>
														<!--end::Edit button-->

														<!--begin::Cancel button-->
														<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="cancel"
														data-bs-toggle="tooltip"
														data-bs-dismiss="click"
														title="Cancel avatar">
															<i class="ki-outline ki-cross fs-3"></i>
														</span>
														<!--end::Cancel button-->

														<!--begin::Remove button-->
														<span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
														data-kt-image-input-action="remove"
														data-bs-toggle="tooltip"
														data-bs-dismiss="click"
														title="Remove avatar">
															<i class="ki-outline ki-cross fs-3"></i>
														</span>
														<!--end::Remove button-->
													</div>
													<!--end::Image input-->
												</div>
												<canvas id="project_overview_chart" width="175" height="175" style="display: block; box-sizing: border-box; height: 175px; width: 175px;"></canvas>
											</div>
											<!--end::Chart-->
											<!--begin::Labels-->
											<div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
												<!--begin::Form-->
												<form class="form" action="#" method="post">
													<!--begin::Input group-->
													<div class="form-group row">
														<!--begin::Label-->
														<!-- <label class="col-lg-2 col-form-label text-lg-right">Upload Files:</label> -->
														<!--end::Label-->

														<!--begin::Col-->
														<div class="col-lg-10">
															<!--begin::Dropzone-->
															<div class="dropzone dropzone-queue mb-2" id="kt_dropzonejs_example_2">
																<!--begin::Controls-->
																<div class="dropzone-panel mb-lg-0 mb-2">
																	<a class="dropzone-select btn btn-sm btn-primary me-2">Attach files</a>
																	<a class="dropzone-upload btn btn-sm btn-light-primary me-2">Upload All</a>
																	<a class="dropzone-remove-all btn btn-sm btn-light-primary">Remove All</a>
																</div>
																<!--end::Controls-->

																<!--begin::Items-->
																<div class="dropzone-items wm-200px">
																	<div class="dropzone-item" style="display:none">
																		<!--begin::File-->
																		<div class="dropzone-file">
																			<div class="dropzone-filename" title="some_image_file_name.jpg">
																				<span data-dz-name>some_image_file_name.jpg</span>
																				<strong>(<span data-dz-size>340kb</span>)</strong>
																			</div>

																			<div class="dropzone-error" data-dz-errormessage></div>
																		</div>
																		<!--end::File-->

																		<!--begin::Progress-->
																		<div class="dropzone-progress">
																			<div class="progress">
																				<div
																					class="progress-bar bg-primary"
																					role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
																				</div>
																			</div>
																		</div>
																		<!--end::Progress-->

																		<!--begin::Toolbar-->
																		<div class="dropzone-toolbar">
																			<span class="dropzone-start"><i class="bi bi-play-fill fs-3"></i></span>
																			<span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="bi bi-x fs-3"></i></span>
																			<span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
																		</div>
																		<!--end::Toolbar-->
																	</div>
																</div>
																<!--end::Items-->
															</div>
															<!--end::Dropzone-->

															<!--begin::Hint-->
															<span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
															<!--end::Hint-->
														</div>
														<!--end::Col-->
													</div>
													<!--end::Input group-->
												</form>
												<!--end::Form-->
											</div>
											<!--end::Labels-->
										</div>
										<!--end::Wrapper-->
									</div>
									<!--end::Card body-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Content-->
</div>
