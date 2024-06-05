<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class Wuling_as_kpi_target extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_kpi_target');
	}

	public function index()
	{
		$this->layout
			->title('Target KPI')
			->view('kpi_target/index');
	}

	public function get()
	{
		$gets 		= $this->input->get();
		$data 		= $this->model_kpi_target->get($gets);
		responseJson(['aaData' => $data]);
	}

	public function import_excel()
	{
		$this->load->helper('file');

		$status 		= false;
		$pesan 			= 'Gagal upload file';
		$id_kategori 	= $this->input->post('id');
		$tahun 			= $this->input->post('tahun');
		$bulan 			= $this->input->post('bulan');

		$file_mimes = [
			'application/octet-stream',
			'application/vnd.ms-excel',
			'application/x-csv',
			'text/x-csv',
			'text/csv',
			'application/csv',
			'application/excel',
			'application/vnd.msexcel',
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'application/wps-office.xlsx',
			'application/wps-office.xls'
		];

		if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {

			$array_file = explode('.', $_FILES['upload_file']['name']);
			$extension  = end($array_file);

			if ('csv' == $extension) {
				$reader = new CsvReader();
			} else {
				$reader = new XlsxReader();
			}

			$spreadsheet   = $reader->load($_FILES['upload_file']['tmp_name']);
			$sheet_data    = $spreadsheet->getActiveSheet(0)->toArray();

			$array_data = [];

			if (empty($id_kategori) || empty($tahun) || empty($bulan)) {
				responseJson([
					'status' => $status,
					'pesan' => "Required data empty!!",
				]);
				die();
			}

			for ($i = 1; $i < count($sheet_data); $i++) {
				$v_dealer_code 		= $sheet_data[$i]['0'];
				$v_target 			= $sheet_data[$i]['2'];

				if (empty($v_dealer_code)) {
					continue;
				} else {
					$data = array(
						'id_kategori_item'	=> $id_kategori,
						'tahun' 			=> $tahun,
						'bulan' 			=> $bulan,
						'dealer_code'   	=> $v_dealer_code,
						'target'   			=> $v_target,
					);
					$array_data[] = $data;
					$result = $this->model_kpi_target->insert_or_update($data);
					if (!$result) {
						responseJson([
							'status' => false,
							'pesan' => "Kesalahan saat insert data, pada baris ke-" . $i,
						]);
						exit();
					}
				}
			}
			$status = true;
			$pesan = 'Upload file berhasil';
		} else {
			$status = false;
			$pesan = 'File tidak support';
		}

		responseJson([
			'status' => $status,
			'pesan' => $pesan,
		]);
	}


	public function select2_key_kategori()
	{
		$data 	= array();
		$query 	= $this->db_holding->select("*")->where('enabled', 1)->from("kpi_kategori_item")->get();
		foreach ($query->result() as $url) {
			$data[] = array(
				'id'        => $url->id,
				'text'      => $url->name,
			);
		}
		responseJson($data);
	}
}

/* End of file Wuling_as_kpi_target.php */
/* Location: ./application/controllers/Wuling_as_kpi_target.php */
