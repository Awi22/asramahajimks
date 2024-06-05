<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_adm_user extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_user');
	}

	public function index()
	{
		$this->layout
			->title('Manajemen User')
			->view('adm_user/index');
	}

	//get semua data user
	public function get()
	{
		$posts 	= $this->input->get();
		$data 	= $this->model_user->get($posts);
		responseJson(['aaData' => $data]);
	}

	//set status user off atau on
	public function set_status()
	{
		$id_user	= $this->input->post('id_user');
		$set_status = $this->input->post('status');
		$pesan	= 'Gagal mengupdate user';
		$status	= false;

		if ($this->model_user->set_status($id_user, $set_status)) {
			$status = true;
			$pesan = "Sukses mengupdate user";
		};

		$result = ['status' => $status, 'pesan' => $pesan];
		responseJson($result);
	}

	//ambil data user berdasarkan id untuk keperluan edit user
	public function get_user_by_id()
	{
		$id		= $this->input->post("id");
		$hasil	= $this->model_user->get_user_by_id($id);
		responseJson($hasil);
	}

	public function tambah_user()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_user->tambah_user($posts);
		responseJson($result);
	}

	public function update_user()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_user->update_user($posts);
		responseJson($result);
	}

	public function copy_user()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_user->copy_user($posts);
		responseJson($result);
	}

	public function reset_user()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_user->reset_user($posts);
		responseJson($result);
	}

	public function hapus_user()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_user->hapus_user($posts);
		responseJson($result);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
