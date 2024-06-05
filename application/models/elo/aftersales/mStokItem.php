<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mStokItem extends Model
{
    protected $table        = 'db_wuling_sp.stok_item';
    protected $primaryKey   = 'id_stok_item';
    protected $keyType      = 'integer';
}
