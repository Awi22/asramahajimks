<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;
use app\models\elo\aftersales\mGroupPelanggan;
use app\models\elo\aftersales\mPelanggan;

use Carbon\Carbon;


class Report_as_customer_part extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->layout
			->title('Report Customer Part')
			->view('customer_part/index');
	}

	public function get()
	{
		$perusahaan = $this->request->perusahaan;
		$group     	= $this->request->group;
		$w_insert   = $this->request->w_insert;
		$start      = $this->request->start;

		$datatable = new Datatable;
		$pelanggan = (new mPelanggan())->newQuery();

		$datatable->query = $pelanggan->whereNotNull('id_perusahaan');

		// Filter
		if (filled($perusahaan)) {
			// $datatable->query = $pelanggan->whereId_Perusahaan($perusahaan);
			$datatable->query = $pelanggan->where('id_perusahaan', $perusahaan);
		}

		if(filled($group)){
			$datatable->query = $pelanggan->whereKode_group_pelanggan($group);
		}

		if(filled($w_insert)) {
			$datatable->query = $pelanggan->where('w_insert','like','%'.$w_insert.'%');
		}
		// End Filter

		$datatable->setColumns(null, 'w_insert','kode_pelanggan','nama_pelanggan','kontak','keterangan');
		$datatable->orderBy('w_insert DESC');
		$response = $datatable->get(); 
		$dataRaw = $response['data'];
		$response['data'] = [];

		foreach ($dataRaw as $key => $value) {
			$response['data'][] = [
				'no'             => $start + $key + 1,
				'w_insert'       => Carbon::parse($value['w_insert'])->format('Y-m-d'),
				'kode_pelanggan' => $value['kode_pelanggan'],
				'nama_pelanggan' => $value['nama_pelanggan'],
				'kontak'         => $value['telepon'],
				'keterangan'     => $value['keterangan']
			];
		}
		
		responseJson($response);
	}

	public function ekspor()
	{
		$perusahaan = $this->request->id_perusahaan;
		$group      = $this->request->group;
		$w_insert   = $this->request->w_insert;

		$pelanggan = mPelanggan::with(array('togrouppelanggan'));
		$query = $pelanggan->whereNotNull('id_perusahaan');

		if (filled($perusahaan)) {
			$query = $pelanggan->where('id_perusahaan', $perusahaan);
		}

		if(filled($group)){
			$query = $pelanggan->whereKode_group_pelanggan($group);
		}

		if(filled($w_insert)) {
			$query = $pelanggan->where('w_insert','like','%'.$w_insert.'%');
		}

		foreach($query->get() as $key => $value) {
			$response[] = [
				'kode_pelanggan'       => $value->kode_pelanggan,
				'nama_pelanggan'       => $value->nama_pelanggan,
				'kode group pelanggan' => $value->kode_group_pelanggan,
				'nama group'           => $value->togrouppelanggan['nama_group'],
				'kontak'               => $value->telepon,
				'email'                => $value->email,
				'ktp'                  => $value->ktp,
				'tgl. input'           => Carbon::parse($value->w_insert)->format('d-m-Y'),
				'alamat'               => $value->alamat,
				'kota'                 => $value->kota,
				'provinsi'             => $value->provinsi,
				'limit_beli'           => $value->limit_beli,
				'keterangan'           => $value->keterangan
			];			
		}

		$exportExcel= new PHPExport; 			
		$exportExcel
			->dataSet($response)                      
			->rataTengah('0,2,3,4,6,7')  
			->rataKanan('11')                         
			->fieldText('4,6')                      
			->excel2003('data-customer-part-'.date('YmdHis'));  
		
	}

	public function select2_group_pelanggan()
	{
		$query = mGroupPelanggan::orderBy('nama_group', 'ASC')->get();
		$group = [];
		foreach($query as $key => $value)
		{
			$group[] = ['id' => $value->kode_group_pelanggan, 'text' => $value->nama_group];
		}

		responseJson($group);
	}
}

/* End of file class Report_as_customer_part extends MY_Controller.php */
/* Location: ./application/modules/report_as_customer */
