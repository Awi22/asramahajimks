<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_area_kerja extends CI_Model
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
            ->from('area_kerja')
            ->order_by('id_area_kerja')
            ->get();
        $no = 1;

        foreach ($query->result() as $area_kerja) {
            $data[] = [
                'no'               => $no++,
                'id_area_kerja'    => $area_kerja->id_area_kerja,
                'nama_area_kerja'  => $area_kerja->nama_area_kerja,
            ];
        }

        return $data;
    }

    public function get_area_kerja_by_id($id)
    {
        $data_area_kerja = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('area_kerja')
                ->where('id_area_kerja', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_area_kerja = [
                    'id_area_kerja'    => $row->id_area_kerja,
                    'nama_area_kerja'  => $row->nama_area_kerja,
                ];
            }
        }
        return $data_area_kerja;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan area kerja';

        if (!empty($posts)) {
            $nama_area_kerja = $posts['nama_area_kerja'];

            //cek existing
            $query_cek_area_kerja = $this->db
                ->select('*')
                ->from('area_kerja')
                ->where('nama_area_kerja', $nama_area_kerja)
                ->get();

            if ($query_cek_area_kerja->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Nama area kerja sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nama_area_kerja'  => $nama_area_kerja,
            ];
            $this->db->insert("area_kerja", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan area kerja';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui area kerja';

        if (!empty($posts)) {
            $id_area_kerja   = $posts['id_area_kerja'];
            $nama_area_kerja = $posts['nama_area_kerja'];

            $data = [
                'nama_area_kerja'  => $nama_area_kerja
            ];

            $this->db->trans_start();
            $this->db->update('area_kerja', $data, ['id_area_kerja' => $id_area_kerja]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui area kerja';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus area kerja';

        if (!empty($posts)) {
            $id_area_kerja = $posts['id_area_kerja'];

            $this->db->trans_start();
            $this->db->delete('area_kerja', ['id_area_kerja' => $id_area_kerja]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus area kerja';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}
