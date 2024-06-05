<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_user extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('Send_Email');
	}

	public function get($posts)
	{
		$cabang = @$posts['cabang'];
		$status = @$posts['status'];
		if (!empty($cabang)) {
			$this->db_wuling->where('u.id_perusahaan', $cabang);
		}
		if (!empty($status)) {
			$this->db_wuling->where('u.status_aktif', $status);
		}
		$data 	= array();
		$query 	= $this->db_wuling
			->select('u.*, j.nama_jabatan, p.lokasi, r.role_name, url.url, hl.time_login')
			->from('users u')
			->join('kmg.jabatan j', 'j.id_jabatan=u.id_jabatan')
			->join('kmg.perusahaan p', 'p.id_perusahaan=u.id_perusahaan')
			->join('menu_role r', 'r.id=u.id_role', 'left')
			->join('p_url url', 'url.id_url=u.id_url', 'left')
			->join('(SELECT a.username, MAX(a.time_login) AS time_login FROM history_login a GROUP BY a.username) hl', 'hl.username=u.username', 'left')
			->order_by('u.id_perusahaan ASC')
			->get();

		foreach ($query->result() as $user) {
			$data[] = array(
				'id_user' 		=> $user->id_user,
				'cabang'		=> $user->lokasi,
				'jabatan'		=> $user->nama_jabatan,
				'nik' 			=> $user->nik,
				'nama_lengkap'	=> $user->nama_lengkap,
				'username' 		=> $user->username,
				'role' 			=> $user->role_name,
				'level' 		=> 0, //$user->level,
				'url' 			=> $user->url,
				'status_aktif'	=> $user->status_aktif,
				'status_login' 	=> $user->status_login,
				'time_login' 	=> $user->time_login,
			);
		}

		return $data;
	}

	public function get_serverside()
	{
		$datatable = new Datatable;

		//* query utama *//
		$datatable->query = $this->db_wuling
			->select('u.id_user, u.id_role, u.id_perusahaan, u.id_jabatan, u.coverage, u.username, u.password, u.nama_lengkap, u.nik, u.id_url, u.status_aktif, u.status_login')
			->from('users u')
			->join('jabatan j', 'j.id_jabatan=u.id_jabatan');

		//* untuk filtering */		
		$datatable->setColumns(
			"u.id_user",
			"u.id_role",
			"u.id_perusahaan",
			"u.id_jabatan",
			"u.coverage",
			"u.username",
			"u.password",
			"u.nama_lengkap",
			"u.nik",
			"u.id_url",
			"u.status_aktif",
			"u.status_login"
		);

		$datatable->orderBy('u.id_perusahaan ASC');
		$raw = $datatable->get();

		$recordsData = [];
		foreach ($raw['data'] as $key => $value) {
			$lokasi	= $this->model_data->getlokasiperusahaan($value->id_perusahaan);
			$level	= $this->model_admins->LevelToAdmin($value->id_role);
			$url	= $this->model_admins->UrlToAdmin($value->id_url);
			$recordsData[] = array(
				'id_user' 		=> $value->id_user,
				'cabang'		=> $lokasi,
				'jabatan'		=> $jabatan,
				'nama_lengkap'	=> $value->nama_lengkap,
				'username' 		=> $value->username,
				'level' 		=> $level,
				'url' 			=> $url,
				'status_aktif'	=> $value->status_aktif,
				'status_login' 	=> $value->status_login,
			);
		}

		// //* buat ulang response datatable_serverside
		$response = [
			'draw'            => $raw['draw'],
			'recordsTotal'    => $raw['recordsTotal'],
			'recordsFiltered' => $raw['recordsFiltered'],
			'data'            => $recordsData
		];

		return $response;
	}

	public function set_status($id, $status)
	{
		$result = false;

		if (!empty($id) && !empty($status)) {
			//kalau $status off, update juga status login di history login
			if ($status == 'off') {
				$this->db_wuling->update("users", ['status_login' => $status], ['id_user' => $id]);
			}
			$this->db_wuling->update("users", ['status_aktif' => $status], ['id_user' => $id]);
			$result	= $this->db_wuling->affected_rows() > 0 ? true : false;
		}

		return $result;
	}

	public function tambah_user($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menyimpan user';
		$username 	= '';
		$password 	= '';
		$nama 		= '';

		if (!empty($posts)) {
			$id_perusahaan  = $posts['cabang'];
			$id_role 		= $posts['role'];
			// $id_url 		= 0;// $this->db_wuling->select('id_url')->from('p_level')->where('id_role',$id_role)->get()->row('id_url');
			$coverage 		= implode(',', $posts['coverage']);
			$username 		= $posts['username'];
			$password 		= $posts['password'];
			$nik 			= $posts['nik'];

			//cek existing
			$query_cek_user = $this->db_wuling->select('username')->from('users')->where('username', $username)->get();
			if ($query_cek_user->num_rows() > 0) {
				return ['status' => false, 'pesan' => 'Username sudah ada!'];
			}

			$query_karyawan = $this->db->select('nik, nama_karyawan, id_jabatan, file_foto, email')->from('karyawan')->where('nik', $nik)->get();
			$karyawan 		= $query_karyawan->row();
			$data 	= array(
				'id_perusahaan'	=> $id_perusahaan,
				'id_role'		=> $id_role,
				// 'id_url' 		=> $id_url,
				'username' 		=> $username,
				'coverage' 		=> $coverage,
				'password'		=> md5($password),
				'password_hash' => password_hash($password, PASSWORD_DEFAULT),
				'nik' 			=> $nik,
				'nama_lengkap'	=> $karyawan->nama_karyawan,
				'id_jabatan' 	=> $karyawan->id_jabatan,
				'foto' 			=> $karyawan->file_foto,
				'status_aktif' 	=> 'on',
			);

			$this->db_wuling->trans_start();
			$this->db_wuling->insert("users", $data);
			$this->db_wuling->trans_complete();

			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil membuat user';
				$nama 	= $karyawan->nama_karyawan;
				$email 	= $karyawan->email;
				$data = [
					'nama_lengkap' => $nama,
					'username'	=> $username,
					'password'	=> $password
				];
				if (!empty($email)) {
					$sukses_kirim_email = $this->send_email->send('password_confirmation', 'DMS Wuling', $email, 'Informasi Login DMS Wuling Kumala', $data);
					if ($sukses_kirim_email) {
						$pesan = "Berhasil membuat user dan mengirim ke email";
					}
				}
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan, 'nama' => $nama, 'username' => $username, 'password' => $password];
		return $result;
	}

	public function update_user($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal mengupdate user';

		if (!empty($posts)) {
			$id_user 		= $posts['id'];
			$id_perusahaan  = $posts['cabang'];
			$id_role 		= $posts['role'];
			// $id_url 		= 0; //$this->db_wuling->select('id_url')->from('p_level')->where('id_role',$id_role)->get()->row('id_url');
			$coverage 		= implode(',', $posts['coverage']);
			$username 		= $posts['username'];
			$nik 			= $posts['nik'];

			$cek_nik = $this->db->select('nik')->from('karyawan')->where('nik', $nik)->get()->num_rows();
			if ($cek_nik < 1) {
				$result = ['status' => $status, 'pesan' => 'Silahkan update NIK terlebih dahulu!'];
				return $result;
			}
			if (!empty($id_user) && !empty($id_perusahaan) && !empty($id_role) && !empty($coverage)) {
				$query_karyawan = $this->db->select('nik, nama_karyawan, id_jabatan, file_foto')->from('karyawan')->where('nik', $nik)->get();
				$karyawan 		= $query_karyawan->row();
				$data 	= array(
					'id_perusahaan'	=> $id_perusahaan,
					'id_role'		=> $id_role,
					// 'id_url' 		=> $id_url,	
					'username' 		=> $username,
					'coverage' 		=> $coverage,
					'nik' 			=> $nik,
					'nama_lengkap'	=> $karyawan->nama_karyawan,
					'id_jabatan' 	=> $karyawan->id_jabatan,
					'foto' 			=> $karyawan->file_foto,
				);
				$this->db_wuling->trans_start();
				$this->db_wuling->update("users", $data, ['id_user' => $id_user]);
				$this->db_wuling->trans_complete();

				if ($this->db_wuling->trans_status() === true) {
					$status = true;
					$pesan 	= 'Berhasil mengupdate user';
				}
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}

	public function copy_user($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menduplikasi user';
		$username 	= '';
		$password 	= '';
		$nama 		= '';

		if (!empty($posts)) {
			$id_user 		= $posts['id'];
			$id_perusahaan  = $posts['cabang'];
			$id_role 		= $posts['role'];
			// $id_url 		= 0; //$this->db_wuling->select('id_url')->from('p_level')->where('id_role',$id_role)->get()->row('id_url');
			$coverage 		= implode(',', $posts['coverage']);
			$username 		= $posts['username'];
			$nik 			= $posts['nik'];

			//ambil password untuk user terkait
			$query_password = $this->db_wuling->select('password, password_hash')->from('users')->where('id_user', $id_user)->get();
			$password 		= $query_password->row();

			//cek existing
			$query_cek_user = $this->db_wuling->select('username')->from('users')->where('username', $username)->get();
			if ($query_cek_user->num_rows() > 0) {
				return ['status' => false, 'pesan' => 'Username sudah ada!'];
			}

			$query_karyawan = $this->db->select('nik, nama_karyawan, id_jabatan, file_foto')->from('karyawan')->where('nik', $nik)->get();
			$karyawan 		= $query_karyawan->row();
			$data 	= array(
				'id_perusahaan'	=> $id_perusahaan,
				'id_role'		=> $id_role,
				// 'id_url' 		=> $id_url,
				'username' 		=> $username,
				'coverage' 		=> $coverage,
				'password'		=> $password->password,
				'password_hash' => $password->password_hash,
				'nik' 			=> $nik,
				'nama_lengkap'	=> $karyawan->nama_karyawan,
				'id_jabatan' 	=> $karyawan->id_jabatan,
				'foto' 			=> $karyawan->file_foto,
				'status_aktif' 	=> 'on',
			);

			$this->db_wuling->trans_start();
			$this->db_wuling->insert("users", $data);
			$this->db_wuling->trans_complete();

			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menduplikasi user';
				$nama 	= $karyawan->nama_karyawan;
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan, 'nama' => $nama, 'username' => $username];
		return $result;
	}



	public function get_user_by_id($id)
	{
		$coverage 	= array();
		$data_user 	= NULL;

		if (!empty($id)) {
			$query_user 	= $this->db_wuling
				->select('u.*, j.nama_jabatan')
				->from('users u')
				->join('kmg.jabatan j', 'j.id_jabatan=u.id_jabatan')
				->where('u.id_user', $id)
				->get();
			$user = $query_user->row();

			if ($query_user->num_rows() > 0) {
				$data_user = array(
					'id_user' 		=> $user->id_user,
					'id_cabang'		=> $user->id_perusahaan,
					'id_role' 		=> $user->id_role,
					'jabatan'		=> $user->nama_jabatan,
					'nama_lengkap'	=> $user->nama_lengkap,
					'username' 		=> $user->username,
					'nik'			=> $user->nik,
					'coverage' 		=> $user->coverage,
				);
			}

			$query_coverage = $this->db
				->select("id_perusahaan, lokasi")->from("kmg.perusahaan")
				->where("id_brand", "5")
				->order_by("lokasi")
				->get();
			$cek_coverage = @explode(',', $data_user['coverage']);
			foreach ($query_coverage->result() as $c) {
				$id = '';
				if (in_array($c->id_perusahaan, $cek_coverage)) {
					$id = $c->id_perusahaan;
				}
				$coverage[] = array(
					'id_perusahaan' => $c->id_perusahaan,
					'lokasi' 		=> $c->lokasi,
					'coverage' 		=> $id,
				);
			}
		}

		return ['aaData' => $coverage, 'user' => $data_user];
	}

	public function reset_user($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal mengupdate user';
		$username 	= '';
		$password 	= '';
		$nama 		= '';

		if (!empty($posts)) {
			$id_user 		= $posts['id'];
			$password 		= $posts['password'];

			$query_user 	= $this->db_wuling->select('username, nama_lengkap, nik')->from('users')->where('id_user', $id_user)->get();
			$user 			= $query_user->row();
			$data 	= array(
				'password'		=> md5($password),
				'password_hash' => password_hash($password, PASSWORD_DEFAULT),
				'last_password_update' => date('Y-m-d H:i:s'),
			);
			$this->db_wuling->trans_start();
			$this->db_wuling->update("users", $data, ['id_user' => $id_user]);
			$this->db_wuling->trans_complete();

			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil mereset password user';
				$username 	= $user->username;
				$nama 		= $user->nama_lengkap;
				$nik  		= $user->nik;

				$data = [
					'nama_lengkap' => $nama,
					'username'	=> $username,
					'password'	=> $password
				];

				//ambil email karyawan
				$email_karyawan = '';
				$query_email = $this->db->select('email')->from('karyawan')->where('nik', $user->nik)->get()->row();
				if (isset($query_email)) {
					$email_karyawan = $query_email->email;
					if (!empty($email_karyawan)) {
						$sukses_kirim_email = $this->send_email->send('password_confirmation', 'DMS Wuling', $email_karyawan, 'Informasi Login DMS Wuling Kumala', $data);
						if ($sukses_kirim_email) {
							$pesan = "Berhasil mereset password user dan mengirim ke email";
						}
					}
				}
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan, 'nama' => $nama, 'username' => $username, 'password' => $password];
		return $result;
	}

	public function hapus_user($posts)
	{
		$status 	= false;
		$pesan 		= 'Gagal menghapus user';

		if (!empty($posts)) {
			$id_user = $posts['id'];
			$this->db_wuling->trans_start();
			$this->db_wuling->delete("users", ['id_user' => $id_user]);
			$this->db_wuling->trans_complete();
			if ($this->db_wuling->trans_status() === true) {
				$status = true;
				$pesan 	= 'Berhasil menghapus user';
			}
		}

		$result = ['status' => $status, 'pesan' => $pesan];
		return $result;
	}
}

/* End of file Model_user.php */
/* Location: ./wuling_admin/models/Model_user.php */
