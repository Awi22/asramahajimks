<?php

use app\models\elo\sales\ModelPricelist;
use app\models\elo\sales\ModelVarian;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_pricelist extends CI_Model
{

    public function getDataVarian()
    {
        $varian = [];
        $data = ModelVarian::whereShow('1')->get()->sortBy('varian');

        foreach ($data as $key => $value) {
            $varian[] = [
                'id' => $value->id_varian,
                'text' => $value->varian,
            ];
        }

        return $varian;
    }

    public function getDataPricelistUnit($id_varian, $id_perusahaan)
    {
        $pricelist = [];
        $no = 1;
        $data = ModelPricelist::with(['toVarian', 'toPerusahaan'])->whereId_perusahaan($id_perusahaan);
        if ($id_varian) {
            $data = $data->whereId_varian($id_varian);
        }
        $data = $data->whereHas('toVarian', function ($query) {
            $query->whereShow('1');
        })->get()->sortBy(function ($query) {
            return $query->toVarian->varian;
        });
        foreach ($data as $key => $value) {
            $pricelist[] = [
                'no'           => $no++,
                'id_pricelist' => $value->id_pricelist,
                'cabang'       => $value->toPerusahaan['lokasi'],
                'varian'       => $value->toVarian['varian'],
                'jenis_warna'  => $value->jenis_warna == 'n' ? 'Normal' : 'Special',
                'harga_off'    => separator_harga($value->harga_off),
                'harga_on'     => separator_harga($value->harga_otr),
            ];
        }

        return $pricelist;
    }
}
