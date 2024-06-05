<?php

use app\models\elo\sales\ModelCsutomerDigital;
use app\models\elo\sales\ModelCustomer;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_customer_digital extends CI_Model
{

    public function getDataCsutomerDigital($id_sales)
    {
        $no = 1;
        $customerDigital = [];
        $data = ModelCsutomerDigital::with(['toPerusahaan'])->whereId_status_customer('7')->whereId_sales_force($id_sales)->get();

        foreach ($data as $key => $row) {
            $customerDigital[] = [
                'no'                  => $no++,
                'id_dl_customer'      => $row->id_dl_customer,
                'id_customer_digital' => $row->id_customer_digital,
                'customer'            => $row->nama,
                'alamat'              => $row->alamat,
                'tlpn'                => $row->no_telp,
                'kota'                => $row->kota,
                'dealer'              => ucwords(strtolower($row->toPerusahaan['lokasi'])),
                'pekerjaan'           => $row->pekerjaan,
                'type_mobil'          => $row->tipe_mobil,
                'brand_lain'          => $row->brand_lain,
                'status'              => $this->getDataStatusCsutomer($row->id_customer_digital),
                // 'nama_sales'          => $this->getKaryawan($row->id_sales_force),
                // 'level'               => $level,
            ];
        }

        return $customerDigital;
    }

    private function getDataStatusCsutomer($id_cus_digital)
    {
        $data = ModelCustomer::whereId_cus_digital($id_cus_digital)->pluck('status');
        return $data;
    }
}
