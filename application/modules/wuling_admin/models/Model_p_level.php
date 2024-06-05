<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_p_level extends CI_Model {


	public function get()
	{
		$data 	= array();
		$query 	= $this->db_wuling
			->select('l.*, u.url')->from('p_level l')
			->join('p_url u', 'u.id_url=l.id_url')
			->order_by('l.level')
			->get();		
		
		foreach ($query->result() as $level)	{
			$data[] = array (					
				'id_level' 		=> $level->id_level,
				'level'			=> $level->level,
				'deskripsi'		=> $level->deskripsi,
				'url' 			=> $level->url,				
			);
		}
		
		return $data;
	}


	public function tambah_level($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menyimpan level';			

		if(!empty($posts)) {			
			$url 			= $posts['id_url'];
			$level 			= $posts['level'];
			$deskripsi 		= $posts['deskripsi'];
			
			$data 	= array(
				'id_url'	=> $url,
				'level'		=> $level,
				'deskripsi' => $deskripsi,				
			);
			$this->db_wuling->trans_start();
			$this->db_wuling->insert("p_level", $data);
			$this->db_wuling->trans_complete();

			if($this->db_wuling->trans_status()===true){
				$status = true;
				$pesan 	= 'Berhasil membuat level';				
			}
		}

		$result = ['status'=>$status,'pesan'=>$pesan];
		return $result;
	}

	public function get_level_by_id($id)
	{		
		$data_level	= NULL;
		if(!empty($id)) {
			$query_level 	= $this->db_wuling
				->select('l.*, u.url')->from('p_level l')
				->where('l.id_level', $id)
				->join('p_url u', 'u.id_url=l.id_url')				
				->order_by('l.level')
				->get();

			$level = $query_level->row();
			if($query_level->num_rows()>0) {				
				$data_level = array (					
					'id_level' 		=> $level->id_level,
					'level'			=> $level->level,
					'url'			=> $level->url,
					'id_url' 		=> $level->id_url,
					'deskripsi'		=> $level->deskripsi,					
				);
			}			
		}

		return $data_level;
	}

	public function update_level($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal mengupdate level';			

		if(!empty($posts)) {
			$id_level 		= $posts['id'];
			$url 			= $posts['id_url'];
			$level 			= $posts['level'];
			$deskripsi 		= $posts['deskripsi'];
			
			if(!empty($id_level) && !empty($url) && !empty($level) && !empty($deskripsi)) {
				$data 	= array(
					'id_url'	=> $url,
					'level'		=> $level,
					'deskripsi' => $deskripsi,
				);
				$this->db_wuling->trans_start();
				$this->db_wuling->update("p_level", $data, ['id_level'=>$id_level]);
				$this->db_wuling->trans_complete();

				if($this->db_wuling->trans_status()===true){
					$status = true;
					$pesan 	= 'Berhasil mengupdate level';					
				}
			} 
		}

		$result = ['status'=>$status,'pesan'=>$pesan];
		return $result;
	}


	public function hapus_level($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus level';
		
		if(!empty($posts)){	
			$id_level = $posts['id'];
			$cek_level_terpakai = $this->db_wuling->select('id_level')->from('users')->where('id_level', $id_level)->get();
			if($cek_level_terpakai->num_rows()>0) {
				$pesan 		= 'Gagal menghapus, level masih digunakan!';				
			} else {										
				$this->db_wuling->trans_start();
				$this->db_wuling->delete("p_level", ['id_level'=>$id_level]);				
				$this->db_wuling->trans_complete();
				if($this->db_wuling->trans_status()===true){
					$status = true;
					$pesan 	= 'Berhasil menghapus level';
				}	
			}		
		}
		
		$result = ['status'=>$status, 'pesan'=>$pesan];
		return $result;
	}

}

/* End of file Model_p_level.php */
/* Location: ./wuling_admin/models/Model_p_level.php */