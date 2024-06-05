<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wuling_as_report_pengeluaran_part_closing_actual extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_report');
    }

    public function index()
    {
        $this->layout
            ->title('Laporan Part Closing Aktual')
            ->view('report_pengeluaran_part_closing_actual/index');
    }

    public function lihat_data()
    {
        $post = $this->input->post();

        if ($post['jenis_part'] == 'reguler') {
            $get = $this->_stok_reguler($post['bulan'], $post['tahun']);
        } else {
            $get = $this->_stok_pud($post['bulan'], $post['tahun']);
        }

        $data = [
            'data' => $get,
        ];

        $this->load->view('report_pengeluaran_part_closing_actual/table', $data);
    }

    // untuk stok reguler
    public function _stok_reguler($bulan, $tahun)
    {
        $tgl_awal        = '2018-01-01';
        $tgl_awal_bulan  = "{$tahun}-{$bulan}-01";
        $tgl_akhir_bulan = (new DateTime("{$tgl_awal_bulan}"))->modify('last day of')->format('Y-m-d');

        $get_awal  = $this->model_report->getStokCurrentRegulerClosingDate($this->id_perusahaan, $tgl_awal, $tgl_awal_bulan, $tgl_akhir_bulan);
        $get_akhir = $this->model_report->getStokCurrentRegulerClosingDate($this->id_perusahaan, $tgl_awal, $tgl_akhir_bulan);

        $awal  = [];
        $akhir = [];

        // untuk ambil awal bulan
        foreach ($get_awal->result() as $key => $row) {
            $stok_masuk_awal   = ($row->masuk_pembelian + $row->masuk_ditemukan + $row->masuk_retur_sparepart + $row->masuk_retur_service);
            $stok_keluar_awal  = ($row->keluar_hilang + $row->keluar_service_new + $row->keluar_service_old + $row->keluar_service_retur + $row->keluar_sparepart + $row->keluar_sparepart_retur);
            $stok_alokasi_awal = ($row->alokasi_sparepart + $row->alokasi_service);
            $stok_wip_awal     = ($row->wip_sparepart + $row->wip_service);
            $stok_awal         = ($stok_masuk_awal - $stok_keluar_awal);
            $stok_ready_awal   = ($stok_awal - $stok_alokasi_awal);
            $stok_aktual_awal  = ($stok_awal - $stok_wip_awal);

            $awal[] = [
                'part_number'       => $row->part_number,
                'kode_item'         => $row->kode_item,
                'nama_item'         => $row->nama_item,
                'stok_awal'         => $stok_awal,
                'stok_alokasi_awal' => $stok_alokasi_awal,
                'stok_wip_awal'     => $stok_wip_awal,
                'stok_aktual_awal'  => $stok_aktual_awal,
                'stok_ready_awal'   => $stok_ready_awal,
                'in_stok'           => $row->stok_in,
                'out_stok'          => $row->stok_out,
                'trans_in'          => $row->trans_in,
                'trans_out'         => $row->trans_out,
            ];
        }

        // untuk ambil akhir bulan
        foreach ($get_akhir->result() as $key => $row) {
            $stok_masuk_akhir   = ($row->masuk_pembelian + $row->masuk_ditemukan + $row->masuk_retur_sparepart + $row->masuk_retur_service);
            $stok_keluar_akhir  = ($row->keluar_hilang + $row->keluar_service_new + $row->keluar_service_old + $row->keluar_service_retur + $row->keluar_sparepart + $row->keluar_sparepart_retur);
            $stok_alokasi_akhir = ($row->alokasi_sparepart + $row->alokasi_service);
            $stok_wip_akhir     = ($row->wip_sparepart + $row->wip_service);
            $stok_akhir         = ($stok_masuk_akhir - $stok_keluar_akhir);
            $stok_ready_akhir   = ($stok_akhir - $stok_alokasi_akhir);
            $stok_aktual_akhir  = ($stok_akhir - $stok_wip_akhir);

            $akhir[] = [
                'part_number'        => $row->part_number,
                'kode_item'          => $row->kode_item,
                'nama_item'          => $row->nama_item,
                'stok_akhir'         => $stok_akhir,
                'stok_alokasi_akhir' => $stok_alokasi_akhir,
                'stok_wip_akhir'     => $stok_wip_akhir,
                'stok_aktual_akhir'  => $stok_aktual_akhir,
                'stok_ready_akhir'   => $stok_ready_akhir,
            ];
        }

        $result = [];
        for ($i = 0; $i < count($awal); $i++) {
            $net     = ($awal[$i]['in_stok'] - $awal[$i]['out_stok']);
            $selisih = ($awal[$i]['stok_awal'] - $akhir[$i]['stok_akhir'] + $net);

            $result[] = [
                'part_number'        => $awal[$i]['part_number'],
                'kode_item'          => $awal[$i]['kode_item'],
                'nama_item'          => $awal[$i]['nama_item'],
                'stok_awal'          => $awal[$i]['stok_awal'],
                'stok_alokasi_awal'  => $awal[$i]['stok_alokasi_awal'],
                'stok_wip_awal'      => $awal[$i]['stok_wip_awal'],
                'stok_aktual_awal'   => $awal[$i]['stok_aktual_awal'],
                'stok_ready_awal'    => $awal[$i]['stok_ready_awal'],
                'in_trans'           => $awal[$i]['trans_in'],
                'in_stok'            => $awal[$i]['in_stok'],
                'out_trans'          => $awal[$i]['trans_out'],
                'out_stok'           => $awal[$i]['out_stok'],
                'net'                => $net,
                'stok_akhir'         => $akhir[$i]['stok_akhir'],
                'stok_alokasi_akhir' => $akhir[$i]['stok_alokasi_akhir'],
                'stok_wip_akhir'     => $akhir[$i]['stok_wip_akhir'],
                'stok_aktual_akhir'  => $akhir[$i]['stok_aktual_akhir'],
                'stok_ready_akhir'   => $akhir[$i]['stok_ready_akhir'],
                'selisih'            => $selisih,
            ];
        }

        return $result;
    }

    // untuk stok pud
    public function _stok_pud($bulan, $tahun)
    {
        $tgl_awal        = '2018-01-01';
        $tgl_awal_bulan  = "{$tahun}-{$bulan}-01";
        $tgl_akhir_bulan = (new DateTime("{$tgl_awal_bulan}"))->modify('last day of')->format('Y-m-d');

        $get_awal  = $this->model_report->getStokCurrentPUDClosingDate($this->id_perusahaan, $tgl_awal, $tgl_awal_bulan, $tgl_akhir_bulan);
        $get_akhir = $this->model_report->getStokCurrentPUDClosingDate($this->id_perusahaan, $tgl_awal, $tgl_akhir_bulan);

        $awal  = [];
        $akhir = [];

        // untuk ambil awal bulan
        foreach ($get_awal->result() as $key => $row) {
            $stok_masuk_awal   = ($row->masuk_pembelian + $row->masuk_ditemukan + $row->masuk_retur_service);
            $stok_keluar_awal  = ($row->keluar_hilang + $row->keluar_service_new + $row->keluar_service_old + $row->keluar_service_retur);
            $stok_alokasi_awal = ($row->alokasi_service);
            $stok_wip_awal     = ($row->wip_service);
            $stok_awal         = ($stok_masuk_awal - $stok_keluar_awal);
            $stok_ready_awal   = ($stok_awal - $stok_alokasi_awal);
            $stok_aktual_awal  = ($stok_awal - $stok_wip_awal);

            $awal[] = [
                'part_number'       => $row->part_number,
                'kode_item'         => $row->kode_item,
                'nama_item'         => $row->nama_item,
                'stok_awal'         => $stok_awal,
                'stok_alokasi_awal' => $stok_alokasi_awal,
                'stok_wip_awal'     => $stok_wip_awal,
                'stok_aktual_awal'  => $stok_aktual_awal,
                'stok_ready_awal'   => $stok_ready_awal,
                'in_stok'           => $row->stok_in,
                'out_stok'          => $row->stok_out,
                'trans_in'          => $row->trans_in,
                'trans_out'         => $row->trans_out,
            ];
        }

        // untuk ambil akhir bulan
        foreach ($get_akhir->result() as $key => $row) {
            $stok_masuk_akhir   = ($row->masuk_pembelian + $row->masuk_ditemukan + $row->masuk_retur_service);
            $stok_keluar_akhir  = ($row->keluar_hilang + $row->keluar_service_new + $row->keluar_service_old + $row->keluar_service_retur);
            $stok_alokasi_akhir = ($row->alokasi_service);
            $stok_wip_akhir     = ($row->wip_service);
            $stok_akhir         = ($stok_masuk_akhir - $stok_keluar_akhir);
            $stok_ready_akhir   = ($stok_akhir - $stok_alokasi_akhir);
            $stok_aktual_akhir  = ($stok_akhir - $stok_wip_akhir);

            $akhir[] = [
                'part_number'        => $row->part_number,
                'kode_item'          => $row->kode_item,
                'nama_item'          => $row->nama_item,
                'stok_akhir'         => $stok_akhir,
                'stok_alokasi_akhir' => $stok_alokasi_akhir,
                'stok_wip_akhir'     => $stok_wip_akhir,
                'stok_aktual_akhir'  => $stok_aktual_akhir,
                'stok_ready_akhir'   => $stok_ready_akhir,
            ];
        }

        $result = [];
        for ($i = 0; $i < count($awal); $i++) {
            $net     = ($awal[$i]['in_stok'] - $awal[$i]['out_stok']);
            $selisih = ($awal[$i]['stok_awal'] - $akhir[$i]['stok_akhir'] + $net);

            $result[] = [
                'part_number'        => $awal[$i]['part_number'],
                'kode_item'          => $awal[$i]['kode_item'],
                'nama_item'          => $awal[$i]['nama_item'],
                'stok_awal'          => $awal[$i]['stok_awal'],
                'stok_alokasi_awal'  => $awal[$i]['stok_alokasi_awal'],
                'stok_wip_awal'      => $awal[$i]['stok_wip_awal'],
                'stok_aktual_awal'   => $awal[$i]['stok_aktual_awal'],
                'stok_ready_awal'    => $awal[$i]['stok_ready_awal'],
                'in_trans'           => $awal[$i]['trans_in'],
                'in_stok'            => $awal[$i]['in_stok'],
                'out_trans'          => $awal[$i]['trans_out'],
                'out_stok'           => $awal[$i]['out_stok'],
                'net'                => $net,
                'stok_akhir'         => $akhir[$i]['stok_akhir'],
                'stok_alokasi_akhir' => $akhir[$i]['stok_alokasi_akhir'],
                'stok_wip_akhir'     => $akhir[$i]['stok_wip_akhir'],
                'stok_aktual_akhir'  => $akhir[$i]['stok_aktual_akhir'],
                'stok_ready_akhir'   => $akhir[$i]['stok_ready_akhir'],
                'selisih'            => $selisih,
            ];
        }

        return $result;
    }
}
