<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelStockUnit extends Model
{
    protected $table = 'db_wuling.stok_unit';
    protected $primaryKey = 'no_rangka';
    protected $keyType = 'varchar';


    public function toDetailUnitMasuk()
    {
        return $this->hasOne(ModelDetailUnitMasuk::class, 'no_rangka', 'no_rangka');
    }
}
