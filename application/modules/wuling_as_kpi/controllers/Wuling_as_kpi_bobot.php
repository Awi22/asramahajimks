<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_kpi_bobot extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_kpi_bobot');
	}

	public function index()
	{
		$this->layout
			->title('KPI Item Kategori')
			->view('kpi_bobot/index');
	}

	public function get()
	{
		$kategori 	= $this->input->get('kategori');
		$data 		= $this->model_kpi_bobot->get($kategori);
		responseJson(['aaData' => $data]);
	}

	public function simpan()
	{
		$posts 	= $this->input->post();
		$data 	= $this->model_kpi_bobot->simpan($posts);
		responseJson($data);
	}

	public function get_kategori_by_id()
	{
		$id 	= $this->input->get('id');
		$data 	= $this->model_kpi_bobot->get_kategori_by_id($id);
		responseJson($data);
	}

	public function hapus()
	{
		$id 	= $this->input->post('id');
		$data 	= $this->model_kpi_bobot->hapus($id);
		responseJson($data);
	}

	public function select2_kategori() 
	{			
		$data 	= array();
		$query 	= $this->db_holding->select("*")->from("kpi_kategori")->get();
		foreach ($query->result() as $url) {
			$data[] = array(
				'id'        => $url->id,
				'text'      => $url->name,
			);
		}		
		responseJson($data);				
	}

}

/* End of file wuling_as_kpi_bobot.php */
/* Location: ./application/controllers/wuling_as_kpi_bobot.php */
