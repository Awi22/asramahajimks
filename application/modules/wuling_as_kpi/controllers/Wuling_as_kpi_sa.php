<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_kpi_sa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_kpi_sa');
    }

    public function index()
    {
        $this->layout
            ->title('Sales Advisor')
            ->view('kpi_sales_advisor/index');
    }

    public function get()
    {
        $data = $this->model_kpi_sa->getListData();
        responseJson(['aaData' => $data]);
    }

    public function import_excel()
    {
        $this->load->helper('file');
    }
}
