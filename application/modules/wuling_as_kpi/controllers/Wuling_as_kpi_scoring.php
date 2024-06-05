<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_kpi_scoring extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_kpi_scoring');
	}

	public function index()
	{
		$this->layout
			->title('KPI Scoring')
			->view('kpi_scoring/index');
	}

	//get semua data kpi
	public function get()
	{
		$gets 	= $this->input->get();
		$data 	= $this->model_kpi_scoring->get($gets);
		responseJson(['aaData' => $data]);
	}

}

/* End of file wuling_as_kpi_scoring.php */
/* Location: ./application/controllers/wuling_as_kpi_scoring.php */
