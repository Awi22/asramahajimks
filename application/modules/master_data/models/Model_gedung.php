<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_gedung extends CI_Model
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
            ->from('gedung')
            ->order_by('id_gedung')
            ->get();
        $no = 1;

        foreach ($query->result() as $gedung) {
            $data[] = [
                'no'           => $no++,
                'id_gedung'    => $gedung->id_gedung,
                'nama_gedung'  => $gedung->nama_gedung,
            ];
        }

        return $data;
    }

    public function get_gedung_by_id($id)
    {
        $data_gedung = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('gedung')
                ->where('id_gedung', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_gedung = [
                    'id_gedung'    => $row->id_gedung,
                    'nama_gedung'  => $row->nama_gedung,
                ];
            }
        }
        return $data_gedung;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan gedung';

        if (!empty($posts)) {
            $nama_gedung = $posts['nama_gedung'];

            //cek existing
            $query_cek_gedung = $this->db
                ->select('*')
                ->from('gedung')
                ->where('nama_gedung', $nama_gedung)
                ->get();

            if ($query_cek_gedung->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Nama gedung sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nama_gedung'  => $nama_gedung,
            ];
            $this->db->insert("gedung", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan gedung';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui gedung';

        if (!empty($posts)) {
            $id_gedung   = $posts['id_gedung'];
            $nama_gedung = $posts['nama_gedung'];

            $data = [
                'nama_gedung'  => $nama_gedung
            ];

            $this->db->trans_start();
            $this->db->update('gedung', $data, ['id_gedung' => $id_gedung]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui gedung';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus gedung';

        if (!empty($posts)) {
            $id_gedung = $posts['id_gedung'];

            $this->db->trans_start();
            $this->db->delete('gedung', ['id_gedung' => $id_gedung]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus gedung';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}
