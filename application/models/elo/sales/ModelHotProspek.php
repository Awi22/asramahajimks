<?php

namespace app\models\elo\sales;

use app\models\elo\kmg\ModelPerusahaan;
use Illuminate\Database\Eloquent\Model;

class ModelHotProspek extends Model
{
    protected $table = 'db_wuling.s_hot_prospek';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
    protected $fillable = [
        'id_prospek',
        'id_sales'
    ];

    public function toCustomer()
    {
        return $this->hasOne(ModelCustomer::class, 'id_prospek', 'id_prospek');
    }
}
