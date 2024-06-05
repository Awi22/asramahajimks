<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\KMGDatatables;
use app\models\elo\sales\ModelAdmSales;
use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelHotProspek;
use app\models\elo\sales\ModelJadwalSales;
use app\models\elo\sales\ModelProspek;
use app\models\elo\sales\ModelSuspect;
use Illuminate\Database\Capsule\Manager as DB;


class Model_adm_sales extends CI_Model
{

	public function __construct()
	{
		$this->load->library('Send_Email');
	}

	//untuk kebutuhan select2
	public function select2_cabang($cabang)
	{
		$data = array();
		$query = $this->db
			->select("id_perusahaan,lokasi")->from("kmg.perusahaan")
			->where("id_brand", "5")->where_in("id_perusahaan", $cabang)
			->order_by("lokasi")->get();
		foreach ($query->result() as $q) {
			$data[] = array(
				'id'        => $q->id_perusahaan,
				'text'      => $q->lokasi,
			);
		}
		return $data;
	}

	//get semua data sales by cabang dan jenis sales
	public function get($gets)
	{
		$data = ModelAdmSales::whereStatusAktif('A');
		debug($data);
		$data 			= array();
		$jenis_sales 	= '';
		$id_perusahaan 	= '';

		if (!empty($gets)) {
			$jenis_sales  = $gets['jenis_sales'];
			$id_perusahaan = $gets['cabang'];
		}

		if (empty($id_perusahaan)) {
			$id_perusahaan 	= explode(',', $this->session->userdata('coverage'));
		}

		if (!empty($jenis_sales)) {
			$this->db->where('ads.jenis_sales', $jenis_sales);
		}

		$query = $this->db
			->select('ads.id_sales, ads.id_jabatan, ads.jenis_sales, ads.id_perusahaan, ads.kode_sales_sgmw, k.nik, k.nama_karyawan, j.nama_jabatan, p.lokasi')
			->from('db_wuling.adm_sales ads')
			->join('kmg.karyawan k', 'ads.id_sales = k.id_karyawan')
			->join('kmg.jabatan j', 'j.id_jabatan = ads.id_jabatan')
			->join('kmg.perusahaan p', 'p.id_perusahaan = ads.id_perusahaan')
			->where('ads.status_aktif', 'A')
			->where_in('ads.id_perusahaan', $id_perusahaan)
			->order_by('k.nama_karyawan, ads.id_perusahaan')
			->get();

		foreach ($query->result() as $sales) {
			$jenis_sales 	= '';
			switch ($sales->jenis_sales) {
				case 's':
					$jenis_sales 	= 'FORCE';
					break;
				case 'c':
					$jenis_sales 	= 'COUNTER';
					break;
				case 'f':
					$jenis_sales 	= 'FLEET';
					break;
			}
			$data[] = array(
				'id_sales'        => $sales->id_sales,
				'nik'             => $sales->nik,
				'kode_sales_sgmw' => $sales->kode_sales_sgmw,
				'nama'            => strtoupper($sales->nama_karyawan),
				'jenis_sales'     => $jenis_sales,
				'jabatan'         => strtoupper($sales->nama_jabatan),
				'cabang'          => strtoupper($sales->lokasi),
			);
		}
		return $data;
	}

