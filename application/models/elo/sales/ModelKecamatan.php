<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelKecamatan extends Model
{
    protected $table = 'db_wuling.kecamatan';
    protected $primaryKey = 'id_kecamatan';
    protected $keyType = 'integer';
}
