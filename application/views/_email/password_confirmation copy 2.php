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
		<!-- <link href="<?= base_url('public/assets/') ?>plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" /> -->
		<!-- <link href="<?= base_url('public/assets/') ?>css/style.bundle.css" rel="stylesheet" type="text/css" /> -->
		<script>
			// Prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
		</script>
	</head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="app-blank" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-column-fluid">
	
				<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color:#D5D9E2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
					<!--begin::Email template-->
					<style>html,body { padding:0; margin:0; font-family: Inter, Helvetica, "sans-serif"; } a:hover { color: #009ef7; }</style>
					<div id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
						<div style="background-color:#ffffff; padding: 45px 0 34px 0; border-radius: 24px; margin:40px auto; max-width: 600px;">
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
								<tbody>
									<tr>
										<td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
											<div style="text-align:center; margin:0 60px 34px 60px">
												<div style="margin-bottom: 30px">
													<a href="https://kumalagroup.id" rel="noopener" target="_blank">
														<img alt="Logo" src="<?=base_url('public/assets/media/logos/wuling-logo2.png')?>" style="height: 35px" />
													</a>
												</div>
											 
												<div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
													<p style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">Informasi Login</p>
													<p style="margin-bottom:2px; color:#7E8299">Gunakan informasi berikut untuk login ke DMS Wuling Kumala</p>
												</div>
											</div>
											<!--end:Email content-->
										</td>
									</tr>
									<tr style="display: flex;justify-content: start;margin: 0 30px 25px 30px;">
										<td align="start" valign="start" style="padding-bottom: 10px; width:100% !important">
											<div style="background: #F9F9F9; border-radius: 12px; padding:15px 15px;">
												<div style="display:flex">
													<div>
														<div>
															<p href="#" style="width:100%; color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Username: <span style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif"><?=$username?></span></p>
															<p href="#" style="width:100%; color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Password: <span style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif"><?=$password?></span></p>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<tr style="display: flex;justify-content: start;margin: 0 30px 25px 30px;">
										<td align="start" valign="start" style="padding-bottom: 10px; width:100% !important">
											<div style="">
												<div style="display:flex; justify-content: center">
									<a href="<?=base_url('auth/logout')?>" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Sign In</a>
												</div>
											</div>
										</td>
									</tr>
								 
									<tr>
										<td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
											<p>&copy; KumalaGroup. 
											<a href="https://kumalagroup.id" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a></p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!--end::Email template-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Root-->
	</body>
	<!--end::Body-->
</html>
