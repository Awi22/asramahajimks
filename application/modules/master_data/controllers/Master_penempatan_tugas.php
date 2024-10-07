<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_penempatan_tugas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_penempatan_tugas');
    }

    public function index()
    {
        $this->layout
            ->title('Master Penempatan Tugas')
            ->view('master_penempatan_tugas/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_penempatan_tugas->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_penempatan_tugas_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_penempatan_tugas->get_penempatan_tugas_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_penempatan_tugas->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_penempatan_tugas->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_penempatan_tugas->hapus($posts);
        responseJson($data);
    }
}