	//get semua data sales by cabang dan jenis sales
	public function get_serverside($gets)
	{
		
		$data 			= array();
		$jenis_sales 	= '';
		// $id_perusahaan 	= '2';

		if (!empty($gets)) {
			$jenis_sales  = $gets['jenis_sales'];
			$id_perusahaan = $gets['cabang'];
		}

		if (empty($id_perusahaan)) {
			$id_perusahaan 	= explode(',', $this->session->userdata('coverage'));
		}

		if (!empty($jenis_sales)) {
			// $this->db->where('ads.jenis_sales', $jenis_sales);
			$data = $data->whereJenis_sales($jenis_sales);
		}

		// $data = ModelAdmSales::where('status_aktif','=','A')->get()->toArray();
		// $data = ModelAdmSales::query("SELECT * FROM db_wuling.adm_sales WHERE status_aktif='A' ")->toSql();
		// ->with(['toKaryawan','toJabatan','toPerusahaan'])
			
			// ->limit(5)->toSql()
			// ->where('status_aktif','=','A')
			// ->whereIn("id_perusahaan", $id_perusahaan);;
		// $sql = ModelAdmSales::getQueryWithBindings($data);


		// dd($data);
		$data = $this->db
			->select('ads.id_sales, ads.id_jabatan, ads.jenis_sales, ads.id_perusahaan, ads.kode_sales_sgmw, k.nik, k.nama_karyawan AS nama, j.nama_jabatan AS jabatan, p.lokasi AS cabang')
			->from('db_wuling.adm_sales ads')
			->join('kmg.karyawan k', 'ads.id_sales = k.id_karyawan')
			->join('kmg.jabatan j', 'j.id_jabatan = ads.id_jabatan')
			->join('kmg.perusahaan p', 'p.id_perusahaan = ads.id_perusahaan')
			->where('ads.status_aktif', 'A')
			->where_in('ads.id_perusahaan', $id_perusahaan);

		// dd($query->get()->result());

		$datatables = new KMGDatatables($data);
		$datatables->asObject()->generate(); // done
	}

	public function get_serversisde($gets)
	{
		$datatable = new Datatable;

		$data 			= array();
		$jenis_sales 	= '';
		$id_perusahaan 	= '';

		if (!empty($gets)) {
			$jenis_sales  = $gets['jenis_sales'];
			$id_perusahaan = $gets['cabang'];
		}

		if (empty($id_perusahaan)) {
			$id_perusahaan 	= explode(',', $this->session->userdata('coverage'));
		}

		if (!empty($jenis_sales)) {
			$this->db->where('ads.jenis_sales', $jenis_sales);
		}

		//* query utama *//
		$datatable->query = $this->db
			->select('ads.id_sales, ads.id_jabatan, ads.jenis_sales, ads.id_perusahaan, ads.kode_sales_sgmw, k.nik, k.nama_karyawan AS nama, j.nama_jabatan AS jabatan, p.lokasi AS cabang')
			->from('db_wuling.adm_sales ads')
			->join('kmg.karyawan k', 'ads.id_sales = k.id_karyawan')
			->join('kmg.jabatan j', 'j.id_jabatan = ads.id_jabatan')
			->join('kmg.perusahaan p', 'p.id_perusahaan = ads.id_perusahaan')
			->where('ads.status_aktif', 'A')
			->where_in('ads.id_perusahaan', $id_perusahaan);
	

		//* untuk filtering */		
		$datatable->setColumns(
			"s.no_spk",
			"DATE_FORMAT(s.tgl_spk,'%d-%m-%Y')",
			"c.nama",
			"CONCAT((SELECT nama_karyawan FROM kmg.karyawan WHERE id_karyawan=c.sales),ats.nama_team)",
			"DATEDIFF(CURDATE(),s.tgl_spk)",
			"c.cara_bayar",
			null,
			"s.no_rangka",
			"s.keterangan"
		);

		//* untuk ordering by, kalo ndak dipake jangan dipanggil, komen saja
		$datatable->orderBy('s.no_spk ASC');

		//* output result datatable  
		//* sudah format datatable_serverside
		//* untuk langsung ke format json, gunakan getJson(); untuk langsung parsing ke view
		$raw = $datatable->get();

		//* untuk customisasi array */
		//* datanya dibentuk ulang, terserah berapa field
		//* pastikan untuk menyesuaikan dengan filtering setColumn
		$recordsData = [];
		foreach ($raw['data'] as $key => $value) {
			$recordsData[] = [
				'no_spk'        		=> $value->no_spk,
				'tgl_spk' 				=> tgl_sql($value->tgl_spk),
				'nama_customer'      	=> $value->nama_customer,
				//'nama_sales'  			=> $this->model_data->get_nama_karyawan($value->sales),
				//'nama_spv' 				=> $value->nama_team,
				'supervisor_sales' 		=> $value->nama_team . ' - ' . strtoupper($this->model_data->get_nama_karyawan($value->sales)),
				'umur_spk' 				=> $value->umur_spk,
				'cara_bayar' 			=> $value->cara_bayar,
				'total_bayar' 			=> $this->status_tanda_jadi($value->no_spk, $id_perusahaan),
				//'status' 				=> ($value->spk?'''sst',//$value->status,
				'no_rangka' 			=> $value->no_rangka,
				'keterangan' 			=> $value->keterangan,
				'id_spk_sgmw' 			=> $value->spk_id
			];
		}

		//* buat ulang response datatable_serverside
		$response = [
			'draw'            => $raw['draw'],
			'recordsTotal'    => $raw['recordsTotal'],
			'recordsFiltered' => $raw['recordsFiltered'],
			'data'            => $recordsData
		];
		//return responseJson($response);	
		return $response;
	}

