<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_report_as_customer_history_penjualan extends CI_Model
{
	// untuk mengambil data penjualan unit yang terakhir dan tidak memiliki retur
	public function penjualanUnitMobil($cabang, $tgl_awal, $tgl_akhir)
	{
		if (!empty($cabang)) {
			$this->db_wuling->where('pu.id_perusahaan', $cabang);
		}
		$query = $this->db_wuling
			->select("pu.no_transaksi, pu.tgl, sc.nama, sc.telepone, spk.nama_stnk, du.no_rangka, duc.no_polisi, duc.no_mesin, pu.cara_bayar, spk.keterangan")
			->from("db_wuling.penjualan_unit AS pu")
			->join("db_wuling.s_spk AS spk", "spk.no_rangka = pu.no_rangka", "left")
			->join("db_wuling.detail_unit_masuk AS du", "du.no_rangka = pu.no_rangka", "left")
			->join("db_wuling.s_customer AS sc", "sc.id_prospek = spk.id_prospek", "left")
			->join("db_wuling_as.detail_unit_customer AS duc", "pu.no_rangka = duc.no_rangka", "left")
			->where("pu.tgl >= '$tgl_awal' AND pu.tgl <= '$tgl_akhir'")
			->where("pu.batal", "n")
			->get();
		return $query->result();
	}

	public function cekHistoryService($no_rangka)
	{
		$hasil = false;
		$query = $this->db_wuling_as->query("SELECT no_wo FROM work_order WHERE no_rangka = '$no_rangka'")->row();
		if (!empty($query->no_wo)) {
			$hasil = true;
		}
		return $hasil;
	}

	// untuk mengambil history service by no rangka
	public function historyService($no_rangka)
	{
		$result = $this->db_wuling_as->query("SELECT no_wo, no_rangka, tgl_service FROM work_order WHERE no_rangka = '$no_rangka'")->row();

		$no_wo = (empty($result->no_wo) ? null : $result->no_wo);

		$work_order = $this->_cekNoWo($no_wo);

		$data = [];
		foreach ($work_order as $value) {
			$total_biaya_jasa = (empty($this->_cekNoInvoiceJasa($value->no_invoice)->jumlah) ? '0' : $this->_cekNoInvoiceJasa($value->no_invoice)->jumlah);
			$total_biaya_part = (empty($this->_cekNoInvoicePart($value->no_invoice)->jumlah) ? '0' : $this->_cekNoInvoicePart($value->no_invoice)->jumlah);
			$total_biaya_lain = (empty($this->_cekNoInvoiceLain($value->no_invoice)->jumlah) ? '0' : $this->_cekNoInvoiceLain($value->no_invoice)->jumlah);
			$total = ($total_biaya_jasa + $total_biaya_part + $total_biaya_lain);
			$detail_wo = $this->_cekDetailNoWo($value->no_ref)->row();

			$data[] = [
				'no_wo'            => $value->no_ref,
				'no_invoice'       => $value->no_invoice,
				'tgl_service'      => $result->tgl_service,
				'total_biaya_jasa' => $total_biaya_jasa,
				'total_biaya_part' => $total_biaya_part,
				'total_biaya_lain' => $total_biaya_lain,
				'pajak_rp'         => '',
				'grand_total'      => $total,
				'keterangan'       => preg_replace('/\s+/', ' ', $detail_wo->keterangan),
			];
		}

		return $data;
	}

	// untuk cek nomor wo work order
	public function _cekDetailNoWo($no_wo)
	{
		$data = $this->db_wuling_as->query("SELECT db_wuling_as.work_order.no_wo, db_wuling_as.work_order.no_estimasi, db_wuling_as.work_order.no_rangka, db_wuling_as.work_order.id_customer, db_wuling_as.work_order.id_perusahaan, db_wuling_as.work_order.tgl_service, db_wuling_as.work_order.kode_paket_wo, db_wuling_as.work_order.km_masuk, db_wuling_as.work_order.keluhan, db_wuling_as.work_order.keterangan, db_wuling_as.work_order.total_biaya_jasa, db_wuling_as.work_order.total_biaya_part, db_wuling_as.work_order.id_pesanan_penjualan, db_wuling_as.work_order.total_biaya_lain, db_wuling_as.work_order.diskon, db_wuling_as.work_order.diskon_rp, db_wuling_as.work_order.pajak, db_wuling_as.work_order.pajak_rp, db_wuling_as.work_order.grand_total, db_wuling_as.work_order.c_start, db_wuling_as.work_order.t_finish, db_wuling_as.work_order.c_finish, db_wuling_as.work_order.closed, db_wuling_as.work_order.saran, db_wuling_as.work_order.s_terbayar, db_wuling_as.work_order.cetak_invoice, db_wuling_as.work_order.`user`, db_wuling_as.work_order.status_konfir, db_wuling_as.work_order.w_insert, db_wuling_as.work_order.note, db_wuling_as.work_order.batal_wo, db_wuling_as.customer.ktp, db_wuling_as.customer.nama, db_wuling_as.customer.alamat, db_wuling_as.customer.kota, db_wuling_as.customer.telepon, db_wuling_as.customer.npwp, db_wuling_as.detail_unit_customer.no_polisi, db_wuling_as.detail_unit_customer.nama_stnk, db_wuling_as.detail_unit_customer.alamat_stnk, db_wuling_as.detail_unit_customer.telepon_stnk, kmg.karyawan.nama_karyawan FROM db_wuling_as.work_order LEFT JOIN db_wuling_as.customer ON db_wuling_as.work_order.id_customer = db_wuling_as.customer.id_customer LEFT JOIN db_wuling_as.detail_unit_customer ON db_wuling_as.work_order.no_rangka = db_wuling_as.detail_unit_customer.no_rangka LEFT JOIN kmg.karyawan ON db_wuling_as.work_order.`user` = kmg.karyawan.nik WHERE db_wuling_as.work_order.no_wo = '$no_wo' GROUP BY db_wuling_as.work_order.no_wo");
		return $data;
	}

	// untuk cek nomor wo yang ada di invoice after sales
	public function _cekNoWo($no_wo)
	{
		$result = $this->db_wuling_as->query("SELECT no_invoice, no_ref, invoice_date FROM invoice_after_sales WHERE no_ref = '$no_wo'")->result();
		return $result;
	}

	// untuk cek nomor invoice jasa yang ada di buku besar
	public function _cekNoInvoiceJasa($no_invoice)
	{
		$result = $this->db_wuling->query("SELECT * FROM buku_besar WHERE no_transaksi = '$no_invoice' AND kode_akun = '420101'")->row();
		return $result;
	}

	// untuk cek nomor invoice part yang ada di buku besar
	public function _cekNoInvoicePart($no_invoice)
	{
		$result = $this->db_wuling->query("SELECT * FROM buku_besar WHERE no_transaksi = '$no_invoice' AND kode_akun = '420202'")->row();
		return $result;
	}

	// untuk cek nomor invoice lain yang ada di buku besar
	public function _cekNoInvoiceLain($no_invoice)
	{
		$result = $this->db_wuling->query("SELECT * FROM buku_besar WHERE no_transaksi = '$no_invoice' AND kode_akun = '420102'")->row();
		return $result;
	}
}
