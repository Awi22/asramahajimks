<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_kpi_bobot extends CI_Model
{

	public function get($kategori)
	{
		$data = array();

		if(!empty($kategori)){
			$this->db_holding->where('kk.id', $kategori);
		}

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
	
	public function simpan($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menyimpan kategori';

		if (!empty($posts)) {
			$id_kategori 	= $posts['id'];
			$data = [
				'id_kategori'  	=> $posts['kategori'],
				'name'  		=> $posts['nama'],
				'bobot2'  		=> $posts['bobot_2'],
				'bobot3'  		=> $posts['bobot_3'],
				'bobot4'  		=> $posts['bobot_4'],
			];

			//cek existing
			$this->db_holding->trans_start();

			$query_cek = $this->db_holding->select('id')->from('kpi_kategori_item')->where('id', $id_kategori)->get();
			
			if ($query_cek->num_rows() > 0) {
				$this->db_holding->update("kpi_kategori_item", $data, ['id' => $id_kategori]);
			} else {
				$this->db_holding->insert("kpi_kategori_item", $data);
			}
			$this->db_holding->trans_complete();

			if ($this->db_holding->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil membuat kategori';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function get_kategori_by_id($id)
	{
		$data = array();

		if (!empty($id)) {
			$query = $this->db_holding
				->select('kki.*, kk.id AS id_kategori, kk.name AS kategori_name, kk.bobot')
				->from('kpi_kategori_item kki')
				->join('kpi_kategori kk', 'kk.id=kki.id_kategori')
				->where('kki.id', $id)
				->get();

			$row = $query->row();
			if(isset($row)){
				$data = [
					'id' 		=> $row->id,
					'kategori'	=> $row->id_kategori,
					'name' 		=> $row->name,
					'bobot1'	=> $row->bobot,
					'bobot2'	=> $row->bobot2,
					'bobot3'	=> $row->bobot3,
					'bobot4'	=> $row->bobot4,
				];
			}
		}
		return $data;
	}

	public function hapus($id)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus kategori';

		if (!empty($id)) {
			$this->db_holding->trans_start();
			$this->db_holding->delete("kpi_kategori_item", ['id' => $id]);
			$this->db_holding->trans_complete();
			if ($this->db_holding->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menghapus kategori';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}
}

/* End of file Model_kpi_bobot.php */
/* Location: ./wuling_admin/models/Model_kpi_bobot.php */
