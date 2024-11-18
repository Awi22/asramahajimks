<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_profil extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->username = $this->session->userdata('username');
    }

    public function get_asn($nip)
    {
        $data_pegawai = NULL;

        if (!empty($nip)) {
            $query = $this->db
                ->select('*')
                ->from('pegawai')
                ->where('nip', $nip)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_pegawai = [
                    'id_pegawai'    => $row->id_pegawai,
                    'nip'           => $row->nip,
                    'jenis_asn'     => $this->_getJenisASN($row->id_jenis_asn),
                    'nama_pegawai'  => $row->nama_pegawai,
                    'jabatan'       => $this->_getJabatan($row->id_jabatan),
                    'email'         => $row->email,
                    'status_aktif'  => $row->status_aktif,
                    'jenis_kelamin' => $row->jenis_kelamin,
                    'id_agama'      => $row->id_agama,
                    'alamat'        => $row->alamat,
                    'tempat_lahir'  => $row->tempat_lahir,
                    'tgl_lahir'     => $row->tgl_lahir,
                    'no_telepon'    => $row->no_telepon,
                    'handphone'     => $row->handphone,
                    'status'        => $row->status
                ];
            }
        }
        return $data_pegawai;
    }

    public function update_asn($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui pegawai';

        if (!empty($posts)) {
            // $id_pegawai       = $posts['id_pegawai'];
            $nip              = $posts['nip'];
            $email            = $posts['email'];
            $jenis_kelamin    = $posts['jenis_kelamin'];
            $id_agama         = $posts['agama'];
            $alamat           = $posts['alamat'];
            $tempat_lahir     = $posts['tempat_lahir'];
            $tgl_lahir        = $posts['tgl_lahir'];
            $no_telepon       = $posts['no_telepon'];
            $handphone        = $posts['handphone'];
            $status           = $posts['status'];

            $data = [
                'email'         => $email,
                'jenis_kelamin' => $jenis_kelamin,
                'id_agama'      => $id_agama,
                'alamat'        => $alamat,
                'tempat_lahir'  => $tempat_lahir,
                'tgl_lahir'     => $tgl_lahir,
                'no_telepon'    => $no_telepon,
                'handphone'     => $handphone,
                'status'        => $status
            ];

            $this->db->trans_start();
            // $this->db->update('pegawai', $data, ['id_pegawai' => $id_pegawai]);
            $this->db->update('pegawai', $data, ['nip' => $nip]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui profil pegawai';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function upload_foto_asn()
    {
        $hasil = false;
        $pesan = 'Unknown error';

        $folder_name = 'public/upload/images/foto_profil/';

        $config = [
            'upload_path'       => './' . $folder_name,
            'allowed_types'     => 'jpg|png|jpeg|webp',
            'max_size'          => 2048,
            'overwrite'         => TRUE,
            'create_thumb'      => FALSE,
            'maintain_ratio'    => TRUE,
            'encrypt_name'      => TRUE,
        ];

        $this->load->library('upload', $config);

        $files    = $_FILES;
        $dataInfo = [];

        $num_files = count($_FILES['photo_file']['name']);

        for ($i = 0; $i < $num_files; $i++) {
            $_FILES['photo_file']['name']       = $files['photo_file']['name'][$i];
            $_FILES['photo_file']['type']       = $files['photo_file']['type'][$i];
            $_FILES['photo_file']['tmp_name']   = $files['photo_file']['tmp_name'][$i];
            $_FILES['photo_file']['error']      = $files['photo_file']['error'][$i];
            $_FILES['photo_file']['size']       = $files['photo_file']['size'][$i];
            // $this->upload->do_upload('photo_file');
            if (empty($files['photo_file']['name'][$i])) {
                $dataInfo[] = $this->upload->data();
            } else {
                if ($this->upload->do_upload('photo_file')) {
                    $hasil         = true;
                    $dataInfo[]    = $this->upload->data();
                    $pesan         = 'Berhasil upload gambar';
                } else {
                    $dataInfo[]    = $this->upload->data();
                    $hasil         = false;
                    $pesan         = $this->upload->display_errors();
                    return ['status' => $hasil, 'pesan' => $pesan];
                }
            }
        }

        $row = $this->db
            ->where('nip', $this->session->userdata('nip'))
            ->get('pegawai')
            ->row();

        if ($files['photo_file']['name'][0] != null) {
            if (!empty($row->file_foto)) {
                if (file_exists('./' . $row->file_foto)) {
                    unlink($row->file_foto);
                }
            }
            $hasil = $this->db->update('pegawai', ['file_foto' => $dataInfo[0]['file_name']], ['nip' => $row->nip]);
        }

        return ['status' => $hasil, 'pesan' => $pesan];
    }

    public function get_karyawan($kode_karyawan)
    {
        $data   = 'Data tidak ditemukan';

        if (!empty($kode_karyawan)) {
            $query = $this->db
                ->select('*')
                ->from('karyawan')
                ->where('kode_karyawan', $kode_karyawan)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data = [
                    'id_karyawan'       => $row->id_karyawan,
                    'kode_karyawan'     => $row->kode_karyawan,
                    'nama_karyawan'     => $row->nama_karyawan,
                    'jabatan'           => $this->_getJabatan($row->id_jabatan),
                    'area_kerja'        => $this->_getAreaKerja($row->id_area_kerja),
                    'tugas'             => $this->_getPenempatanTugas($row->id_tugas),
                    'status_aktif'      => $row->status_aktif,
                    'email'             => $row->email,
                    'jenis_kelamin'     => $row->jenis_kelamin,
                    'id_agama'          => $row->id_agama,
                    'alamat'            => $row->alamat,
                    'tempat_lahir'      => $row->tempat_lahir,
                    'tgl_lahir'         => $row->tgl_lahir,
                    'no_telepon'        => $row->no_telepon,
                    'handphone'         => $row->handphone,
                    'status'            => $row->status
                ];
            }
        }
        return $data;
    }

    public function update_karyawan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui karyawan';

        if (!empty($posts)) {
            // $id_karyawan       = $posts['id_karyawan'];
            $kode_karyawan    = $posts['kode_karyawan'];
            $jenis_kelamin    = $posts['jenis_kelamin'];
            $id_agama         = $posts['agama'];
            $email            = $posts['email'];
            $alamat           = $posts['alamat'];
            $tempat_lahir     = $posts['tempat_lahir'];
            $tgl_lahir        = $posts['tgl_lahir'];
            $no_telepon       = $posts['no_telepon'];
            $handphone        = $posts['handphone'];
            $status           = $posts['status'];

            $data = [
                'jenis_kelamin' => $jenis_kelamin,
                'id_agama'      => $id_agama,
                'email'         => $email,
                'alamat'        => $alamat,
                'tempat_lahir'  => $tempat_lahir,
                'tgl_lahir'     => $tgl_lahir,
                'no_telepon'    => $no_telepon,
                'handphone'     => $handphone,
                'status'        => $status
            ];

            $this->db->trans_start();
            // $this->db->update('karyawan', $data, ['id_karyawan' => $id_karyawan]);
            $this->db->update('karyawan', $data, ['kode_karyawan' => $kode_karyawan]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui profil karyawan';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function upload_foto_karyawan()
    {
        $hasil = false;
        $pesan = 'Unknown error';

        $folder_name = 'public/upload/images/foto_profil/';

        $config = [
            'upload_path'       => './' . $folder_name,
            'allowed_types'     => 'jpg|png|jpeg|webp',
            'max_size'          => 2048,
            'overwrite'         => TRUE,
            'create_thumb'      => FALSE,
            'maintain_ratio'    => TRUE,
            'encrypt_name'      => TRUE,
        ];

        $this->load->library('upload', $config);

        $files    = $_FILES;
        $dataInfo = [];

        $num_files = count($_FILES['photo_file']['name']);

        for ($i = 0; $i < $num_files; $i++) {
            $_FILES['photo_file']['name']       = $files['photo_file']['name'][$i];
            $_FILES['photo_file']['type']       = $files['photo_file']['type'][$i];
            $_FILES['photo_file']['tmp_name']   = $files['photo_file']['tmp_name'][$i];
            $_FILES['photo_file']['error']      = $files['photo_file']['error'][$i];
            $_FILES['photo_file']['size']       = $files['photo_file']['size'][$i];
            // $this->upload->do_upload('photo_file');
            if (empty($files['photo_file']['name'][$i])) {
                $dataInfo[] = $this->upload->data();
            } else {
                if ($this->upload->do_upload('photo_file')) {
                    $hasil         = true;
                    $dataInfo[]    = $this->upload->data();
                    $pesan         = 'Berhasil upload gambar';
                } else {
                    $dataInfo[]    = $this->upload->data();
                    $hasil         = false;
                    $pesan         = $this->upload->display_errors();
                    return ['status' => $hasil, 'pesan' => $pesan];
                }
            }
        }

        $row = $this->db
            ->where('kode_karyawan', $this->session->userdata('kode_karyawan'))
            ->get('karyawan')
            ->row();

        if ($files['photo_file']['name'][0] != null) {
            if (!empty($row->file_foto)) {
                if (file_exists('./' . $row->file_foto)) {
                    unlink($row->file_foto);
                }
            }
            $hasil = $this->db->update('karyawan', ['file_foto' => $dataInfo[0]['file_name']], ['kode_karyawan' => $row->kode_karyawan]);
        }

        return ['status' => $hasil, 'pesan' => $pesan];
    }

    public function _getJenisASN($id_jenis_asn)
    {
        $data   = 'Data tidak ditemukan';
        $query  = $this->db
            ->select('*')
            ->from('jenis_asn')
            ->where('id_jenis_asn', $id_jenis_asn)
            ->get();

        $row = $query->row();
        if (isset($row)) {
            $data =  $row->nama;
        }

        return $data;
    }

    public function _getJabatan($id_jabatan)
    {
        $data   = 'Data tidak ditemukan';
        $query  = $this->db
            ->select('*')
            ->from('jabatan')
            ->where('id_jabatan', $id_jabatan)
            ->get();

        $row = $query->row();
        if (isset($row)) {
            $data =  $row->nama_jabatan;
        }

        return $data;
    }


    public function _getAreaKerja($id_area_kerja)
    {
        $data   = 'Data tidak ditemukan';
        $query  = $this->db
            ->select('*')
            ->from('area_kerja')
            ->where('id_area_kerja', $id_area_kerja)
            ->get();

        $row = $query->row();
        if (isset($row)) {
            $data =  $row->nama_area_kerja;
        }

        return $data;
    }

    public function _getPenempatanTugas($id_tugas)
    {
        $data   = 'Data tidak ditemukan';
        $query  = $this->db
            ->select('*')
            ->from('penempatan_tugas')
            ->where('id_penempatan_tugas', $id_tugas)
            ->get();

        $row = $query->row();
        if (isset($row)) {
            $data =  $row->nama_penempatan_tugas;
        }

        return $data;
    }
}

/* End of file Model_user.php */
/* Location: ./administrator/models/Model_user.php */
