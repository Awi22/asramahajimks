<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Master_coa_budget extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_coa_budget');
	}

	public function index()
	{
		$this->layout
			->title('COA Budget')
			->view('master_coa_budget/index');
	}

	public function select2_akun()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$hasil	= $this->model_coa_budget->select2_akun($posts);
		return $hasil;
	}

	//get semua data
	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_coa_budget->get($posts);
		responseJson(['aaData' => $data]);
	}

	public function get_pilih_akun()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_coa_budget->get_pilih_akun($posts);
		responseJson(['aaData' => $data]);
	}


	public function tambah_coa()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_coa_budget->tambah_coa($posts);
		responseJson($result);
	}

	//set status coa off atau on
	public function set_status()
	{
		$id_coa	= $this->input->post('id_coa');
		$set_status = $this->input->post('status');
		$pesan	= 'Gagal mengupdate coa';
		$status	= false;

		if ($this->model_coa_budget->set_status($id_coa, $set_status)) {
			$status = true;
			$pesan = "Sukses mengupdate coa";
		};

		$result = ['status' => $status, 'pesan' => $pesan];
		responseJson($result);
	}

	public function hapus_coa()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_coa_budget->hapus_coa($posts);
		responseJson($result);
	}

	public function get_approval_coa_by_id()
	{
		$id 	= $this->input->get('id');
		$data 	= $this->model_coa_budget->get_approval_coa_by_id($id);
		responseJson($data);
	}

	public function update_approval()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_coa_budget->update_approval($posts);
		responseJson($result);
	}

}

/* End of file class Master_coa_budget extends MY_Controller
.php */
/* Location: ./application/controllers/class Master_coa_budget extends MY_Controller
.php */
