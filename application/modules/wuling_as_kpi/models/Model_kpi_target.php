<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_kpi_target extends CI_Model
{

	public function get($gets)
	{
		$data	 	= array();
		$kategori 	= null; //8 cco
		$tahun 		= $gets['tahun'];
		$bulan 		= $gets['bulan'];
		$cabang 	= $gets['cabang'];

		if(!empty($cabang)){
			$query = $this->db_holding
				->select('kki.name, kki.method, kkid.id, kkid.target, p.lokasi')
				->from('kpi_kategori_item_detail kkid')
				->join('kpi_kategori_item kki','kki.id=kkid.id_kategori_item')
				->join('db_wuling_as.api_dealer_code adc','adc.dealer_code=kkid.dealer_code')
				->join('kmg.perusahaan p','p.id_perusahaan=adc.id_perusahaan')
				->where('kkid.tahun', $tahun)
				->where('kkid.bulan', $bulan)
				->where('p.id_perusahaan', $cabang)
				->where('kkid.target !='. NULL)
				->order_by('kki.id')
				->get();
		} else {
			$query = $this->db_holding
				->select("SUM(kkid.target) AS target, kki.name, kki.method, kkid.id, 'SEMUA CABANG' AS lokasi")
				->from('kpi_kategori_item_detail kkid')
				->join('kpi_kategori_item kki','kki.id=kkid.id_kategori_item')
				->join('db_wuling_as.api_dealer_code adc','adc.dealer_code=kkid.dealer_code')
				->join('kmg.perusahaan p','p.id_perusahaan=adc.id_perusahaan')
				->where('kkid.tahun', $tahun)
				->where('kkid.bulan', $bulan)
				->group_by('kkid.id_kategori_item')
				->order_by('kki.id')
				->get();
		}

		

		foreach ($query->result() as $kpi) {
			$data[] = [
				'id' 		=> $kpi->id,
				'cabang' 	=> $kpi->lokasi,
				'name' 		=> $kpi->name,
				'target' 	=> $kpi->target,
			];
		}
		
		return $data;
	}
	
	public function insert_or_update($data)
	{
		$result 	= false;

		if (!empty($data)) {
			$id_kategori 	= $data['id_kategori_item'];
			$tahun 			= $data['tahun'];
			$bulan 			= $data['bulan'];
			$dealer_code	= $data['dealer_code'];
			
			//cek data ada
			$query_cek = $this->db_holding->get_where('kpi_kategori_item_detail', [
				'id_kategori_item' => $id_kategori, 
				'tahun' =>$tahun, 
				'bulan' => $bulan, 
				'dealer_code' => $dealer_code
			]);

			$this->db_holding->trans_start();
			if($query_cek->num_rows()>0){ 
				//update
				unset($data['id_kategori_item']);
				unset($data['tahun']);
				unset($data['bulan']);
				unset($data['dealer_code']);

				$target_lama = $query_cek->row('target');
				$target_baru = $data['target'];
				if($target_baru=='' || $target_baru==0){
					$target_baru = $target_lama;
				}

				$this->db_holding->update("kpi_kategori_item_detail", [
					'target' => $target_baru
				], [
					'id_kategori_item' => $id_kategori,
					'tahun' =>$tahun, 
					'bulan' => $bulan, 
					'dealer_code' => $dealer_code
				]);
			} else { 
				//insert
				$this->db_holding->insert("kpi_kategori_item_detail", $data);
			}
			$this->db_holding->trans_complete();

			if ($this->db_holding->trans_status() === true) {
				$result = true;
			}
		}

		return $result;
	}

}

/* End of file Model_kpi_target.php */
/* Location: ./wuling_admin/models/Model_kpi_target.php */
