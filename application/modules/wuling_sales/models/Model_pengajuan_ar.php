<?php

use app\models\elo\sales\ModelCustomer;
use app\models\elo\sales\ModelRequestAr;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_pengajuan_ar extends CI_Model
{

    public function getDataCustomerRequestAr($id_sales)
    {
        $requsetAr = [];
        $data = ModelCustomer::with(['toHotProspek', 'toSspk'])->whereSales($id_sales)->whereIn('status', ['spk', 'ado'])->get();

        foreach ($data as $key => $value) {
            $requsetAr[] = [
                'id_prospek_no_spk'     => $value->id_prospek . ' ( ' . $value->toSspk['no_spk'] . ' )',
                'id_prospek'            => $value->id_prospek,
                'nama'                  => $value->nama,
                'tdp'                   => separator_harga($value->tdp),
                'no_spk'                => $value->toSspk['no_spk'],
                'id_spv'                => $value->toSspk['id_supervisor'],
                'requst_ar'             => separator_harga($this->getDataRequstAr($value->id_prospek)['request_ar']),
                'status_sales'          => $this->getDataRequstAr($value->id_prospek)['toRequsetArProgress']['sales'],
                'status_spv'            => $this->getDataRequstAr($value->id_prospek)['toRequsetArProgress']['spv'],
                'status_sm'             => $this->getDataRequstAr($value->id_prospek)['toRequsetArProgress']['sm'],
                'status_admin_keuangan' => $this->getDataRequstAr($value->id_prospek)['toRequsetArProgress']['admin_keuangan'],
            ];
        }

        return $requsetAr;

        // dd($data->toArray(), $requsetAr);
    }

    public function getDataRequstAr($id_prospek)
    {
        $data = ModelRequestAr::with(['toRequsetArProgress'])->whereId_prospek($id_prospek)->first();
        return $data;
    }
}
