<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adm_sp_item extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_adm_sp_item');
    }

    public function index()
    {
        $this->layout
            ->title('Master Item Part')
            ->view('item/item');
    }

    public function get()
    {
        $data = $this->model_adm_sp_item->get();
        responseJson(['aaData' => $data]);
    }

    public function select2_class()
    {
        $data = $this->model_adm_sp_item->get_class();
        responseJson($data);
    }

    public function select2_tipe()
    {
        $data = $this->model_adm_sp_item->get_tipe();
        responseJson($data);
    }

    public function select2_kategori()
    {
        $data = $this->model_adm_sp_item->get_kategori();
        responseJson($data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
