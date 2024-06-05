<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Final_planning_budget extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_final_planning_budget');
	}

	public function index()
	{
		$this->layout
			->title('Final Planning Budget')
			->view('final_planning_budget/index');
	}

	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_final_planning_budget->get($posts);
		responseJson(['aaData' => $data]);
	}

	public function approve_data()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_final_planning_budget->approve_data($posts);
		responseJson($result);
	}

	function eksport_data()
	{
		/* Data */
		$gets 	= $this->input->get();
		$data 	= $this->model_final_planning_budget->get_eksport($gets);
		$exportExcel= new PHPExport; 			
		$exportExcel
			->dataSet($data)                      
			->rataTengah('1')                         
			->fieldAccounting('6,7,8,9,10,11,12,13,14,15,16,17,18')                            
			->excel2003('final-planning-budget-'.date('YmdHis'));  
	}

	

}

/* End of file Wuling_approve_planning_budget.php */
/* Location: ./application/controllers/Wuling_approve_planning_budget.php */
