<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Daftar_pengajuan_biaya extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_daftar_pengajuan_biaya');
	}

	public function index()
	{
		$this->layout
			->title('Daftar Pengajuan Biaya')
			->view('daftar_pengajuan_biaya/index');
	}

	public function get()
	{
		$gets 	= $this->input->get();
		$data 	= $this->model_daftar_pengajuan_biaya->get($gets);
		responseJson(['aaData' => $data]);
	}

	public function edit()
	{
		// die($this->uri->segment(2));
		$this->session->set_userdata(['id_po' => $this->uri->segment(2)]);
		$this->layout
			->title('Edit Pengajuan Biaya')
			->view('daftar_pengajuan_biaya/edit');
	}

	public function get_budget_po_by_id()
	{
		$id_po = $this->input->get('id');
		if(!isset($id_po)) {
			$id_po = $this->session->userdata('id_po');
		}
		$data = $this->model_daftar_pengajuan_biaya->get_budget_po_by_id($id_po);
		// $this->session->set_userdata(['id_po' => null]);
		responseJson($data);
	}

	public function reset_status_by_id()
	{
		$id_po = $this->input->post('id');
		$data = $this->model_daftar_pengajuan_biaya->reset_status_by_id($id_po);
		responseJson($data);
	}

	public function hapus_by_id()
	{
		$id_po = $this->input->post('id');
		$data = $this->model_daftar_pengajuan_biaya->hapus_by_id($id_po);
		responseJson($data);
	}

	public function update_po_budget()
	{
		$posts 	= $this->input->post();
		$data 	= $this->model_daftar_pengajuan_biaya->update_po_budget($posts);
		responseJson($data);
	}

}

/* End of file daftar_pengajuan_biaya.php */
/* Location: ./application/controllers/daftar_pengajuan_biaya.php */
