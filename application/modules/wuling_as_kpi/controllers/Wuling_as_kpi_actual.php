<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Csv as CsvReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

use function PHPUnit\Framework\isNan;

class Wuling_as_kpi_actual extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_kpi_actual');
    }

    public function index()
    {
        $this->layout
            ->title('Actual Kategori')
            ->view('kpi_actual/index');
    }

    public function get()
    {
        $data         = $this->model_kpi_actual->get();
        responseJson(['aaData' => $data]);
    }

    function import_excel()
    {
        $this->load->helper('file');

        $status         = false;
        $pesan          = 'Gagal upload file';
        $id_kategori    = $this->input->post('id');
        $tahun          = $this->input->post('tahun');
        $bulan          = $this->input->post('bulan');

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

            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheet_data    = $spreadsheet->getActiveSheet(0)->toArray();

            $array_data = [];

            if (empty($id_kategori) || empty($tahun) || empty($bulan)) {
                responseJson([
                    'status' => $status,
                    'pesan' => "Required data empty!!",
                ]);
                die();
            }

            $nama_kategori = $this->model_kpi_actual->id_kategori_to_name($id_kategori);

            for ($i = 1; $i < count($sheet_data); $i++) {
                $v_dealer_code    = $sheet_data[$i]['0'];
                $v_actual         = $sheet_data[$i]['2'];

                if (empty($v_dealer_code)) {
                    continue;
                } else {
                    if ($v_actual != 0) {
                        $data = array(
                            'id_kategori_item'  => $id_kategori,
                            'tahun'             => $tahun,
                            'bulan'             => $bulan,
                            'dealer_code'       => $v_dealer_code,
                            'actual'            => $v_actual,
                        );
                        $array_data[] = $data;
                        $result = $this->model_kpi_actual->insert_or_update($data);
                        if (!$result) {
                            responseJson([
                                'status' => false,
                                'pesan' => "Kesalahan saat insert data, pada baris ke-" . $i . " atau target belum ada untuk kategori " . $nama_kategori,
                            ]);
                            exit();
                        }
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

    public function sinkron_data()
    {
        $id_kategori    = $this->input->post('id');
        $tahun          = $this->input->post('tahun');
        $bulan          = $this->input->post('bulan');

        switch ($id_kategori) {
            case '10':
                $this->count_revenue_jasa_part($id_kategori, $tahun, $bulan);
                break;
            case '11':
                $this->count_gross_profit_sparepart($id_kategori, $tahun, $bulan);
                break;
            case '12':
                $this->count_ue_revenue_upselling($id_kategori, $tahun, $bulan);
                break;
            case '16':
                $this->count_penyerapan_customer($id_kategori, $tahun, $bulan);
                break;

            default:
                die('Kesalahan! Kategori tidak terdeteksi');
                break;
        }
    }

    public function count_revenue_jasa_part($id_kategori_item, $year, $month)
    {
        $qry_perusahaan = $this->db_wuling_as->query("SELECT adc.id_perusahaan, adc.dealer_code FROM api_dealer_code AS adc WHERE adc.id_perusahaan IS NOT NULL");

        foreach ($qry_perusahaan->result() as $key => $value) {
            $id_perusahaan    = $value->id_perusahaan;
            $nil_revenue_jasa = 0;
            $nil_revenue_part = 0;

            $qry_revenue_jasa = $this->db_wuling->query("SELECT b.id_perusahaan, a.kode_akun, a.nama_akun, b.tahun, b.bulan, b.jumlah FROM akun AS a LEFT JOIN( SELECT bb.id_perusahaan, bb.kode_akun, YEAR( bb.tgl) AS tahun, MONTH( bb.tgl) AS bulan, SUM( bb.jumlah) AS jumlah FROM db_wuling.buku_besar AS bb WHERE bb.id_perusahaan IS NOT NULL GROUP BY YEAR( bb.tgl), MONTH ( bb.tgl ), bb.kode_akun, bb.id_perusahaan ORDER BY bb.id_perusahaan ASC ) AS b ON b.kode_akun = a.kode_akun WHERE b.tahun = '$year' AND b.bulan = '$month' AND b.id_perusahaan = '$id_perusahaan' AND a.kode_akun IN ( '420101', '420102', '450501' ) ORDER BY b.id_perusahaan ASC");

            foreach ($qry_revenue_jasa->result() as $key => $row) {
                $nil_420101 = 0;
                $nil_420102 = 0;
                $nil_450501 = 0;

                if ($row->kode_akun == '420101') {
                    $nil_420101 = $row->jumlah;
                }

                if ($row->kode_akun == '420102') {
                    $nil_420102 = $row->jumlah;
                }

                if ($row->kode_akun == '450501') {
                    $nil_450501 = $row->jumlah;
                }

                $nil_revenue_jasa += (($nil_420101 + $nil_420102) - $nil_450501);
            }

            $qry_revenue_part = $this->db_wuling->query("SELECT b.id_perusahaan, a.kode_akun, a.nama_akun, b.tahun, b.bulan, b.jumlah FROM akun AS a LEFT JOIN( SELECT bb.id_perusahaan, bb.kode_akun, YEAR( bb.tgl) AS tahun, MONTH( bb.tgl) AS bulan, SUM( bb.jumlah) AS jumlah FROM db_wuling.buku_besar AS bb WHERE bb.id_perusahaan IS NOT NULL GROUP BY YEAR( bb.tgl), MONTH ( bb.tgl ), bb.kode_akun, bb.id_perusahaan ORDER BY bb.id_perusahaan ASC ) AS b ON b.kode_akun = a.kode_akun WHERE b.tahun = '$year' AND b.bulan = '$month' AND b.id_perusahaan = '$id_perusahaan' AND a.kode_akun IN ( '420201', '420202', '450502' ) ORDER BY b.id_perusahaan ASC");

            foreach ($qry_revenue_part->result() as $key => $row) {
                $nil_420201 = 0;
                $nil_420202 = 0;
                $nil_450502 = 0;

                if ($row->kode_akun == '420201') {
                    $nil_420201 = $row->jumlah;
                }

                if ($row->kode_akun == '420202') {
                    $nil_420202 = $row->jumlah;
                }

                if ($row->kode_akun == '450502') {
                    $nil_450502 = $row->jumlah;
                }

                $nil_revenue_part += (($nil_420201 + $nil_420202) - $nil_450502);
            }

            $actual = ($nil_revenue_jasa + $nil_revenue_part);

            $where = [
                'id_kategori_item' => $id_kategori_item,
                'dealer_code'      => $value->dealer_code,
                'tahun'            => $year,
                'bulan'            => $month,
            ];

            $qry = $this->db_holding->where($where)->get('kpi_kategori_item_detail');
            $num = $qry->num_rows();
            $row = $qry->row();

            if ($num > 0) {
                $score = number_format(@($actual / $row->target) * 100);

                $data = [
                    'id_kategori_item' => $id_kategori_item,
                    'dealer_code'      => $value->dealer_code,
                    'tahun'            => $year,
                    'bulan'            => $month,
                    'actual'           => $actual,
                    'score'            => (is_infinite($score) ? 0 : $score),
                ];

                $this->db_holding->where($where)->update('kpi_kategori_item_detail', $data);
            }
        }

        responseJson([
            'status' => true,
            'pesan'  => 'Sinkron data berhasil',
        ]);
    }

    public function count_gross_profit_sparepart($id_kategori_item, $year, $month)
    {
        $qry_perusahaan = $this->db_wuling_as->query("SELECT adc.id_perusahaan, adc.dealer_code FROM api_dealer_code AS adc WHERE adc.id_perusahaan IS NOT NULL");

        foreach ($qry_perusahaan->result() as $key => $value) {
            $id_perusahaan    = $value->id_perusahaan;
            $nil_hpp_part     = 0;
            $nil_revenue_part = 0;

            $qry_hpp_part = $this->db_wuling->query("SELECT b.id_perusahaan, a.kode_akun, a.nama_akun, b.tahun, b.bulan, b.jumlah FROM akun AS a LEFT JOIN( SELECT bb.id_perusahaan, bb.kode_akun, YEAR( bb.tgl) AS tahun, MONTH( bb.tgl) AS bulan, SUM( bb.jumlah) AS jumlah FROM db_wuling.buku_besar AS bb WHERE bb.id_perusahaan IS NOT NULL GROUP BY YEAR ( bb.tgl ), MONTH ( bb.tgl ), bb.kode_akun, bb.id_perusahaan ORDER BY bb.id_perusahaan ASC ) AS b ON b.kode_akun = a.kode_akun WHERE b.tahun = '$year' AND b.bulan = '$month' AND b.id_perusahaan = '$id_perusahaan' AND a.kode_akun IN ( '505201', '505202' ) ORDER BY b.id_perusahaan ASC");

            foreach ($qry_hpp_part->result() as $key => $row) {
                $nil_505201 = 0;
                $nil_505202 = 0;

                if ($row->kode_akun == '505201') {
                    $nil_505201 = $row->jumlah;
                }

                if ($row->kode_akun == '505202') {
                    $nil_505202 = $row->jumlah;
                }

                $nil_hpp_part += (($nil_505201 + $nil_505202) * -1);
            }

            $qry_revenue_part = $this->db_wuling->query("SELECT b.id_perusahaan, a.kode_akun, a.nama_akun, b.tahun, b.bulan, b.jumlah FROM akun AS a LEFT JOIN( SELECT bb.id_perusahaan, bb.kode_akun, YEAR( bb.tgl) AS tahun, MONTH( bb.tgl) AS bulan, SUM( bb.jumlah) AS jumlah FROM db_wuling.buku_besar AS bb WHERE bb.id_perusahaan IS NOT NULL GROUP BY YEAR( bb.tgl), MONTH ( bb.tgl ), bb.kode_akun, bb.id_perusahaan ORDER BY bb.id_perusahaan ASC ) AS b ON b.kode_akun = a.kode_akun WHERE b.tahun = '$year' AND b.bulan = '$month' AND b.id_perusahaan = '$id_perusahaan' AND a.kode_akun IN ( '420201', '420202', '450502' ) ORDER BY b.id_perusahaan ASC");

            foreach ($qry_revenue_part->result() as $key => $row) {
                $nil_420201 = 0;
                $nil_420202 = 0;
                $nil_450502 = 0;

                if ($row->kode_akun == '420201') {
                    $nil_420201 = $row->jumlah;
                }

                if ($row->kode_akun == '420202') {
                    $nil_420202 = $row->jumlah;
                }

                if ($row->kode_akun == '450502') {
                    $nil_450502 = $row->jumlah;
                }

                $nil_revenue_part += (($nil_420201 + $nil_420202) - $nil_450502);
            }

            $actual = ($nil_revenue_part + $nil_hpp_part);

            $where = [
                'id_kategori_item' => $id_kategori_item,
                'dealer_code'      => $value->dealer_code,
                'tahun'            => $year,
                'bulan'            => $month,
            ];

            $qry = $this->db_holding->where($where)->get('kpi_kategori_item_detail');
            $num = $qry->num_rows();
            $row = $qry->row();

            if ($num > 0) {
                $score = number_format(@($actual / $row->target) * 100);

                $data = [
                    'id_kategori_item' => $id_kategori_item,
                    'dealer_code'      => $value->dealer_code,
                    'tahun'            => $year,
                    'bulan'            => $month,
                    'actual'           => $actual,
                    'score'            => (is_infinite($score) ? 0 : $score),
                ];

                $this->db_holding->where($where)->update('kpi_kategori_item_detail', $data);
            }
        }

        responseJson([
            'status' => true,
            'pesan' => 'Sinkron data berhasil',
        ]);
    }

    public function count_ue_revenue_upselling()
    {
        debug('count_ue_revenue_upselling');
    }

    public function count_penyerapan_customer($id, $tahun, $bulan)
    {
        $hasil = $this->model_kpi_actual->count_penyerapan_customer($id, $tahun, $bulan);
        responseJson([
            'status' => $hasil['status'],
            'pesan'  => $hasil['pesan'],
        ]);
    }
}

/* End of file Wuling_as_kpi_actual.php */
/* Location: ./application/controllers/Wuling_as_kpi_actual.php */
