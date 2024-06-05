<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_test_drive extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_test_drive');
    }


    public function index()
    {
        $this->layout
            ->title('Data Test Drive')
            ->view('test_drive/test_drive');
    }

    public function getDataTestDrive()
    {
        $post = $this->input->post();
        $data = $this->Model_test_drive->getDataTestDrive($post['tahun'], $post['bulan'], $this->id_sales);
        responseJson(['aaData' => $data]);
    }

    public function getDataDetailTestDrive()
    {
        $id_prospek = $this->input->post('id_prospek');
        $data = $this->Model_test_drive->getDataDetailTestDrive($id_prospek);
        responseJson($data);
    }

    public function getDataUnit()
    {
        $kode_unit = $this->input->post('kode_unit');
        $data = $this->Model_test_drive->getDataUnit($kode_unit);
        responseJson($data);
    }

    public function getDataPekerjaan()
    {
        $pekerjaan = $this->input->post('pekerjaan');
        $data = $this->Model_test_drive->getDataPekerjaan($pekerjaan);
        responseJson($data);
    }
}
