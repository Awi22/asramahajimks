<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_p_region extends CI_Model {


 	public function ada($id){
 		$q 	 = $this->db_wuling->get_where("p_region",$id);
		$row = $q->num_rows();

		return $row > 0;
 	}

 	public function get($id){
 		$q 	 = $this->db_wuling->get_where("p_region",$id);
		$rows = $q->num_rows();

		if ($rows > 0){
			$results = $q->result();
			return $results[0];
		} else {
			return null;
		}
 	}

    public function last_kode(){
		$q = $this->db_wuling->query("SELECT MAX(right(kode_region,3)) as kode FROM p_region ");
		$row = $q->num_rows();

		if($row > 0){
            $rows = $q->result();
            $hasil = (int)$rows[0]->kode;
        }else{
            $hasil = 0;
        }
		return $hasil;
	}


	public function all(){
		$q = $this->db_wuling->order_by('kode_region');
		$q = $this->db_wuling->get('p_region');
		return $q;
	}

 	public function insert($dt){
 		$this->db_wuling->insert("p_region",$dt);
 	}

 	public function update($id, $dt){
 		$this->db_wuling->update("p_region",$dt,$id);
 	}

 	public function delete($id){
 		$this->db_wuling->delete("p_region",$id);
 	}




}

/* End of file app_model.php */
/* Location: ./application/models/app_model.php */
