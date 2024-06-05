<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\Datatable;

class Wuling_as_report_hutang_vendor_lokal extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_report');
    }

    public function index()
    {
        $this->layout
            ->title('Laporan Hutang Vendor Lokal')
            ->view('report_hutang_vendor_lokal/index');
    }

    public function get_cabang()
    {
        return $this->model_report->getCabang();
    }

    public function lihat_data()
    {
        // $post = $this->input->post();

        // $tgl_awal   = tgl_sql($post['tgl_awal']);
        // $tgl_akhir  = tgl_sql($post['tgl_akhir']);
        // $perusahaan = encrypter($post['perusahaan'], 'decrypt');
        // $status     = (int) $post['status'];

        // $get = $this->model_report->lihat_data_hutang_vendor_lokal($perusahaan, $tgl_awal, $tgl_akhir, $status);

        // $data = [
        //     'data' => $get
        // ];

        // $this->load->view('report_hutang_vendor_lokal/table', $data);

        $offset     = $this->request->start;

        $perusahaan = encrypter($this->request->perusahaan, 'decrypt');
        if (!$perusahaan) $perusahaan = 0;
        $awal   = tgl_sql($this->request->awal);
        $akhir  = tgl_sql($this->request->akhir);
        $status = (int) $this->request->status;

        $datatable        = new Datatable;
        $datatable->query = $this->db->select('hutang_vendor_lokal.*,vendor_master.nama,pengeluaranOperasional.no_pengeluaran,pengeluaranOperasional.no_bukti_bku,pengeluaranOperasional.jumlah')->from('db_wuling_as.hutang_vendor_lokal')->join('db_wuling_as.vendor_master', 'vendor_master.id=hutang_vendor_lokal.id_vendor')->join("(SELECT pengeluaran_operasional_detail.*,pengeluaran_operasional.no_bukti_bku FROM db_wuling.pengeluaran_operasional_detail JOIN db_wuling.pengeluaran_operasional ON pengeluaran_operasional.no_pengeluaran=pengeluaran_operasional_detail.no_pengeluaran WHERE (pengeluaran_operasional.approved='0' OR (pengeluaran_operasional.approved='1' AND EXISTS (SELECT*FROM db_wuling.buku_besar WHERE no_transaksi=pengeluaran_operasional.no_bukti_bku AND jb='0' LIMIT 1))) AND pengeluaran_operasional.hapus='0') AS pengeluaranOperasional", 'pengeluaranOperasional.no_ref=hutang_vendor_lokal.no_po', 'left')->where("hutang_vendor_lokal.id_perusahaan=$perusahaan AND hutang_vendor_lokal.tanggal BETWEEN '$awal' AND '$akhir' AND hutang_vendor_lokal.status='0'")->where($status === 0 ? 'pengeluaranOperasional.no_bukti_bku IS NULL' : 'pengeluaranOperasional.no_bukti_bku IS NOT NULL');
        $results          = (object) $datatable->setColumns(null, 'hutang_vendor_lokal.tanggal', 'hutang_vendor_lokal.no_po', 'hutang_vendor_lokal.no_ref', 'pengeluaranOperasional.no_pengeluaran', 'pengeluaranOperasional.no_bukti_bku', 'vendor_master.nama')->get();

        $noPo = [];
        foreach ($results->data as $key => $value) {
            $noPo[] = $value->no_po;
        }

        if (count($noPo) > 0) {
            $toBukuBesar = $this->db->from('db_wuling.buku_besar')->where_in('no_transaksi', $noPo)->get()->result();
        }
        foreach ($results->data as $key => $value) {
            $bukuBesar = [];
            foreach ($toBukuBesar as $key1 => $value1) {
                if ($value1->no_transaksi === $value->no_po) {
                    $bukuBesar[] = $value1;
                }
            }
            $value->toBukuBesar = $bukuBesar;
        }

        $recordsData = [];
        foreach ($results->data as $key => $value) {
            $harga = $ppn = $total = 0;
            foreach ($value->toBukuBesar as $key1 => $value1) {
                if ($value1->kode_akun === '110890') {
                    $harga = $value1->jumlah;
                }
                if ($value1->kode_akun === '110905') {
                    $ppn = $value1->jumlah;
                }
                if ($value1->kode_akun === '210202') {
                    $total = $value1->jumlah;
                }
            }
            $nilaiHutang = $total;
            if (!empty($value->no_bukti_bku)) {
                $nilaiHutang =  $total - $value->jumlah;
            }
            $recordsData[] = [
                'no'             => $offset + $key + 1,
                'tanggal'        => $value->tanggal,
                'no_po'          => $value->no_po,
                'no_wo'          => $value->no_ref,
                'no_pengeluaran' => $value->no_pengeluaran ?? '-',
                'no_bukti_bku'   => $value->no_bukti_bku ?? '-',
                'nama_vendor'    => $value->nama,
                'harga'          => separator_harga($harga),
                'ppn'            => separator_harga($ppn),
                'total'          => separator_harga($total),
                'hutang'         => separator_harga($nilaiHutang),
            ];
        }
        $sumQuery = $this->db->select("SUM(CASE WHEN buku_besar.kode_akun='110890' AND buku_besar.dk='D' THEN buku_besar.jumlah ELSE 0 END) AS totalHarga,SUM(CASE WHEN buku_besar.kode_akun='110905' AND buku_besar.dk='D' THEN buku_besar.jumlah ELSE 0 END) AS totalPpn,SUM(CASE WHEN buku_besar.kode_akun='210202' AND buku_besar.dk='K' THEN buku_besar.jumlah ELSE 0 END) AS total,SUM(CASE WHEN buku_besar.kode_akun='210202' AND buku_besar.dk='K' THEN pengeluaranOperasional.jumlah ELSE 0 END) AS totalHutang")->from('db_wuling.buku_besar')->join("(SELECT pengeluaran_operasional_detail.*,pengeluaran_operasional.no_bukti_bku FROM db_wuling.pengeluaran_operasional_detail JOIN db_wuling.pengeluaran_operasional ON pengeluaran_operasional.no_pengeluaran=pengeluaran_operasional_detail.no_pengeluaran WHERE pengeluaran_operasional.approved='1' AND EXISTS (SELECT*FROM db_wuling.buku_besar WHERE no_transaksi=pengeluaran_operasional.no_bukti_bku AND jb='0' LIMIT 1) AND pengeluaran_operasional.hapus='0') AS pengeluaranOperasional", 'pengeluaranOperasional.no_ref=buku_besar.no_transaksi', 'left')->where("journal='pembelian_sublet' AND jb='0' AND id_perusahaan=$perusahaan AND tgl BETWEEN '$awal' AND '$akhir'")->where($status === 0 ? "pengeluaranOperasional.no_bukti_bku IS NULL" : "pengeluaranOperasional.no_bukti_bku IS NOT NULL")->get()->row();
        $summary = [
            'totalHarga'  => separator_harga($sumQuery->totalHarga),
            'totalPpn'    => separator_harga($sumQuery->totalPpn),
            'total'       => separator_harga($sumQuery->total),
            'totalHutang' => separator_harga($sumQuery->total - $sumQuery->totalHutang),
        ];
        //*untuk response json
        $response = [
            'draw'            => $results->draw,
            'recordsTotal'    => $results->recordsTotal,
            'recordsFiltered' => $results->recordsFiltered,
            'data'            => $recordsData,
            'summary'         => $summary
        ];
        return responseJson($response);
    }
}
