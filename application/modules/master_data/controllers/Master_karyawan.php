<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_karyawan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_karyawan');
    }

    public function index()
    {
        $this->layout
            ->title('Master Karyawan')
            ->view('master_karyawan/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_karyawan->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_karyawan_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_karyawan->get_karyawan_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_karyawan->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_karyawan->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_karyawan->hapus($posts);
        responseJson($data);
    }

    public function select2_jabatan()
    {
        $data     = $this->model_karyawan->select2_jabatan();
        responseJson($data);
    }

    public function select2_area_kerja()
    {
        $data     = $this->model_karyawan->select2_area_kerja();
        responseJson($data);
    }

    public function select2_penempatan_tugas()
    {
        $data     = $this->model_karyawan->select2_penempatan_tugas();
        responseJson($data);
    }

    public function select2_agama()
    {
        $data     = $this->model_karyawan->select2_agama();
        responseJson($data);
    }

    public function getKodeKaryawan()
    {
        $data     = $this->model_karyawan->getKodeKaryawan();
        responseJson($data);
    }
}
