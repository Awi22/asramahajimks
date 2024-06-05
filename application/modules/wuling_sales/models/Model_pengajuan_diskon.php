<?php

use app\models\elo\sales\ModelPengajuanDiskon;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_pengajuan_diskon extends CI_Model
{

    public function  getDataPengajuanDiskon($id_sales)
    {
        $pengajuanDiskon = [];
        $data = ModelPengajuanDiskon::with(['toSspk', 'toSspk.toCustomer'])->whereId_sales($id_sales);
        $data = $data->whereHas('toSspk', function ($query) {
            $query->whereBatal('n');
        })->orderBy('w_insert', 'desc')->get();

        foreach ($data as $key => $value) {
            $pengajuanDiskon[] = [
                'no_spk'         => $value->no_spk,
                'diskon'         => separator_harga($value->diskon),
                'approve_diskon' => separator_harga($value->approve_diskon),
                'checked'        => $value->checked,
                'customer'       => $value->toSspk->toCustomer['nama'],
            ];
        }

        return $pengajuanDiskon;
    }
}
