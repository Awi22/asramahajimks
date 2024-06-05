<!DOCTYPE html>
<html>

<head>
	<title>PERMOHONAN PEMBUATAN FAKTUR</title>

	<style type="text/css">
		.h1,
		.h2,
		.h3,
		.h4,
		.h5,
		.h6,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: inherit;
			font-weight: 400;
			line-height: 1.1;
			color: inherit;
		}

		body {
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 12px;
			line-height: 1.32857143;
			color: #111;
		}

		.h1,
		h1 {
			font-size: 18px;
			margin-top: -10px;
			margin-bottom: 50px;
			text-align: center;
		}

		.logo {
			height: 110px;
			width: 110px;
			display: block;
			text-align: right;
			background-image: url(<?= base_url('assets/img/wuling.png') ?>);
			background-position: center;
			background-repeat: no-repeat;
			background-size: contain;
			position: absolute;
			right: 40px;
			margin-top: 40px;
		}
	</style>


</head>


<body>
	<!-- <table style="width:100%;">
  <tr>
    <td align="center">
      <img width="100px" src="< ?php echo base_url('/assets/img/asset-ku.png') ;?>"/>
    </td>
   </tr>
</table> -->

	<table>
		<tr>
			<td>Logo</td>
			<td>Cabang</td>
			<td>Alamat</td>
		</tr>
	</table>

	<div class="logo">
	</div>

	<h1>PERMOHONAN PEMBUATAN FAKTUR</h1>

	<table class="table">
		<tbody>
			<tr class="no_border">
				<!-- <td class="no_border">KEPADA YTH</td><td class="no_border">:</td><td class="no_border">IBU ERNA</td> -->
				<td class="no_border"></td>
				<td class="no_border"></td>
				<td class="no_border"></td>
			</tr>
			<tr class="no_border">
				<!-- <td class="no_border">PERIHAL </td><td class="colon no_border">:</td><td class="no_border">PENGAJUAN FAKTUR</td> -->
				<td class="no_border"></td>
				<td class="colon no_border"></td>
				<td class="no_border"></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td class="sub_judul">A. DATA FAKTUR </td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="judul">NAMA </td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['nama_customer'] ?></td>
			</tr>
			<tr>
				<td class="judul top">ALAMAT </td>
				<td class="no_border top">:</td>
				<td><?= $pengajuan['alamat_customer'] ?></td>
			</tr>
			<tr>
				<td class="judul top">ALAMAT STNK </td>
				<td class="no_border top">:</td>
				<td><?= $pengajuan['alamat_stnk'] ?></td>
			</tr>
			<tr>
				<td class="judul top">KOTA & PROPINSI</td>
				<td class="no_border top">:</td>
				<td><?= $pengajuan['kota_provinsi_customer'] ?></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td class="sub_judul">B. DATA OWNER </td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="judul">NAMA</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['nama_owner'] ?></td>
			</tr>
			<tr>
				<td class="judul">NO KTP</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['no_ktp'] ?></td>
			</tr>
			<tr>
				<td class="judul">TEMPAT & TANGGAL LAHIR</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['tgl_lahir'] ?></td>
			</tr>
			<tr>
				<td class="judul">AGAMA</td>
				<td class="no_border">:</td>
				<td></td>
			</tr>
			<tr>
				<td class="judul">NO TELP/HP</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['telepone'] ?></td>
			</tr>
			<tr>
				<td class="judul">EMAIL</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['email_customer'] ?></td>
			</tr>
			<!-- <tr>
            <td class="judul">BIDANG USAHA</td><td class="no_border">:</td><td><?= $pengajuan['bidang_usaha'] ?></td>
        </tr> -->
			<tr>
				<td class="judul">DIGUNAKAN UNTUK</td>
				<td class="no_border">:</td>
				<td></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td class="sub_judul" colspan="3">C. DATA UNIT IDENTIFIKASI </td>
			</tr>
			<tr>
				<td class="judul">MERK/TYPE</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['varian'] ?></td>
			</tr>
			<tr>
				<td class="judul">NO RANGKA</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['no_rangka'] ?></td>
			</tr>
			<tr>
				<td class="judul">NO MESIN</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['no_mesin'] ?></td>
			</tr>
			<tr>
				<td class="judul">TAHUN</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['tahun'] ?></td>
			</tr>
			<tr>
				<td class="judul">WARNA</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['warna'] ?></td>
			</tr>
			<tr>
				<td class="judul">WARNA TNKB</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['warna'] ?></td>
			</tr>
			<tr>
				<td class="judul">TGL PENYERAHAN</td>
				<td class="no_border">:</td>
				<td> </td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td class="sub_judul">D. DATA PEMBELIAN UNIT </td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td class="judul">CARA PEMBELIAN</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['cara_bayar'] ?></td>
			</tr>
			<tr>
				<td class="judul">BANK/OTHERS</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['leasing'] ?></td>
			</tr>
			<tr>
				<td class="judul">CABANG</td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['cabang'] ?></td>
			</tr>
			<tr>
				<td class="judul">NAMA SALES </td>
				<td class="no_border">:</td>
				<td><?= $pengajuan['nama_sales'] ?></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
			<tr class="no_border">
				<td></td>
			</tr>
		</tbody>
	</table>
	<br />
	<table class="tanda_tangan">
		<tr>
			<td colspan="3">Demikian Pengajuan Faktur ini Dibuat, atas bantuan dan kerja sama yang baik, kami ucapkan terima kasih
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
			<td><?= $pengajuan['cabang'] ?>, <?= $pengajuan['tgl_pengajuan']; ?></td>
		</tr>
		<tr>
			<td></td>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td>&nbsp; </td>
			<td>&nbsp;</td>
			<td>Diketahui,</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<!-- <td><strong><u><?= $pengajuan['nama_admin']; ?></u></strong></td> -->
			<td></td>
			<td></td>
			<td><strong><u><?= $pengajuan['nama_ttd']; ?></u></strong></td>
		</tr>
		<tr>
			<!-- <td><?= $pengajuan['jabatan_admin']; ?></td> -->
			<td></td>
			<td></td>
			<td><?= $pengajuan['jabatan_ttd']; ?></td>
		</tr>
	</table>
</body>

</html>
