<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_tambah_planning_budget extends CI_Model
{

	public function __construct()
	{
		parent::__construct();		
		$this->username = $this->session->userdata('username');
	}

	public function get_kategori($kategori)
	{
		$query 	= $this->db_wuling
		->select('a.nama_akun')
		->from('akun a')
		->where('a.')
		->get();
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
			->where_in('b.status_approve',['n','r'])
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
			);
		}

		return $data;
	}

	public function select2_kategori() {				
		$data = array();
		$query = $this->db
			->select("id_akun,kode_akun,nama_akun")
			->from("db_wuling.akun a")
			->where('kode_akun' , "600000")
			->where('level', 0)
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
	
	public function select2_sub_kategori($kategori) {
		// dd($kategori);				
		$data = array();
		$query = $this->db
			->select("id_akun,kode_akun,nama_akun")
			->from("db_wuling.akun a")
			->where('kode_akun LIKE  "6%"')
			->where('level', 1)
			->where('kode_parent', $kategori)
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

	public function select2_coa_budget($sub_kategori) {
		$data = array();
		$query = $this->db
			->select("a.id_akun, a.kode_akun, a.nama_akun")
			->from("db_wuling.akun a")
			->join("db_wuling.budgetting_coa b","a.kode_akun=b.kode_akun")
			->where('a.kode_parent',$sub_kategori)
			->order_by("a.kode_akun")
			->get();
	
		foreach ($query->result() as $q) {
			$data[] = array(
				'id'   => $q->kode_akun,
				'text' => $q->nama_akun,
			);
		}        
	
		responseJson($data);
	}

	public function x_select2_coa_budget($sub_kategori) {
		$data = array();
	
		$filterValue = substr($sub_kategori, 0, 3);
	
		$hasLevel3 = $this->db
			->select("COUNT(*) as count")
			->from("db_wuling.akun a")
			->where('kode_akun LIKE  "6%"')
			->like('kode_parent', $filterValue, 'after')
			->where('level', 3)
			->get()
			->row()
			->count > 0;
	
		$query = $this->db
			->select("id_akun, kode_akun, nama_akun")
			->from("db_wuling.akun a")
			->where('kode_akun LIKE  "6%"')
			->like('kode_parent', $filterValue, 'after')
			->group_start()
				->where('level', $hasLevel3 ? 3 : 2) 
			->group_end()
			->order_by("kode_akun")
			->get();
	
		foreach ($query->result() as $q) {
			$data[] = array(
				'id'   => $q->kode_akun,
				'text' => $q->nama_akun,
			);
		}        
	
		responseJson($data);
	}

	public function tambah_planning($posts) {	
		$cabang	= $posts['cabang'];
		$kategori = $posts['kategori'];
		$sub_kategori = $posts['sub_kategori'];
		$coa_budget = $posts['coa_budget'];
		$nama = $posts['nama'];
		$set_biaya = $posts['set_biaya'];
		$jumlah = $posts['jumlah'];
		$tahun = $posts['tahun'];
		$bulan = $posts['bulan'];
		$data = array();

		$jumlah_tahun_lalu = $this->get_total_tahun_lalu(['cabang'=>$cabang, 'tahun'=>$tahun, 'coa_budget'=>$coa_budget])['total'];

		//cek coa_budget sudah dibuat atau belum
		$query_cek = $this->db_wuling
			->select("coa_budget")
			->from("budgetting")
			->where('id_perusahaan', $cabang)
			->where('coa_budget', $coa_budget)
			->where('tahun', $tahun)
			->where_in('status_approve',['n','r'])
			->get();

		if($query_cek->num_rows() > 0){
			$result = ['status' => false, 'pesan' => 'COA budget sudah dibuat, silahkan pilih COA budget yang berbeda'];
			return $result;
		}

		$currentTimestamp = date('Y-m-d H:i:s');

		$data 	= array(
			'id_perusahaan'	=> $cabang,
			'kategori'		=> $kategori,
			'sub_kategori'  => $sub_kategori,
			'coa_budget'	=> $coa_budget,
			'nama'	 		=> $nama,
			'set_biaya'		=> $set_biaya,
			'jumlah' 		=> $jumlah,
			'jumlah_tahun_lalu' => $jumlah_tahun_lalu,
			'tahun' 		=> $tahun,
			'januari'		=> $bulan['januari'],
			'februari'		=> $bulan['februari'],
			'maret'			=> $bulan['maret'],
			'april'			=> $bulan['april'],
			'mei'			=> $bulan['mei'],
			'juni'			=> $bulan['juni'],
			'juli'			=> $bulan['juli'],
			'agustus'		=> $bulan['agustus'],
			'september'		=> $bulan['september'],
			'september'		=> $bulan['september'],
			'oktober'		=> $bulan['oktober'],
			'november'		=> $bulan['november'],
			'desember'		=> $bulan['desember'],
			'created_at'	=> $currentTimestamp,
			'updated_at'	=> $currentTimestamp,
			'created_by' 	=> $this->username,
		);

		$this->db_wuling->trans_start();
		$this->db_wuling->insert("budgetting", $data);
		$this->db_wuling->trans_complete();

		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil tambah data planning';
			$nama 	= $nama;
		}
		$result = ['status' => $status, 'pesan' => $pesan, 'nama' => $nama];
		return $result;
	}

	public function get_total_tahun_lalu($posts)
	{
		$cabang = @$posts['cabang'];
		$tahun = @$posts['tahun'];
		$coa_budget = @$posts['coa_budget'];
		$max_budget = 0;

		//cek max budget kalau ada
		
		$query_max_budget = $this->db_wuling
			->select('b.max_budget')
			->from('budgetting_coa b')
			->where('b.kode_akun', $coa_budget)
			->get();
		$row_max_budget = $query_max_budget->row();
		if(isset($row_max_budget->max_budget) && $row_max_budget->max_budget !== null){
			$max_budget = $row_max_budget->max_budget;
		} 
		if($max_budget==0){
			$tahun_sebelum = $tahun - 1;
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
			$hasil = $data_total->row()->total !== null ? $data_total->row()->total : 0;
			return ['max_budget'=> 0, 'total' => $hasil];
		} else {
			return  ['max_budget'=> $max_budget, 'total' => $max_budget];
		}
	}


	function separator_harga($harga)
	{
		$format_number = number_format($harga, 0, ',', '.');
		return $format_number;
	}

	function remove_separator($harga)
	{
		return str_replace('.', '', $harga);
	}

	public function cek_coa_budget($coa_budget)
	{
		$query = $this->db_wuling
			->select("coa_budget")
			->from("budgetting")
			->where('coa_budget', $coa_budget)
			->where('status_approve','n')
			->get();
		if($query->num_rows() > 0){
			
		}
		return $query->row();
	}

}

/* End of file Model_tambah_planning_budget.php */
/* Location: ./wuling_finance/models/Model_tambah_planning_budget.php */

