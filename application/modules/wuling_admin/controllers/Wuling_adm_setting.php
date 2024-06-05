<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// use EdSDK\FlmngrServer\FlmngrServer;

// use EdSDK\FlmngrServer\FlmngrServer;
// use edsd\FlmngrServer;

// use Illuminate\Database\Capsule\Manager as DB;
// use Illuminate\Http\Request;

// include APPPATH . 'third_party/flmngr/flmngr.php';


// use EdSDK\FlmngrServer\FlmngrServer;


class Wuling_adm_setting extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_adm_setting');
	}


	public function index()
	{
		$row = $this->db_wuling->get('system_setting')->row();

		$data = [
			'background_home' => $row->background_home,
			'background_home_default' => $row->background_home_default,
			'background_login' => $row->background_login,
			'background_login_default' => $row->background_login_default
		];
		$this->layout
			->title('Setting')
			->data($data)
			->view('adm_setting/index');
	}

	public function upload_background()
	{
		$result = $this->model_adm_setting->upload_background();
		responseJson($result);
	}
}

/* End of file Wuling_adm_home.php */
/* Location: ./wuling_admin/controllers/Wuling_adm_home.php */
