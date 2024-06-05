<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_kpi_scoring_by_kpi extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_kpi_scoring_by_kpi');
	}

	public function index()
	{
		$this->layout
			->title('KPI Scoring')
			->view('kpi_cabang/by_kpi_score/index');
	}

	public function get_view_table()
	{
		$bulan          = $this->input->get('month');
		$range          = $this->input->get('range');
		$month = $bulan ? $bulan : date('m');
		if ($range == 'mtd' || $range == null) {
			$month = $month;
		} else {
			$m = array();
			for ($i = 1; $i <= $month; $i++) {
				$m[] = $i;
			}
			$month = str_replace("'\'", '', $m);
		}
		$data_db = $this->model_kpi_scoring_by_kpi->get($month);
		$data = array(
			'totalScore' => $data_db['total_score'],
			'totalGroup' => $data_db['total_group'],
			'titleHead' => $data_db['title_head'],
			'titleScore' => $data_db['bobot_score'], // Target Score
			'titleGroup' => $data_db['bobot_group'],   // Actual Score
			'dealer_code' => $data_db['dealer_code'], //Body: Dealer Cabang
			'bulan_where_in' => $month,
			'functions' => $this,
		);
		$this->load->view('kpi_cabang/by_kpi_score/indexx', $data);
	}

	public function get_sum_score_perdealer($code_dealer, $id_kategori_item, $month)
	{
		$data = $this->model_kpi_scoring_by_kpi->get_total_score($code_dealer, $id_kategori_item, $month);
		return array(
			'score' => $data['score'],
			'bobot4' => $data['bobot4'],
		);
	}
}

/* End of file Wuling_as_kpi_scoring_by_kpi.php */
/* Location: ./application/controllers/Wuling_as_kpi_scoring_by_kpi.php */
