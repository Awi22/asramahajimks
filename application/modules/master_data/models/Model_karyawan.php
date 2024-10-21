<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_karyawan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->username = $this->session->userdata('username');
    }

    public function get()
    {
        $data = array();
        $query = $this->db
            ->select('*')
            ->from('karyawan')
            ->order_by('id_karyawan')
            ->get();
        $no = 1;

        foreach ($query->result() as $karyawan) {
            $data[] = [
                'no'                    => $no++,
                'id_karyawan'           => $karyawan->id_karyawan,
                'nama_karyawan'         => $karyawan->nama_karyawan,
                'jabatan'               => $this->get_jabatan($karyawan->id_jabatan),
                'area_kerja'            => $this->get_area_kerja($karyawan->id_area_kerja),
                'penempatan_tugas'      => $this->get_penempatan_tugas($karyawan->id_tugas),
            ];
        }

        return $data;
    }

    public function get_karyawan_by_id($id)
    {
        $data_karyawan = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('karyawan')
                ->where('id_karyawan', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_karyawan = [
                    'kode_karyawan' => $row->kode_karyawan,
                    'id_karyawan'   => $row->id_karyawan,
                    'nama_karyawan' => $row->nama_karyawan,
                    'id_jabatan'    => $row->id_jabatan,
                    'id_area_kerja' => $row->id_area_kerja,
                    'id_tugas'      => $row->id_tugas,
                    'jenis_kelamin' => $row->jenis_kelamin,
                    'id_agama'      => $row->id_agama,
                    'email'         => $row->email,
                    'alamat'        => $row->alamat,
                    'tempat_lahir'  => $row->tempat_lahir,
                    'tgl_lahir'     => $row->tgl_lahir,
                    'no_telepon'    => $row->no_telepon,
                    'handphone'     => $row->handphone,
                    'status'        => $row->status
                ];
            }
        }
        return $data_karyawan;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan karyawan';

        if (!empty($posts)) {
            $kode_karyawan  = $posts['kode_karyawan'];
            $nama_karyawan  = $posts['nama_karyawan'];
            $jabatan        = $posts['jabatan'];
            $area_kerja     = $posts['area_kerja'];
            $tugas          = $posts['tugas'];
            $jenis_kelamin  = $posts['jenis_kelamin'];
            $agama          = $posts['agama'];
            $email          = $posts['email'];
            $alamat         = $posts['alamat'];
            $tempat_lahir   = $posts['tempat_lahir'];
            $tgl_lahir      = $posts['tgl_lahir'];
            $no_telepon     = $posts['no_telepon'];
            $handphone      = $posts['handphone'];
            $status         = $posts['status'];

            //cek existing
            $query_cek_karyawan = $this->db
                ->select('*')
                ->from('karyawan')
                ->where('kode_karyawan', $kode_karyawan)
                ->get();

            if ($query_cek_karyawan->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Kode karyawan sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'kode_karyawan' => $kode_karyawan,
                'nama_karyawan' => $nama_karyawan,
                'id_jabatan'    => $jabatan,
                'id_area_kerja' => $area_kerja,
                'id_tugas'      => $tugas,
                'jenis_kelamin' => $jenis_kelamin,
                'id_agama'      => $agama,
                'email'         => $email,
                'alamat'        => $alamat,
                'tempat_lahir'  => $tempat_lahir,
                'tgl_lahir'     => $tgl_lahir,
                'no_telepon'    => $no_telepon,
                'handphone'     => $handphone,
                'status'        => $status
            ];
            $this->db->insert("karyawan", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan karyawan';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui karyawan';

        if (!empty($posts)) {
            $id_karyawan    = $posts['id_karyawan'];
            $kode_karyawan  = $posts['kode_karyawan'];
            $nama_karyawan  = $posts['nama_karyawan'];
            $jabatan        = $posts['jabatan'];
            $area_kerja     = $posts['area_kerja'];
            $tugas          = $posts['tugas'];
            $jenis_kelamin  = $posts['jenis_kelamin'];
            $agama          = $posts['agama'];
            $email          = $posts['email'];
            $alamat         = $posts['alamat'];
            $tempat_lahir   = $posts['tempat_lahir'];
            $tgl_lahir      = $posts['tgl_lahir'];
            $no_telepon     = $posts['no_telepon'];
            $handphone      = $posts['handphone'];
            $status         = $posts['status'];

            $data = [
                'kode_karyawan' => $kode_karyawan,
                'nama_karyawan' => $nama_karyawan,
                'id_jabatan'    => $jabatan,
                'id_area_kerja' => $area_kerja,
                'id_tugas'      => $tugas,
                'jenis_kelamin' => $jenis_kelamin,
                'id_agama'      => $agama,
                'email'         => $email,
                'alamat'        => $alamat,
                'tempat_lahir'  => $tempat_lahir,
                'tgl_lahir'     => $tgl_lahir,
                'no_telepon'    => $no_telepon,
                'handphone'     => $handphone,
                'status'        => $status
            ];

            $this->db->trans_start();
            $this->db->update('karyawan', $data, ['id_karyawan' => $id_karyawan]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui karyawan';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus karyawan';

        if (!empty($posts)) {
            $id_karyawan = $posts['id_karyawan'];

            $this->db->trans_start();
            $this->db->delete('karyawan', ['id_karyawan' => $id_karyawan]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus karyawan';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function get_jabatan($id_jabatan)
    {
        $data = '';
        $query = $this->db
            ->select('nama_jabatan')
            ->from('jabatan')
            ->where('id_jabatan', $id_jabatan)
            ->get()
            ->row();

        if (isset($query)) {
            $data = $query->nama_jabatan;
        }

        return $data;
    }

    public function get_area_kerja($id_area_kerja)
    {
        $data = '';
        $query = $this->db
            ->select('nama_area_kerja')
            ->from('area_kerja')
            ->where('id_area_kerja', $id_area_kerja)
            ->get()
            ->row();

        if (isset($query)) {
            $data = $query->nama_area_kerja;
        }

        return $data;
    }

    public function get_penempatan_tugas($id_penempatan_tugas)
    {
        $data = '';
        $query = $this->db
            ->select('nama_penempatan_tugas')
            ->from('penempatan_tugas')
            ->where('id_penempatan_tugas', $id_penempatan_tugas)
            ->get()
            ->row();

        if (isset($query)) {
            $data = $query->nama_penempatan_tugas;
        }

        return $data;
    }

    //* Select2
    public function select2_jabatan()
    {
        $data = [];
        $query  = $this->db->get('jabatan');

        if (isset($query)) {
            foreach ($query->result() as $jabatan) {
                $data[] = array(
                    'id'        => $jabatan->id_jabatan,
                    'text'      => $jabatan->nama_jabatan
                );
            }
        }

        return $data;
    }

    public function select2_area_kerja()
    {
        $data = [];
        $query  = $this->db->get('area_kerja');

        if (isset($query)) {
            foreach ($query->result() as $area_kerja) {
                $data[] = array(
                    'id'        => $area_kerja->id_area_kerja,
                    'text'      => $area_kerja->nama_area_kerja
                );
            }
        }

        return $data;
    }

    public function select2_penempatan_tugas()
    {
        $data = [];
        $query  = $this->db->get('penempatan_tugas');

        if (isset($query)) {
            foreach ($query->result() as $penempatan_tugas) {
                $data[] = array(
                    'id'        => $penempatan_tugas->id_penempatan_tugas,
                    'text'      => $penempatan_tugas->nama_penempatan_tugas
                );
            }
        }

        return $data;
    }

    public function select2_agama()
    {
        $data = [];
        $query  = $this->db->get('agama');

        if (isset($query)) {
            foreach ($query->result() as $agama) {
                $data[] = array(
                    'id'        => $agama->id_agama,
                    'text'      => $agama->nama_agama
                );
            }
        }

        return $data;
    }

    public function getKodeKaryawan()
    {
        $data = $this->db
            ->select('kode_karyawan')
            ->order_by('kode_karyawan', 'desc')
            ->get('karyawan', 1);

        if ($data->num_rows() > 0) {
            $row    = $data->row();
            $kode   = $row->kode_karyawan;
        } else {
            $kode = null;
        }

        // Generate kode baru
        if ($kode) {
            $lastNumber = (int) substr($kode, 1);
            $newNumber  = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format kode baru (K + 3 digit angka)
        $newKode = "K" . str_pad($newNumber, 3, "0", STR_PAD_LEFT);

        return $newKode;
    }
}
