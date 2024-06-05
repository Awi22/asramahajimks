<?php

use Rakit\Validation\Validator;


if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_spk_progress extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_spk_progress');
    }


    public function index()
    {
        $this->layout
            ->title('Data Spk Progress')
            ->view('spk_progress/spk_progress');
    }

    public function getDataSpk()
    {
        $data = $this->Model_spk_progress->getDataSpk($this->id_sales);
        responseJson(['aaData' => $data]);
    }
}
