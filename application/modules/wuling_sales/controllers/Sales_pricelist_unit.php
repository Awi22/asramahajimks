<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_pricelist_unit extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pricelist');
    }

    public function index()
    {
        $this->layout
            ->title('Pricelist Unit')
            ->view('pricelist/pricelist');
    }

    public function getDataVarian()
    {
        $data = $this->Model_pricelist->getDataVarian();
        responseJson($data);
    }

    public function getDataPricelistUnit()
    {
        $id_varian = $this->input->post('id_varian');
        $data = $this->Model_pricelist->getDataPricelistUnit($id_varian, $this->id_perusahaan);
        responseJson(['aaData' => $data]);
    }
}
