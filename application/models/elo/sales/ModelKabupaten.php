<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelKabupaten extends Model
{
    protected $table = 'db_wuling.kabupaten';
    protected $primaryKey = 'id_kabupaten';
    protected $keyType = 'integer';
}
