<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelLeasing extends Model
{
    protected $table = 'db_wuling.leasing';
    protected $primaryKey = 'id_leasing';
    protected $keyType = 'integer';
}
