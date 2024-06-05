<html>

<head>
	<style>
		body {
			font-family: Verdana, Geneva, Tahoma, sans-serif;
			font-size: 10pt;
		}

		p {
			margin: 0pt;
		}

		table.items {
			border: 0.1mm solid #000000;	
		}

		td {
			vertical-align: top;
		}

		.items td {
			border-left: 0.1mm solid #000000;
			border-right: 0.1mm solid #000000;
		}

		table thead td {
			background-color: #EEEEEE;
			text-align: center;
			border: 0.1mm solid #000000;
			font-variant: small-caps;
		}

		.items td.blanktotal {
			background-color: #EEEEEE;
			border: 0.1mm solid #000000;
			background-color: #FFFFFF;
			border: 0mm none #000000;
			border-top: 0.1mm solid #000000;
			border-right: 0.1mm solid #000000;
		}

		.items td.totals {
			text-align: right;
			border: 0.1mm solid #000000;
		}

		.items td.cost {
			text-align: "." right;
		}
	</style>
	<?php
		if(empty($details)) {
			echo "<script>alert('Data Kosong');window.close();</script>";
		}
	?>
</head>
<body>

	<!--mpdf
	<htmlpageheader name="myheader">
	<table width="100%" border="0">
		<tbody>
			<tr>
				<td width="120px" style="text-align: center;padding-top:10px"><img width="96px" src="<?= base_url() ?>public/assets/media/logos/wuling-logo-single2.png"></td>
				<td style="background-color:#da2327;padding:23px 0px;text-align:center;color:white;font-size:large;font-weight:bold"><?= $cabang->lokasi; ?></td>
				<td width="40%" style="padding-left:10px;font-size:9pt"><b><?= $cabang->nama_perusahaan; ?></b>
					<br> <?=$cabang->alamat;?>
				</td>
		</tbody>
	</table>
	</htmlpageheader>

	<htmlpagefooter name="myfooter">
	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
	Halaman {PAGENO} dari {nb}
	</div>
	</htmlpagefooter>

	<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
	<sethtmlpagefooter name="myfooter" value="on" />
	mpdf-->
	<br />

	<table width="100%" style="font-size: 9pt;">
		<tr>
			<td>Kode Dealer</td>
			<td>:</td>
			<td><?= intval($dealer->dealer_code); ?></td>
			<td></td>
			<td>Nomor PO</td>
			<td>:</td>
			<td><?= $no_po; ?></td>
		</tr>
		<tr>
			<td>Nama Dealer</td>
			<td>:</td>
			<td><?= $dealer->dealer_name; ?></td>
			<td></td>
			<td>Tanggal PO</td>
			<td>:</td>
			<td><?= $tgl_po; ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td>:</td>
			<td><?= $cabang->alamat; ?></td>
			<td></td>
			<td>Diajukan Oleh</td>
			<td>:</td>
			<td><?= $created_by;?></td>
		</tr>
		<tr>
			<td>Telp</td>
			<td>:</td>
			<td><?= $cabang->telepon?></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>

	<br />
	<br />

	<table width="100%">
		<tr>
			<td style="background-color:#da2327;padding:5px 15px; text-align: center;color:white">
				<h4>PURCHASE ORDER</h4>
			</td>
		</tr>
	</table>

	<br />



	<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
		<thead>
			<tr>
				<td width="">No</td>
				<td width="">Item</td>
				<td width="">Sub Item</td>
				<td width="">Qty</td>
				<td width="">Keterangan</td>
				<td width="">Harga Pengajuan</td>
			</tr>
		</thead>
		<tbody>
			<!-- ITEMS HERE -->

			<?php $no=1; ?>
			<?php foreach ($details as $detail) : ?>
			<tr>
				<td align="center"><?= $no++; ?></td>
				<td><?=$detail['parent_akun'];?></td>
				<td><?=$detail['nama_akun'];?></td>
				<td class="cost"><?=$detail['qty'];?></td>
				<td><?=$detail['keterangan'];?></td>
				<td class="cost">Rp<?=$detail['total'];?></td>
			</tr>
			<?php endforeach ?>
			<!-- END ITEMS HERE -->
			<tr>
				<td class="blanktotal" colspan="4"></td>
				<td class="totals"><b>TOTAL</b></td>
				<td class="totals cost"><b>Rp<?=$grand_total;?></b></td>
			</tr>
		</tbody>
	</table>

	<br />
	<br />

	<table align="center" border="0" width="100%" style="padding-top:25px">
		<tr>
			<td align="center">Service Supervisor</td>
			<td align="center">Area Service Manager</td>
			<td align="center">General Manager</td>
		</tr>
		<tr>
			<td style="padding-top:75px"></td>
			<td style="padding-top:75px"></td>
			<td style="padding-top:75px"></td>
		</tr>
		<tr>
			<td align="center"><b>M. Khaerul Rijal</b></td>
			<td align="center"><b>Asta Werdiana</b></td>
			<td align="center"><b>Bing Hermawan</b></td>
		</tr>
	</table>

</body>

</html>
