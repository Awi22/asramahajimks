<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_approve_planning_budget extends CI_Model
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
			->where('b.status_approve', "n")	
			->order_by('b.created_at DESC')
			->get();
		$no = 1;
		foreach ($query->result() as $budget)	{	
			//hitung over budgget
			$status_over = false;
			$persen_selisih =  $budget->jumlah_tahun_lalu * 1.1;  //10% selisih
			$selisih = ($budget->jumlah - $persen_selisih) ;

			if($selisih>0){
				$status_over = true;
			}
			if($budget->jumlah_tahun_lalu==0){
				$status_over = false;
			}
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
				'biaya_tahun_lalu'	=> $budget->jumlah_tahun_lalu,
				'status_over' 	=> $status_over,
				'status_approve'=> $budget->status_approve,
			);
		}

		return $data;
	}

	public function approve_data($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal approve planning budget';

		if (!empty($posts)) {
			$id_budget = $posts['id_budget'];
			$this->db_wuling->trans_start();
			$this->db_wuling->update("budgetting",['status_approve' => "y"] , ['id_budget' => $id_budget]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil approve planning budget';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function reject_data($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal approve planning budget';

		if (!empty($posts)) {
			$id_budget = $posts['id_budget'];
			$this->db_wuling->trans_start();
			$this->db_wuling->update("budgetting",['status_approve' => "r"] , ['id_budget' => $id_budget]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil approve planning budget';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

}

/* End of file Model_daftar_planning_budget.php */
/* Location: ./wuling_finance/models/Model_daftar_planning_budget.php */

