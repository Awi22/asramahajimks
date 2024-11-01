<div class="d-flex flex-column flex-column-fluid">
	<!--begin::Toolbar-->
	<div id="kt_app_toolbar" class="app-toolbar py-3">
		<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
			<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
				<h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
			</div>
			<div class="d-flex align-items-center gap-2 gap-lg-3">
				<!-- <button href="<?= base_url() ?>adm_menugroup/add" type="button" name="btn-tambah" id="btn-tambah" class="btn btn-sm fw-bold btn-primary" >Tambah Group Menu</button> -->
			</div>
		</div>
	</div>
	<!--end::Toolbar-->


	<!--begin::Content-->
	<div id="kt_app_content" class="app-content flex-column-fluid py-3">
		<!--begin::Content container-->
		<div id="kt_app_content_container" class="app-container container-fluid">
			<!--begin::Layout-->
			<div class="d-flex flex-column flex-xl-row">
				<!--sidebar-->
				<div class="flex-column flex-lg-row-auto w-100 w-xl-250px mb-10">
					<div class="card mb-5 mb-xl-8">
						<div class="container-fluid d-flex flex-stack p-4">
							<!-- <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3"> -->
							<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
								<h3 class="fw-semibold m-0 fs-6 text-gray-800">Menu Group</h3>
							</div>
							<div class="d-flex align-items-center  ">
								<button href="<?= base_url() ?>adm_menugroup/add" type="button" name="btn-tambah" id="btn-tambah" class="btn btn-sm fw-bold btn-primary"> + </button>
							</div>
						</div>
						<div class="card-body p-5">
							<div>
								<span id="edit-group-input" class="fs-6 text-gray-800"><?php echo $group_title->title; ?></span>
								(ID: <b><?php echo $group_id; ?></b>)
								<div class="edit-group-buttons">
									<a id="edit-group" href="#" title="Edit Menu">
										<span class="btn btn-sm btn-light-primary">Ubah Group Menu</span>
									</a>
									<?php if ($group_id > 1) : ?>
										<a id="delete-group" href="#">
											<span class="btn btn-sm btn-light-danger">Hapus</span>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>

					<div class="card mb-5 mb-xl-8">
						<div class="card-title border p-5">
							<h3 class="fw-semibold m-0 fs-6 text-gray-800">Tambah ke Menu</h3>
						</div>
						<div class="card-body pt-5 pb-2">
							<form id="form-add-menu" method="post" action="<?= site_url('adm_menu/add'); ?>">
								<div class="fv-row mb-5">
									<label class="fs-6 mb-1" for="menu-title">Title</label>
									<input type="text" name="title" required id="menu-title" class="form-control form-control-sm w-100" />
								</div>
								<div class="fv-row mb-5">
									<label class="fs-6 mb-1" for="menu-icon">Icon</label>
									<input name="icon" type="text" autocomplete="off" class="form-control form-control-sm w-100 icon-picker" id="icon-picker" />
								</div>
								<div class="fv-row mb-5">
									<label class="fs-6 mb-1" for="menu-url">URL</label>
									<input type="text" name="url" id="menu-url" class="form-control form-control-sm w-100" required>
								</div>
								<p class="buttons">
									<input type="hidden" name="group_id" value="<?= $group_id; ?>">
									<button id="add-menu" type="submit" class="btn btn-sm btn-light-primary">Tambah Item Menu</button>
								</p>
							</form>
						</div>
					</div>
				</div>
				<!--end sidebar-->

				<!--content-->
				<div class="flex-lg-row-fluid ms-lg-6">
					<div class="card mb-5 mb-xl-8">
						<!--begin::Card body-->
						<div class="card-body p-4">
							<div id="main" class="col">
								<div class="mb-5 hover-scroll-x">
									<div class="d-grid">
										<ul id="menu-group" class="nav nav-tabs nav-line-tabs-2x fs-6 flex-nowrap text-nowrap">

											<?php foreach ($menu_groups as $menu) : ?>
												<li id="group-<?= $menu->id; ?>" class="nav-item">
													<?php if ($menu->id == '1') { ?>
														<a href="<?= site_url('adm_menu'); ?>" class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0">
															<?= $menu->title; ?>
														</a>
													<?php } else { ?>

														<a href="<?= site_url('adm_menu/menu'); ?>/<?= $menu->id; ?>" class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0">
															<?= $menu->title; ?>
														</a>
													<?php } ?>
												</li>
											<?php endforeach; ?>

										</ul>
									</div>
								</div>

								<div class="clearfix"></div>

								<form method="post" id="form-menu" action="<?= site_url('adm_menu/save_position'); ?>">
									<div class="ns-row bg-body-secondary text-active-danger" id="ns-header">
										<div class="actions">Actions</div>
										<div class="ns-url">URL</div>
										<div class="ns-url"></div>
										<div class="ns-title">Title</div>
									</div>

									<div style="min-height:400px;max-height:400px;overflow:auto">
										<?= $menu_ul; ?>
									</div>
									<div class="card-footer border-0 d-flex justify-content-center p-5">
										<!-- <a href="#" class="btn btn-sm btn-light-primary me-5" data-bs-toggle="modal" data-bs-target="#modal_tambah_menu">Tambah Item Menu</a> -->
										<!-- <button id="btn-add-menu" type="button" class="btn btn-sm btn-light-primary me-5">Tambah Item Menu</button> -->
										<button id="btn-save-menu" type="submit" class="btn btn-sm btn-light-primary">Simpan Urutan Menu</button>
									</div>
								</form>
							</div>
						</div>
						<!--end::Card body-->
					</div>
				</div>
				<!--end content-->
			</div>
			<!--end::Layout-->
		</div>
		<!--end::Content container-->
	</div>
	<!--end::Content-->
</div>