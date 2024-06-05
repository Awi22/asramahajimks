<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Approve_planning_budget extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_approve_planning_budget');
	}

	public function index()
	{
		$this->layout
			->title('Approve Planning Budget')
			->view('approve_planning_budget/index');
	}

	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_approve_planning_budget->get($posts);
		responseJson(['aaData' => $data]);
	}

	public function approve_data()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_approve_planning_budget->approve_data($posts);
		responseJson($result);
	}

	public function reject_data()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_approve_planning_budget->reject_data($posts);
		responseJson($result);
	}

}

/* End of file Approve_planning_budget.php */
/* Location: ./application/controllers/Approve_planning_budget.php */
