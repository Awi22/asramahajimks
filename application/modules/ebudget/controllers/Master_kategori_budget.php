<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_kategori_budget extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_kategori_budget');
	}

	public function index()
	{
		$this->layout
			->title('Kategori Budget')
			->view('master_kategori_budget/index');
	}

	//get semua data
	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_kategori_budget->get($posts);
		responseJson(['aaData' => $data]);
	}

}

/* End of file Wuling_kategori_budget.php */
/* Location: ./application/controllers/Wuling_kategori_budget.php */
