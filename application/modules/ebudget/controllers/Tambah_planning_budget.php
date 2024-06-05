<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tambah_planning_budget extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_tambah_planning_budget');
	}

	public function index()
	{
		$this->layout
			->title('Tambah Planning Budget')
			->view('tambah_planning_budget/index');
	}

	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_tambah_planning_budget->get($posts);
		responseJson(['aaData' => $data]);
	}

	public function select2_kategori()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$hasil	= $this->model_tambah_planning_budget->select2_kategori($posts);
		return $hasil;
	}

	public function select2_sub_kategori()
	{
		$kategori	= $this->input->post('kategori');
		$hasil	= $this->model_tambah_planning_budget->select2_sub_kategori($kategori);
		return $hasil;
	}

	public function select2_coa_budget()
	{
		$sub_kategori	= $this->input->post('sub_kategori');
		$hasil	= $this->model_tambah_planning_budget->select2_coa_budget($sub_kategori);
		return $hasil;
	}

	public function tambah_planning()
	{
		$result = ['status'=>false];
		$posts = $this->input->post();
		if(!empty($posts)){
			$result = $this->model_tambah_planning_budget->tambah_planning($posts);
		}
		responseJson($result);
	}

	public function get_total_tahun_lalu()
	{
		$posts = $this->input->post();
		$result = $this->model_tambah_planning_budget->get_total_tahun_lalu($posts);
		responseJson($result);
	}


}

/* End of file Tambah_planning_budget.php */
/* Location: ./application/controllers/Tambah_planning_budget.php */
