<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;
use app\models\elo\aftersales\mGroupPelanggan;
use app\models\elo\aftersales\mPelanggan;
use app\models\elo\sales\ModelPenjualanUnit;

use Carbon\Carbon;


class Report_as_customer_history_penjualan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_report_as_customer_history_penjualan', 'model_lap_unit');
	}

	public function index()
	{
		$this->layout
			->title('Report Penjualan Unit dan History Service')
			->view('customer_history_penjualan/index');
	}

	public function get()
	{
		$perusahaan = $this->request->perusahaan;
		$tgl_awal 	= tgl_sql($this->request->tgl_awal);
		$tgl_akhir 	= tgl_sql($this->request->tgl_akhir);
		$result = [];
		$data  	= $this->model_lap_unit->penjualanUnitMobil($perusahaan, $tgl_awal, $tgl_akhir);
		$no = 1;
		foreach ($data as $dt) {
			$history_service = $this->model_lap_unit->cekHistoryService($dt->no_rangka);
			$result[] = [
				'no'    		=> $no++,
				'tanggal'    	=> tgl_sql($dt->tgl),
				'nama'       	=> $dt->nama,
				'telepone'      => $dt->telepone,
				'nama_stnk'  	=> $dt->nama_stnk,
				'no_rangka'  	=> $dt->no_rangka,
				'no_mesin'   	=> $dt->no_mesin,
				'no_polisi'  	=> $dt->no_polisi,
				'cara_bayar' 	=> ($dt->cara_bayar == 'k' ? 'Kredit' : 'Cash'),
				'keterangan' 	=> $dt->keterangan,
				'history_service' => $history_service
			];
		}

		responseJson(['aaData' => $result]);
	}

	public function details()
	{
		$no_rangka = $this->request->no_rangka;
		$data = $this->model_lap_unit->historyService($no_rangka);
		$result = '<div class="table-responsive">';
		$result .= '<table class="table">';
		$result .=
		'<tr class="fw-bold fs-6 text-gray-600">
			<th class="py-2">Tgl Service</th>
			<th class="py-2">No Invoice</th>
			<th class="py-2">No WO</th>
			<th class="py-2">Total Biaya Jasa</th>
			<th class="py-2">Total Biaya Part</th>
			<th class="py-2">Total Biaya Lain</th>
			<th class="py-2">Keterangan</th>
		</tr>';
		foreach ($data as $dt) {
			$result .= '<tr class="fw-semi-bold fs-7 text-gray-600">';
			$result .= '<td class="py-2">' . $dt['tgl_service'] . '</td>';
			$result .= '<td class="py-2">' . $dt['no_invoice'] . '</td>';
			$result .= '<td class="py-2">' . $dt['no_wo'] . '</td>';
			$result .= '<td class="py-2">' . 'Rp'.separator_harga($dt['total_biaya_jasa']) . '</td>';
			$result .= '<td class="py-2">' . 'Rp'.separator_harga($dt['total_biaya_part']) . '</td>';
			$result .= '<td class="py-2">' . 'Rp'.separator_harga($dt['total_biaya_lain']) . '</td>';
			$result .= '<td class="py-2">' . $dt['keterangan'] . '</td>';
			$result .= '</tr>';
		}
		$result .= '</table></div>';
		responseJson($result);
	}

	public function ekspor()
	{
		$perusahaan = $this->request->perusahaan;
		$tgl_awal 	= tgl_sql($this->request->tgl_awal);
		$tgl_akhir 	= tgl_sql($this->request->tgl_akhir);
		$result = [];
		$data  	= $this->model_lap_unit->penjualanUnitMobil($perusahaan, $tgl_awal, $tgl_akhir);
		$no = 1;
		foreach ($data as $dt) {
			$history_service = $this->model_lap_unit->cekHistoryService($dt->no_rangka);
			if($history_service){
				$data_history_service = $this->model_lap_unit->historyService($dt->no_rangka);
				$i = 1;
				foreach ($data_history_service as $hs) {
					if($i==1){
						$result[] = [
							'no'    		=> $no++,
							'tanggal'    	=> tgl_sql($dt->tgl),
							'nama'       	=> $dt->nama,
							'telepone'      => $dt->telepone,
							'nama_stnk'  	=> $dt->nama_stnk,
							'no_rangka'  	=> $dt->no_rangka,
							'no_mesin'   	=> $dt->no_mesin,
							'no_polisi'  	=> $dt->no_polisi,
							'cara_bayar' 	=> ($dt->cara_bayar == 'k' ? 'Kredit' : 'Cash'),
							'keterangan' 	=> $dt->keterangan,
							'no_wo'            => $hs['no_wo'] ,
							'no_invoice'       => $hs['no_invoice'],
							'tgl_service'      => tgl_sql($hs['tgl_service']),
							'total_biaya_jasa' => $hs['total_biaya_jasa'],
							'total_biaya_part' => $hs['total_biaya_part'],
							'total_biaya_lain' => $hs['total_biaya_lain'],
							// 'grand_total'      => "",
						];
						$i++;
					} else {
						$result[] = [
							'no'    		=> "",
							'tanggal'    	=> "",
							'nama'       	=> "",
							'telepone'      => "",
							'nama_stnk'  	=> "",
							'no_rangka'  	=> "",
							'no_mesin'   	=> "",
							'no_polisi'  	=> "",
							'cara_bayar' 	=> "",
							'keterangan' 	=> "",
							'no_wo'            => $hs['no_wo'] ,
							'no_invoice'       => $hs['no_invoice'],
							'tgl_service'      => tgl_sql($hs['tgl_service']),
							'total_biaya_jasa' => $hs['total_biaya_jasa'],
							'total_biaya_part' => $hs['total_biaya_part'],
							'total_biaya_lain' => $hs['total_biaya_lain'],
							// 'grand_total'      => "",
						];
					}
				}
			} else {
				$result[] = [
					'no'    		=> $no++,
					'tanggal'    	=> tgl_sql($dt->tgl),
					'nama'       	=> $dt->nama,
					'telepone'      => $dt->telepone,
					'nama_stnk'  	=> $dt->nama_stnk,
					'no_rangka'  	=> $dt->no_rangka,
					'no_mesin'   	=> $dt->no_mesin,
					'no_polisi'  	=> $dt->no_polisi,
					'cara_bayar' 	=> ($dt->cara_bayar == 'k' ? 'Kredit' : 'Cash'),
					'keterangan' 	=> $dt->keterangan,
					'no_wo'            => "",
					'no_invoice'       => "",
					'tgl_service'      => "",
					'total_biaya_jasa' => "",
					'total_biaya_part' => "",
					'total_biaya_lain' => "",
					// 'grand_total'      => "",
				];
			}
		}
		
		$exportExcel= new PHPExport; 			
		$exportExcel
			->dataSet($result)                      
			->rataTengah('1,3,5,6,7,8,10,11,12')  
			->fieldAccounting('13,14,15')                         
			->fieldText('3')                      
			->excel2003('data-penjualan-customer-dan-history-service-'.date('YmdHis'));  
	}

	public function select2_group_pelanggan()
	{
		$query = mGroupPelanggan::orderBy('nama_group', 'ASC')->get();
		$group = [];
		foreach ($query as $key => $value) {
			$group[] = ['id' => $value->kode_group_pelanggan, 'text' => $value->nama_group];
		}

		responseJson($group);
	}
}

/* End of file class Report_as_customer_history_penjualan extends MY_Controller.php */
/* Location: ./application/modules/report_as_customer */
