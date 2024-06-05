<?php

namespace app\models\elo\sales;

use app\models\elo\sales\ModelTypeUnit;
use app\models\elo\sales\ModelVarian;
use app\models\elo\sales\ModelWarna;
use app\modules\elo_models\wuling_as\mDetailUnitCustomer;
use Illuminate\Database\Eloquent\Model;

class ModelUnit extends Model
{
    protected $table        = 'db_wuling.unit';
    protected $primaryKey   = 'id_unit';
    protected $keyType      = 'integer';



    public function toPVarian()
    {
        return $this->hasOne(ModelVarian::class, 'id_varian', 'id_varian');
    }

    public function toPWarna()
    {
        return $this->hasOne(ModelWarna::class, 'id_warna', 'id_warna');
    }

    public function toPType()
    {
        return $this->hasOne(ModelTypeUnit::class, 'id_type', 'id_type');
    }
}
