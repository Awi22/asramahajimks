<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_status_pegawai extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_status_pegawai');
    }

    public function index()
    {
        $this->layout
            ->title('Master Status Pegawai')
            ->view('master_status_pegawai/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_status_pegawai->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_status_pegawai_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_status_pegawai->get_status_pegawai_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_status_pegawai->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_status_pegawai->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_status_pegawai->hapus($posts);
        responseJson($data);
    }
}
