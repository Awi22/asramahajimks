<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Wuling_as_kpi_cco extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_kpi_cco');
	}

	public function index()
	{
		$this->layout
			->title('CCO')
			->view('kpi_cco/index');
	}

	public function get()
	{
		$data 		= $this->model_kpi_cco->get();
		responseJson(['aaData' => $data]);
	}

	function import_excel()
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
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		];

        if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {

            $array_file = explode('.', $_FILES['upload_file']['name']);
            $extension  = end($array_file);

            if('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet= $reader->load($_FILES['upload_file']['tmp_name']);
            $sheet_data	= $spreadsheet->getActiveSheet(0)->toArray();
            
			$array_data = [];

			if(empty($id_kategori) || empty($tahun) || empty($bulan)){
				responseJson([
					'status' => $status,
					'pesan' => "Required data empty!!",
				]);
				die();
			}

			$nama_kategori = $this->model_kpi_cco->id_kategori_to_name($id_kategori);

            for($i = 1; $i < count($sheet_data); $i++) {
				$v_dealer_code 		= $sheet_data[$i]['0'];
				$v_actual 			= $sheet_data[$i]['2'];
				
				if(empty($v_dealer_code)){
					continue;
				} else {
					if($v_actual!=0) {
						$data = array(
							'id_kategori_item'	=> $id_kategori,
							'tahun' 			=> $tahun,
							'bulan' 			=> $bulan,
							'dealer_code'   	=> $v_dealer_code,
							'actual' 			=> $v_actual,
						);
						$array_data[] = $data;
						$result = $this->model_kpi_cco->insert_or_update($data);
						if(!$result){
							responseJson([
								'status' => false,
								'pesan' => "Kesalahan saat insert data, pada baris ke-" . $i ." atau target belum ada untuk kategori ". $nama_kategori,
							]);
							exit();
						}
					}
				}
            }
			$status = true;
			$pesan = 'Upload file berhasil';
        }

		responseJson([
			'status' => $status,
			'pesan' => $pesan,
		]);
    }

}

/* End of file Wuling_as_kpi_cco.php */
/* Location: ./application/controllers/Wuling_as_kpi_cco.php */
