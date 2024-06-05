<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelNoSpk extends Model
{
    protected $table      = 'db_wuling.no_spk';
    protected $primaryKey = 'no_spk';
    protected $keyType    = 'string';
    const CREATED_AT  = 'w_insert';
    const UPDATED_AT  = 'w_update';
}
