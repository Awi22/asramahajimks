<?php

namespace app\models\elo\sales;

use app\models\elo\kmg\ModelPerusahaan;
use Illuminate\Database\Eloquent\Model;

class ModelPricelist extends Model
{
    protected $table = 'db_wuling.pricelist';
    protected $primaryKey = 'id_pricelist';
    protected $keyType = 'varchar';

    public function toVarian()
    {
        return $this->hasOne(ModelVarian::class, 'id_varian', 'id_varian');
    }

    public function toPerusahaan()
    {
        return $this->hasOne(ModelPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
