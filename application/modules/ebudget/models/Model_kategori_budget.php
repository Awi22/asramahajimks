<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Model_kategori_budget extends CI_Model
{

	public function __construct()
	{
		parent::__construct();		
	}
	
	public function get($posts)
	{
		$data 	= array();
		$query 	= $this->db_wuling
			->select('a.*')
			->from('akun a')
			->where('a.kode_akun LIKE  "6%" ')
			->where('a.level <> 0')
			->order_by('a.kode_akun ASC')
			->get();

		$data = array();
		$sub_kategori = $coa_budget = $sub_coa_budget = '';
		$prev_kategori = $prev_sub_kategori = '';

		foreach ($query->result() as $kategori_budget) {
			$level = $kategori_budget->level;
			$kode_akun = $kategori_budget->kode_akun;
			$nama_akun = $kategori_budget->nama_akun;

			if ($level == 1) {
				$sub_kategori = ($sub_kategori != $nama_akun) ? $kode_akun . ' - ' . $nama_akun : '';
				$coa_budget = $sub_coa_budget = '';
			} elseif ($level == 2) {
				$coa_budget = ($coa_budget != $nama_akun) ? $kode_akun . ' - ' . $nama_akun : '';
				$sub_coa_budget = '';
			} elseif ($level == 3) {
				$sub_coa_budget = $kode_akun . ' - ' . $nama_akun;
			}

			// Check if the current category or sub-category is different from the previous one
			if ($sub_kategori != $prev_kategori || $coa_budget != $prev_sub_kategori) {
				// Check if both sub_category and sub_detail_category are empty, skip the entry
				if (!empty($coa_budget) || !empty($sub_coa_budget)) {
					$data[] = array(
						'sub_kategori' => $sub_kategori,
						'coa_budget' => $coa_budget,
						'sub_coa_budget' => $sub_coa_budget,
					);
				}
			} else {
				// If the category and sub-category are the same, append sub_coa_budget
				end($data);
				$key = key($data);
				$data[$key]['sub_coa_budget'] .= '<br>' . $sub_coa_budget;
			}

			// Always update the previous category and sub-category
			$prev_kategori = $sub_kategori;
			$prev_sub_kategori = $coa_budget;
		}

		return $data;
	}	
}

/* End of file Model_kategori_budget.php */
/* Location: ./wuling_finance/models/Model_kategori_budget.php */

