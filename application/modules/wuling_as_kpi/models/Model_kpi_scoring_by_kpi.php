<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_kpi_scoring_by_kpi extends CI_Model
{

	public function get($month)
	{
		// Title Head
		$query_all_kategori_item = $this->db_holding->select('id, name')
			->from('kpi_kategori_item')
			->where('enabled', 1)
			->get();
		$title_head = array('KPI');
		foreach ($query_all_kategori_item->result() as $kpi) {
			$title_head[$kpi->id] = $kpi->name;
		}

		// Title Head Score & Group (Target & Actual)
		$headTitle  = $title_head;
		unset($headTitle[0]);
		$totalScore = 0;
		$totalGroup = 0;
		$bobotScore = array('Score');
		$titleGroup = array('Group');
		foreach ($headTitle as $id => $val) {
			// Score Target (Score Head)
			$bobot4 = $this->db_holding
				->where('id', $id)
				->get('kpi_kategori_item')
				->row_array();
			if (isset($bobot4['bobot4'])) {
				$bobotScore[] = $bobot4['bobot4'] . '%';
				$totalScore += $bobot4['bobot4'];
			}
			// Score Actual (Group Head)
			$actual = $this->db_holding
				->select('SUM(target) AS target, SUM(actual) AS actual')
				->where('tahun', date('Y'))
				->where_in('bulan', $month)
				->where('id_kategori_item', $id)
				->get('kpi_kategori_item_detail')
				->row_array();
			$achTotal = 0;
			if (isset($actual['actual'])) {
				$totalAch = round($actual['actual'] / $actual['target'] * 100, 2);
				$decimal_bobot = floatval($bobot4['bobot4']) / 100.00;
				if ($totalAch > 1) {
					$achTotal = $bobot4['bobot4'] . '%';
					$totalGroup += $bobot4['bobot4'];
				} else {
					$achTotal = round(($totalAch * $decimal_bobot) * 100, 2) . '%';
					$totalGroup += round(($totalAch * $decimal_bobot) * 100, 2);
				}
			}
			if ($achTotal == 0) {
				$achTotal = '0.00%';
			}
			$titleGroup[] = $achTotal;
		}

		// Dealer Code (Nama Cabang)
		$query_dealer_code = $this->db_holding->select('kkid.dealer_code, kkid.id_kategori_item, adc.dealer_name')
			->from('kpi_kategori_item_detail kkid')
			->join('db_wuling_as.api_dealer_code adc', 'adc.dealer_code=kkid.dealer_code')
			->where('kkid.tahun', date('Y'))
			->where_in('kkid.bulan', $month)
			->group_by('dealer_code')
			->get();
		$dealer_code = array();
		foreach ($query_dealer_code->result() as $dealer) {
			$dealer_code[$dealer->dealer_code] = str_replace(array('Kumala Cemerlang Abadi ', 'Kumala Motor ', 'Kumala '), '', $dealer->dealer_name);
		}

		return (array(
			'title_head' => $title_head,
			'dealer_code' => $dealer_code,
			'total_score' => $totalScore . '%',
			'total_group' => $totalGroup . '%',
			'bobot_score' => $bobotScore,
			'bobot_group' => $titleGroup
		));
	}
	public function get_total_score($code_dealer, $id_kategori_item, $month)
	{
		$query_ach = $this->db_holding
			->select('kkid.score, kki.bobot4')
			->from('kpi_kategori_item_detail kkid')
			->join('kpi_kategori_item kki', 'kki.id=kkid.id_kategori_item')
			->where('kkid.dealer_code', $code_dealer)
			->where('kkid.id_kategori_item', $id_kategori_item)
			->where('kkid.tahun', date('Y'))
			->where_in('kkid.bulan', $month)
			->get()
			->row_array();
		return $query_ach;
	}
}

/* End of file Model_kpi_scoring_by_kpi.php */
/* Location: ./wuling_admin/models/Model_kpi_scoring_by_kpi.php */
