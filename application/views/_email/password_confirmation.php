<body id="#kt_app_body_content" style="background-color:#D5D9E2; font-family:Arial,Helvetica,sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2F3044; margin:0; padding:0; width:100%;">
	<div style="background-color:#ffffff; padding: 25px 0 15px 0; border-radius: 10px; margin:30px auto; max-width: 600px;">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse:collapse">
			<tbody>
				<tr>
					<td align="center" valign="center" style="text-align:center;">
						<div style="text-align:center; margin:0 60px 34px 60px">
							<div style="margin-bottom: 30px">
								<a href="https://kumalagroup.id" rel="noopener" target="_blank">
									<img alt="Logo" src="<?= base_url('public/assets/media/logos/upt-logo-horizontal-black.png') ?>" style="height: 35px" />
								</a>
							</div>

							<div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
								<p style="margin-bottom:30px; color:#181C32; font-size: 22px; font-weight:700">Informasi Login</p>
								<p style="margin-bottom:2px; color:#7E8299">Hai <b><?= $nama_lengkap ?></b>, gunakan informasi berikut untuk login ke Portal UPT Asrama Haji Makassar</p>
							</div>
						</div>
					</td>
				</tr>
				<tr style="display: flex;justify-content: start;margin: 0 30px 15px 30px;">
					<td align="start" valign="start" style="padding-bottom: 10px; width:100% !important">
						<div style="background: #F9F9F9; border-radius: 12px; padding:15px 15px;">
							<div style="display:flex">
								<div>
									<div>
										<p href="#" style="width:100%; color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Username: <span style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif"><?= $username ?></span></p>
										<p href="#" style="width:100%; color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">Password: <span style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif"><?= $password ?></span></p>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr style="display: flex;justify-content: start;margin: 0 30px 15px 30px;">
					<td align="start" valign="start" style="padding-bottom: 10px; width:100% !important">
						<div>
							<div style="display:flex; justify-content: center">
								<a href="<?= base_url('auth/logout') ?>" target="_blank" style="background-color:#50cd89; border-radius:6px;display:inline-block; padding:11px 19px; color: #FFFFFF; font-size: 14px; font-weight:500; font-family:Arial,Helvetica,sans-serif;">Sign In</a>
							</div>
						</div>
					</td>
				</tr>

				<tr>
					<td align="center" valign="center" style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
						<p>&copy; UPT Asrama Haji Makassar.
							<a href="http://asramahajimks.infinityfreeapp.com/?i=1" rel="noopener" target="_blank" style="font-weight: 600;font-family:Arial,Helvetica,sans-serif"></a>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>