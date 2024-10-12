<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_agama extends CI_Model
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
            ->from('agama')
            ->order_by('id_agama')
            ->get();
        $no = 1;

        foreach ($query->result() as $agama) {
            $data[] = [
                'no'          => $no++,
                'id_agama'    => $agama->id_agama,
                'nama_agama'  => $agama->nama_agama,
            ];
        }

        return $data;
    }

    public function get_agama_by_id($id)
    {
        $data_agama = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('agama')
                ->where('id_agama', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_agama = [
                    'id_agama'    => $row->id_agama,
                    'nama_agama'  => $row->nama_agama,
                ];
            }
        }
        return $data_agama;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan agama';

        if (!empty($posts)) {
            $nama_agama = $posts['nama_agama'];

            //cek existing
            $query_cek_agama = $this->db
                ->select('*')
                ->from('agama')
                ->where('nama_agama', $nama_agama)
                ->get();

            if ($query_cek_agama->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Nama agama sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nama_agama'  => $nama_agama,
            ];
            $this->db->insert("agama", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan agama';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui agama';

        if (!empty($posts)) {
            $id_agama   = $posts['id_agama'];
            $nama_agama = $posts['nama_agama'];

            $data = [
                'nama_agama'  => $nama_agama
            ];

            $this->db->trans_start();
            $this->db->update('agama', $data, ['id_agama' => $id_agama]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui agama';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus agama';

        if (!empty($posts)) {
            $id_agama = $posts['id_agama'];

            $this->db->trans_start();
            $this->db->delete('agama', ['id_agama' => $id_agama]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus agama';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}
