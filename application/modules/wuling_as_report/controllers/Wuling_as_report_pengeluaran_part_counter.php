<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_report_pengeluaran_part_counter extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_report');
    }

    public function index()
    {
        $this->layout
            ->title('Laporan Part Keluar By Part Counter')
            ->view('report_pengeluaran_part_counter/index');
    }

    public function lihat_data()
    {
        $post = $this->input->post();

        $tgl_awal  = tgl_sql($post['tgl_awal']);
        $tgl_akhir = tgl_sql($post['tgl_akhir']);
        $get       = $this->model_report->get_data_part_counter($this->id_perusahaan, $tgl_awal, $tgl_akhir);

        $data = [
            'data' => $get,
        ];

        $this->load->view('report_pengeluaran_part_counter/table', $data);
    }
}
