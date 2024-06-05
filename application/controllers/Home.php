<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('wuling_admin/model_adm_setting');
	}


	public function index()
	{
        $row = $this->db_wuling->get('system_setting')->row();
		if(empty($row->background_home)){
			$background = $row->background_home_default;
		} else {
			$background = $row->background_home;
		}
		$data = [
			'background' => $background
		];
		// dd($this->session->userdata());

		$this->layout
			->title('HOME')
			->data($data)
			->view('home');
	}
	
}

/* End of file Home.php */
/* Location: ./controllers/Home.php */
