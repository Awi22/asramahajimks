<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_report_pesanan_sparepart extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_report');
    }

    public function index()
    {
        $this->layout
            ->title('Laporan Pesanan Sparepart')
            ->view('report_pesanan_sparepart/index');
    }

    public function lihat_data()
    {
        $post = $this->input->post();

        $tgl_awal  = tgl_sql($post['tgl_awal']);
        $tgl_akhir = tgl_sql($post['tgl_akhir']);

        // untuk ambil pesanan pembelian
        $get = $this->model_report->get_data_laporan_pesanan_pembelian($this->id_perusahaan, $tgl_awal, $tgl_akhir);

        $result = [];
        foreach ($get->result() as $row) {
            // untuk ambil detail pesanan pembelian
            $detail = $this->model_report->get_data_pembelian($row->id_pesanan_pembelian);

            $result[] = [
                'tgl'         => $row->tanggal,
                'no_po'       => $row->no_po,
                'no_order_id' => $row->no_order_id,
                'supplier'    => $row->nama_supplier,
                'kategori'    => $row->nama_kategori,
                'detail'      => $detail
            ];
        }

        $data = [
            'data' => $result
        ];
        $this->load->view('report_pesanan_sparepart/table', $data);
    }
}