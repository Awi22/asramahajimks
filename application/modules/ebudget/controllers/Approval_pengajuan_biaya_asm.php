<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Approval_pengajuan_biaya_asm extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_approval_pengajuan_biaya');
	}

	public function index()
	{
		$this->layout
			->title('Approval Pengajuan Biaya')
			->view('approval_pengajuan_biaya/asm');
	}

	public function get()
	{
		$gets 	= $this->input->get();
		$data 	= $this->model_approval_pengajuan_biaya->get_asm($gets);
		responseJson(['aaData' => $data]);
	}

	public function approve()
	{
		$id 	= $this->input->post('id');
		$result = $this->model_approval_pengajuan_biaya->approve_asm($id);
		responseJson($result);
	}

	public function reject()
	{
		$posts 	= $this->input->post(NULL, TRUE);
		$result = $this->model_approval_pengajuan_biaya->reject_asm($posts);
		responseJson($result);
	}

}

/* End of file approval_pengajuan_biaya_ap.php */
/* Location: ./application/controllers/approval_pengajuan_biaya_ap.php */
