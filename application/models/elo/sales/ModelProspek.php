<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelProspek extends Model
{
    protected $table = 'db_wuling.s_prospek';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toCustomer()
    {
        return $this->hasOne(ModelCustomer::class, 'id_prospek', 'id_prospek');
    }

    public function toUnit()
    {
        return $this->hasOne(ModelUnit::class, 'kode_unit', 'kode_unit');
    }
}
