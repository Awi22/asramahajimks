<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelPustakaMedia extends Model
{
    protected $table = 'db_wuling.p_media';
    protected $primaryKey = 'id_media';
    protected $keyType = 'integer';
}
