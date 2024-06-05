<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_customer_dgital extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_customer_digital');
        $this->load->model('Model_customer');
    }


    public function index()
    {
        $data = [
            'id_prospek' => $this->Model_customer->createId(),
        ];
        $this->layout
            ->title('Data Digital Customer')
            ->data($data)
            ->view('customer/customer_digital');
    }

    public function getDataCsutomerDigital()
    {
        $post = $this->input->post();
        $data = $this->Model_customer_digital->getDataCsutomerDigital($this->id_sales);
        responseJson(['aaData' => $data]);
    }
}
