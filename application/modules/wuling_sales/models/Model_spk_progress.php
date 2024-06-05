<?php

use app\models\elo\sales\ModelSspk;
use app\models\elo\sales\ModelSurvaiDo;
use app\models\elo\sales\ModelWsaDataSuspect;

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Model_spk_progress extends CI_Model
{

    public function getDataSpk($id_sales)
    {
        $spkProgress = [];
        $data = ModelSspk::with(['toCustomer', 'toSprospek.toUnit.toPVarian'])
            ->whereId_sales($id_sales)->whereBatal('n')
            ->get();

        foreach ($data as $key => $value) {
            $spkProgress[] = [
                'no_spk'    => $value->no_spk,
                'tgl_setor' => $value->tgl_setor,
                'spk_fix'   => $value->spk_fix,
                'diskon'    => $value->diskon,
                'no_rangka' => $value->no_rangka,
                'customer'  => $value->toCustomer['nama'],
                'unit'      => $value->toSprospek->toUnit->toPVarian['varian'] ?? '',
                'status'    => $value->toCustomer['status'],
            ];
        }

        return $spkProgress;
    }
}
