<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_profil');
    }

    public function index()
    {
        $nip              = $this->session->userdata("nip");
        $kode_karyawan    = $this->session->userdata("kode_karyawan");

        if (!empty($nip)) {
            $foto   = $this->db
                ->select('file_foto')
                ->from('pegawai')
                ->where('nip', $nip)
                ->get()
                ->row('file_foto');

            if (empty($foto)) {
                $foto = 'blank.png';
            }

            $data = [
                'foto'  => $foto,
            ];

            $this->layout
                ->title('Profil ASN')
                ->data($data)
                ->view('asn/index');
        } else if (!empty($kode_karyawan)) {
            $foto   = $this->db
                ->select('file_foto')
                ->from('karyawan')
                ->where('kode_karyawan', $kode_karyawan)
                ->get()
                ->row('file_foto');

            if (empty($foto)) {
                $foto = 'blank.png';
            }

            $data = [
                'foto'  => $foto,
            ];

            $this->layout
                ->title('Profil Karyawan')
                ->data($data)
                ->view('karyawan/index');
        }
    }

    public function get_asn()
    {
        $nip      = $this->session->userdata("nip");
        $data     = $this->model_profil->get_asn($nip);
        responseJson($data);
    }

    public function update_asn()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_profil->update_asn($posts);
        responseJson($result);
    }

    public function upload_foto_asn()
    {
        $result   = $this->model_profil->upload_foto_asn();
        responseJson($result);
    }

    public function get_karyawan()
    {
        $kode_karyawan    = $this->session->userdata("kode_karyawan");
        $data             = $this->model_profil->get_karyawan($kode_karyawan);
        responseJson($data);
    }

    public function update_karyawan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_profil->update_karyawan($posts);
        responseJson($result);
    }

    public function upload_foto_karyawan()
    {
        $result   = $this->model_profil->upload_foto_karyawan();
        responseJson($result);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
