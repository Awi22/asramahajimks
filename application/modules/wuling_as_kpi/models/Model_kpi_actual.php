<?php

use app\models\elo\aftersales\mApiRepairOrders;
use app\models\elo\aftersales\mApiUsers;
use app\models\elo\aftersales\mDealerCode;
use app\models\elo\aftersales\mKpiKategoriDetail;
use Illuminate\Database\Capsule\Manager as DB;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_kpi_actual extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('api/Model_api');
	}

	public function get()
	{
		$data = array();
		// $kategori = 8;

		// if(!empty($kategori)){
		// $this->db_holding->where('kki.id_sub_kategori', $kategori);
		// }

		$query = $this->db_holding
			->select('kki.*, kk.name AS kategori_name, kk.bobot')
			->from('kpi_kategori_item kki')
			->join('kpi_kategori kk', 'kk.id=kki.id_kategori')
			->where('kki.enabled', 1)
			->order_by('kki.id')
			->get();

		foreach ($query->result() as $kpi) {
			$data[] = [
				'id' 		=> $kpi->id,
				'kategori'	=> $kpi->kategori_name,
				'name' 		=> $kpi->name,
				// 'bobot1'	=> $kpi->bobot,
				// 'bobot2'	=> $kpi->bobot2,
				// 'bobot3'	=> $kpi->bobot3,
				// 'bobot4'	=> $kpi->bobot4,
				'method' 	=> $kpi->method
			];
		}

		return $data;
	}

	public function insert_or_update($data)
	{
		$result 	= false;

		if (!empty($data)) {
			$actual 		= $data['actual'];
			$v_score 		= 0;

			$arr_where 	=  [
				'id_kategori_item' => $data['id_kategori_item'],
				'dealer_code' => $data['dealer_code'],
				'tahun' => $data['tahun'],
				'bulan' => $data['bulan'],
			];

			//cek data ada
			$query_cek = $this->db_holding->get_where('kpi_kategori_item_detail', $arr_where);

			$this->db_holding->trans_start();
			if ($query_cek->num_rows() > 0) { //data ada
				//ambil target yang sudah ada
				$target = $query_cek->row('target');

				if ($target != 0 && $actual != 0) {
					$v_score 	= number_format(@($actual / $target) * 100);
				}
				//update

				$this->db_holding->update("kpi_kategori_item_detail", [
					'actual' => $actual,
					'score' => $v_score,
				], $arr_where);
			} else {
				//insert
				//kayaknya gak bakalan ke sini deh, soalnya sudah terinsert target saat upload targetnya
				//$this->db_holding->insert("kpi_kategori_item_detail", $data);
				return $result;
			}
			$this->db_holding->trans_complete();

			if ($this->db_holding->trans_status() === true) {
				$result = true;
			}
		}

		return $result;
	}

	public function id_kategori_to_name($id_kategori)
	{
		$result = '';
		$query = $this->db_holding->select('kki.name')->from('kpi_kategori_item kki')->where('kki.id', $id_kategori)->get()->row();
		if (isset($query)) {
			$result = $query->name;
		}
		return $result;
	}

	public function count_penyerapan_customer($id_kategori_item, $tahun, $bulan)
	{
		$qry_dealer_code = mDealerCode::whereNotNull('id_perusahaan')->get();

		foreach ($qry_dealer_code as $key => $value) {
			$dealer_code   = $value->dealer_code;
			$actual        = 0;

			$qry_repair_orders = mApiRepairOrders::whereDealer_code($dealer_code)->whereYear('arrival_time', '=', $tahun)->whereMonth('arrival_time', '=', $bulan)->groupBy('vin')->get()->toArray();
			$actual            = count($qry_repair_orders);

			$where = [
				'id_kategori_item' => $id_kategori_item,
				'dealer_code'      => $dealer_code,
				'tahun'            => $tahun,
				'bulan'            => $bulan,
			];

			$qry       = mKpiKategoriDetail::where($where)->first();
			$target    = $qry->target ?? NULL;

			if ($target != null) {
				$score = round(@($actual / $target) * 100, 2);

				$data = [
					'id_kategori_item' => $id_kategori_item,
					'dealer_code'      => $value->dealer_code,
					'tahun'            => $tahun,
					'bulan'            => $bulan,
					'actual'           => $actual,
					'score'            => (is_infinite($score) ? 0 : $score),
				];

				$this->db_holding->where($where)->update('kpi_kategori_item_detail', $data);

				$status = true;
				$pesan = 'Sinkron data berhasil';
			} else {
				$status = false;
				$pesan = 'Data target belum diisi pada dealer code ' . $dealer_code;

				return [
					'status' => $status,
					'pesan'  => $pesan,
				];
			}
		}

		return [
			'status' => $status,
			'pesan'  => $pesan,
		];
	}

	//* REQUEST API *//
	public function jumlah_page_yg_harus_direquest($id)
	{
		$params = [
			'record_count_only' => 'true',
		];

		$hari_ini   = date('Y-m-d');
		$tomorrow   = new DateTime('tomorrow');
		$besok      = $tomorrow->format('Y-m-d');

		$params['create_date_from'] = $hari_ini;
		$params['create_date_to']   = $besok;
		$params['dealer_code']      = mDealerCode::whereId_perusahaan($id)->pluck('dealer_code')->first();

		$id_akun = mDealerCode::whereId_perusahaan($id)
			->select(DB::raw('SUBSTRING(dealer_code, 1, 3) AS kode'))
			->first();

		$akun_api = mApiUsers::whereGroup_code($id_akun->kode)
			->select('id')
			->first();

		//* $akun_api = 1 | 2

		$total_row   = $this->model_api->request_api($akun_api->id, 'repair_orders', 'get', $params);
		$total_count = json_decode($total_row)->record_count;
		$jml_request = ceil($total_count / 100);

		return $jml_request;
	}

	public function get_data_dari_api($id)
	{
		$jml_request    = $this->jumlah_page_yg_harus_direquest($id);
		$start_record   = 1;
		$params = [
			'record_count_only' => 'false',
			'start_record' => $start_record, // offset
			'max_record' => 100              // limit
		];

		$hari_ini   = date('Y-m-d');
		$tomorrow   = new DateTime('tomorrow');
		$besok      = $tomorrow->format('Y-m-d');

		$params['create_date_from'] = $hari_ini;
		$params['create_date_to']   = $besok;
		$params['dealer_code']      = mDealerCode::whereId_perusahaan($id)->pluck('dealer_code')->first();

		$id_akun = mDealerCode::whereId_perusahaan($id)
			->select(DB::raw('SUBSTRING(dealer_code, 1, 3) AS kode'))
			->first();

		$akun_api = mApiUsers::whereGroup_code($id_akun->kode)
			->select('id')
			->first();

		//* $akun_api = 1 | 2

		$result = [];
		for ($i = 1; $i <= $jml_request; $i++) {
			$r = json_decode($this->model_api->request_api($akun_api->id, 'repair_orders', 'get', $params));

			foreach ($r as $rr) {
				$result[] = $rr;
			}

			$params['start_record'] += 100;
		}

		return $result;
	}
}

/* End of file Model_kpi_actual.php */
/* Location: ./wuling_admin/models/Model_kpi_actual.php */
