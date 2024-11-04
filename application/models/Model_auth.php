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
		$query  = $this->db->get_where('users', ['username' => $username]);
		$pesan 	= 'Unknown Error';
		$status = false;
		$url 	= 'auth';

		if ($query->num_rows() > 0) { //user found
			$user 	= $query->row();
			if ($user->status_aktif == 'on') { //user aktif
				if (password_verify($password, $user->password_hash) || md5($password) == $user->password) {
					$url       = $this->set_login($user);
					$status    = true;
					$pesan     = 'Login berhasil';
				} else {
					$pesan = 'Username/Password yang anda masukkan salah, silahkan hubungi Administrator!';
				}
			} else {
				$pesan = 'Maaf, Akun anda tidak aktif!';
			}
		} else {
			//user not found
			//coba cek di sales
			$pesan = 'User tidak ditemukan!';
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
			$cek_role_id = $this->db->get_where('menu_role', ['id' => $user->id_role]);
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

		$role_name 			= $this->db->select('role_name')->from('menu_role')->where('id', $user->id_role)->get()->row()->role_name;
		// cek asn
		$pegawai 			= $this->db->select("*")->from('pegawai')->where('nip', $user->nip)->get()->row();
		if (empty($pegawai)) {
			// cek karyawan
			$pegawai = $this->db->select("*")->from('karyawan')->where('kode_karyawan', $user->kode_karyawan)->get()->row();
		}

		$sessions = array(
			'logged_in' 	=> 'getLoginASHAMA_operasional',
			'nip' 			=> $user->nip ?? null,
			'kode_karyawan' => $user->kode_karyawan ?? null,
			'username' 		=> $user->username,
			'coverage' 		=> $user->coverage,
			'id_jabatan' 	=> $user->id_jabatan,
			'id_user' 		=> $user->id_user,
			'nama_lengkap' 	=> $user->nama_lengkap,
			'email' 		=> $pegawai->email,
			'foto' 			=> $pegawai->file_foto,
			'level' 		=> null, //$level,
			'url' 			=> null, //$url,
			'role_id'		=> $user->id_role,
			'role_name' 	=> $role_name,
			'divisi' 		=> 'operasional',
		);
		$this->db->query("INSERT INTO history_login (id, username, time_login, status) VALUES ('$token','$user->username','$time_login','1')");
		$this->db->query("UPDATE users SET status_login='on' WHERE username='$user->username'");

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

		$this->db->trans_start();

		switch ($divisi) {
			case 'sales':
				//untuk user divisi sales  
				$query_cek_sales = $this->db->select('username')->from('adm_sales')->where('username', $username)->get();
				if ($query_cek_sales->num_rows() > 0) { //sales
					$this->db->update("adm_sales", ['password' => $md5_password, 'password_hash' => $hash_password], ['username' => $username]);
				}
				break;
			case 'operasional':
				//untuk user operasional
				$query_cek_user = $this->db->select('username')->from('users')->where('username', $username)->get();
				if ($query_cek_user->num_rows() > 0) { //user
					$this->db->update("users", ['password' => $md5_password, 'password_hash' => $hash_password], ['username' => $username]);
				}
				break;
			default:
				die('unknown divisi!');
				break;
		}

		$this->db->trans_complete();
		$hasil = $this->db->trans_status();

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
