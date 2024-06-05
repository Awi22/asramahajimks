<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_daftar_pengajuan_biaya extends CI_Model
{

	public function __construct()
	{
		parent::__construct();		
	}

	public function get_kategori($kategori)
	{
		$query 	= $this->db_wuling
		->select('a.nama_akun')
		->from('akun a')
		->where('a.')
		->get();
	}

	public function get($gets)
	{
		$data 	= array();
		if(!empty($gets['status'])){
			$status = $gets['status'];
			switch ($status) {
				case '0':
					$this->db_wuling->where('bo.status', $status);
					break;
				case '1':
					$this->db_wuling->where('bo.status', $status);
					break;
				case '2':
					$this->db_wuling->where('bo.status', $status);
					break;
				default:
					# code...
					break;
			}
		}
		if(!empty($gets['cabang'])){
			$cabang = $gets['cabang'];
			$this->db_wuling->where('bo.id_perusahaan', $cabang);
		};
		
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
				'alasan' 		=> $budget->alasan,
				'status' 		=> $budget->status,
			);
		}

		return $data;
	}


	public function get_budget_po_by_id($id)
	{
		$data 	= array();
		$query_no_po = $this->db_wuling->select('no_po, tgl_po')->from('budgetting_po')->where('id', $id)->get();
		$po = $query_no_po->row();
		if(isset($po)){
			$query 	= $this->db_wuling
				->select('bp.*, a.nama_akun')
				->from('budgetting_pengajuan bp')
				->join('akun a','a.kode_akun=bp.coa_budget', 'left')
				->where('bp.no_po', $po->no_po)
				->where('bp.is_deleted', 0)
				->order_by('bp.created_at','DESC')
				->get();
			
			foreach ($query->result() as $budget)	{		                        
				$data[] = array (		
					'id'			=> $budget->id,
					'coa'			=> $budget->nama_akun,
					'qty'			=> $budget->qty,
					'pengajuan'		=> $budget->pengajuan,
					'total' 		=> $budget->total,
					'keterangan' 	=> $budget->keterangan,
					'status' 		=> $budget->status,
				);
			}

		}
		return ['aaData'=>$data, 'no_po'=>$po->no_po, 'tgl_po' => tgl_sql($po->tgl_po)];
	}

	public function update_po_budget($posts)
	{
		$status = false;
		$pesan = 'Gagal menyimpan pengajuan biaya';

		$cabang = $this->session->userdata('id_perusahaan');
		$no_po	= $posts['no_po'];
		$tgl_po = tgl_sql($posts['tgl_po']);
		$total 	= remove_separator($posts['total_budget']);

		$this->db_wuling->trans_start();
		$data 	= array(
			'total'			=> $total,
			'updated_by' 	=> $this->session->userdata('username'),
		);
		//update budgetting_pengajuan
		$this->db_wuling->where('no_po', $no_po);
		$this->db_wuling->update("budgetting_po", $data);

		$this->db_wuling->trans_complete();

		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil update pengajuan biaya';
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function reset_status_by_id($id)
	{
		$status = false;
		$pesan = 'Gagal mereset status';

		$this->db_wuling->trans_start();
		$data 	= array(
			'approval_sm'	=> 0,
			'tgl_approve_sm' => NULL,
			'approval_asm' 	=> 0,
			'tgl_approve_asm' => NULL,
			'approval_gm' 	=> 0,
			'tgl_approve_gm' => NULL,
			'alasan'		=> '',
			'updated_by' 	=> $this->session->userdata('username'),
		);
		//reset status
		$this->db_wuling->where('id', $id);
		$this->db_wuling->update("budgetting_po", $data);
		$this->db_wuling->trans_complete();

		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil mereset status';
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function hapus_by_id($id)
	{
		$status = false;
		$pesan = 'Gagal menghapus status';

		$this->db_wuling->trans_start();
		$data 	= array(
			'is_deleted'	=> 1,
			'deleted_at' 	=> date('Y-m-d H:i:s'),
			'deleted_by' 	=> $this->session->userdata('username'),
		);
		//reset status
		$this->db_wuling->where('id', $id);
		$this->db_wuling->update("budgetting_po", $data);
		$this->db_wuling->trans_complete();

		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil menghapus data';
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}
	
}

/* End of file Model_daftar_pengajuan_biaya.php */
/* Location: ./wuling_finance/models/Model_daftar_pengajuan_biaya.php */

