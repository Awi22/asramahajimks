<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_jenis_asn extends CI_Model
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
            ->from('jenis_asn')
            ->order_by('id_jenis_asn')
            ->get();
        $no = 1;

        foreach ($query->result() as $jenis_asn) {
            $data[] = [
                'no'                    => $no++,
                'id_jenis_asn'          => $jenis_asn->id_jenis_asn,
                'nama'                  => $jenis_asn->nama,
                'deskripsi'             => $jenis_asn->deskripsi
            ];
        }

        return $data;
    }

    public function get_jenis_asn_by_id($id)
    {
        $data_jenis_asn = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('*')
                ->from('jenis_asn')
                ->where('id_jenis_asn', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_jenis_asn = [
                    'id_jenis_asn'    => $row->id_jenis_asn,
                    'nama'            => $row->nama,
                    'deskripsi'       => $row->deskripsi
                ];
            }
        }
        return $data_jenis_asn;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan jenis ASN';

        if (!empty($posts)) {
            $nama       = $posts['nama'];
            $deskripsi  = $posts['deskripsi'];

            //cek existing
            $query_cek_jenis_asn = $this->db
                ->select('*')
                ->from('jenis_asn')
                ->where('nama', $nama)
                ->get();

            if ($query_cek_jenis_asn->num_rows() > 0) {
                return ['status' => false, 'pesan' => 'Jenis ASN sudah ada!'];
            }

            $this->db->trans_start();
            $data = [
                'nama'      => $nama,
                'deskripsi' => $deskripsi
            ];
            $this->db->insert("jenis_asn", $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan jenis ASN';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui jenis ASN';

        if (!empty($posts)) {
            $id_jenis_asn   = $posts['id_jenis_asn'];
            $nama           = $posts['nama'];
            $deskripsi      = $posts['deskripsi'];

            $data = [
                'nama'      => $nama,
                'deskripsi' => $deskripsi
            ];

            $this->db->trans_start();
            $this->db->update('jenis_asn', $data, ['id_jenis_asn' => $id_jenis_asn]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui jenis ASN';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus jenis ASN';

        if (!empty($posts)) {
            $id_jenis_asn = $posts['id_jenis_asn'];

            $this->db->trans_start();
            $this->db->delete('jenis_asn', ['id_jenis_asn' => $id_jenis_asn]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus jenis ASN';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }
}
