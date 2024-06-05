<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_tambah_pengajuan_biaya extends CI_Model
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

	public function get($cabang)
	{
		$data 	= array();
		$query 	= $this->db_wuling
			->select('bp.*, a.nama_akun')
			->from('budgetting_pengajuan bp')
			->join('akun a','a.kode_akun=bp.coa_budget', 'left')
			->where('bp.status', 0)
			->where('bp.is_deleted', 0)
			->where('bp.id_perusahaan', $cabang)
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

		return $data;
	}

	public function generate_no_po($id_perusahaan)
	{
		// $id_perusahaan 	= $this->session->userdata('id_perusahaan');
		$perusahaan     = $this->db->get_where("perusahaan", "id_perusahaan = '$id_perusahaan'")->row();
		$arrBulan    	= array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
		$bulan          = $arrBulan[date('n')];
		$tahun          = date("Y");
		$str_kode 		= 'PO/BUDGET/' . $perusahaan->singkat . '-' . $perusahaan->kode_perusahaan . '/'  . $bulan . '/' . $tahun . '/';
		$last_num 		= 0;
		//cek last_kode 		
		$cek_last_kode = $this->db_wuling->query("SELECT MAX(SUBSTR(no_po,-4,4)) AS 'last' FROM budgetting_po 
				WHERE SUBSTR(no_po, 1, LENGTH(no_po)-LENGTH(SUBSTR(no_po,-4,4))) = '$str_kode'");
		if ($cek_last_kode->num_rows() > 0) {
			$last_num = $cek_last_kode->row('last') + 1;
		}
		$str_num 	= str_pad($last_num, 4, "0", STR_PAD_LEFT);
		$kode 		= $str_kode . $str_num;
		return $kode;
	}

	public function get_pengajuan_biaya_by_id($id)
	{
		$data 	= new stdClass();
		$query 	= $this->db_wuling
			->select('bp.*, a.nama_akun')
			->from('budgetting_pengajuan bp')
			->join('akun a','a.kode_akun=bp.coa_budget', 'left')
			->where('bp.id', $id)
			->get();
		$row = $query->row();
		if(isset($row)) {
			$data = array (		
				'id'			=> $row->id,
				'cabang' 		=> $row->id_perusahaan,
				'coa_budget'	=> $row->coa_budget,
				'qty'			=> $row->qty,
				'pengajuan'		=> $row->pengajuan,
				'total' 		=> $row->total,
				'keterangan' 	=> $row->keterangan,
				'status' 		=> $row->status,
				'diajukan_oleh'	=> $row->diajukan_oleh,
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

	public function select2_coa_budget($id_perusahaan) {
		// $id_perusahaan = $this->session->userdata('id_perusahaan');
		$data = [];

		$query = $this->db_wuling
			->select("b.coa_budget, kode_akun, nama_akun")
			->from("budgetting b")
			->join("akun a",'a.kode_akun=b.coa_budget')
			->where('b.id_perusahaan', $id_perusahaan)
			->where('b.tahun', date('Y'))
			->where('b.status_approve','y')
			->get();
	
		foreach ($query->result() as $q) {
			$data[] = [
				'id'   => $q->kode_akun,
				'text' => $q->nama_akun,
			];
		}        
	
		return $data;
	}

	public function get_planning_budget_from_coa($gets)
	{
		$data = null;
		if(!empty($gets['coa_budget']) && !empty($gets['cabang'])) {
			$id_perusahaan = $gets['cabang'];
			$coa_budget = $gets['coa_budget'];
			$query = $this->db_wuling
				->select("b.*")
				->from("budgetting b")
				->where('b.coa_budget', $coa_budget)
				->where('b.id_perusahaan', $id_perusahaan)
				->get();
			$row = $query->row();
			if(isset($row)){
				$bulan_now = strtolower(getBulan(date('m')));
				$budget_bulanan = [
					'januari' => $row->januari,
					'februari' => $row->februari,
					'maret' => $row->maret,
					'april' => $row->april,
					'mei' => $row->mei,
					'juni' => $row->juni,
					'juli' => $row->juli,
					'agustus' => $row->agustus,
					'september' => $row->september,
					'oktober' => $row->oktober,
					'november' => $row->november,
					'desember' => $row->desember
				];

				//hitung budget yang sudah diapprove by month and by year
				$query_approved_bulan = $this->db_wuling
					->select("SUM(b.total) AS approved")
					->from("budgetting_pengajuan b")
					->join("budgetting_po p", "p.no_po = b.no_po")
					->where('b.coa_budget', $coa_budget)
					->where('b.id_perusahaan', $id_perusahaan)
					->where('b.status', '1')
					->where('b.is_deleted', '0')
					->where('p.status', '1')
					->where('YEAR(p.approved_at)',date('Y'))
					->where('MONTH(p.approved_at)',date('m'))
					->get();
				$row_approved_bulan = $query_approved_bulan->row();
				$approved_bulan = isset($row_approved_bulan->approved) ? $row_approved_bulan->approved : 0;
				
				$query_approved_tahun = $this->db_wuling
					->select("SUM(b.total) AS approved")
					->from("budgetting_pengajuan b")
					->join("budgetting_po p", "p.no_po = b.no_po")
					->where('b.coa_budget', $coa_budget)
					->where('b.id_perusahaan', $id_perusahaan)
					->where('b.status', '1')
					->where('b.is_deleted', '0')
					->where('p.status', '1')
					->where('YEAR(p.approved_at)',date('Y'))
					->get();
				$row_approved_tahun = $query_approved_tahun->row();
				$approved_tahun = isset($row_approved_tahun->approved) ? $row_approved_tahun->approved : 0;
				$data = [
					'budget_tahun' => $row->jumlah - $approved_tahun,
					'budget_bulan' => $budget_bulanan[$bulan_now] - $approved_bulan,
				];
			}
			
		}
		return $data;
	}

	public function simpan($posts) {
		$status = false;
		$pesan = 'Gagal menyimpan pengajuan biaya';

		// $cabang = $this->session->userdata('id_perusahaan');
		$cabang = $posts['cabang'];
		$diajukan_oleh	= $posts['diajukan_oleh'];
		$coa_budget = $posts['coa_budget'];
		$qty = $posts['qty'];
		$pengajuan = remove_separator($posts['pengajuan']);
		$total = remove_separator($posts['total']);
		$keterangan = $posts['keterangan'];

		$this->db_wuling->trans_start();
		$data 	= array(
			'id_budget'		=> 0, 			
			'id_perusahaan'	=> $cabang,
			'coa_budget'	=> $coa_budget,
			'qty' 			=> $qty,
			'pengajuan'	 	=> $pengajuan,
			'total'			=> $total,
			'keterangan' 	=> $keterangan,
			'created_by' 	=> $this->session->userdata('username'),
			'diajukan_oleh'	=> $diajukan_oleh,
		);
		if(isset($posts['id'])) {
			$this->db_wuling->where('id', $posts['id']);
			$this->db_wuling->update("budgetting_pengajuan", $data);
		} else {
			$this->db_wuling->insert("budgetting_pengajuan", $data);
		}
		$this->db_wuling->trans_complete();

		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil tambah pengajuan biaya';
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
			
	}

	public function simpan_po_budget($posts)
	{
		$status = false;
		$pesan = 'Gagal menyimpan pengajuan biaya';

		// $cabang = $this->session->userdata('id_perusahaan');
		$cabang = $posts['cabang'];
		$no_po	= $posts['no_po'];
		$tgl_po = tgl_sql($posts['tgl_po']);
		$total 	= remove_separator($posts['total_budget']);

		$this->db_wuling->trans_start();
		$data 	= array(
			'id_perusahaan'	=> $cabang,
			'no_po'			=> $no_po,
			'tgl_po' 		=> $tgl_po,
			'total'			=> $total,
			'created_by' 	=> $this->session->userdata('username'),
		);
		//update budgetting_pengajuan
		$this->db_wuling->where('id_perusahaan', $cabang);
		$this->db_wuling->where('status', 0);
		$this->db_wuling->update("budgetting_pengajuan", ['no_po'=>$no_po, 'status'=> 1]);

		$this->db_wuling->insert("budgetting_po", $data);
	
		$this->db_wuling->trans_complete();

		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil tambah pengajuan biaya';
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function hapus($id)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus pengajuan biaya';

		if (!empty($id)) {
			$this->db_wuling->trans_start();

			$this->db_wuling->where('id', $id);
			$this->db_wuling->update('budgetting_pengajuan', ['is_deleted'=>1]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menghapus pengajuan biaya';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}
}

/* End of file Model_tambah_pengajuan_biaya.php */
/* Location: ./wuling_finance/models/Model_tambah_pengajuan_biaya.php */

