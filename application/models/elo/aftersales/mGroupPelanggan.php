<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\wuling_sp\mPClassItem;

class mGroupPelanggan extends Model
{
    protected $table = 'db_wuling_sp.group_pelanggan';
    protected $primaryKey = 'id_group_pelanggan';
    protected $keyType = 'integer';
}
