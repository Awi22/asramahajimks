<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_survai_do extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_survai_do');
    }


    public function index()
    {
        $this->layout
            ->title('Data Survai DO')
            ->view('survai_do/survai_do');
    }

    public function getDataSurvaiDO()
    {
        $data = $this->Model_survai_do->getDataSurvaiDO($this->id_sales);
        responseJson(['aaData' => $data]);
    }
}
