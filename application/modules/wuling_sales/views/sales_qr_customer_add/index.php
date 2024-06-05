<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
	<title>DMS Wuling</title>
	<meta charset="utf-8" />
	<meta name="description" content="DMS Wuling" />
	<meta name="keywords" content="dms, wuling, admin, kumalagroup" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="DMS Wuling" />
	<meta property="og:url" content="https://wuling.kumalagroup.co.id" />
	<meta property="og:site_name" content="DMS Wuling" />
	<link rel="canonical" href="https://wuling.kumalagroup.co.id" />
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
		<!--begin::Page bg image-->
		<style>
			body {
				background-image: url('<?= base_url() ?>public/assets/media/auth/bg6.jpg');
			}
		</style>
		<!--end::Page bg image-->

		<div class="d-flex flex-column flex-center text-center p-4 p-md-10">
			<div class="card card-flush w-100 w-md-650px py-5">
				<div class="card-body p-4 p-md-8">
					<div class="mb-8">
						<a href="index.html" class="">
							<img alt="Logo" src="<?= base_url() ?>public/assets/media/logos/wuling-logo-single2.png" class="h-40px" />
						</a>
					</div>
					<h2 class="fw-bolder text-gray-900 mb-5">Wuling Customer Data Entry</h2>
					<!--begin::Message-->
					<div class="fs-6 fw-semibold text-gray-500 mb-10"><i>Setelah pengisian form di bawah ini, Bapak/Ibu akan
						<br />dikonfirmasi oleh tim sales kami <span id="nama_sales"></span></i>
					</div>
					<!--end::Message-->

					<!--begin::Form-->
					<form class="my-auto pb-5" novalidate="novalidate" id="form-simpan" data-kt-redirect-url="###" method="post" action="<?= base_url('sales_qr_customer_add/simpan') ?>">
						<!-- <form class="my-auto pb-5" novalidate="novalidate" id="form-simpan"> -->
						<input type="hidden" value="<?= $ref ?>" name="ref" />
						<input type="hidden" value="<?= $token ?>" name="token" />
						<div class="w-100">
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="required">Nama</span>
								</label>
								<input type="text" class="form-control form-control-solid" placeholder="Nama" name="txt_name" />
							</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="required">Alamat</span>
								</label>
								<input type="text" class="form-control form-control-solid" placeholder="Alamat" name="txt_alamat" />
							</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="required">Telp/Handphone</span>
								</label>
								<input type="text" class="form-control form-control-solid" placeholder="Telp/Handphone" name="txt_handphone" />
							</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="required">Model Diminati</span>
								</label>
								<div class="row fv-row">
									<div class="col">
										<select id="opt_model" name="opt_model" class="form-select form-select-solid" data-control="select2" datas-hide-search="true" data-placeholder="Model Diminati">
											<option></option>
										</select>
									</div>
								</div>
							</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="">Waktu Bersedia Dihubungi</span>
								</label>
								<input type="text" class="form-control form-control-solid" placeholder="Waktu Bersedia Dihubungi" name="txt_waktu_dihubungi" />
							</div>
							<div class="d-flex flex-column mb-7 fv-row">
								<label class="d-flex align-items-center fs-6 fw-semibold form-label mb-2">
									<span class="">Request Test Drive</span>
								</label>
								<div class="row fv-row">
									<!--begin::Col-->
									<div class="col-6">
										<select name="opt_test_drive" class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Request testdrive">
											<option value="n">Tidak</option>
											<option value="y">Ya</option>
										</select>
									</div>
									<!--end::Col-->
								</div>
							</div>
						</div>

						<!--begin::Actions-->
						<div class="d-grid mt-20">
							<button type="submit" id="btn-submit" class="btn btn-primary">
								<span class="indicator-label">Simpan</span>
								<span class="indicator-progress">
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
							</button>
						</div>
						<!--end::Actions-->
					</form>
					<!--end::Form-->

				</div>
			</div>
		</div>
	</div>
	<!--end::App-->

	<!--begin::Javascript-->
	<script>
		var hostUrl = "<?= base_url() ?>public/assets/";
	</script>

	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="<?= base_url() ?>public/assets/plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url() ?>public/assets/js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->

	<!--begin::Custom Javascript-->
	<script src="<?= base_url() ?>public/assets/js/custom/kmg.js"></script>
	<!--end::Custom Javascript-->


	<script type="text/javascript">
		$(document).ready(function() {
			$.ajax({
				url: "<?= site_url('sales_qr_customer_add/select2_unit'); ?>",
				dataType: 'JSON',
				success: function(response) {
					$("#opt_model").select2({
						data: response,
					});
				}
			});
		})

		"use strict";
		const form = document.getElementById("form-simpan");
		var opt_model = document.getElementById("opt_model");

		$("#opt_model").on('change', function() {
			validator.revalidateField('opt_model');
		});

		var validator = FormValidation.formValidation(
			form, {
				fields: {
					txt_name: {
						validators: {
							notEmpty: {
								message: "Name is required",
							},
						},
					},
					txt_alamat: {
						validators: {
							notEmpty: {
								message: "Address is required",
							},
						},
					},
					txt_handphone: {
						validators: {
							notEmpty: {
								message: "Handphone is required",
							},
						},
					},
					opt_model: {
						validators: {
							notEmpty: {
								message: "Model is required",
							},
						},
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap5({
						rowSelector: ".fv-row",
						eleInvalidClass: "",
						eleValidClass: ""
					})
				}
			}
		);

		// Submit button handler
		const submitButton = document.getElementById("btn-submit");
		submitButton.addEventListener("click", function(e) {
			e.preventDefault();

			if (validator) {
				validator.validate().then(function(status) {
					if (status == "Valid") {
						submitButton.setAttribute("data-kt-indicator", "on");
						submitButton.disabled = true;
						// Simulate form submission. For more info check the plugin"s official documentation: https://sweetalert2.github.io/
						setTimeout(function() {
							submitButton.removeAttribute("data-kt-indicator");
							submitButton.disabled = false;
							axios.post(submitButton.closest("form").getAttribute("action"),
								new FormData(form), {}
							).then(function(e) {
								console.log(e);
								if (e.data.status == true) {
									// const the_url = e.data.url;
									// the_url && (location.href = the_url);
									Swal.fire({
										title: "Terima kasih",
										text: e.data.pesan,
										icon: "success",
										buttonsStyling: !1,
										confirmButtonText: "OK",
										customClass: {
											confirmButton: "btn btn-primary",
										},
									}).then(() => {
										window.location.replace("https://kumalagroup.id/otomotif/wuling");
									});
								} else {
									Swal.fire({
										text: "Terjadi kesalahan saat menyimpan data",
										icon: "error",
										buttonsStyling: !1,
										confirmButtonText: "OK",
										customClass: {
											confirmButton: "btn btn-primary",
										},
									}).then(() => {
										location.reload();
									});
								}
							}).catch(function(error) {
								console.log(error);
								Swal.fire({
									text: "Terjadi kesalahan, silahkan coba lagi.",
									icon: "error",
									buttonsStyling: !1,
									confirmButtonText: "Ok",
									customClass: {
										confirmButton: "btn btn-primary",
									},
								});
							}).then(() => {
								// location.reload();
								submitButton.removeAttribute(
									"data-kt-indicator"
								),
								(submitButton.disabled = !1);
							});
							// Show popup confirmation
							// Swal.fire({
							// 	text: "Form has been successfully submitted!",
							// 	icon: "success",
							// 	buttonsStyling: false,
							// 	confirmButtonText: "Ok, got it!",
							// 	customClass: {
							// 		confirmButton: "btn btn-primary"
							// 	}
							// });
							// form.submit(); // Submit form
						}, 250);
					}
				});
			}
		});

		var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = window.location.search.substring(1),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
				}
			}
			return false;
		};
	</script>

	<!--end::Javascript-->

</body>
<!--end::Body-->

</html>
