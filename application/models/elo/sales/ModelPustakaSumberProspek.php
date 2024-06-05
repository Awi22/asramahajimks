<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelPustakaSumberProspek extends Model
{
    protected $table = 'db_wuling.p_sumber_prospek';
    protected $primaryKey = 'id_sumber_prospek';
    protected $keyType = 'integer';
}
