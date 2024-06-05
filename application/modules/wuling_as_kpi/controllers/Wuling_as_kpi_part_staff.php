<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_kpi_part_staff extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_kpi_part_staff');
    }

    public function index()
    {
        $this->layout
            ->title('Part Staff')
            ->view('kpi_part_staff/index');
    }

    public function get()
    {
        $data = $this->model_kpi_part_staff->get();
        responseJson(['aaData' => $data]);
    }

    public function import_excel()
    {
        $this->load->helper('file');
    }
}
