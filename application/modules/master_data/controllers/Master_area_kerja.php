<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_area_kerja extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_area_kerja');
    }

    public function index()
    {
        $this->layout
            ->title('Master Area Kerja')
            ->view('master_area_kerja/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_area_kerja->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_area_kerja_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_area_kerja->get_area_kerja_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_area_kerja->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_area_kerja->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_area_kerja->hapus($posts);
        responseJson($data);
    }
}
