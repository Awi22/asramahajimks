<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan_laporan_kinerja extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_kinerja_karyawan');
    }

    public function index()
    {
        $this->layout
            ->title('Laporan Kinerja Karyawan')
            ->view('karyawan_laporan_kinerja/index');
    }

    public function get()
    {
        $gets    = $this->input->get();
        $data    = $this->model_kinerja_karyawan->get_laporan($gets);
        responseJson(['aaData' => $data]);
    }

    public function export()
    {
        $gets    = $this->input->get();
        $data    = $this->model_kinerja_karyawan->get_laporan($gets);
        $exportExcel = new PHPExport;
        $exportExcel
            ->dataSet($data)
            ->rataTengah('0,1,2,3,5,6')
            ->excel2003('laporan-kinerja-karyawan-' . date('Y-m-d-His'));
    }

    public function select2_area_kerja()
    {
        $data     = $this->model_kinerja_karyawan->select2_area_kerja();
        responseJson($data);
    }
}
