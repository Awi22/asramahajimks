<!DOCTYPE html>
<html lang="en">

<head>
	<base hrsef="<?= base_url('public/assets/') ?> " />
	<title>UPT Asrama Haji Makassar</title>
	<meta charset="utf-8" />
	<meta name="description" content="UPT Asrama Haji Makassar Login" />
	<meta name="keywords" content="upt, asramahaji, login, kemenag" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="UPT Asrama Haji Makassar" />
	<meta property="og:url" content="https://asramahajimakassar.com" />
	<meta property="og:site_name" content="UPT Asrama Haji Makassar" />
	<link rel="shortcut icon" href="<?= base_url() ?>public/assets/media/favicon/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>public/assets/media/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>public/assets/media/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>public/assets/media/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?= base_url() ?>public/assets/media/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?= base_url() ?>public/assets/media/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="theme-color" content="#ffffff">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<link href="<?= base_url('public/assets/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('public/assets/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" />
	<script>
		// Prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
	</script>
</head>

<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
	<!--begin::Theme mode setup on page load-->
	<!--end::Theme mode setup on page load-->
	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<!--begin::Page bg image-->
		<style>
			body {
				background-image: url('<?= base_url("$background") ?>');
			}

			[data-bs-theme="dark"] body {
				background-image: url('media/auth/bg4-dark.jpg');
			}
		</style>
		<!--end::Page bg image-->
		<!--begin::Authentication - Sign-in -->
		<div class="d-flex flex-column flex-column-fluid flex-lg-row">
			<!--begin::Aside-->
			<div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
				<!--begin::Aside-->

				<!--begin::Aside-->
			</div>
			<!--begin::Aside-->
			<!--begin::Body-->

			<!-- <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20"> -->
			<div class="m-auto">
				<!--begin::Card-->
				<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-500px p-20">
					<!--begin::Wrapper-->
					<div class="d-flex flex-center flex-column flex-column-fluid px-lg-5 pb-5 pb-lg-5">
						<div class="d-flex flex-center flex-lg-start flex-column">
							<a href="<?= base_url() ?>" class="mb-10" style="text-align:center">
								<img class="w-300px mb-5" alt="Logo" src="<?= base_url('public/assets/') ?>media/logos/upt-logo-horizontal-black.png" />
							</a>
						</div>
						<!--begin::Form-->
						<form class="form w-100" novalidate="novalidate" id="formLogin" data-kt-redirect-url="###" method="post" action="<?= base_url('auth') ?>">
							<div class="input-group fv-row mb-8">
								<span class="input-group-text"><i class="bi bi-person-circle fs-1"></i></span>
								<input type="text" placeholder="Username" name="username" autocomplete="off" class="form-control" />
							</div>
							<div class="input-group fv-row mb-3">
								<span class="input-group-text"><i class="bi bi-key fs-1"></i></span>
								<input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
							</div>
							<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
								<div></div>
								<!-- <a href="#" class="link-primary">Forgot Password ?</a> -->
							</div>
							<div class="d-grid">
								<button type="submit" id="btn-submit" class="btn btn-primary">
									<span class="indicator-label">Sign In</span>
									<span class="indicator-progress">
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>
						</form>
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Card-->
			</div>
			<!--end::Body-->
			<div class="flashdata" data-flashdata="< ?= $this->session->flashdata('result_login') ?>"></div>
		</div>
		<!--end::Authentication - Sign-in-->
	</div>
	<!--end::Root-->

	<!--begin::Javascript-->
	<script>
		var hostUrl = "<?= base_url('public/assets/') ?>";
	</script>
	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<script src="<?= base_url('public/assets/') ?>plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url('public/assets/') ?>js/scripts.bundle.js"></script>
	<!--end::Global Javascript Bundle-->
	<!--begin::Custom Javascript(used for this page only)-->
	<script src="<?= base_url('public/assets/') ?>js/custom/authentication/sign-in/general.js"></script>
	<!--end::Custom Javascript-->
	<!--end::Javascript-->

	<script>

	</script>
</body>
<!--end::Body-->

</html>