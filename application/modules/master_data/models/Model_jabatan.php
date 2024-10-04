<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_jabatan extends CI_Model
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
            ->from('jabatan')
            ->order_by('id_jabatan')
            ->get();
        $no = 1;

        foreach ($query->result() as $jabatan) {
            $data[] = [
                'no'            => $no++,
                'id_jabatan'    => $jabatan->id_jabatan,
                'nama_jabatan'  => $jabatan->nama_jabatan,
                'deskripsi'     => $jabatan->deskripsi
            ];
        }

        return $data;
    }

    public function get_jabatan_by_id($id)
    {
        $data_jabatan = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('jabatan')
                ->where('id_jabatan', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_jabatan = [
                    'id_jabatan'    => $row->id_jabatan,
                    'nama_jabatan'  => $row->nama_jabatan,
                    'deskripsi'     => $row->deskripsi
                ];
            }
        }
        return $data_jabatan;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan jabatan';

        if (!empty($posts)) {
            $nama_jabatan = $posts['nama_jabatan'];
            $deskripsi = $posts['deskripsi'];

            //cek existing
            $query_cek_jabatan = $this->db
                ->select('*')
                ->from('jabatan')
                ->where('nama_jabatan', $nama_jabatan)
                ->get();

            if ($query_cek_jabatan->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Nama Jabatan sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nama_jabatan'  => $nama_jabatan,
                'deskripsi'     => $deskripsi
            ];
            $this->db->insert("jabatan", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan jabatan';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui jabatan';

        if (!empty($posts)) {
            $id_jabatan   = $posts['id_jabatan'];
            $nama_jabatan = $posts['nama_jabatan'];
            $deskripsi    = $posts['deskripsi'];

            $data = [
                'nama_jabatan'  => $nama_jabatan,
                'deskripsi'     => $deskripsi
            ];

            $this->db->trans_start();
            $this->db->update('jabatan', $data, ['id_jabatan' => $id_jabatan]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui jabatan';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus jabatan';

        if (!empty($posts)) {
            $id_jabatan = $posts['id_jabatan'];

            $this->db->trans_start();
            $this->db->delete('jabatan', ['id_jabatan' => $id_jabatan]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus jabatan';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}
