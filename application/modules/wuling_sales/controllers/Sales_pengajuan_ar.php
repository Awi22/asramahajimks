<?php

use app\models\elo\sales\ModelRequestAr;
use app\models\elo\sales\ModelRequestArProgress;
use Illuminate\Database\Capsule\Manager as DB;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_pengajuan_ar extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_pengajuan_ar');
    }


    public function index()
    {
        $this->layout
            ->title('Data Pengajuan AR')
            ->view('pengajuan_ar/pengajuan_ar_sales');
    }

    public function getDataCustomerRequestAr()
    {
        $data = $this->Model_pengajuan_ar->getDataCustomerRequestAr($this->id_sales);
        responseJson(['aaData' => $data]);
    }


    public function simpanPengajuanAr()
    {
        $post = $this->input->post();

        DB::beginTransaction();
        try {
            $objectId = ModelRequestAr::updateOrCreate(
                [
                    'id_prospek' => $post['id_prospek']
                ],
                [
                    'id_sales'     => $this->id_sales,
                    'id_spv'       => $post['id_spv'],
                    'id_prospek'   => $post['id_prospek'],
                    'request_ar'   => remove_separator($post['pengajuan_ar']),
                    'start_ar'     => remove_separator($post['pengajuan_ar']),
                    'jenis_bayar'  => null,
                    'id_bank'      => null,
                    'no_transaksi' => null,
                ]
            );

            $id = $objectId->id_request_ar;

            ModelRequestArProgress::updateOrCreate(
                [
                    'id_request_ar' => $id,
                ],
                [
                    'id_request_ar'  => $id,
                    'sales'          => '2',
                    'spv'            => '1',
                    'sm'             => '0',
                    'admin_keuangan' => '0',
                ]
            );
            DB::commit();
            return responseJson(
                [
                    'status' => true,
                    'pesan' => 'Berhasil Simpan Data',
                ]
            );
        } catch (\Throwable $th) {
            DB::rollback();
            return responseJson(
                [
                    'status' => false,
                    'pesan' => $th->errorInfo
                ]
            );
        }
    }
}
