<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;


class Edit_planning_budget extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_daftar_planning_budget');
		$this->load->model('model_edit_planning_budget');
	}

	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_edit_planning_budget->get($posts);
		responseJson(['aaData' => $data]);
	}

	public function index()
	{
		$this->layout
			->title('Daftar Planning Budget')
			->view('edit_planning_budget/index');
	}

	public function get_data_by_id()
	{
		$id		= $this->input->post("id_budget");
		// dd($id);
		$hasil	= $this->model_daftar_planning_budget->get_data_by_id($id);
		responseJson($hasil);
	}

	public function update_data_planning()
	{
		$posts = $this->input->post();
		$result = $this->model_daftar_planning_budget->update_data_planning($posts);
		responseJson($result);
	}

	public function hapus_data()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_daftar_planning_budget->hapus_data($posts);
		responseJson($result);
	}

	function eksport_data()
	{
		/* Data */
		$posts 	= $this->input->post();
		$data 	= $this->model_daftar_planning_budget->get_eksport($posts);
		$exportExcel= new PHPExport; 			
		$exportExcel
			->dataSet($data)                      
			->rataTengah('1')                         
			->fieldAccounting('6,7,8,9,10,11,12,13,14,15,16,17,18')                            
			->excel2003('daftar-planning-budget-'.date('YmdHis'));  
	}

}

/* End of file Daftar_planning_budget.php */
/* Location: ./application/controllers/Daftar_planning_budget.php */
