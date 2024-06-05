<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class History_planning_budget extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_history_planning_budget');

	}

	public function index()
	{
		$this->layout
			->title('Daftar Planning Budget')
			->view('history_planning_budget/index');
	}

	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_history_planning_budget->get($posts);
		responseJson(['aaData' => $data]);
	}

}

/* End of file History_planning_budget.php */
/* Location: ./application/controllers/History_planning_budget.php */
