<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;
// use app\modules\elo_models\wuling_sp\mPClassItem;

class mKpiKategoriItem extends Model
{
    protected $table = 'db_holding.kpi_kategori_item';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toKpiKategori()
    {
        return $this->hasOne(mKpiKategori::class,'id','id_kategori');
    }

    // public function toKpiKategoriDetail()
    // {
    //     return $this->hasMany(mKpiKategoriDetail::class, 'kode_item', 'kode_item');
    // }
}
