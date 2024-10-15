<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_asn extends CI_Model
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
            ->from('pegawai')
            ->order_by('id_pegawai')
            ->get();
        $no = 1;

        foreach ($query->result() as $pegawai) {
            $data[] = [
                'no'                    => $no++,
                'id_pegawai'            => $pegawai->id_pegawai,
                'nama_pegawai'          => $pegawai->nama_pegawai,
                'nip'                   => $pegawai->nip,
                'jenis_asn'             => $this->get_jenis_asn($pegawai->id_jenis_asn),
                'jabatan'               => $this->get_jabatan($pegawai->id_jabatan),
            ];
        }

        return $data;
    }

    public function get_asn_by_id($id)
    {
        $data_pegawai = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('pegawai')
                ->where('id_pegawai', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_pegawai = [
                    'id_pegawai'    => $row->id_pegawai,
                    'nip'           => $row->nip,
                    'id_jenis_asn'  => $row->id_jenis_asn,
                    'nama_pegawai'  => $row->nama_pegawai,
                    'id_jabatan'    => $row->id_jabatan,
                    'email'         => $row->email,
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

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan pegawai';

        if (!empty($posts)) {
            $nip            = $posts['nip'];
            $id_jenis_asn   = $posts['id_jenis_asn'];
            $nama_pegawai   = $posts['nama_pegawai'];
            $id_jabatan     = $posts['id_jabatan'];
            $email          = $posts['email'];
            $jenis_kelamin  = $posts['jenis_kelamin'];
            $id_agama       = $posts['agama'];
            $alamat         = $posts['alamat'];
            $tempat_lahir   = $posts['tempat_lahir'];
            $tgl_lahir      = $posts['tgl_lahir'];
            $no_telepon     = $posts['no_telepon'];
            $handphone      = $posts['handphone'];
            $status         = $posts['status'];

            //cek existing
            $query_cek_pegawai = $this->db
                ->select('*')
                ->from('pegawai')
                ->where('nip', $nip)
                ->get();

            if ($query_cek_pegawai->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Pegawai dengan NIP yang dimasukkan sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nip'           => $nip,
                'id_jenis_asn'  => $id_jenis_asn,
                'nama_pegawai'  => $nama_pegawai,
                'id_jabatan'    => $id_jabatan,
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
            $this->db->insert("pegawai", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan pegawai';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui pegawai';

        if (!empty($posts)) {
            $id_pegawai       = $posts['id_pegawai'];
            $nip              = $posts['nip'];
            $id_jenis_asn     = $posts['id_jenis_asn'];
            $nama_pegawai     = $posts['nama_pegawai'];
            $id_jabatan       = $posts['id_jabatan'];
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
                'nip'           => $nip,
                'id_jenis_asn'  => $id_jenis_asn,
                'nama_pegawai'  => $nama_pegawai,
                'id_jabatan'    => $id_jabatan,
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
            $this->db->update('pegawai', $data, ['id_pegawai' => $id_pegawai]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui pegawai';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus pegawai';

        if (!empty($posts)) {
            $id_pegawai = $posts['id_pegawai'];

            $this->db->trans_start();
            $this->db->delete('pegawai', ['id_pegawai' => $id_pegawai]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus pegawai';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function get_jenis_asn($id_jenis_asn)
    {
        $data = '';
        $query = $this->db
            ->select('nama')
            ->from('jenis_asn')
            ->where('id_jenis_asn', $id_jenis_asn)
            ->get()
            ->row();

        if (isset($query)) {
            $data = $query->nama;
        }

        return $data;
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

    //* Select2
    public function select2_jenisASN()
    {
        $data = [];
        $query  = $this->db->get('jenis_asn');

        if (isset($query)) {
            foreach ($query->result() as $jenis_asn) {
                $data[] = array(
                    'id'        => $jenis_asn->id_jenis_asn,
                    'text'      => $jenis_asn->nama
                );
            }
        }

        return $data;
    }

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

    // public function get_area_kerja($id_area_kerja)
    // {
    //     $data = '';
    //     $query = $this->db
    //         ->select('nama_area_kerja')
    //         ->from('area_kerja')
    //         ->where('id_area_kerja', $id_area_kerja)
    //         ->get()
    //         ->row();

    //     if (isset($query)) {
    //         $data = $query->nama_area_kerja;
    //     }

    //     return $data;
    // }

    // public function get_penempatan_tugas($id_penempatan_tugas)
    // {
    //     $data = '';
    //     $query = $this->db
    //         ->select('nama_penempatan_tugas')
    //         ->from('penempatan_tugas')
    //         ->where('id_penempatan_tugas', $id_penempatan_tugas)
    //         ->get()
    //         ->row();

    //     if (isset($query)) {
    //         $data = $query->nama_penempatan_tugas;
    //     }

    //     return $data;
    // }
}
