<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
	<title>UPT Asrama Haji Makassar</title>
	<meta charset="utf-8" />
	<meta name="description" content="UPT Asrama Haji Makassar" />
	<meta name="keywords" content="upt, asramahaji, login, kemenag" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="UPT Asrama Haji Makassar" />
	<meta property="og:url" content="https://asramahajimakassar.com" />
	<meta property="og:site_name" content="UPT Asrama Haji Makassar" />
	<link rel="canonical" href="https://asramahajimakassar.com" />
	<link rel="shortcut icon" href="<?= base_url() ?>public/assets/media/favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>public/assets/media/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>public/assets/media/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>public/assets/media/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url() ?>public/assets/media/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?= base_url() ?>public/assets/media/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<!--begin::Fonts(mandatory for all pages)-->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" /> -->
	<link href="<?= base_url() ?>public/assets/css/fonts.css" rel="stylesheet" type="text/css" />
	<!--end::Fonts-->


	<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
	<link href="<?= base_url() ?>public/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>public/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>public/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->


	<!--begin::CurrentPage Stylesheets-->
	<?= $css ?>
	<!--end::CurrentPage Stylesheets-->


	<script>
		// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
	</script>
</head>
<!--end::Head-->

<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" datsa-kt-app-toolbar-enabled="true" class="app-default">
	<!--begin::Theme mode setup on page load-->
	<script>
		var defaultThemeMode = "light";
		var themeMode;
		if (document.documentElement) {
			if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
				themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
			} else {
				if (localStorage.getItem("data-bs-theme") !== null) {
					themeMode = localStorage.getItem("data-bs-theme");
				} else {
					themeMode = defaultThemeMode;
				}
			}
			if (themeMode === "system") {
				themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
			}
			document.documentElement.setAttribute("data-bs-theme", themeMode);
		}
	</script>
	<!--end::Theme mode setup on page load-->

	<!--begin::App-->
	<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
		<!--begin::Page-->
		<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
			<!--begin::Header-->
			<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
				<!--begin::Header container-->
				<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
					<!--begin::Sidebar mobile toggle-->
					<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
						<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
							<i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
								<span class="path1"></span>
								<span class="path2"></span>
							</i>
						</div>
					</div>
					<!--end::Sidebar mobile toggle-->

					<!--begin::Mobile logo-->
					<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
						<a href="index.html" class="d-lg-none">
							<img alt="Logo" src="<?= base_url() ?>public/assets/media/logos/upt-logo-horizontal-black.png" class="h-20px" />
						</a>
						<div class="menu-item menu-accordion d-lg-none">
							<span class="menu-link">
								<span class="menu-title"><?= $nama_cabang ?></span>
							</span>
						</div>
					</div>
					<!--end::Mobile logo-->

					<!--begin::Header wrapper-->
					<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
						<!--begin::Menu wrapper-->
						<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
							<div class="menu menu-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
								<div class="menu-item menu-accordion">
									<span class="menu-link">
										<span class="menu-icon">
											<i class="ki-duotone ki-element-11 fs-2">
												<span class="path1"></span>
												<span class="path2"></span>
												<span class="path3"></span>
												<span class="path4"></span>
											</i>
										</span>
										<span class="menu-title"><?= $nama_cabang ?> :: <?= $role_name ?></span>
									</span>
								</div>
							</div>
						</div>
						<!--end::Menu wrapper-->

						<!--begin::Navbar-->
						<div class="app-navbar flex-shrink-0">
							<!--begin::Notifications-->
							<?php //echo $notifications 
							?>
							<!--end::Notifications-->

							<!--begin::User menu-->
							<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">

								<div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
									<!-- <img src="<?= base_url() ?>public/assets/media/avatars/blank.png" class="rounded-3" alt="user" /> -->
									<?php
									if (empty($this->session->userdata('foto'))) {
										echo '<img alt="Logo" src="' . base_url() . 'public/assets/media/avatars/blank.png" class="rounded-3" alt="user"/>';
									} else {
										echo '<img alt="Logo" src="' . base_url() . 'public/upload/images/foto_profil/' . $this->session->userdata('foto') . '" class="rounded-3" alt="user"/>';
									}
									?>
								</div>

								<!--begin::User account menu-->
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">

									<div class="menu-item px-3">
										<div class="menu-content d-flex align-items-center px-3" style="overflow: scroll;">
											<!--begin::Avatar-->
											<div class="symbol symbol-50px me-5">
												<?php
												if (empty($this->session->userdata('foto'))) {
													echo '<img alt="Logo" src="' . base_url() . 'public/assets/media/avatars/blank.png" />';
												} else {
													echo '<img alt="Logo" src="' . base_url() . 'public/upload/images/foto_profil/' . $this->session->userdata('foto') . '" />';
												}
												?>
											</div>
											<!--end::Avatar-->
											<!--begin::Username-->
											<div class="d-flex flex-column">
												<div class="fw-bold d-flex align-items-center fs-5"><?= $this->session->userdata('nama_lengkap'); ?>
												</div>
												<a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?= $this->session->userdata('email'); ?></a>
											</div>
											<!--end::Username-->
										</div>
									</div>

									<div class="separator my-2"></div>

									<div class="menu-item px-5">
										<a href="#" class="menu-link px-5" data-bs-toggle="modal" data-bs-target="#modal_ganti_password">Ganti Password</a>
									</div>

									<div class="separator my-2"></div>

									<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
										<a href="#" class="menu-link px-5">
											<span class="menu-title position-relative">Mode
												<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
													<i class="ki-duotone ki-night-day theme-light-show fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
														<span class="path3"></span>
														<span class="path4"></span>
														<span class="path5"></span>
														<span class="path6"></span>
														<span class="path7"></span>
														<span class="path8"></span>
														<span class="path9"></span>
														<span class="path10"></span>
													</i>
													<i class="ki-duotone ki-moon theme-dark-show fs-2">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
												</span></span>
										</a>

										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-night-day fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
															<span class="path5"></span>
															<span class="path6"></span>
															<span class="path7"></span>
															<span class="path8"></span>
															<span class="path9"></span>
															<span class="path10"></span>
														</i>
													</span>
													<span class="menu-title">Light</span>
												</a>
											</div>

											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-moon fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
														</i>
													</span>
													<span class="menu-title">Dark</span>
												</a>
											</div>

											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-screen fs-2">
															<span class="path1"></span>
															<span class="path2"></span>
															<span class="path3"></span>
															<span class="path4"></span>
														</i>
													</span>
													<span class="menu-title">System</span>
												</a>
											</div>
										</div>
									</div>

									<div class="menu-item px-5">
										<a href="<?= base_url('auth/logout') ?>" class="menu-link px-5">Sign Out</a>
									</div>
								</div>
								<!--end::User account menu-->
								<!--end::Menu wrapper-->
							</div>
							<!--end::User menu-->

						</div>
						<!--end::Navbar-->
					</div>
					<!--end::Header wrapper-->
				</div>
				<!--end::Header container-->
			</div>
			<!--end::Header-->

			<!--begin::Wrapper-->
			<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
				<!--begin::Sidebar-->
				<?= $sidebar ?>
				<!--end::Sidebar-->

				<!--begin::Main-->
				<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
					<!--begin::Content wrapper-->
					<?= $contents ?>
					<!--end::Content wrapper-->

					<!--begin::Footer-->
					<div id="kt_app_footer" class="app-footer">
						<div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
							<!--begin::Copyright-->
							<div class="text-gray-900 order-2 order-md-1">
								<span class="text-muted fw-semibold">2024-<?= date('Y') ?> &copy;</span>
								<a href="https://asramahajimakassar.com" target="_blank" class="text-gray-800 text-hover-primary">UPT Asrama Haji Makassar</a>. All Rights Reserved.
							</div>
							<!--end::Copyright-->
							<?php
							$version = "ASHAMA Connect v0.1.0";
							if (ENVIRONMENT === 'development') {
								$version .= ' :: Rendered in: ' . ' <strong> {elapsed_time}</strong> seconds. CodeIgniter V<strong>' . CI_VERSION . '</strong>';
							}
							?>
							<ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
								<li class="menu-item">
									<a href="#" target="_blank" class="menu-link px-2"><?= $version ?></a>
								</li>
							</ul>
						</div>
					</div>
					<!--end::Footer-->
				</div>
				<!--end:::Main-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::App-->

	<!--begin::Scrolltop-->
	<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
		<i class="ki-duotone ki-arrow-up">
			<span class="path1"></span>
			<span class="path2"></span>
		</i>
	</div>
	<!--end::Scrolltop-->

	<!-- start::modal_ganti_password -->
	<div class="modal fade" id="modal_ganti_password" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header p-5">
					<h3 class="text-gray-700">Ganti Password</h3>
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="bi bi-x fs-1"></i>
					</div>
				</div>
				<div class="modal-body p-5">
					<div class="row">
						<div class="col">
							<form class="form w-100" novalidate="novalidate" id="form_ganti_password" data-kt-redirect-url="<?= base_url('auth/logout') ?>" action="<?= base_url('change_password') ?>">
								<div class="fv-row mb-8" data-kt-password-metesr="truse" id="password_meter">
									<div class="mb-1">
										<div class="position-relative mb-3">
											<label class="fs-6 mb-1" for="password">Password</label>
											<input class="form-control bg-transparent" type="password" placeholder="Password" name="password" id="password" autocomplete="off" />
											<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="ki-duotone ki-eye-slash fs-2"></i>
												<i class="ki-duotone ki-eye fs-2 d-none"></i>
											</span>
										</div>
										<div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
											<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
										</div>
									</div>
									<div class="text-muted">Minimal 8 karakter dan harus terdiri dari huruf kapital, huruf kecil dan angka.</div>
								</div>
								<div class="fv-row mb-8">
									<label class="fs-6 mb-1" for="confirm-password">Ulangi Password</label>
									<input type="password" placeholder="Repeat Password" name="confirm-password" id="confirm-password" autocomplete="off" class="form-control bg-transparent" />
								</div>
								<div class="d-grid mb-10">
									<button type="button" id="btn_simpan_password" class="btn btn-primary">
										<span class="indicator-label">Simpan</span>
										<span class="indicator-progress">
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
									</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end::modal_ganti_password -->

	<!--begin::Javascript-->
	<script>
		var hostUrl = "<?= base_url() ?>public/assets/";
	</script>

	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="<?= base_url() ?>public/assets/plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url() ?>public/assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->

	<!--begin::Vendors Javascript-->
	<script src="<?= base_url() ?>public/assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Vendors Javascript-->

	<!--begin::Custom Javascript-->
	<script src="<?= base_url() ?>public/assets/js/custom/kmg.js"></script>
	<script src="<?= base_url() ?>public/assets/js/custom/authentication/new-password.js"></script>

	<!--end::Custom Javascript-->

	<!--begin::CurrentPage Javascript-->
	<?= $javascript; ?>
	<!--end::CurrentPage Javascript-->

	<script type="text/javascript">
		$(document).ready(function() {
			var target_url = window.location.href;
			// $("a[href='" + target_url + "']").parent().addClass("here show");
			// $("a[href='" + target_url + "']").parent().parent().addClass("here show");
			$("a[href='" + target_url + "']").parent().parent().parent().addClass("here show");
			$("a[href='" + target_url + "']").parent().parent().parent().parent().addClass("here show");
			$("a[href='" + target_url + "']").parent().parent().parent().parent().parent().addClass("here show");
			$("a[href='" + target_url + "']").parent().parent().parent().parent().parent().parent().addClass("here show");

			$("a[href='" + target_url + "']").addClass("active");
		})
	</script>

	<!--end::Javascript-->

</body>
<!--end::Body-->

</html>