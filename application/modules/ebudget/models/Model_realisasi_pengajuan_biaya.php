<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_realisasi_pengajuan_biaya extends CI_Model
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
		$tgl_awal = tgl_sql($gets['tgl_awal']);
		$tgl_akhir = tgl_sql($gets['tgl_akhir']);

		$query 	= $this->db_wuling
			->select('bo.*')
			->from('budgetting_po bo')
			// ->where('approval_sm',1)
			// ->where('approval_asm',1)
			// ->where('approval_gm',1)
			->where('bo.status',1)
			->where('bo.is_deleted','0')
			// ->where('bo.id_perusahaan', $id_perusahaan)
			->where('bo.tgl_po >=', $tgl_awal)
			->where('bo.tgl_po <=', $tgl_akhir)
			->order_by('bo.created_at','DESC')
			->get();
		
		foreach ($query->result() as $budget)	{		                        
			$data[] = array (		
				'id'			=> $budget->id,
				'no_po'			=> $budget->no_po,
				'tgl_po'		=> tgl_sql($budget->tgl_po),
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

	public function get_cetak($id)
	{
		$id_perusahaan = $this->session->userdata('id_perusahaan');
		$data 	= array();
		$query 	= $this->db_wuling
			->select('bp.*')
			->from('budgetting_po bp')
			->where('bp.id', $id)
			->where('bp.is_deleted', 0)
			->where('bp.status', 1)
			->get();
		$row = $query->row();
		if(isset($row)){
			$query_detail = $this->db_wuling
				->select('bp.*, a.nama_akun')
				->from('budgetting_pengajuan bp')
				->join('akun a','a.kode_akun=bp.coa_budget')
				->where('bp.no_po', $row->no_po)
				->where('bp.is_deleted', 0)
				->where('bp.status', 1)
				->get();
			foreach($query_detail->result() as $row_detail){
				$arr_detail[] = array (		
					'id'			=> $row_detail->id,
					'nama_akun'		=> $row_detail->nama_akun,
					'parent_akun'	=> $this->_get_parent_akun($row_detail->coa_budget),
					'qty'			=> $row_detail->qty,
					'pengajuan'		=> $row_detail->pengajuan,
					'total' 		=> separator_harga($row_detail->total),
					'keterangan' 	=> $row_detail->keterangan,
				);
			}
			$query_perusahaan = $this->db
				->select('p.*')
				->from('perusahaan p')
				->where('p.id_perusahaan', $id_perusahaan)
				->get();
			$row_perusahaan = $query_perusahaan->row();

			$query_dealer = $this->db_wuling_as
				->select('*')
				->from('api_dealer_code')
				->where('id_perusahaan', $id_perusahaan)
				->get();
			$row_dealer = $query_dealer->row();

			

			$data = [	
				'dealer' 		=> $row_dealer,
				'cabang'		=> $row_perusahaan,
				'id'			=> $row->id,
				'no_po'			=> $row->no_po,
				'tgl_po'		=> $row->tgl_po,
				'created_by'	=> $row->created_by,
				'grand_total'	=> separator_harga($row->total),
				'details' 		=> $arr_detail,
			];
		} 
		return $data;
	}

	private function _get_parent_akun($coa)
	{
		$parent_akun = 'akun-not-found';
		$query_parent = $this->db_wuling->select('kode_parent')->from('akun')->where('kode_akun',$coa)->get()->row('kode_parent');
		if(isset($query_parent)){
			$query_akun = $this->db_wuling->select('nama_akun')->from('akun')->where('kode_akun',$query_parent)->get()->row('nama_akun');
			$parent_akun = $query_akun;
		}
		return $parent_akun;
	}
}

/* End of file Model_realisasi_pengajuan_biaya.php */
/* Location: ./wuling_finance/models/Model_realisasi_pengajuan_biaya.php */

