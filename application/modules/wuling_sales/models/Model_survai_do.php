<?php

use app\models\elo\sales\ModelSspk;
use app\models\elo\sales\ModelSurvaiDo;
use app\models\elo\sales\ModelWsaDataSuspect;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_survai_do extends CI_Model
{
    public function getDataSurvaiDO($id_sales)
    {
        $survaiDo = [];
        $data = ModelSspk::with(['toCustomer', 'toSdo', 'toSprospek', 'toAdmSales', 'toSprospek.toUnit.toPVarian'])
            ->whereBatal('n')->whereHas('toAdmSales', function ($query) use ($id_sales) {
                $query->whereStatus_aktif('A')->whereId_sales($id_sales);
            })->whereHas('toCustomer', function ($query) {
                $query->whereStatus('do');
            })->get()->sortByDesc(function ($query) {
                return $query->toSdo->tgl_do;
            });

        // debug($data->toArray());

        foreach ($data as $key => $value) {

            if ($value->toSdo['tgl_do'] <  '2023-07-01') {
                $cutoff = true;
            } else {
                $cutoff = false;
            }
            $fotoSurvaiDO = $this->getDataFotoSurvaiDo($value->id_prospek);
            $foto = $fotoSurvaiDO == null ? base_url() . "public/assets/penerimaan_unit_foto/wuling/no_image_available.jpg" :  base_url() . "public/assets/penerimaan_unit_foto/wuling/" . $fotoSurvaiDO;
            $survaiDo[] = [
                'id_prospek'   => $value->id_prospek,
                'tgl_do'       => tgl_sql($value->toSdo['tgl_do']),
                'customer'     => strtoupper($value->toCustomer['nama']),
                'kode_unit'    => $value->toSprospek->toUnit->toPVarian['varian'],
                'cara_bayar'   => $value->toCustomer['cara_bayar'] == 'k' ? 'Kredit' : 'Cash',
                'no_rangka'    => $value->no_rangka,
                'status'       => $value->toSprospek['status_survei']  == '1' ? 'Done' : 'Belum Survai',
                'payment_foto' => $foto,
                'wsa'          => $this->getCekDataWsaSuspect($value->id_prospek),
                'cutoff'       => $cutoff,
            ];
        }
        // debug($survaiDo);
        return $survaiDo;
    }

    private function getDataFotoSurvaiDo($id_prospek)
    {
        $data = ModelSurvaiDo::whereId_prospek($id_prospek)->pluck('payment_foto')->first();
        return $data;
    }


    private function getCekDataWsaSuspect($id_prospek)
    {
        $data = ModelWsaDataSuspect::whereId_prospek($id_prospek)->first();
        if (!empty($data->prospect_id) == '' || !empty($data->prospect_id) == null && !empty($data->dealer_id) == '' || !empty($data->dealer_id) == null && !empty($data->salesman_id) == '' || !empty($data->salesman_id) == null) {
            return false;
        } else {
            return true;
        }
    }
}
