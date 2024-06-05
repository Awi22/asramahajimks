<?php

use app\models\elo\aftersales\mKpiKategoriItem;

 if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_kpi_sa extends CI_Model
{

    public function getListData(){
        
        $data = [];
        $kategori = 6;
        $query = mKpiKategoriItem::with(['toKpiKategori']);
        if (!empty($kategori)) {
            $query->whereId_sub_kategori($kategori);
        }

        $query->orderBy('id','DESC');
        

        foreach ($query->get() as $value) {
            $data[] = [
                'id'        => $value->id,
                'kategori'  => $value->toKpikategori->name,
                'name'      => $value->name,
                'bobot'     => $value->bobot4,
                'target'    => 200,
                'actual'    => 150,
                'score'     => 21,
                'method'    => $value->method
            ];
        }

        return $data;
    }
}
