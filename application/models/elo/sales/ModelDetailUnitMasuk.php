<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelDetailUnitMasuk extends Model
{
    protected $table = 'db_wuling.detail_unit_masuk';
    protected $primaryKey = 'no_rangka';
    protected $keyType = 'varchar';
}
