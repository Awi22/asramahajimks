<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelSdo extends Model
{
    protected $table = 'db_wuling.s_do';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
