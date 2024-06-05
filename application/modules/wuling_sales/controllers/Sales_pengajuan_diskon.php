<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_pengajuan_diskon extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pengajuan_diskon');
    }

    public function index()
    {
        $this->layout
            ->title('Pengajuan Diskon')
            ->view('pengajuan_diskon/pengajuan_diskon');
    }

    public function getDataPengajuanDiskon()
    {
        $post = $this->input->post();
        $data = $this->Model_pengajuan_diskon->getDataPengajuanDiskon($this->id_sales);
        responseJson(['aaData' => $data]);
    }
}
