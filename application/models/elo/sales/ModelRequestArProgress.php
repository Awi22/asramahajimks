<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelRequestArProgress extends Model
{
    protected $table = 'db_wuling.request_ar_progress';
    protected $primaryKey = 'id_request_ar_progress';
    protected $keyType = 'integer';
    protected $fillable     = [
        'id_request_ar',
        'sales',
        'spv',
        'sm',
        'admin_keuangan',
    ];
    const CREATED_AT        = 'w_insert';
    const UPDATED_AT        = 'w_update';
}
