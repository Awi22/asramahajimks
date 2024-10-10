<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_jenis_asn extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_jenis_asn');
    }

    public function index()
    {
        $this->layout
            ->title('Master Jenis ASN')
            ->view('master_jenis_asn/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_jenis_asn->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_jenis_asn_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_jenis_asn->get_jenis_asn_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_jenis_asn->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_jenis_asn->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_jenis_asn->hapus($posts);
        responseJson($data);
    }
}
