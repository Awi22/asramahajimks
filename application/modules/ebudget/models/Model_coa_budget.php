<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_coa_budget extends CI_Model
{

	public function __construct()
	{
		parent::__construct();	
		$this->username = $this->session->userdata('username');	
	}
	
	public function get($posts)
	{
		$data 	= array();
		$query 	= $this->db_wuling
			->select('cb.*, a.nama_akun')
			->from('budgetting_coa cb')
			->join('akun a','a.kode_akun=cb.kode_akun')		
			->order_by('cb.kode_akun ASC')
			->get();
		$no= 1;
		foreach ($query->result() as $coa_budget)	{		                        
			$data[] = array (		
				'no'			=> $no++,	
				'id_coa'		=> $coa_budget->id_coa,		
				'kode_akun' 	=> $coa_budget->kode_akun,
				'nama_akun'		=> $coa_budget->nama_akun,
				'departemen'	=> "After Sales",
				'p_sm'			=> $coa_budget->p_sm,
				'p_asm'			=> $coa_budget->p_asm,
				'p_gm'			=> $coa_budget->p_gm,
				'status' 		=> $coa_budget->status,		
			);
		}

		return $data;
	}

	public function get_pilih_akun($posts)
	{
		$data 	= array();
		$query = $this->db
			->select("a.kode_akun,a.nama_akun, cb.kode_akun as exist")
			->from("db_wuling.akun a")
			->join('db_wuling.budgetting_coa cb','a.kode_akun=cb.kode_akun', 'left')		
			->where('a.kode_akun LIKE  "6%"')
			->order_by("a.kode_akun")
			->get();
		$no= 1;
		foreach ($query->result() as $coa_budget)	{
			$exist = ($coa_budget->exist !== null) ? "ya" : "tidak"; 		                        
			$data[] = array (		
				'no'			=> $no++,			
				'kode_akun' 	=> $coa_budget->kode_akun,
				'nama_akun'		=> $coa_budget->nama_akun,
				'departemen'	=> "After Sales",
				// 'status' 		=> 0,	
				'exist'			=> $exist
			);
		}

		return $data;
	}

	//ambil data akun untuk kebutuhan select2
	public function select2_akun() {				
		$data = array();
		$query = $this->db
			->select("id_akun,kode_akun,nama_akun")
			->from("db_wuling.akun a")
			->where('kode_akun LIKE  "6%"')
			->order_by("kode_akun")->get();
		foreach ($query->result() as $q) {
			$data[] = array(
				'id'        => $q->kode_akun,
				// 'kode' 		=> $q->kode_akun,
				'text'      => $q->nama_akun,
			);
		}		
		responseJson($data);		
	}

	public function tambah_coa($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menyimpan COA';
	
		if(!empty($posts)) {
			$coaArray = $posts['coa'];
			
			$this->db_wuling->trans_start();
			foreach ($coaArray as $coaValue){
				//cek existing
				$query_cek_kode = $this->db_wuling->select('kode_akun')->from('budgetting_coa')->where('kode_akun',$coaValue)->get();

				if ($query_cek_kode->num_rows() > 0) {
					// If kode_akun already exists, skip to the next iteration
					continue;
				}
				$data 	= array(
					'kode_akun'	 => $coaValue,
					'status' 	 => 'on',
					'created_by' => $this->username,
				);

				$this->db_wuling->insert("budgetting_coa", $data);
			}
			$this->db_wuling->trans_complete();

			if($this->db_wuling->trans_status()===true){
				$status = true;
				$pesan 	= 'Berhasil tambah COA';
			}
		}

		$result = ['status'=>$status,'pesan'=>$pesan];
		return $result;
	}

	public function set_status($id, $status)
	{
		$result = false;
		if (!empty($id) && !empty($status)) {
			$this->db_wuling->update("budgetting_coa", ['status' => $status, 'modified_by' => $this->username], ['id_coa' => $id] );
			$result	= $this->db_wuling->affected_rows() > 0 ? true : false;
		}
		return $result;
	}

	public function hapus_coa($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus COA atau COA masih digunakan';

		if (!empty($posts)) {
			$id_coa = $posts['id'];
			//cek apa digunakan atau tidak
			$query_cek = $this->db_wuling->select('b.coa_budget')
			->from('budgetting b')
			->join('budgetting_coa bc','bc.kode_akun=b.coa_budget')
			->where('bc.id_coa', $id_coa)->get();
			if ($query_cek->num_rows() == 0) {	
				$this->db_wuling->trans_start();
				$this->db_wuling->delete("budgetting_coa", ['id_coa' => $id_coa]);
				$this->db_wuling->trans_complete();
				if ($this->db_wuling->trans_status() === true) {
					$status = true;
					$pesan 	= 'Berhasil menghapus Coa Akun';
				}
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function get_approval_coa_by_id($id)
	{
		$query = $this->db_wuling->select('p_sm, p_asm, p_gm, max_budget')->from('budgetting_coa')->where('id_coa', $id)->get();
		return $query->row();
	}

	public function update_approval($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal mengupdate approval';

		$data 	= [
			'p_sm'			=> $posts['p_sm'],
			'p_asm'			=> $posts['p_asm'],
			'p_gm'			=> $posts['p_gm'],
			'max_budget' 	=> remove_separator($posts['max_budget']),
			'modified_by'	=> $this->username
		];

		if (!empty($posts)) {
			$id_coa = $posts['id'];
			$this->db_wuling->trans_start();
			$this->db_wuling->update("budgetting_coa", $data, ['id_coa' => $id_coa]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil mengupdate approval';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

}

/* End of file Model_coa_budget.php */
/* Location: ./wuling_finance/models/Model_coa_budget.php */
