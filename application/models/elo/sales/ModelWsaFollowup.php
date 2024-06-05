<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelWsaFollowup extends Model
{
    protected $table = 'db_wuling.wsa_data_followup';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
