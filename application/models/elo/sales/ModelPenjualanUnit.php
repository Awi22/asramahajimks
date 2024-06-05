<?php

// namespace app\modules\elo_models\wuling;
namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelPenjualanUnit extends Model
{
    protected $table = 'db_wuling.penjualan_unit';
    protected $primaryKey = 'no_transaksi';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
}
