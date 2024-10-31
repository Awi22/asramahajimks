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
        $status_pegawai = @$posts['status_pegawai'];
        $status         = @$posts['status'];

        if (!empty($status_pegawai)) {
            $this->db->where('u.id_status_pegawai', $status_pegawai);
        }

        if (!empty($status)) {
            $this->db->where('u.status_aktif', $status);
        }

        $data   = array();
        $query  = $this->db
            ->select('u.*, sp.nama_status_pegawai, j.nama_jabatan, r.role_name, url.url, hl.time_login')
            ->from('users u')
            ->join('jabatan j', 'j.id_jabatan = u.id_jabatan')
            ->join('status_pegawai sp', 'sp.id_status_pegawai = u.id_status_pegawai')
            ->join('menu_role r', 'r.id = u.id_role', 'left')
            ->join('p_url url', 'url.id_url = u.id_url', 'left')
            ->join('(SELECT a.username, MAX(a.time_login) AS time_login FROM history_login a GROUP BY a.username) hl', 'hl.username=u.username', 'left')
            ->order_by('u.id_status_pegawai ASC')
            ->get();

        foreach ($query->result() as $user) {
            $data[] = array(
                'id_user'           => $user->id_user,
                'status_pegawai'    => $user->nama_status_pegawai,
                'jabatan'           => $user->nama_jabatan,
                'nama_lengkap'      => $user->nama_lengkap,
                'username'          => $user->username,
                'role'              => $user->role_name,
                'level'             => 0, //$user->level,
                'url'               => $user->url,
                'status_aktif'      => $user->status_aktif,
                'status_login'      => $user->status_login,
                'time_login'        => $user->time_login,
            );
        }

        return $data;
    }

    //! Belum dipakai
    public function get_serverside()
    {
        $datatable = new Datatable;

        //* query utama *//
        $datatable->query = $this->db
            ->select('u.id_user, u.id_role, u.area_kerja, u.id_jabatan, u.coverage, u.username, u.password, u.nama_lengkap, u.nik, u.id_url, u.status_aktif, u.status_login')
            ->from('users u')
            ->join('jabatan j', 'j.id_jabatan=u.id_jabatan');

        //* untuk filtering */		
        $datatable->setColumns(
            "u.id_user",
            "u.id_role",
            "u.area_kerja",
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

        $datatable->orderBy('u.area_kerja ASC');
        $raw = $datatable->get();

        $recordsData = [];
        foreach ($raw['data'] as $key => $value) {
            $lokasi    = $this->model_data->getlokasiperusahaan($value->id_perusahaan);
            $level    = $this->model_admins->LevelToAdmin($value->id_role);
            $url    = $this->model_admins->UrlToAdmin($value->id_url);
            $recordsData[] = array(
                'id_user'        => $value->id_user,
                'cabang'         => $lokasi,
                // 'jabatan'        => $jabatan,
                'nama_lengkap'   => $value->nama_lengkap,
                'username'       => $value->username,
                'level'          => $level,
                'url'            => $url,
                'status_aktif'   => $value->status_aktif,
                'status_login'   => $value->status_login,
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
                $this->db->update("users", ['status_login' => $status], ['id_user' => $id]);
            }
            $this->db->update("users", ['status_aktif' => $status], ['id_user' => $id]);
            $result    = $this->db->affected_rows() > 0 ? true : false;
        }

        return $result;
    }

    public function tambah_user($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan user';
        $username = '';
        $password = '';
        $nama     = '';

        if (!empty($posts)) {
            $status_pegawai   = $posts['status_pegawai'];
            $id_role          = $posts['role'];
            // $id_url 		= 0;// $this->db->select('id_url')->from('p_level')->where('id_role',$id_role)->get()->row('id_url');
            $coverage         = implode(',', $posts['coverage']);
            $username         = $posts['username'];
            $password         = $posts['password'];
            $nip_kk           = $posts['nip_kk'];

            //cek existing
            $query_cek_user = $this->db->select('username')->from('users')->where('username', $username)->get();
            if ($query_cek_user->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Username sudah ada!'];
            }

            if ($status_pegawai == '1') {
                $query_asn = $this->db
                    ->select('nip, nama_pegawai, id_jabatan, file_foto, email')
                    ->from('pegawai')
                    ->where('nip', $nip_kk)
                    ->get();

                $asn    = $query_asn->row();
                $data   = array(
                    'id_status_pegawai' => $status_pegawai,
                    'id_role'           => $id_role,
                    'id_jabatan'        => $asn->id_jabatan,
                    // 'id_url'            => $id_url,
                    'username'          => $username,
                    'coverage'          => $coverage,
                    'password'          => md5($password),
                    'password_hash'     => password_hash($password, PASSWORD_DEFAULT),
                    'nip'               => $nip_kk,
                    'nama_lengkap'      => $asn->nama_pegawai,
                    'foto'              => $asn->file_foto,
                    'status_aktif'      => 'on',
                );
            } else if ($status_pegawai == '2') {
                $query_karyawan = $this->db
                    ->select('kode_karyawan, nama_karyawan, id_jabatan, file_foto, email')
                    ->from('karyawan')
                    ->where('kode_karyawan', $nip_kk)
                    ->get();

                $karyawan    = $query_karyawan->row();
                $data   = array(
                    'id_status_pegawai' => $status_pegawai,
                    'id_role'           => $id_role,
                    'id_jabatan'        => $karyawan->id_jabatan,
                    // 'id_url'            => $id_url,
                    'username'          => $username,
                    'coverage'          => $coverage,
                    'password'          => md5($password),
                    'password_hash'     => password_hash($password, PASSWORD_DEFAULT),
                    'kode_karyawan'     => $nip_kk,
                    'nama_lengkap'      => $karyawan->nama_karyawan,
                    'foto'              => $karyawan->file_foto,
                    'status_aktif'      => 'on',
                );
            }

            $this->db->trans_start();
            $this->db->insert("users", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil membuat user';
                $nama     = $asn->nama_pegawai ?? $karyawan->nama_karyawan;
                $email    = $asn->email ?? $karyawan->email;
                $data     = [
                    'nama_lengkap'  => $nama,
                    'username'      => $username,
                    'password'      => $password
                ];
                if (!empty($email)) {
                    $sukses_kirim_email = $this->send_email->send('password_confirmation', 'DMS Asrama Haji Makassar', $email, 'Informasi Login DMS Asrama Haji Makassar', $data);
                    if ($sukses_kirim_email) {
                        $pesan = "Berhasil membuat user dan mengirim ke email";
                    }
                }
            }
        }

        $result = [
            'status'    => $status,
            'pesan'     => $pesan,
            'nama'      => $nama,
            'username'  => $username,
            'password'  => $password
        ];

        return $result;
    }

    public function get_user_by_id($id)
    {
        $coverage   = array();
        $data_user  = NULL;

        if (!empty($id)) {
            $query_user     = $this->db
                ->select('u.*, j.nama_jabatan')
                ->from('users u')
                ->join('jabatan j', 'j.id_jabatan = u.id_jabatan')
                ->where('u.id_user', $id)
                ->get();
            $user = $query_user->row();

            if ($query_user->num_rows() > 0) {
                $data_user = array(
                    'id_user'           => $user->id_user,
                    'id_status_pegawai' => $user->id_status_pegawai,
                    'nip_kk'            => $user->nip ?? $user->kode_karyawan,
                    'id_role'           => $user->id_role,
                    'jabatan'           => $user->nama_jabatan,
                    'nama_lengkap'      => $user->nama_lengkap,
                    'username'          => $user->username,
                    'coverage'          => $user->coverage,
                );
            }

            $query_coverage = $this->db
                ->select("id_area_kerja, nama_area_kerja")
                ->from("area_kerja")
                ->order_by("nama_area_kerja")
                ->get();
            $cek_coverage = @explode(',', $data_user['coverage']);

            foreach ($query_coverage->result() as $c) {
                $id = '';
                if (in_array($c->id_area_kerja, $cek_coverage)) {
                    $id = $c->id_area_kerja;
                }

                $coverage[] = array(
                    'id_area_kerja'     => $c->id_area_kerja,
                    'nama_area_kerja'   => $c->nama_area_kerja,
                    'coverage'          => $id,
                );
            }
        }

        return ['aaData' => $coverage, 'user' => $data_user];
    }

    public function update_user($posts)
    {
        $status   = false;
        $pesan    = 'Gagal mengupdate user';

        if (!empty($posts)) {
            $id_user          = $posts['id'];
            $status_pegawai   = $posts['status_pegawai'];
            $id_role          = $posts['role'];
            // $id_url 		  = 0; //$this->db->select('id_url')->from('p_level')->where('id_role',$id_role)->get()->row('id_url');
            $coverage         = implode(',', $posts['coverage']);
            $username         = $posts['username'];
            $nip_kk           = $posts['nip_kk'];

            if ($status_pegawai == '1') {
                $cek_nip = $this->db
                    ->select('nip')
                    ->from('pegawai')
                    ->where('nip', $nip_kk)
                    ->get()
                    ->num_rows();

                if ($cek_nip < 1) {
                    $result = [
                        'status' => $status,
                        'pesan' => 'Silahkan update NIP terlebih dahulu!'
                    ];

                    return $result;
                }

                if (!empty($id_user) && !empty($status_pegawai) && !empty($id_role) && !empty($coverage)) {
                    $query_asn = $this->db
                        ->select('nip, nama_pegawai, id_jabatan, file_foto')
                        ->from('pegawai')
                        ->where('nip', $nip_kk)
                        ->get();

                    $asn    = $query_asn->row();
                    $data   = array(
                        'id_status_pegawai' => $status_pegawai,
                        'id_role'           => $id_role,
                        // 'id_url' 		    => $id_url,	
                        'username'          => $username,
                        'coverage'          => $coverage,
                        'nip'               => $nip_kk,
                        'nama_lengkap'      => $asn->nama_pegawai,
                        'id_jabatan'        => $asn->id_jabatan,
                        'foto'              => $asn->file_foto,
                    );
                }
            } else if ($status_pegawai == '2') {
                $cek_kk = $this->db
                    ->select('kode_karyawan')
                    ->from('karyawan')
                    ->where('kode_karyawan', $nip_kk)
                    ->get()
                    ->num_rows();

                if ($cek_kk < 1) {
                    $result = [
                        'status' => $status,
                        'pesan' => 'Silahkan update Kode karyawan terlebih dahulu!'
                    ];

                    return $result;
                }

                if (!empty($id_user) && !empty($status_pegawai) && !empty($id_role) && !empty($coverage)) {
                    $query_karyawan = $this->db
                        ->select('kode_karyawan, nama_karyawan, id_jabatan, file_foto')
                        ->from('karyawan')
                        ->where('kode_karyawan', $nip_kk)
                        ->get();

                    $karyawan   = $query_karyawan->row();
                    $data       = array(
                        'id_status_pegawai' => $status_pegawai,
                        'id_role'           => $id_role,
                        // 'id_url' 		    => $id_url,	
                        'username'          => $username,
                        'coverage'          => $coverage,
                        'kode_karyawan'     => $nip_kk,
                        'nama_lengkap'      => $karyawan->nama_karyawan,
                        'id_jabatan'        => $karyawan->id_jabatan,
                        'foto'              => $karyawan->file_foto,
                    );
                }
            }

            $this->db->trans_start();
            $this->db->update("users", $data, ['id_user' => $id_user]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan     = 'Berhasil mengupdate user';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function copy_user($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menduplikasi user';
        $username = '';
        $password = '';
        $nama     = '';

        if (!empty($posts)) {
            $id_user          = $posts['id'];
            $status_pegawai   = $posts['status_pegawai'];
            $id_role          = $posts['role'];
            // $id_url 		  = 0; //$this->db->select('id_url')->from('p_level')->where('id_role',$id_role)->get()->row('id_url');
            $coverage         = implode(',', $posts['coverage']);
            $username         = $posts['username'];
            $nip_kk           = $posts['nip_kk'];

            //ambil password untuk user terkait
            $query_password   = $this->db
                ->select('password, password_hash')
                ->from('users')
                ->where('id_user', $id_user)
                ->get();
            $password         = $query_password->row();

            //cek existing
            $query_cek_user   = $this->db
                ->select('username')
                ->from('users')
                ->where('username', $username)
                ->get();
            if ($query_cek_user->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Username sudah ada!'];
            }

            if ($status_pegawai == '1') {
                $query_asn = $this->db
                    ->select('nip, nama_pegawai, id_jabatan, file_foto')
                    ->from('pegawai')
                    ->where('nip', $nip_kk)
                    ->get();

                $asn    = $query_asn->row();
                $data   = array(
                    'id_status_pegawai' => $status_pegawai,
                    'id_role'           => $id_role,
                    'id_jabatan'        => $asn->id_jabatan,
                    // 'id_url' 		=> $id_url,
                    'username'          => $username,
                    'coverage'          => $coverage,
                    'password'          => $password->password,
                    'password_hash'     => $password->password_hash,
                    'nip'               => $nip_kk,
                    'nama_lengkap'      => $asn->nama_pegawai,
                    'foto'              => $asn->file_foto,
                    'status_aktif'      => 'on',
                );
            } else if ($status_pegawai == '2') {
                $query_karyawan = $this->db
                    ->select('kode_karyawan, nama_karyawan, id_jabatan, file_foto')
                    ->from('karyawan')
                    ->where('kode_karyawan', $nip_kk)
                    ->get();

                $karyawan   = $query_karyawan->row();
                $data       = array(
                    'id_status_pegawai' => $status_pegawai,
                    'id_role'           => $id_role,
                    'id_jabatan'        => $karyawan->id_jabatan,
                    // 'id_url' 		=> $id_url,
                    'username'          => $username,
                    'coverage'          => $coverage,
                    'password'          => $password->password,
                    'password_hash'     => $password->password_hash,
                    'nip'               => $nip_kk,
                    'nama_lengkap'      => $karyawan->nama_karyawan,
                    'foto'              => $karyawan->file_foto,
                    'status_aktif'      => 'on',
                );
            }

            $this->db->trans_start();
            $this->db->insert("users", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil menduplikasi user';
                $nama     = $asn->nama_pegawai ?? $karyawan->nama_karyawan;
            }
        }

        $result = [
            'status'    => $status,
            'pesan'     => $pesan,
            'nama'      => $nama,
            'username'  => $username
        ];

        return $result;
    }

    public function reset_user($posts)
    {
        $status   = false;
        $pesan    = 'Gagal mengupdate user';
        $username = '';
        $password = '';
        $nama     = '';

        if (!empty($posts)) {
            $id_user    = $posts['id'];
            $password   = $posts['password'];

            $query_user = $this->db
                ->select('username, nama_lengkap, nip, kode_karyawan')
                ->from('users')
                ->where('id_user', $id_user)
                ->get();
            $user       = $query_user->row();

            $data       = array(
                'password'              => md5($password),
                'password_hash'         => password_hash($password, PASSWORD_DEFAULT),
                'last_password_update'  => date('Y-m-d H:i:s'),
            );

            $this->db->trans_start();
            $this->db->update("users", $data, ['id_user' => $id_user]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil mereset password user';
                $username = $user->username;
                $nama     = $user->nama_lengkap;
                $nip_kk   = $user->nip ?? $user->kode_karyawan;

                $data = [
                    'nama_lengkap'  => $nama,
                    'username'      => $username,
                    'password'      => $password
                ];

                //ambil email pegawai
                $email_pegawai      = '';
                if (!empty($user->nip)) {
                    $query_email    = $this->db
                        ->select('email')
                        ->from('pegawai')
                        ->where('nip', $nip_kk)
                        ->get()
                        ->row();
                } else if (!empty($user->kode_karyawan)) {
                    $query_email    = $this->db
                        ->select('email')
                        ->from('karyawan')
                        ->where('kode_karyawan', $nip_kk)
                        ->get()
                        ->row();
                }

                if (isset($query_email)) {
                    $email_pegawai = $query_email->email;
                    if (!empty($email_pegawai)) {
                        $sukses_kirim_email = $this->send_email->send('password_confirmation', 'UPT Asrama Haji Makassar', $email_pegawai, 'Informasi Login Portal Asrama Haji Makassar', $data);
                        if ($sukses_kirim_email) {
                            $pesan = "Berhasil mereset password user dan mengirim ke email";
                        }
                    }
                }
            }
        }

        $result = [
            'status'    => $status,
            'pesan'     => $pesan,
            'nama'      => $nama,
            'username'  => $username,
            'password'  => $password
        ];

        return $result;
    }

    public function hapus_user($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menghapus user';

        if (!empty($posts)) {
            $id_user = $posts['id'];
            $this->db->trans_start();
            $this->db->delete("users", ['id_user' => $id_user]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil menghapus user';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}

/* End of file Model_user.php */
/* Location: ./administrator/models/Model_user.php */
