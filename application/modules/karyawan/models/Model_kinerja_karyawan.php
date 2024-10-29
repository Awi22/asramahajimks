<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_kinerja_karyawan extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->username = $this->session->userdata('username');
    }

    public function get($gets)
    {
        $data          = array();

        $kode_karyawan = $this->kode_karyawan;
        $tgl_awal      = tgl_sql($gets['tgl_awal']);
        $tgl_akhir     = tgl_sql($gets['tgl_akhir']);

        $query = $this->db
            ->select('kk.*, k.nama_karyawan')
            ->from('kinerja_karyawan kk')
            ->join('karyawan k', 'k.kode_karyawan = kk.kode_karyawan')
            ->where('kk.kode_karyawan', $kode_karyawan)
            ->where('kk.tanggal >=', $tgl_awal)
            ->where('kk.tanggal <=', $tgl_akhir)
            ->order_by('kk.tanggal', 'asc')
            ->get();
        $no = 1;

        foreach ($query->result() as $kinerja) {
            $data[] = [
                'no'                => $no++,
                'id'                => $kinerja->id,
                'tanggal'           => tgl_str($kinerja->tanggal),
                'nama'              => $kinerja->nama_karyawan,
                'ranah_kerja'       => $kinerja->ranah_kerja,
                'uraian_pekerjaan'  => $kinerja->uraian,
                'kendala'           => $kinerja->kendala,
                'absensi'           => $kinerja->absensi,
            ];
        }

        return $data;
    }

    public function get_by_id($id)
    {
        $data_kinerja = NULL;

        if (!empty($id)) {
            $query = $this->db
                ->select('kk.*, k.kode_karyawan, k.nama_karyawan')
                ->from('kinerja_karyawan kk')
                ->join('karyawan k', 'k.kode_karyawan = kk.kode_karyawan')
                ->where('kk.id', $id)
                ->get();

            $row = $query->row();
            if (isset($row)) {
                $data_kinerja = [
                    'id_kinerja'        => $row->id,
                    'kode_karyawan'     => $row->kode_karyawan,
                    'nama_karyawan'     => $row->nama_karyawan,
                    'tanggal'           => tgl_str($row->tanggal),
                    'ranah_kerja'       => $row->ranah_kerja,
                    'uraian'            => $row->uraian,
                    'kendala'           => $row->kendala,
                    'absensi'           => $row->absensi,
                ];
            }
        }
        return $data_kinerja;
    }

    public function simpan($posts)
    {
        $status   = false;
        $pesan    = 'Gagal menyimpan data kinerja!';

        if (!empty($posts)) {
            $kode_karyawan  = $posts['kode_karyawan'];
            $jabatan        = $this->id_jabatan;
            $area_kerja     = $this->_getAreaKerja($kode_karyawan);
            $ranah_kerja    = $posts['ranah_kerja'];
            $tanggal        = tgl_sql($posts['tgl_kinerja']);
            $uraian         = $posts['uraian'];
            $kendala        = $posts['kendala'];
            $absensi        = $posts['absensi'];

            $this->db->trans_start();
            $data = [
                'kode_karyawan'  => $kode_karyawan,
                'id_jabatan'     => $jabatan,
                'id_area_kerja'  => $area_kerja,
                'ranah_kerja'    => $ranah_kerja,
                'tanggal'        => $tanggal,
                'uraian'         => $uraian,
                'kendala'        => $kendala,
                'absensi'        => $absensi,
            ];
            $this->db->insert('kinerja_karyawan', $data);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menyimpan data kinerja';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function update($posts)
    {
        $status   = false;
        $pesan    = 'Gagal memperbarui kinerja karyawan';

        if (!empty($posts)) {
            $id             = $posts['id'];
            // $kode_karyawan  = $posts['kode_karyawan'];
            // $nama_karyawan  = $posts['nama_karyawan'];
            $ranah_kerja    = $posts['ranah_kerja'];
            $tanggal        = tgl_sql($posts['tgl_kinerja']);
            $uraian         = $posts['uraian'];
            $kendala        = $posts['kendala'];
            $absensi        = $posts['absensi'];

            $data = [
                // 'kode_karyawan' => $kode_karyawan,
                // 'nama_karyawan' => $nama_karyawan,
                'ranah_kerja'    => $ranah_kerja,
                'tanggal'        => $tanggal,
                'uraian'         => $uraian,
                'kendala'        => $kendala,
                'absensi'        => $absensi,
            ];

            $this->db->trans_start();
            $this->db->update('kinerja_karyawan', $data, ['id' => $id]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status   = true;
                $pesan    = 'Berhasil memperbarui kinerja karyawan';
            }
        };

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function hapus($posts)
    {
        $status = false;
        $pesan  = 'Gagal menghapus kinerja';

        if (!empty($posts)) {
            $id = $posts['id'];

            $this->db->trans_start();
            $this->db->delete('kinerja_karyawan', ['id' => $id]);
            $this->db->trans_complete();

            if ($this->db->trans_status() === true) {
                $status = true;
                $pesan  = 'Berhasil menghapus kinerja';
            }
        }

        $result = ['status' => $status, 'pesan' => $pesan];
        return $result;
    }

    public function _getAreaKerja($kode_karyawan)
    {
        $data = '';
        $query = $this->db
            ->select('id_area_kerja')
            ->from('karyawan')
            ->where('kode_karyawan', $kode_karyawan)
            ->get()
            ->row();

        if (isset($query)) {
            $data = $query->id_area_kerja;
        }

        return $data;
    }

    //* Laporan Kinerja
    public function get_laporan($gets)
    {
        $data          = array();

        $coverage      = explode(',', $this->coverage);
        $area_kerja    = $gets['area_kerja'];
        $tgl_awal      = tgl_sql($gets['tgl_awal']);
        $tgl_akhir     = tgl_sql($gets['tgl_akhir']);

        if (!empty($area_kerja)) {
            $this->db->where_in('kk.id_area_kerja', $area_kerja);
        } else {
            $this->db->where_in('kk.id_area_kerja', $coverage);
        }

        $query = $this->db
            ->select('kk.*, k.nama_karyawan')
            ->from('kinerja_karyawan kk')
            ->join('karyawan k', 'k.kode_karyawan = kk.kode_karyawan')
            ->where('kk.tanggal >=', $tgl_awal)
            ->where('kk.tanggal <=', $tgl_akhir)
            ->order_by('kk.tanggal asc, k.nama_karyawan asc')
            ->get();
        $no = 1;

        foreach ($query->result() as $kinerja) {
            $data[] = [
                'no'                => $no++,
                'tanggal'           => tgl_str($kinerja->tanggal),
                'nama'              => $kinerja->nama_karyawan,
                'ranah_kerja'       => $kinerja->ranah_kerja,
                'uraian_pekerjaan'  => $kinerja->uraian,
                'kendala'           => $kinerja->kendala,
                'absensi'           => $kinerja->absensi,
            ];
        }

        return $data;
    }

    public function select2_area_kerja()
    {
        $data       = [];
        $coverage   = explode(',', $this->coverage);
        $query      = $this->db
            ->select('id_area_kerja, nama_area_kerja')
            ->from('area_kerja')
            ->where_in('id_area_kerja', $coverage)
            ->get();

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
}
