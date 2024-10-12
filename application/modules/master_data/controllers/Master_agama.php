<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_agama extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_agama');
    }

    public function index()
    {
        $this->layout
            ->title('Master Agama')
            ->view('master_agama/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_agama->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_agama_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_agama->get_agama_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_agama->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_agama->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_agama->hapus($posts);
        responseJson($data);
    }
}
