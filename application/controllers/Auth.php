<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_auth');
		$this->load->model('wuling_admin/model_adm_setting');
	}


	public function index()
	{
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);

		if ($this->session->userdata('id_user')) {
			redirect('home', 'refresh');
		}

		$row = $this->db_wuling->get('system_setting')->row();
		if(empty($row->background_login)){
			$background = $row->background_login_default;
		} else {
			$background = $row->background_login;
		}
		$data = [
			'background' => $background
		];

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		if ($this->form_validation->run() == false) {
			$this->load->view('_auth/index', $data);
		} else {
			$result = $this->model_auth->verify_login($username, $password);
			responseJson($result);
		}
	}

	public function change_password()
	{
		$status = false;
		$pesan = 'Gagal mengganti password';
		
		if (empty($this->session->userdata('logged_in'))) {
			redirect('auth', 'refresh');
		}
		
		$username = $this->session->userdata('username');
		$password = $this->input->post('password');
		$confirm_password = $this->input->post('confirm-password');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('confirm-password', 'Confirm-Password', 'trim|required');
		if ($this->form_validation->run() == true) {
			$status = $this->model_auth->change_password($username, $password);
			$pesan  = 'Berhasil mengganti password';
		} 
		$result = ['status'=>$status, 'pesan'=>$pesan];
		responseJson($result);
	}

	public function logout()
	{
		date_default_timezone_set('Asia/Makassar');
		$username 	= $this->session->userdata('username');
		$id 		= $this->session->userdata('id_login');
		$fp 		= $this->session->userdata('fp');
		$time_logout = date('Y-m-d H:i:s');
		$this->db_wuling->query("UPDATE history_login SET time_logout='$time_logout',status='0' WHERE id='$id'");
		$this->db_wuling->query("UPDATE users SET fp='0', status_login='off' WHERE username='$username'");
		//$this->db_wuling->query("UPDATE users SET fp='0' WHERE username='$username'");
		$this->session->sess_destroy();
		redirect(base_url(),'refresh');
	}

	public function blocked()
	{
		$this->load->view('_auth/blocked');
	}

	public function not_found()
	{
		$this->load->view('_auth/404');
	}

	public function system_error()
	{
		$this->load->view('_auth/500');
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
