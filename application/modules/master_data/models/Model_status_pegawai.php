<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_status_pegawai extends CI_Model
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
            ->from('status_pegawai')
            ->order_by('id_status_pegawai')
            ->get();
        $no = 1;

        foreach ($query->result() as $status_pegawai) {
            $data[] = [
                'no'                    => $no++,
                'id_status_pegawai'     => $status_pegawai->id_status_pegawai,
                'nama_status_pegawai'   => $status_pegawai->nama_status_pegawai,
                'deskripsi'             => $status_pegawai->deskripsi
            ];
        }

        return $data;
    }

    public function get_status_pegawai_by_id($id)
    {
        $data_status_pegawai = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('status_pegawai')
                ->where('id_status_pegawai', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_status_pegawai = [
                    'id_status_pegawai'    => $row->id_status_pegawai,
                    'nama_status_pegawai'  => $row->nama_status_pegawai,
                    'deskripsi'            => $row->deskripsi
                ];
            }
        }
        return $data_status_pegawai;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan status pegawai';

        if (!empty($posts)) {
            $nama_status_pegawai = $posts['nama_status_pegawai'];
            $deskripsi           = $posts['deskripsi'];

            //cek existing
            $query_cek_status_pegawai = $this->db
                ->select('*')
                ->from('status_pegawai')
                ->where('nama_status_pegawai', $nama_status_pegawai)
                ->get();

            if ($query_cek_status_pegawai->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Status Pegawai sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nama_status_pegawai'  => $nama_status_pegawai,
                'deskripsi'            => $deskripsi
            ];
            $this->db->insert("status_pegawai", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan status pegawai';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui status pegawai';

        if (!empty($posts)) {
            $id_status_pegawai   = $posts['id_status_pegawai'];
            $nama_status_pegawai = $posts['nama_status_pegawai'];
            $deskripsi           = $posts['deskripsi'];

            $data = [
                'nama_status_pegawai'  => $nama_status_pegawai,
                'deskripsi'            => $deskripsi
            ];

            $this->db->trans_start();
            $this->db->update('status_pegawai', $data, ['id_status_pegawai' => $id_status_pegawai]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui status pegawai';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus status pegawai';

        if (!empty($posts)) {
            $id_status_pegawai = $posts['id_status_pegawai'];

            $this->db->trans_start();
            $this->db->delete('staus_pegawai', ['id_status_pegawai' => $id_status_pegawai]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus status pegawai';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}
