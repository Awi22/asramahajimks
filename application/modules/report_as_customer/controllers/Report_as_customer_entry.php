<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;
use app\models\elo\aftersales\mCustomer;
use app\models\elo\kmg\ModelAgama;
use app\models\elo\sales\ModelUnit;

use Carbon\Carbon;


class Report_as_customer_entry extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->layout
			->title('Report Customer Entry')
			->view('customer_entry/index');
	}

	public function get()
	{
		$perusahaan = $this->request->perusahaan;
		$varian     = $this->request->varian;
		$agama      = $this->request->agama;
		$tahun      = $this->request->tahun;
		$w_insert   = $this->request->w_insert;
		$start      = $this->request->start;

		$datatable = new Datatable;

		$customers = (new mCustomer())
			->selectRaw('customer.*,detail_unit_customer.no_rangka')
			->join('db_wuling_as.detail_unit_customer', 'detail_unit_customer.id_customer', '=', 'customer.id_customer');

		// Filter
		$coverage = explode(',', $this->session->userdata('coverage'));
		$datatable->query = $customers->whereIn('customer.id_perusahaan', $coverage);
		
		if (filled($perusahaan)) {
			$datatable->query = $customers->where('customer.id_perusahaan', $perusahaan);
		}

		if (filled($varian)) {
			$datatable->query = $customers->where('detail_unit_customer.kode_unit', '=', $varian);
		}

		if (filled($agama)) {
			$datatable->query = $customers->where('customer.id_agama', '=', $agama);
		}

		if (filled($tahun)) {
			$datatable->query = $customers->where('detail_unit_customer.tahun', '=', $tahun);
		}

		if (filled($w_insert)) {
			$datatable->query = $customers->where('customer.w_insert', 'like', '%' . $w_insert . '%');
		}
		// End Filter

		$datatable->setColumns(null, "customer.w_insert", "customer.id_customer", "detail_unit_customer.no_rangka", "customer.ktp", "customer.nama", "customer.telepon", "customer.keterangan_cus");
		$datatable->orderBy('customer.w_insert desc');
		$response = $datatable->get();
		$dataRaw = $response['data'];
		$response['data'] = [];

		foreach ($dataRaw as $key => $value) {
			$response['data'][] = [
				'no'             => $start + $key + 1,
				'w_insert'       => Carbon::parse($value['w_insert'])->format('Y-m-d'),
				'id_customer'    => $value['id_customer'],
				'no_rangka'      => $value['no_rangka'],
				'ktp'            => $value['ktp'],
				'nama'           => $value['nama'],
				'telepon'        => $value['telepon'],
				'keterangan_cus' => $value['keterangan_cus']
			];
		}

		responseJson($response);
	}

	public function ekspor()
	{
		$perusahaan = $this->request->perusahaan;
		$varian     = $this->request->varian;
		$agama      = $this->request->agama;
		$tahun      = $this->request->tahun;
		$w_insert   = $this->request->w_insert;

		$customers =  mCustomer::selectRaw('customer.*,detail_unit_customer.tahun,detail_unit_customer.no_mesin,detail_unit_customer.no_polisi,
		detail_unit_customer.no_rangka,detail_unit_customer.tgl_deliv,km_deliv,tgl_akhir_garansi,
		km_akhir_garansi,p_type_unit.type,p_warna.warna,kabupaten.nama as nama_kota')
		->join('db_wuling_as.detail_unit_customer', 'detail_unit_customer.id_customer', '=', 'customer.id_customer','left')
		->join('db_wuling.unit','detail_unit_customer.kode_unit','=','unit.kode_unit','left')
		->join('db_wuling_as.p_type_unit','unit.id_type','=','p_type_unit.id_type','left')
		->join('db_wuling.kabupaten', 'kabupaten.id_kabupaten','=','customer.kota','left')
		->join('db_wuling_as.p_warna','unit.id_warna','=','p_warna.id_warna','left');
		

		// Filter
		$coverage = explode(',', $this->session->userdata('coverage'));
		$customers->whereIn('customer.id_perusahaan', $coverage);
		if (filled($perusahaan)) {
			$customers->where('customer.id_perusahaan', $perusahaan);
		}

		if (filled($varian)) {
			$customers->where('detail_unit_customer.kode_unit', '=', $varian);
		}

		if (filled($agama)) {
			$customers->where('customer.id_agama', '=', $agama);
		}

		if (filled($tahun)) {
			$customers->where('detail_unit_customer.tahun', '=', $tahun);
		}

		if (filled($w_insert)) {
			$customers->where('customer.w_insert', 'like', '%' . $w_insert . '%');
		}
		// dd($customers->get()->toArray());
		if ($customers->count() > 0) {
			//table header
			// $cols = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V");

			// $val = array("No", "No. Rangka", "No. Mesin", "Tipe", "Warna", "No. Polisi", 
			// "Tahun", "Tgl. Deliv", "KM. Deliv", "Tgl. Akhir Garansi", "KM. Akhir Garansi", 
			// "No. ID (No. KTP/SIM/HP)", "Nama Customer", "Alamat", "Kabupaten/Kota", 
			// "Telepon", "Email", "Tgl. Lahir", "Keterangan", "Agama", "Customer Kumala?", "ID Customer");

			// for ($a = 0; $a < 22; $a++) {
			// 	$objset->setCellValue($cols[$a] . '1', $val[$a]);

			// 	//Setting lebar cell
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(30);
			// 	$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(30);

			// 	$style = array(
			// 		'alignment' => array(
			// 			'horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			// 		)
			// 	);
			// 	$objPHPExcel->getActiveSheet()->getStyle($cols[$a] . '1')->applyFromArray($style);
			// }

			foreach ($customers->get() as $dt) {
				if ($dt->kumala == 'y') {
					$cust_kumala = 'Ya';
				} else {
					$cust_kumala = 'Tidak';
				}
				$km_deliv = '';
				$km_akhir = '';

				if(substr(strtolower(rtrim($dt->km_deliv)),-2)=='km'){
					$km_deliv = strtolower($dt->km_deliv);
				} else {
					$km_deliv = $dt->km_deliv.'km';
				}

				if(substr(strtolower(rtrim($dt->km_akhir_garansi)),-2)=='km'){
					$km_akhir = strtolower($dt->km_akhir_garansi);
				} else {
					$km_akhir = $dt->km_akhir_garansi.'km';
				}

				$datas[] = [
					"no_rangka" => $dt->no_rangka,
					"no_mesin" => $dt->no_mesin,
					"tipe" => $dt->type,
					"warna" => $dt->warna,
					"no_polisi" => $dt->no_polisi,
					"tahun" => $dt->tahun,
					"tgl_deliv" => tgl_sql($dt->tgl_deliv),
					"km_deliv" => $km_deliv,
					"tgl_akhir_garansi" => tgl_sql($dt->tgl_akhir_garansi),
					"km_akhir_garansi" => $km_akhir,
					"no_ktp_sim" => $dt->ktp,
					"nama_customer" => $dt->nama,
					"alamat" => $dt->alamat,
					"kab/kota" => $dt->nama_kota,
					"telepon" => $dt->telepon,
					"email" => $dt->email,
					"tgl_lahir" => tgl_sql($dt->ttl),
					"keterangan" => $dt->keterangan_cus,
					"agama" => $dt->nama_agama,
					"customer_kumala" => $cust_kumala,
					"id_customer" => $dt->id_customer
				];
			}

			$exportExcel= new PHPExport; 			
			$exportExcel
				->dataSet($datas)                      
				->rataTengah('0,1,2,3,4,5,6,8,10,14,16,18,19,20')  
				->rataKanan('7,9')                         
				->fieldText('10,14')                      
				->excel2003('data-customer-cco-'.date('YmdHis'));  
		} else {
			echo ('data kosong');
			sleep(3);
			redirect('report_as_customer_entry');
		}
	}

	public function select2_varian()
	{
		// $query = ModelUnit->toPWarna()->orderBy('varian','ASC')->get();
		// $varian = array();
		// foreach ($query as $key => $value) {
		// 	$varian[] = ['id' => $value->kode_unit, 'text' => $value->varian];
		// }

		// return responseJson(compact('varian'));
		$unit = [];
        $data = ModelUnit::with(['toPVarian', 'toPWarna']);
        $data = $data->whereHas('toPVarian', function ($query) {
            $query->whereShow('1');
        })->get()->sortBy(function ($query) {
            return $query->toPVarian->varian;
        });
        foreach ($data as $key => $row) {
            $unit[] = [
                'id'       => $row->kode_unit,
                'text'     => $row->toPVarian['varian'] . ' - ' . $row->toPWarna['warna'],
            ];
        }
		responseJson($unit);
	}

	public function select2_agama()
	{
		$query = ModelAgama::orderBy('nama_agama', 'ASC')->get();
		$agama = array();
		foreach ($query as $key => $value) {
			$agama[] = ['id' => $value->id_agama, 'text' => $value->nama_agama];
		}

		responseJson($agama);
	}
}

/* End of file class Report_as_customer_entry extends MY_Controller.php */
/* Location: ./application/modules/report_as_customer */
