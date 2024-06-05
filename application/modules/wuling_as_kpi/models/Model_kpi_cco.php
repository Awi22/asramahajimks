<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_kpi_cco extends CI_Model
{

	public function get()
	{
		$data = array();
		$kategori = 8;

		if(!empty($kategori)){
			$this->db_holding->where('kki.id_sub_kategori', $kategori);
		}

		$query = $this->db_holding
			->select('kki.*, kk.name AS kategori_name, kk.bobot')
			->from('kpi_kategori_item kki')
			->join('kpi_kategori kk','kk.id=kki.id_kategori')
			// ->where()
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
			if($query_cek->num_rows()>0){ //data ada
				//ambil target yang sudah ada
				$target = $query_cek->row('target');

				if($target!=0 && $actual!=0) {
					$v_score 	= round(($actual/$target)*100,2);
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
		if(isset($query)){
			$result = $query->name;
		}
		return $result;
	}

}

/* End of file Model_kpi_cco.php */
/* Location: ./wuling_admin/models/Model_kpi_cco.php */
