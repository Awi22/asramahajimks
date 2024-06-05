<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mApiRepairOrders extends Model
{
    protected $table        = 'db_wuling_as.api_repair_orders';
    protected $primaryKey   = 'ro_id';
    protected $keyType      = 'integer';
}
