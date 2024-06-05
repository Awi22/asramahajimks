<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adm_sales_sales extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_adm_sales');
		$this->load->library('WSA_API');
	}

	public function index()
	{
		$this->layout->title('Data Sales')->view('adm_sales/index');
	}


	public function get()
	{
		$gets 	= $this->input->get();
		$data	= $this->model_adm_sales->get_serverside($gets);
		header('Content-Type: application/json');
		echo $data;
	}

	//untuk select2
	public function select2_cabang()
	{
		$cabang	= $this->input->post('cabang');
		if ($cabang == '' || $cabang == null) {
			$cabang = explode(',', $this->coverage);
		}
		$data = array();
		$data 	= $this->model_adm_sales->select2_cabang($cabang);
		responseJson($data);
	}

	//download data dari HRD ke adminsales
	public function download()
	{
		$data = $this->model_adm_sales->download();
		responseJson($data);
	}

	//get single data sales untuk kebutuhan edit/update	
	public function get_data_sales_by_id()
	{
		$data 	= array();
		$gets 	= $this->input->get();
		$data 	= $this->model_adm_sales->get_data_sales_by_id($gets);
		responseJson($data);
	}

	//update sales
	public function update_sales()
	{
		$posts 	= $this->input->post();
		$data 	= $this->model_adm_sales->update_sales($posts);
		responseJson($data);
	}

	//reset password
	public function reset_password()
	{
		$posts 	= $this->input->post();
		$data 	= $this->model_adm_sales->reset_password($posts);
		responseJson($data);
	}



	public function getDataSalesWsaApi()
	{
		$data = $this->wsa_api->get_master('salesmen');

		responseJson(['aaData' => $data]);
	}

	// //get data sm by coverage untuk memilih daftar sm yang belum buat tim sm
	// public function get_data_sm_by_coverage()
	// {
	// 	$data 	= array();
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->get_data_sm_by_coverage($posts);
	// 	responseJson(['aaData'=>$data]);
	// }


	// public function select2_cabang() {	
	// 	$cabang	= $this->input->post('cabang'); 
	// 	if($cabang==''||$cabang==null){
	// 		$cabang = explode(',',$this->coverage);
	// 	}		
	// 	$data = array();		
	// 	$data 	= $this->model_adm_sales->select2_cabang($cabang);
	// 	responseJson($data);		
	// }

	// //get all coverage perusahaan
	// public function get_coverage()
	// {
	// 	$data 	= array();
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->get_coverage();
	// 	responseJson(['aaData'=>$data]);
	// }

	// //simpan data team sm
	// public function tambah_sm()
	// {		
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->tambah_sm($posts);
	// 	responseJson($data);
	// }

	// //update data team sm
	// public function update_sm()
	// {		
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->update_sm($posts);
	// 	responseJson($data);
	// }

	// //get all data team spv by id_team_sm dan yang masih kosong id_team_smnya
	// public function get_data_team_sm()
	// {
	// 	$data 	= array();
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->get_data_team_sm($posts);
	// 	responseJson(['aaData'=>$data]);
	// }

	// //simpan data sm ke data team sm
	// public function add_to_team_sm()
	// {
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->add_to_team_sm($posts);
	// 	responseJson($data);
	// }

	// //get all data team spv by id_team_sm (yang sudah ada team spv nya)
	// public function get_data_by_id_team_sm()
	// {
	// 	$data 	= array();
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->get_data_by_team_sm($posts);
	// 	responseJson(['aaData'=>$data]);
	// }

	// //hapus data team sm
	// public function hapus_sm()
	// {
	// 	$data 	= array();
	// 	$posts 	= $this->input->post();
	// 	$data 	= $this->model_adm_sales->hapus_sm($posts);
	// 	responseJson($data);
	// }

}

/* End of file Adm_sales_sales.php */
/* Location: ./wuling_admin_sales/controllers/Adm_sales_sales.php */
