<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Realisasi_pengajuan_biaya extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_realisasi_pengajuan_biaya');
	}

	public function index()
	{
		$this->layout
			->title('Realisasi Pengajuan Biaya')
			->view('realisasi_pengajuan_biaya/index');
	}

	public function get()
	{
		$gets 	= $this->input->get();
		$data 	= $this->model_realisasi_pengajuan_biaya->get($gets);
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
		$data = $this->model_realisasi_pengajuan_biaya->get_budget_po_by_id($id_po);
		// $this->session->set_userdata(['id_po' => null]);
		responseJson($data);
	}

	public function reset_status_by_id()
	{
		$id_po = $this->input->post('id');
		$data = $this->model_realisasi_pengajuan_biaya->reset_status_by_id($id_po);
		responseJson($data);
	}

	public function update_po_budget()
	{
		$posts 	= $this->input->post();
		$data 	= $this->model_realisasi_pengajuan_biaya->update_po_budget($posts);
		responseJson($data);
	}

	public function cetak()
	{
		$id = base64_decode($this->input->get('id'));

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => 'A4',
			'curlAllowUnsafeSslRequests' => 'true',
			'margin_left' => 15,
			'margin_right' => 15,
			'margin_top' => 35,
			'margin_bottom' => 10,
			'margin_header' => 10,
			'margin_footer' => 5
		]);

		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("PurchaseOrder");
		$mpdf->SetAuthor("DMS-Wuling-Kumala");
		$mpdf->SetDisplayMode('fullpage');
		// $mpdf->SetWatermarkText("Paid");
		// $mpdf->showWatermarkText = true;
		// $mpdf->watermark_font = 'DejaVuSansCondensed';
		// $mpdf->watermarkTextAlpha = 0.1;
		$arr = $this->model_realisasi_pengajuan_biaya->get_cetak($id);
		// $html = $this->load->view('realisasi_pengajuan_biaya/cetak_realisasi', $data, false);
		$html = $this->load->view('realisasi_pengajuan_biaya/cetak_realisasi', $arr, true);
		$mpdf->writeHTML($html);
		$mpdf->Output();
		
	}

}

/* End of file daftar_pengajuan_biaya.php */
/* Location: ./application/controllers/daftar_pengajuan_biaya.php */
