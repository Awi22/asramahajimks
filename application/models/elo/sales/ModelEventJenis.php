<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelEventJenis extends Model
{
    protected $table        = 'db_wuling.event_jenis';
    protected $primaryKey   = 'id_event_jenis';
    protected $keyType      = 'integer';
}
