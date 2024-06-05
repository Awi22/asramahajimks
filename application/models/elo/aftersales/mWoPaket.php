<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mWoPaket extends Model
{
    protected $table = 'db_wuling_as.wo_paket';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    // public function toPaketMaster()
    // {
    //     return $this->hasOne(mPaketPerawatanMaster::class, 'id', 'id_paket_perawatan');
    // }
    public function toPaketProgress()
    {
        return $this->hasMany(mWoPaketProgress::class, 'id_paket', 'id');
    }
    public function toWorkOrder()
    {
        return $this->belongsTo(mWorkOrder::class, 'no_wo', 'no_wo');
    }
    public function toLabor()
    {
        return $this->hasOne(mLabor::class, 'id', 'id_labor');
    }
}
