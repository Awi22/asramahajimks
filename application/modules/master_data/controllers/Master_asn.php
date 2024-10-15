<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_asn extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_asn');
    }

    public function index()
    {
        $this->layout
            ->title('Master Daftar ASN')
            ->view('master_asn/index');
    }

    public function get()
    {
        $posts    = $this->input->get();
        $data     = $this->model_asn->get($posts);
        responseJson(['aaData' => $data]);
    }

    public function get_asn_by_id()
    {
        $id       = $this->input->get('id');
        $data     = $this->model_asn->get_asn_by_id($id);
        responseJson($data);
    }

    public function simpan()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_asn->simpan($posts);
        responseJson($data);
    }

    public function update()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $result   = $this->model_asn->update($posts);
        responseJson($result);
    }

    public function hapus()
    {
        $posts    = $this->input->post(NULL, TRUE);
        $data     = $this->model_asn->hapus($posts);
        responseJson($data);
    }

    public function select2_jenisASN()
    {
        $data     = $this->model_asn->select2_jenisASN();
        responseJson($data);
    }

    public function select2_jabatan()
    {
        $data     = $this->model_asn->select2_jabatan();
        responseJson($data);
    }

    public function select2_agama()
    {
        $data     = $this->model_asn->select2_agama();
        responseJson($data);
    }
}
