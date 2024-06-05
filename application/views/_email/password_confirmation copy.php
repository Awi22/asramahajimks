<!DOCTYPE html>
<html lang="en">

<head>
	<base hrsef="<?= base_url('public/assets/') ?> " />
	<title>Password Confirmation - DMS Wuling</title>
	<meta charset="utf-8" />
	<meta name="description" content="DMS Wuling Login" />
	<meta name="keywords" content="dms, wuling, login, kumalagroup" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="DMS Wuling" />
	<meta property="og:url" content="https://wuling.kumalagroup.co.id" />
	<meta property="og:site_name" content="DMS Wuling" />
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
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">

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

	<!--begin::Root-->
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<style>
			body {
				background-image: url('<?= base_url("public/assets/media/auth/bg6.jpg") ?>');
			}

			[data-bs-theme="dark"] body {
				background-image: url('<?= base_url("public/assets/media/auth/bg6-dark.jpg") ?>');
			}
		</style>
		<div class="d-flex flex-column flex-center flex-column-fluid">
			<div class="d-flex flex-column flex-center text-center p-10">
				<div class="card card-flush w-lg-650px py-5">
					<div class="card-body py-15 py-lg-20">
						<div class="mb-14">
							<a href="index.html" class="">
								<img alt="Logo" src="<?= base_url('public/assets/') ?>media/logos/wuling-logo2.png" class="h-40px" />
							</a>
						</div>
						<h1 class="fw-bolder text-gray-900 mb-5">Informasi login sudah terganti!</h1>
						<div class="fs-6 fw-semibold text-gray-500 mb-10">This is your opportunity to get creative
							<a href="#" class="link-primary fw-semibold">max@keenthemes.com</a>
							<br />that gives readers an idea
						</div>
						<!--begin::Link-->
						<div class="mb-11">
							<a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-primary">Sign in</a>
						</div>
						<div class="mb-0">
							<img src="<?= base_url('public/assets/media/auth/ok.png') ?>" class="mw-100 mh-300px theme-light-show" alt="" />
							<img src="<?= base_url('public/assets/media/auth/ok-dark.png') ?>" class="mw-100 mh-300px theme-dark-show" alt="" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end::Root-->

	<script>
		var hostUrl = "<?= base_url('public/assets/') ?>";
	</script>
	<script src="<?= base_url('public/assets/') ?>plugins/global/plugins.bundle.js"></script>
	<script src="<?= base_url('public/assets/') ?>js/scripts.bundle.js"></script>

</body>

</html>
