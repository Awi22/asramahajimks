<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelKelurahan extends Model
{
    protected $table = 'db_wuling.kelurahan';
    protected $primaryKey = 'id_kelurahan';
    protected $keyType = 'integer';
}
