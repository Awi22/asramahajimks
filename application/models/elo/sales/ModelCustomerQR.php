<?php

// namespace app\modules\elo_models\wuling;
namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelCustomerQR extends Model
{
    protected $table = 'db_wuling.s_customer_qrcode';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

}
