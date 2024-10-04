<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_jabatan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_jabatan');
    }

    public function index()
    {
        $this->layout
            ->title('Master Jabatan')
            ->view('master_jabatan/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_jabatan->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_jabatan_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_jabatan->get_jabatan_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_jabatan->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_jabatan->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_jabatan->hapus($posts);
        responseJson($data);
    }
}
