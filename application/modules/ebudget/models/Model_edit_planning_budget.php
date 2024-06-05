<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_edit_planning_budget extends CI_Model
{

	public function __construct()
	{
		parent::__construct();		
	}

	public function get($posts)
	{
		$cabang = @$posts['cabang'];
		$tahun = @$posts['tahun'];
		if (!empty($cabang)) {
			$this->db_wuling->where('b.id_perusahaan', $cabang);
		}
		if (!empty($tahun)) {
			$this->db_wuling->where('b.tahun', $tahun);
		}
		$data 	= array();
		$query 	= $this->db_wuling
			->select('b.*, a.nama_akun as kategori, a2.nama_akun as sub_kategori, a3.nama_akun as coa_budget, p.lokasi ')
			->from('budgetting b')
			->join('kmg.perusahaan p','b.id_perusahaan=p.id_perusahaan')
			->join('akun a','a.kode_akun=b.kategori', 'left')
			->join('akun a2','a2.kode_akun=b.sub_kategori', 'left')	
			->join('akun a3','a3.kode_akun=b.coa_budget', 'left')	
			->where('p.id_brand', 5)	
			->where_in('b.status_approve', ['n','r'])
			->order_by('b.created_at DESC')
			->get();
		$no= 1;
		foreach ($query->result() as $budget)	{		                        
			$data[] = array (		
				'no'			=> $no++,	
				'id_budget'		=> $budget->id_budget,
				'cabang'		=> $budget->lokasi,
				'tahun'			=> $budget->tahun,
				'kategori' 		=> $budget->kategori,
				'sub_kategori'  => $budget->sub_kategori,
				'coa_budget'    => $budget->coa_budget,
				'nama'			=> $budget->nama,
				'biaya'			=> $budget->jumlah,
				'status_approve'=> $budget->status_approve,
			);
		}

		return $data;
	}

	public function get_total_tahun_lalu($posts)
	{
		$cabang = @$posts['cabang'];
		$tahun = @$posts['tahun'];
		$coa_budget = @$posts['coa_budget'];

		$tahun_sebelum = $tahun - 1;
		// dd($tahun_sebelum);
		if (!empty($cabang)) {
			$this->db_wuling->where('b.id_perusahaan', $cabang);
		}
		if (!empty($tahun)) {
			$start_date = $tahun_sebelum . '-01-01';
			$end_date = $tahun_sebelum . '-12-31';
			$this->db_wuling->where("b.tgl BETWEEN '$start_date' AND '$end_date'");
		}
		if (!empty($coa_budget)) {
			$this->db_wuling->where('b.kode_akun', $coa_budget);
		}
		$data_total 	= $this->db_wuling
			->select('SUM(b.jumlah) as total')
			->from('buku_besar b')
			->get();
	
		return $data_total->row()->total !== null ? $data_total->row()->total : 0;;
	}

}

/* End of file Model_daftar_planning_budget.php */
/* Location: ./wuling_finance/models/Model_daftar_planning_budget.php */

