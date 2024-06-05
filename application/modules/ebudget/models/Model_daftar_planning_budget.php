<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_daftar_planning_budget extends CI_Model
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
			// ->where_in('b.status_approve', ['n', 'y'])
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

	public function get_data_by_id($id)
	{
		$budget 	= NULL;

		if (!empty($id)) {
			$query 	= $this->db_wuling
			->select('b.*')
			->from('budgetting b')
			->where('b.id_budget', $id)	
			->get();
			$budget = $query->row();
		}

		return [ 'data_budget' => $budget];
	}

	public function update_data_planning($posts) {	
		$id_budget = $posts['id_budget'];
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

		$currentTimestamp = date('Y-m-d H:i:s');

		$jumlah_tahun_lalu = $this->get_total_tahun_lalu(['cabang'=>$cabang, 'tahun'=>$tahun, 'coa_budget'=>$coa_budget]);


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
			'oktober'		=> $bulan['oktober'],
			'november'		=> $bulan['november'],
			'desember'		=> $bulan['desember'],
			'created_at'	=> $currentTimestamp,
			'updated_at'	=> $currentTimestamp,
		);

		$this->db_wuling->trans_start();
		$this->db_wuling->update("budgetting", $data,  ['id_budget' => $id_budget]);
		$this->db_wuling->trans_complete();

		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil update data planning';
			$nama 	= $nama;
		}
		$result = ['status' => $status, 'pesan' => $pesan, 'nama' => $nama];
		return $result;
			
	}

	public function hapus_data($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus data';

		if (!empty($posts)) {
			$id_budget = $posts['id_budget'];
			$this->db_wuling->trans_start();
			$this->db_wuling->delete("budgetting", ['id_budget' => $id_budget]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menghapus data';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function get_eksport($posts)
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
			->order_by('b.created_at DESC')
			->get();
		$no= 1;
		foreach ($query->result() as $budget)	{
			$status_approve = $budget->status_approve;
			$teks_approve = "";
			if ($status_approve === "n"){
				$teks_approve = " Belum Approve";
			} else if ($status_approve === "y"){
				$teks_approve = "Approved";
			} else if($status_approve === "b") {
				$teks_approve = "Batal";
			} else {
				$teks_approve = "";
			}
			$data[] = array (		
				// 'no'			=> $no++,	
				// 'id_budget'		=> $budget->id_budget,
				'cabang'		=> $budget->lokasi,
				'tahun'			=> $budget->tahun,
				'kategori' 		=> $budget->kategori,
				'sub_kategori'  => $budget->sub_kategori,
				'coa_budget'    => $budget->coa_budget,
				'nama'			=> $budget->nama,
				'biaya'			=> $budget->jumlah,
				'januari'		=> $budget->januari,
				'februari'		=> $budget->februari,
				'maret'			=> $budget->maret,
				'april'			=> $budget->april,
				'mei'			=> $budget->mei,
				'juni'			=> $budget->juni,
				'juli'			=> $budget->juli,
				'agustus'		=> $budget->agustus,
				'september'		=> $budget->september,
				'oktober'		=> $budget->oktober,
				'november'		=> $budget->november,
				'desember'		=> $budget->desember,
				'status_approve'=> $teks_approve
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

