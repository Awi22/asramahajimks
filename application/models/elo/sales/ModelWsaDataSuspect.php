<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelWsaDataSuspect extends Model
{
    protected $table = 'db_wuling.wsa_data_suspect';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
