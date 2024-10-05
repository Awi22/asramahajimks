<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_gedung extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_gedung');
    }

    public function index()
    {
        $this->layout
            ->title('Master Gedung')
            ->view('master_gedung/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_gedung->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_gedung_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_gedung->get_gedung_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_gedung->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_gedung->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_gedung->hapus($posts);
        responseJson($data);
    }
}
