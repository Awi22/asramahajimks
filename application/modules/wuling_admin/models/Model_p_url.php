<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_p_url extends CI_Model {


	public function get()
	{
		$data 	= array();
		$query 	= $this->db_wuling
			->select('u.*')->from('p_url u')			
			->order_by('u.url')
			->get();		
		
		foreach ($query->result() as $url)	{
			$data[] = array (					
				'id_url' 		=> $url->id_url,
				'url'			=> $url->url,
				'url_menu'		=> $url->url_menu,
				'url_notifikasi'=> $url->url_notifikasi,
				'deskripsi'		=> $url->deskripsi,
			);
		}

		return $data;
	}


	public function tambah_url($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menyimpan URL';			

		if(!empty($posts)) {						
			$url_home 		= $posts['url_home'];
			$url_menu 		= $posts['url_menu'];
			$url_notifikasi	= $posts['url_home'];
			$deskripsi 		= $posts['deskripsi'];
			
			$data 	= array(				
				'url'			=> $url_home,
				'url_menu'		=> $url_menu,
				'url_notifikasi'=> $url_notifikasi,
				'deskripsi' 	=> $deskripsi,
			);
			$this->db_wuling->trans_start();
			$this->db_wuling->insert("p_url", $data);
			$this->db_wuling->trans_complete();

			if($this->db_wuling->trans_status()===true){
				$status = true;
				$pesan 	= 'Berhasil membuat URL';				
			}
		}

		$result = ['status'=>$status,'pesan'=>$pesan];
		return $result;
	}


	public function get_url_by_id($id)
	{		
		$data_url	= NULL;
		if(!empty($id)) {
			$query_url 	= $this->db_wuling
				->select('l.*, u.url')->from('p_url l')
				->where('l.id_url', $id)
				->join('p_url u', 'u.id_url=l.id_url')				
				->order_by('l.url')
				->get();

			$url = $query_url->row();
			if($query_url->num_rows()>0) {				
				$data_url = array (					
					'id_url' 		=> $url->id_url,					
					'url'			=> $url->url,
					'url_menu'		=> $url->url_menu,
					'url_notifikasi'=> $url->url_notifikasi,
					'deskripsi'		=> $url->deskripsi,					
				);
			}
		}

		return $data_url;
	}

	public function update_url($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal mengupdate url';			

		if(!empty($posts)) {
			$id_url 		= $posts['id'];
			$url_home 		= $posts['url_home'];
			$url_notifikasi	= $posts['url_notifikasi'];
			$url_menu 		= $posts['url_menu'];
			$deskripsi 		= $posts['deskripsi'];
			
			if(!empty($id_url) && !empty($url_home) && !empty($url_notifikasi) && !empty($url_menu) && !empty($deskripsi)) {
				$data 	= array(					
					'url'			=> $url_home,
					'url_menu'		=> $url_menu,
					'url_notifikasi'=> $url_notifikasi,
					'deskripsi' 	=> $deskripsi,
				);
				$this->db_wuling->trans_start();
				$this->db_wuling->update("p_url", $data, ['id_url'=>$id_url]);
				$this->db_wuling->trans_complete();

				if($this->db_wuling->trans_status()===true){
					$status = true;
					$pesan 	= 'Berhasil mengupdate url';					
				}
			} 
		}

		$result = ['status'=>$status,'pesan'=>$pesan];
		return $result;
	}


	public function hapus_url($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus URL';
		
		if(!empty($posts)){	
			$id_url = $posts['id'];
			$cek_url_terpakai = $this->db_wuling->select('id_url')->from('users')->where('id_url', $id_url)->get();
			if($cek_url_terpakai->num_rows()>0) {
				$pesan 		= 'Gagal menghapus, url masih digunakan!';				
			} else {										
				$this->db_wuling->trans_start();
				$this->db_wuling->delete("p_url", ['id_url'=>$id_url]);				
				$this->db_wuling->trans_complete();
				if($this->db_wuling->trans_status()===true){
					$status = true;
					$pesan 	= 'Berhasil menghapus URL';
				}	
			}		
		}
		
		$result = ['status'=>$status, 'pesan'=>$pesan];
		return $result;
	}


}

/* End of file Model_p_url.php */
/* Location: ./wuling_admin/models/Model_p_url.php */
