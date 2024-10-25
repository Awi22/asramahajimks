<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan_daftar_kinerja extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_kinerja_karyawan');
    }

    public function index()
    {
        $this->layout
            ->title('Daftar Kinerja Karyawan')
            ->view('karyawan_daftar_kinerja/index');
    }

    public function get()
    {
        $gets    = $this->input->get();
        $data    = $this->model_kinerja_karyawan->get($gets);
        responseJson(['aaData' => $data]);
    }

    public function get_by_id()
    {
        $id      = $this->input->get('id');
        $data    = $this->model_kinerja_karyawan->get_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $post    = $this->input->post(NULL, TRUE);
        $data    = $this->model_kinerja_karyawan->simpan($post);
        responseJson($data);
    }

    public function update()
    {
        $post    = $this->input->post(NULL, TRUE);
        $data    = $this->model_kinerja_karyawan->update($post);
        responseJson($data);
    }

    public function hapus()
    {
        $post    = $this->input->post(NULL, TRUE);
        $data    = $this->model_kinerja_karyawan->hapus($post);
        responseJson($data);
    }

    public function get_KodeKaryawan()
    {
        $data     = $this->kode_karyawan;
        responseJson($data);
    }

    public function get_NamaKaryawan()
    {
        $data     = $this->nama_lengkap;
        responseJson($data);
    }
}
