<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_approval_pengajuan_biaya extends CI_Model
{

	public function __construct()
	{
		parent::__construct();		
	}


	public function get($gets)
	{
		$data 	= array();
		$cabang = $gets['cabang'];
		if(!empty($cabang)){
			$this->db_wuling->where('bo.id_perusahaan', $cabang);
		}
		$query 	= $this->db_wuling
			->select('bo.*')
			->from('budgetting_po bo')
			->where('bo.is_deleted','0')
			->order_by('bo.created_at','DESC')
			->get();
		
		foreach ($query->result() as $budget)	{		                        
			$data[] = array (		
				'id'			=> $budget->id,
				'no_po'			=> $budget->no_po,
				'tgl_po'		=> $budget->tgl_po,
				'total' 		=> $budget->total,
				'approval_sm' 	=> $budget->approval_sm,
				'approval_asm' 	=> $budget->approval_asm,
				'approval_gm' 	=> $budget->approval_gm,
				'alasan'		=> $budget->alasan,
				'status' 		=> $budget->status,
			);
		}

		return $data;
	}

	public function get_asm($gets)
	{
		$data 	= array();
		$cabang = $gets['cabang'];
		if(!empty($cabang)){
			$this->db_wuling->where('bo.id_perusahaan', $cabang);
		}
		$query 	= $this->db_wuling
			->select('bo.*')
			->from('budgetting_po bo')
			->where('approval_sm', 1)
			->where('bo.is_deleted','0')
			->order_by('bo.created_at','DESC')
			->get();
		
		foreach ($query->result() as $budget)	{		                        
			$data[] = array (		
				'id'			=> $budget->id,
				'no_po'			=> $budget->no_po,
				'tgl_po'		=> $budget->tgl_po,
				'total' 		=> $budget->total,
				'approval_sm' 	=> $budget->approval_sm,
				'approval_asm' 	=> $budget->approval_asm,
				'approval_gm' 	=> $budget->approval_gm,
				'alasan'		=> $budget->alasan,
				'status' 		=> $budget->status,
			);
		}

		return $data;
	}

	public function get_gm($gets)
	{
		$data 	= array();
		$query 	= $this->db_wuling
			->select('bo.*')
			->from('budgetting_po bo')
			->where('approval_sm', 1)
			->where('bo.is_deleted','0')
			// ->where('bo.id_perusahaan', $id_perusahaan)
			->group_start()
				->where('approval_asm', 1)
				->or_where('status', 1)
			->group_end()
			->order_by('bo.created_at','DESC')
			->get();
		
		foreach ($query->result() as $budget)	{		                        
			$data[] = array (		
				'id'			=> $budget->id,
				'no_po'			=> $budget->no_po,
				'tgl_po'		=> $budget->tgl_po,
				'total' 		=> $budget->total,
				'approval_sm' 	=> $budget->approval_sm,
				'approval_asm' 	=> $budget->approval_asm,
				'approval_gm' 	=> $budget->approval_gm,
				'alasan'		=> $budget->alasan,
				'status' 		=> $budget->status,
			);
		}

		return $data;
	}
	
	public function approve($id)
	{
		$status 	= false;
		$pesan 		= 'Gagal approve data';

		if (!empty($id)) {
			$this->db_wuling->trans_start();
			$this->db_wuling->where('id', $id);
			$this->db_wuling->update("budgetting_po",['approval_sm' => 1, 'tgl_approve_sm' => date('Y-m-d H:i:s')]);
			if($this->_cek_approval_coa($id, 'sm') == true){
				$this->db_wuling->where('id', $id);
				$this->db_wuling->update("budgetting_po",['status' => 1, 'approved_at' => date('Y-m-d H:i:s')]);
			}
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil approve data';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function approve_asm($id)
	{
		$status 	= false;
		$pesan 		= 'Gagal approve data';

		if (!empty($id)) {
			$this->db_wuling->trans_start();
			$this->db_wuling->where('id', $id);
			$this->db_wuling->update("budgetting_po",['approval_asm' => 1, 'tgl_approve_asm' => date('Y-m-d H:i:s')]);
			if($this->_cek_approval_coa($id, 'asm') == true){
				$this->db_wuling->where('id', $id);
				$this->db_wuling->update("budgetting_po",['status' => 1, 'approved_at' => date('Y-m-d H:i:s')]);
			}
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil approve data';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function approve_gm($id)
	{
		$status 	= false;
		$pesan 		= 'Gagal approve data';

		if (!empty($id)) {
			$this->db_wuling->trans_start();
			$this->db_wuling->where('id', $id);
			$this->db_wuling->update("budgetting_po",[
				'approval_gm' => 1, 
				'tgl_approve_gm' => date('Y-m-d H:i:s'),
				 'status'=> '1', 
				 'approved_at'=>date('Y-m-d H:i:s')
				]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil approve data';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function reject($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal reject data';

		if (!empty($posts)) {
			$this->db_wuling->trans_start();
			$this->db_wuling->where('id', $posts['id']);
			$this->db_wuling->update("budgetting_po",[
				'approval_sm' => 2, 
				'alasan' => $posts['alasan'],
				'tgl_approve_sm' => date('Y-m-d H:i:s')
			]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil reject data';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function reject_asm($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal reject data';

		if (!empty($posts)) {
			$this->db_wuling->trans_start();
			$this->db_wuling->where('id', $posts['id']);
			$this->db_wuling->update("budgetting_po",[
				'approval_asm' => 2, 
				'alasan' => $posts['alasan'],
				'tgl_approve_asm' => date('Y-m-d H:i:s')]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil reject data';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function reject_gm($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal reject data';

		if (!empty($posts)) {
			$this->db_wuling->trans_start();
			$this->db_wuling->where('id', $posts['id']);
			$this->db_wuling->update("budgetting_po",[
				'approval_gm' => 2, 
				'alasan' => $posts['alasan'],
				'tgl_approve_gm' => date('Y-m-d H:i:s')
			]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil reject data';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	private function _cek_approval_coa($id_po, $level){
		$status = false;
		$query_po = $this->db_wuling
			->select('bp.coa_budget')
			->from('budgetting_po p')
			->join('budgetting_pengajuan bp','bp.no_po=p.no_po')
			->where('p.id', $id_po)
			->where('bp.is_deleted','0')
			->where('bp.status','1')
			->get();
		// foreach ($query_po->result() as $po) {
		// 	switch ($level) {
		// 		case 'sm':
		// 			$this->db_wuling->where('p_asm','0');
		// 			$this->db_wuling->where('p_gm','0');
		// 			break;
		// 		case 'asm':
		// 			$this->db_wuling->where('p_gm','0');
		// 			break;
		// 	}
		// 	$query = $this->db_wuling->get_where('budgetting_coa', [
		// 		'kode_akun' => $po->coa_budget, 
		// 		'status' => 'on']);
		// 	if ($query->num_rows() > 0) {
		// 		$status = true;
		// 	}
		// }
		$cek_total = 0;
		$arr_kode_akun = [];
		foreach ($query_po->result() as $po) {
			$arr_kode_akun[] = $po->coa_budget;
		}
		// $arr_kode_akun = array_unique($arr_kode_akun);
		// $cek_total = count($arr_kode_akun);
		// if($cek_total > 0){
		// 	$status = true;
		// }
		// foreach ($query_po->result() as $po) {
			switch ($level) {
				case 'sm':
					$query = $this->db_wuling
						->select("SUM(p_asm) AS p_asm")
						->from('budgetting_coa')
						->where_in('kode_akun', $arr_kode_akun)
						->where('status', 'on')
						->get();
					$row = $query->row();
					if(isset($row)){
						if($row->p_asm == 0){
							$status = true;
						}
					}
					break;
				case 'asm':
					$query = $this->db_wuling
						->select("SUM(p_gm) AS p_gm")
						->from('budgetting_coa')
						->where_in('kode_akun', $arr_kode_akun)
						->where('status', 'on')
						->get();
					$row = $query->row();
					if(isset($row)){
						if($row->p_gm == 0){
							$status = true;
						}
					}
					break;
			}
			// $query = $this->db_wuling->get_where('budgetting_coa', [
			// 	'kode_akun' => $po->coa_budget, 
			// 	'status' => 'on']);
			// if ($query->num_rows() > 0) {
			// 	$status = true;
			// }
		// }
		return $status;
	}
}

/* End of file Model_approval_pengajuan_biaya.php */
/* Location: ./wuling_finance/models/Model_approval_pengajuan_biaya.php */

