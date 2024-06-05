<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelSsurvaiProses extends Model
{
    protected $table        = 'db_wuling.s_survei_proses';
    protected $primaryKey   = 'id_type';
    protected $keyType      = 'integer';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