	//update data sales dari HRD
	public function download()
	{
		$status 	= false;
		$pesan 		= 'Gagal download data';
		$this->db_wuling->trans_start();
		// $this->db_wuling->query("INSERT INTO adm_sales (id_sales,id_jabatan,id_perusahaan,username,password) SELECT id_karyawan,id_jabatan,id_perusahaan,CONCAT('WS',nik),MD5(CONCAT('WS',nik)) FROM kmg.karyawan k WHERE k.id_brand='5' AND k.id_divisi='1' AND k.status_aktif='Aktif' ON DUPLICATE KEY UPDATE id_perusahaan=k.id_perusahaan,id_jabatan=k.id_jabatan");
		//select semua sales
		$all_sales = $this->db->query("SELECT k.id_karyawan, k.id_jabatan, k.id_perusahaan, k.nama_karyawan, k.email, CONCAT('WS',k.nik) AS username, MD5(CONCAT('WS',k.nik)) AS password FROM kmg.karyawan AS k WHERE k.id_brand='5' AND k.id_divisi='1' AND k.status_aktif='Aktif'");
		
		foreach($all_sales->result() as $sales) {
			$cek_sales = $this->db_wuling->select('id_sales')->from('adm_sales')->where('id_sales',$sales->id_karyawan)->get()->row();
			if(isset($cek_sales->id_sales)){
				$data = [
					'id_perusahaan' => $sales->id_perusahaan,
					'id_jabatan' => $sales->id_jabatan,
				];
				$this->db_wuling->update('adm_sales', $data, ['id_sales'=>$sales->id_karyawan]);
				//update juga supervisornya
				$this->db_wuling->query("UPDATE adm_team_supervisor AS ats
					JOIN kmg.karyawan AS k ON k.id_karyawan=ats.id_supervisor
					SET ats.id_perusahaan=k.id_perusahaan 
					WHERE k.id_perusahaan != ats.id_perusahaan");
			} else {
				$data = [
					'id_sales' => $sales->id_karyawan,
					'id_jabatan' => $sales->id_jabatan,
					'id_perusahaan' => $sales->id_perusahaan, 
					'username' => $sales->username, 
					'password' => $sales->password,
				];
				$nama 	= $sales->nama_karyawan;
				$email 	= $sales->email;
				$data_email = [
					'nama_lengkap' => $nama, 
					'username' => $sales->username, 
					'password' => $sales->username,
				];
				$this->db_wuling->insert('adm_sales', $data, ['id_sales'=>$sales->id_karyawan]);
				if (!empty($email)) {
					$sukses_kirim_email = $this->send_email->send('password_confirmation', 'DMS Wuling', $email, 'Informasi Login DMS Wuling Kumala', $data_email);
					if ($sukses_kirim_email) {
						$pesan = "Berhasil membuat user dan mengirim ke email";
					}
				}
			}
		}

		$this->db_wuling->trans_complete();
		if ($this->db_wuling->trans_status() === true) {
			$status = true;
			$pesan 	= 'Berhasil download data';
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	//get single data sm dan coveragenya berdasarkan id untuk kebutuhan edit dan datatable coverage
	public function get_data_sales_by_id($gets)
	{
		$data = null;
		if (!empty($gets)) {
			$id_sales	= $gets['id_sales'];
			$query_sales = $this->db
				->select('ads.id_sales, ads.username, ads.status_leader, ads.jenis_sales, ads.status_aktif, ads.kode_sales_sgmw, k.nik, k.nama_karyawan, ads.id_jabatan, ads.id_perusahaan, j.nama_jabatan')
				->from('db_wuling.adm_sales ads')
				->join('kmg.karyawan k', 'k.id_karyawan = ads.id_sales')
				->join('kmg.jabatan j', 'j.id_jabatan = ads.id_jabatan')
				->where('ads.id_sales', $id_sales)
				->get();
			if ($query_sales->num_rows() > 0) {
				$sales = $query_sales->row();
				$data = [
					'id_sales'        => $sales->id_sales,
					'nik'             => $sales->nik,
					'kode_sales_sgmw' => $sales->kode_sales_sgmw,
					'nama'            => strtoupper($sales->nama_karyawan),
					'jabatan'         => strtoupper($sales->nama_jabatan),
					'username'        => $sales->username,
					'status_leader'   => $sales->status_leader,
					'jenis_sales'     => $sales->jenis_sales,
					'status_aktif'    => $sales->status_aktif,
				];
			}
		}
		return $data;
	}

	//update data sales
	public function update_sales($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal simpan data';
		if (!empty($posts)) {
			$id_sales      = $posts['id_sales'];
			$status_aktif  = $posts['status_aktif'];
			$status_leader = $posts['status_leader'];
			$jenis_sales   = $posts['jenis_sales'];
			$kode_sgmw     = $posts['kode_sgmw'];

			if (!empty($id_sales) && !empty($status_aktif) && !empty($status_leader) && !empty($jenis_sales)) {
				if ($status_aktif == 'R') {
					$cek_survei_do = $this->_cek_survei_do($id_sales);
					if ($cek_survei_do) {
						$result = ['status' => $status, 'pesan' => 'Belum selesai Survei DO !'];
						return $result;
					}
				}
				$cek_team_aktif = $this->_cek_team_aktif($id_sales);
				if (!$cek_team_aktif) {
					$result = ['status' => $status, 'pesan' => 'Masih terdapat anggota dalam team SPV/SM !'];
					return $result;
				}
				$data = array(
					'status_aktif'    => $status_aktif,
					'status_leader'   => $status_leader,
					'jenis_sales'     => $jenis_sales,
					'kode_sales_sgmw' => $kode_sgmw,
				);
				$this->db_wuling->trans_start();
				$this->db_wuling->update("adm_sales", $data, ['id_sales' => $id_sales]); //update adm_sales
				$this->db_wuling->trans_complete();
				if ($this->db_wuling->trans_status() === true) {
					$status = true;
					$pesan 	= 'Berhasil simpan data';
				}
			}
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	//reset password
	public function reset_password($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal reset password';
		if (!empty($posts)) {
			$id_sales 	= $posts['id_sales'];
			$username 	= $posts['username'];

			if (!empty($id_sales) && !empty($username)) {
				$data = array(
					'password' 	=> md5($username),
					'password_hash' => password_hash($username, PASSWORD_DEFAULT),
				);
				$this->db_wuling->trans_start();
				$this->db_wuling->update("adm_sales", $data, ['id_sales' => $id_sales]); //reset password
				$this->db_wuling->trans_complete();
				if ($this->db_wuling->trans_status() === true) {
					$status = true;
					$pesan 	= 'Berhasil reset password';

					$karyawan = $this->db->select('nik, nama_karyawan, id_jabatan, file_foto, email')->from('karyawan')->where('id_karyawan', $id_sales)->get()->row();
					if(isset($karyawan)){
						$nama 	= $karyawan->nama_karyawan;
						$email 	= $karyawan->email;
						$data_email = [
							'nama_lengkap' => $nama, 
							'username' => $username, 
							'password' => $username,
						];
						if (!empty($email)) {
							$sukses_kirim_email = $this->send_email->send('password_confirmation', 'DMS Wuling', $email, 'Informasi Login DMS Wuling Kumala', $data_email);
							if ($sukses_kirim_email) {
								$pesan = "Berhasil membuat reset sales dan mengirim ke email ".$email;
							}
						}	
					}
				}
			}
		}
		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	private function _cek_team_aktif($id_sales)
	{
		$hasil = false;
		$id_jabatan = $this->db_wuling->get_where('adm_sales', ['id_sales' => $id_sales])->row('id_jabatan');
		switch ($id_jabatan) {
			case '22': //Sales
				$hasil = true;
				break;
			case '21': //SPV
				$id_team_spv 	= $this->db_wuling->get_where('adm_team_supervisor', ['id_supervisor' => $id_sales])->row('id_team_supervisor');
				$cek_team_spv 	= $this->db_wuling->get_where('adm_sales', ['id_leader' => $id_team_spv, 'status_aktif' => 'A'])->num_rows();
				if ($cek_team_spv == 0) {
					$hasil = true;
				}
				break;
			case '67': //SM
				$id_team_sm 	= $this->db_wuling->get_where('adm_team_sm', ['id_sm' => $id_sales])->row('id_team_sm');
				$cek_team_sm 	= $this->db_wuling
					->select('ads.id_sales')
					->from('adm_team_supervisor ats')
					->join('adm_sales ads', 'ads.id_sales=ats.id_supervisor')
					->where('ats.id_team_sm', $id_team_sm)
					->where('ads.status_aktif', 'A')
					->get()
					->num_rows();
				if ($cek_team_sm == 0) {
					$hasil = true;
				}
				break;
			case '175': //ASM
				$id_team_asm 	= $this->db_wuling->get_where('adm_team_asm', ['id_asm' => $id_sales])->row('id_team_asm');
				$cek_team_asm 	= $this->db_wuling
					->select('ads.id_sales')
					->from('adm_team_sm ats')
					->join('adm_sales ads', 'ads.id_sales=ats.id_sm')
					->where('asm.id_team_asm', $id_team_asm)
					->where('ads.status_aktif', 'A')
					->get()
					->num_rows();
				// $cek_team_asm 	= $this->db_wuling->get_where('adm_team_sm', ['id_team_asm' => $id_team_asm, 'status_aktif'=>'A'])->num_rows();
				if ($cek_team_asm == 0) {
					$hasil = true;
				}
				break;
			case '218': //Fleet Account Manager
				$hasil = true;
				break;
			case '24': //Sales Counter
				$hasil = true;
				break;
			default:
				# code...
				die('ID Jabatan tidak ditemukan !!!!');
				break;
		}

		return $hasil;
	}

	private function _cek_survei_do($id_sales)
	{
		$hasil = false;
		$cekSurveiDO = $this->db_wuling
			->select('COUNT(c.status) AS total')
			->from('s_customer c')
			->join('s_spk s', 's.id_prospek=c.id_prospek', 'left')
			->join('s_prospek p', 'p.id_prospek=c.id_prospek')
			->group_start()
			->where('status_survei', 0)
			->or_where('status_survei', null)
			->group_end()
			->where('c.sales', $id_sales)
			->where('c.status', 'do')
			->where('s.batal', 'n')
			->get()
			->row();
		if (isset($cekSurveiDO)) {
			if ($cekSurveiDO->total > 0) {
				$hasil = true;
			}
		}
		return $hasil;
	}
}

/* End of file Model_adm_sales.php */
/* Location: ./wuling_admin_sales/models/Model_adm_sales.php */
