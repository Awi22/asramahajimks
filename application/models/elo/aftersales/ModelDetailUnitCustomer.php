<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelDetailUnitCustomer extends Model
{
    protected $table        = 'db_wuling_as.detail_unit_customer';
    protected $primaryKey   = 'no_rangka';
    protected $keyType      = 'string';
    const CREATED_AT        = 'w_insert';

    public function toUnit()
    {
        return $this->hasOne(mUnit::class, "kode_unit", "kode_unit");
    }

    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, "id_customer", "id_customer");
    }

    public function toWorkOrder()
    {
        return $this->belongsTo(mWorkOrder::class, 'no_wo', 'no_wo');
    }

    // public function toHistory()
    // {
    //     return $this->hasMany(mHistoryNoRangka::class, "no_rangka", "no_rangka");
    // }

    public function toVariant()
    {
        return $this->hasOne(mVariant::class, "code", "kode_unit");
    }
}
