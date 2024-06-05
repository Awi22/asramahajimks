<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelSettingTandaJadi extends Model
{
    protected $table = 'db_wuling.setting_tanda_jadi';
    protected $primaryKey = 'id_perusahaan';
    protected $keyType = 'integer';
}
