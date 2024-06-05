<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_auth extends CI_Model
{

	/**
	 * Fungsi untuk verifikasi login user berdasarkan username dan password, 
	 * dengan me-return status, pesan dan url redirectnya
	 * @param string  	$username   	usernamenya
	 * @param string  	$password   	passwordnya
	 * @return array
	 */
	public function verify_login($username, $password)
	{
		$query  = $this->db_wuling->get_where('users', ['username' => $username]);
		$pesan 	= 'Unknown Error';
		$status = false;
		$url 	= 'auth';

		if ($query->num_rows() > 0) { //user found
			$user 	= $query->row();
			if ($user->status_aktif == 'on') { //user aktif
				if (password_verify($password, $user->password_hash) || md5($password) == $user->password) {
					$url = $this->set_login($user);
					$status = true;
					$pesan = 'Login berhasil';
				} else {
					$pesan = 'Username/Password yang anda masukkan salah, silahkan hubungi Administrator!';
				}
			} else {
				$pesan = 'Maaf, Akun anda tidak aktif!';
			}
		} else {
			//user not found
			//coba cek di sales
			$query_sales = $this->db_wuling->get_where('adm_sales', ['username' => $username]);
			if ($query_sales->num_rows() > 0) { //sales found
				$sales 	= $query_sales->row();
				if ($sales->status_aktif == 'A') { //user aktif
					if (password_verify($password, $sales->password_hash) || md5($password) == $sales->password) {
						$url = $this->set_login_sales($sales);
						$status = true;
						$pesan = 'Login berhasil';
					} else {
						$pesan = 'Username/Password yang anda masukkan salah, silahkan hubungi AdminSales!';
					}
				} else {
					$pesan = 'Maaf, Akun anda tidak aktif!';
				}
			} else {
				$pesan = 'User tidak ditemukan!';
			}
		}
		$result = [
			'status' => $status,
			'pesan' => $pesan,
			'url' => $url
		];
		return $result;
	}

	/**
	 * Fungsi untuk mengeset user yang telah sukses login
	 * terkait data sessionnya
	 * @param object  	$user   	object user
	 * @return string
	 */
	private function set_login($user)
	{
		date_default_timezone_set('Asia/Makassar');
		$time_login 		= date('Y-m-d H:i:s');

		$url 				= 'home';
		$token 				= uniqid(rand(), true);
		$role_name 			= 'Unknown Role!!';

		if (empty($user->id_role)) {
			$result = [
				'status' => FALSE,
				'pesan' => "User Role belum disetting!",
				'url' => 'auth/logout'
			];
			responseJson($result);
			die();
		} else {
			$cek_role_id = $this->db_wuling->get_where('menu_role', ['id' => $user->id_role]);
			if ($cek_role_id->num_rows() == 0) {
				$result = [
					'status' => FALSE,
					'pesan' => "User Role tidak ditemukan!",
					'url' => 'auth/logout'
				];
				responseJson($result);
				die();
			}
		}

		$role_name 			= $this->db_wuling->select('role_name')->from('menu_role')->where('id', $user->id_role)->get()->row()->role_name;
		$nama_cabang 		= 'WULING ' . id_perusahaan_to_lokasi($user->id_perusahaan);
		$karyawan 			= $this->db->select("*")->from('karyawan')->where('nik', $user->nik)->get()->row();

		$sessions = array(
			'logged_in' 	=> 'getLoginKMG_operasional',
			'nik' 			=> $user->nik,
			'username' 		=> $user->username,
			'id_perusahaan' => $user->id_perusahaan,
			'coverage' 		=> $user->coverage,
			'id_jabatan' 	=> $user->id_jabatan,
			'id_user' 		=> $user->id_user,
			'nama_lengkap' 	=> $karyawan->nama_karyawan,
			'email' 		=> $karyawan->email,
			'foto' 			=> $karyawan->file_foto,
			'level' 		=> null, //$level,
			'url' 			=> null, //$url,
			'role_id'		=> $user->id_role,
			'role_name' 	=> $role_name,
			'nama_cabang' 	=> $nama_cabang,
			'divisi' 		=> 'operasional',
		);
		$this->db_wuling->query("INSERT INTO history_login (id, username, time_login, status) VALUES ('$token','$user->username','$time_login','1')");
		$this->db_wuling->query("UPDATE users SET status_login='on' WHERE username='$user->username'");

		$this->session->set_userdata($sessions);
		setcookie("sidebar_minimize_state", "on", time() + (86400 * 30 * 7), "/"); // = 1 pekan

		return $url;
	}

	/**
	 * Fungsi untuk mengeset user sales yang telah sukses login
	 * terkait data sessionnya
	 * @param object  	$sales   	object sales
	 * @return string
	 */
	private function set_login_sales($sales)
	{
		date_default_timezone_set('Asia/Makassar');
		$time_login 		= date('Y-m-d H:i:s');
		$url 				= 'home';
		$token 				= uniqid(rand(), true);

		$role_id 			= $this->_jabatan_to_role($sales->id_jabatan);
		$role_name			= $this->db_wuling->select('role_name')->from('menu_role')->where('id', $role_id)->get()->row()->role_name;
		$nama_cabang 		= 'WULING ' . id_perusahaan_to_lokasi($sales->id_perusahaan);
		$karyawan 			= $this->db->select("*")->from('karyawan')->where('id_karyawan', $sales->id_sales)->get()->row();

		//team sales
		$id_team_supervisor = null;
		$kode_spv_sgmw 		= null;
		$team_supervisor 	= $this->db_wuling->get_where('adm_team_supervisor', ['id_supervisor' => $sales->id_sales])->row();
		if (isset($team_supervisor)) {
			$id_team_supervisor = $team_supervisor->id_team_supervisor;
			$kode_spv_sgmw = $team_supervisor->kode_spv_sgmw;
		}

		$id_team_sm 		= null;
		$team_sm  			= $this->db_wuling->select('id_team_sm,coverage')->get_where('adm_team_sm', ['id_sm' => $sales->id_sales])->row();
		if (isset($team_sm)) {
			$id_team_sm = $team_supervisor->id_team_sm;
		}

		$id_team_asm 		= null;
		$team_asm 			= $this->db_wuling->select('id_team_asm')->get_where('adm_team_asm', ['id_asm' => $sales->id_sales])->row();
		if (isset($team_asm)) {
			$id_team_asm = $team_asm->id_team_asm;
		}

		$id_team_sales_by_spv = null;
		$id_team_sales_by_sm = null;
		$team_sales_by_sm = $this->db_wuling->select('ats.id_team_supervisor, atm.id_team_sm')
			->from('adm_sales ads')
			->join('adm_team_supervisor ats', 'ats.id_team_supervisor = ads.id_leader')
			->join('adm_team_sm atm', 'atm.id_team_sm = ats.id_team_sm')
			->where('ads.id_sales', $sales->id_sales)
			->get()->row();
		if (isset($team_sales_by_sm)) {
			$id_team_sales_by_spv = $team_sales_by_sm->id_team_supervisor;
			$id_team_sales_by_sm = $team_sales_by_sm->id_team_sm;
		}

		$sessions = array(
			'logged_in' 			=> 'getLoginKMG_sales',
			'username' 				=> $sales->username,
			'id_perusahaan' 		=> $sales->id_perusahaan,
			'coverage' 				=> $sales->coverage,
			'id_jabatan' 			=> $sales->id_jabatan,
			'id_sales' 				=> $sales->id_sales,
			'id_leader' 			=> $sales->id_leader,
			'id_team_supervisor' 	=> $id_team_supervisor,
			'id_team_sm' 			=> $id_team_sm,
			'id_team_asm' 			=> $id_team_asm,
			'kode_sales_sgmw' 		=> $sales->kode_sales_sgmw,
			'kode_spv_sgmw' 		=> $kode_spv_sgmw,
			'nik' 					=> $karyawan->nik,
			'nama_lengkap' 			=> $karyawan->nama_karyawan,
			'email' 				=> $karyawan->email,
			'foto' 					=> $karyawan->file_foto,
			'level' 				=> null, //$level,
			'url' 					=> null, //$url,
			'role_id'				=> $role_id,
			'role_name' 			=> $role_name,
			'nama_cabang' 			=> $nama_cabang,
			'divisi' 				=> 'sales',
			'id_team_sales_by_spv'  => $id_team_sales_by_spv,
			'id_team_sales_by_sm'   => $id_team_sales_by_sm,
		);

		$this->db_wuling->query("INSERT INTO history_login_sales (id_sales, time_login, asal) VALUES ('$sales->id_sales','$time_login','w')");

		$this->session->set_userdata($sessions);
		setcookie("sidebar_minimize_state", "on", time() + (86400 * 30 * 7), "/"); // = 1 pekan
		return $url;
	}

	/**
	 * Fungsi untuk mengganti password user 
	 * @param string  	$username   usernamenya
	 * @param string  	$password   passwordnya
	 * @return boolean
	 */
	public function change_password($username, $password)
	{
		$hasil = false;
		$hash_password 	= password_hash($password, PASSWORD_DEFAULT);
		$md5_password 	= md5($password);
		$divisi = $this->session->userdata('divisi');

		$this->db_wuling->trans_start();

		switch ($divisi) {
			case 'sales':
				//untuk user divisi sales  
				$query_cek_sales = $this->db_wuling->select('username')->from('adm_sales')->where('username', $username)->get();
				if ($query_cek_sales->num_rows() > 0) { //sales
					$this->db_wuling->update("adm_sales", ['password' => $md5_password, 'password_hash' => $hash_password], ['username' => $username]);
				}
				break;
			case 'operasional':
				//untuk user operasional
				$query_cek_user = $this->db_wuling->select('username')->from('users')->where('username', $username)->get();
				if ($query_cek_user->num_rows() > 0) { //user
					$this->db_wuling->update("users", ['password' => $md5_password, 'password_hash' => $hash_password], ['username' => $username]);
				}
				break;
			default:
				die('unknown divisi!');
				break;
		}

		$this->db_wuling->trans_complete();
		$hasil = $this->db_wuling->trans_status();

		return $hasil;
	}


	/**
	 * Private Fungsi statis untuk mengkonversi id_jabatan 
	 * menjadi role_id untuk kebutuhan hak akses menu,
	 * ka siapa lagi mau update satu-satu sales ke role nya masing-masing. 
	 * @param string  	$id_jabatan   id jabatannyasales
	 * @return int|string
	 */
	private function _jabatan_to_role($id_jabatan)
	{
		$role_id = 0;

		if (empty($id_jabatan) || $id_jabatan == 0) {
			die('Wrong ID Jabatan!!!');
		}

		// ID JABATAN STATIC
		// Sales
		//22	Sales Consultant
		//24	Sales Counter

		// Supervisor
		//21	Sales Supervisor

		// Sales Manager
		//67	Sales Manager

		// Area Sales Manager
		//175	Area Sales Manager

		// Sales Fleet
		//124	Fleet Account Manager Sample 2
		//210	Fleet Account Manager
		//218	FLEET ACCOUNT MANAGER (Tidak digunakan l

		// Supervisor Fleet
		//211	Fleet Area Manager

		// NOT USED
		//165	Fleet Coordinator xxx
		//199	Fleet Manager xxx
		//215	SPV OFFICE FLEET xxx


		// ROLE ID STATIC//
		//2	Sales
		//3	Supervisor
		//4	Sales Manager
		//5	Area Sales Manager
		//6	Fleet Account Manager
		//7	Fleet Area Manager

		$sales = ['22', '24'];
		$supervisor = ['21'];
		$sales_manager = ['67'];
		$area_sales_manager = ['175'];
		$sales_fleet = ['124', '210', '218'];
		$supervisor_fleet = ['211'];

		switch ($id_jabatan) {
				//sales
			case '22':
			case '24':
				$role_id = 2;
				break;
				//supervisor
			case '21':
				$role_id = 3;
				break;
				//sales manager
			case '67':
				$role_id = 4;
				break;
				//area sales manager
			case '175':
				$role_id = 5;
				break;
				//sales fleet
			case '124':
			case '210':
			case '218':
				$role_id = 6;
				break;
				//supervisor fleet
			case '211':
				$role_id = 7;
				break;
		}

		return $role_id;
	}
}
