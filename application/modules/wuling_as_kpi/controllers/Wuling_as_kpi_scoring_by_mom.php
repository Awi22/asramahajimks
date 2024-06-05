<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Wuling_as_kpi_scoring_by_mom extends MY_Controller
{
    public $bulan = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_kpi_by_cabang');

        for ($i = 1; $i <= 12; $i++) {
            $this->bulan[] = $i;
        }
    }

    public function index()
    {
        $data = [
            'data'       => $this->get_data(),
            'array_head' => $this->count_score_head(),
        ];

        $this->layout
            ->title('By MoM')
            ->data($data)
            ->view('kpi_cabang/by_mom/index');
    }

    public function get_data()
    {
        $get = $this->db_holding->query("SELECT kg.id_kpi_grup, ka.nama as dealer_area, kg.id_perusahaan, kg.dealer_code, adc.dealer_name FROM kpi_grup AS kg LEFT JOIN kpi_area AS ka ON ka.id_kpi_area = kg.id_kpi_area LEFT JOIN db_wuling_as.api_dealer_code AS adc ON adc.dealer_code = kg.dealer_code");
        $data = [];

        foreach ($get->result() as $key => $value) {
            $dealer_code = substr($value->dealer_code, -3);
            $dealer_name = str_replace(array('Kumala Cemerlang Abadi ', 'Kumala Motor ', 'Kumala '), '', $value->dealer_name);
            $dealer_score = [];

            foreach ($this->bulan as $k => $v) {
                $dealer_score[] = $this->count_score_body($dealer_code, $v, date('Y'));
            }

            $data[] = [
                'dealer_code'  => $dealer_code,
                'dealer_area'  => $value->dealer_area,
                'dealer_name'  => $dealer_name,
                'dealer_score' => $dealer_score
            ];
        }

        return $data;
    }

    public function count_score_head()
    {
        $year  = date('Y');
        $score = [];

        foreach ($this->bulan as $k => $v) {
            $get = $this->db_wuling_sp->query("SELECT kki.id, kki.NAME AS nama, kki.bobot4, kkid.dealer_code, kkid.bulan, kkid.tahun, SUM(kkid.target) as target, SUM(kkid.actual) as actual FROM db_holding.kpi_kategori_item AS kki LEFT JOIN db_holding.kpi_kategori_item_detail AS kkid ON kkid.id_kategori_item = kki.id WHERE kkid.tahun = '$year' AND kkid.bulan = '$v' AND kki.id IN( '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17') GROUP BY kki.id");
            
            $total_score = [];
            foreach ($get->result() as $key => $value) {
                $ach   = number_format(($value->actual / $value->target) * 100, 2);
                $bobot = floatval($value->bobot4) / 100.00;

                if ($ach > 1) {
                    $count = floatval($value->bobot4);
                } else {
                    $count = round(($ach * $bobot) * 100, 2);
                }

                $total_score[] = $count;
            }

            $score[] = array_sum($total_score) . '%';
        }

        $array_head = [
            'month' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            'score' => $score
        ];

        return $array_head;
    }

    public function count_score_body($dealer_code, $month, $year)
    {
        $get = $this->db_wuling_sp->query("SELECT kki.id, kki.NAME AS nama, kki.bobot4, kkid.dealer_code, kkid.bulan, kkid.tahun, kkid.score FROM db_holding.kpi_kategori_item AS kki LEFT JOIN db_holding.kpi_kategori_item_detail AS kkid ON kkid.id_kategori_item = kki.id WHERE kkid.dealer_code = '$dealer_code' AND kkid.tahun = '$year' AND kkid.bulan = '$month' AND kki.id IN( '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17')");
        $score = 0;

        foreach ($get->result() as $key => $value) {
            $decimal_ach    = floatval($value->score) / 100.00;
            $decimal_bobot  = floatval($value->bobot4) / 100.00;

            if (isset($value->score)) {
                if (floatval($value->score) > 100) {
                    $score += $value->bobot4;
                } else {
                    $score += number_format(($decimal_ach * $decimal_bobot) * 100, 2);
                }
            }
        }

        return $score . '%';
    }
}

/* End of file wuling_as_kpi_bobot.php */
/* Location: ./application/controllers/wuling_as_kpi_bobot.php */