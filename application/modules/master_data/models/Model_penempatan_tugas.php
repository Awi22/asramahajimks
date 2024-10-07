<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_penempatan_tugas extends CI_Model
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
            ->from('penempatan_tugas')
            ->order_by('id_penempatan_tugas')
            ->get();
        $no = 1;

        foreach ($query->result() as $penempatan_tugas) {
            $data[] = [
                'no'                     => $no++,
                'id_penempatan_tugas'    => $penempatan_tugas->id_penempatan_tugas,
                'nama_penempatan_tugas'  => $penempatan_tugas->nama_penempatan_tugas,
            ];
        }

        return $data;
    }

    public function get_penempatan_tugas_by_id($id)
    {
        $data_penempatan_tugas = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('penempatan_tugas')
                ->where('id_penempatan_tugas', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_penempatan_tugas = [
                    'id_penempatan_tugas'    => $row->id_penempatan_tugas,
                    'nama_penempatan_tugas'  => $row->nama_penempatan_tugas,
                ];
            }
        }
        return $data_penempatan_tugas;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan penempatan tugas';

        if (!empty($posts)) {
            $nama_penempatan_tugas = $posts['nama_penempatan_tugas'];

            //cek existing
            $query_cek_penempatan_tugas = $this->db
                ->select('*')
                ->from('penempatan_tugas')
                ->where('nama_penempatan_tugas', $nama_penempatan_tugas)
                ->get();

            if ($query_cek_penempatan_tugas->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Nama penempatan tugas sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nama_penempatan_tugas'  => $nama_penempatan_tugas,
            ];
            $this->db->insert("penempatan_tugas", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan penempatan tugas';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui penempatan tugas';

        if (!empty($posts)) {
            $id_penempatan_tugas   = $posts['id_penempatan_tugas'];
            $nama_penempatan_tugas = $posts['nama_penempatan_tugas'];

            $data = [
                'nama_penempatan_tugas'  => $nama_penempatan_tugas
            ];

            $this->db->trans_start();
            $this->db->update('penempatan_tugas', $data, ['id_penempatan_tugas' => $id_penempatan_tugas]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui penempatan tugas';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus penempatan tugas';

        if (!empty($posts)) {
            $id_penempatan_tugas = $posts['id_penempatan_tugas'];

            $this->db->trans_start();
            $this->db->delete('penempatan_tugas', ['id_penempatan_tugas' => $id_penempatan_tugas]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus penempatan tugas';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}
