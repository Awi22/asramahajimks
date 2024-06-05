<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_kpi_scoring extends CI_Model
{

	public function get()
	{
		$data = array();
		$query = $this->db_holding
			->select('kki.*, kk.name AS kategori_name, kk.bobot')
			->from('kpi_kategori_item kki')
			->join('kpi_kategori kk','kk.id=kki.id_kategori')
			->get();
		foreach ($query->result() as $kpi) {
			$data[] = [
				'id' 		=> $kpi->id,
				'kategori'	=> $kpi->kategori_name,
				'name' 		=> $kpi->name,
				'bobot1'	=> $kpi->bobot,
				'bobot2'	=> $kpi->bobot2,
				'bobot3'	=> $kpi->bobot3,
				'bobot4'	=> $kpi->bobot4,
			];
		}
		return $data;
	}
	
}

/* End of file Model_kpi_scoring.php */
/* Location: ./wuling_admin/models/Model_kpi_scoring.php */
