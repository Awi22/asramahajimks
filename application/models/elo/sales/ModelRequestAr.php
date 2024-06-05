<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelRequestAr extends Model
{
    protected $table = 'db_wuling.request_ar';
    protected $primaryKey = 'id_request_ar';
    protected $keyType = 'integer';
    protected $fillable     = [
        'id_request_ar',
        'id_sales',
        'id_spv',
        'id_prospek',
        'request_ar',
        'start_ar',
        'jenis_bayar',
        'id_bank',
        'no_transaksi',

    ];
    const CREATED_AT        = 'w_insert';
    const UPDATED_AT        = 'w_update';

    public function toRequsetArProgress()
    {
        return $this->hasOne(ModelRequestArProgress::class, 'id_request_ar', 'id_request_ar');
    }

    public function toSspk()
    {
        return $this->hasOne(ModelRequestArProgress::class, 'id_prospek', 'id_prospek');
    }

    public function toHotProspek()
    {
        return $this->hasOne(ModelHotProspek::class, 'id_prospek', 'id_prospek');
    }

    public function toCustomer()
    {
        return $this->hasOne(ModelCustomer::class, 'id_prospek', 'id_prospek');
    }
}
