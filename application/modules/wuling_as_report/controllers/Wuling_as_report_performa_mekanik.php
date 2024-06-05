<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\models\elo\kmg\ModelPerusahaan;
use app\models\elo\kmg\ModelKaryawan;

class Wuling_as_report_performa_mekanik extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_report');
    }

    public function index()
    {
        $this->layout
            ->title('Laporan Performa Mekanik')
            ->view('report_performa_mekanik/index');
    }

    public function lihat_data()
    {
        $post = $this->input->post();

        $tgl_awal   = tgl_sql($post['awal']);
        $tgl_akhir  = tgl_sql($post['akhir']);
        $perusahaan = encrypter($post['perusahaan'], 'decrypt');
        $mekanik    = encrypter($post['list_mekanik'], 'decrypt');

        $get        = $this->model_report->lihat_data_performa_mekanik($perusahaan, $tgl_awal, $tgl_akhir, $mekanik);

        $data = [
            'data' => $get
        ];

        $this->load->view('report_performa_mekanik/table', $data);
    }

    public function get_cabang()
    {
        return $this->model_report->getCabang();
    }

    public function get_mekanik()
    {
        $perusahaan = encrypter($this->request->perusahaan, 'decrypt');
        $query = ModelKaryawan::whereIn('id_jabatan', [38, 39, 72, 123, 140, 156])->whereIdPerusahaan($perusahaan)->whereStatusAktif('Aktif')->orderBy('nama_karyawan', 'ASC')->get();
        $mekanik = array();

        foreach ($query as $value) {
            $mekanik[] = [
                'id'    => encrypter($value['id_karyawan']),
                'text'  => $value['nama_karyawan']
            ];
        }

        return responseJson(compact('mekanik'));
    }
}
