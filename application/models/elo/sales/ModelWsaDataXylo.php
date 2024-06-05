<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelWsaDataXylo extends Model
{
    protected $table = 'db_wuling.wsa_prospect_xylo';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
