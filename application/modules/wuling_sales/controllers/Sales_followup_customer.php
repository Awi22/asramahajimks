<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_followup_customer extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_followup_customer');
    }


    public function index()
    {
        $this->layout
            ->title('Data Followup Customer')
            ->view('followup_customer/followup_customer');
    }

    public function getDataFuSales()
    {
        $post = $this->input->post();
        $data = $this->Model_followup_customer->getDataFuSales($post['tgl_awal'], $post['tgl_akhir'], $this->id_sales);
        responseJson(['aaData' => $data]);
    }

    public function detail()
    {
        $tgl_awal = $this->input->get('tgl_awal');
        $tgl_akhir = $this->input->get('tgl_akhir');
        $data = [
            'history' => $this->Model_followup_customer->getDataDetailFuPerHistory($tgl_awal, $tgl_akhir, $this->id_sales),
            'jadwal' => $this->Model_followup_customer->getDataDetailFuPerJadwal($tgl_awal, $tgl_akhir, $this->id_sales),
            'new' => $this->Model_followup_customer->getDataDetailFuNewProspek($tgl_awal, $tgl_akhir, $this->id_sales),

        ];
        $this->layout
            ->title('Data Detail Followup Customer')
            ->data($data)
            ->view('followup_customer/followup_detail_customer');
    }
}
