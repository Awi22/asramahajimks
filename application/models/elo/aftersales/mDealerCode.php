<?php

namespace app\models\elo\aftersales;

use app\models\elo\kmg\ModelPerusahaan;
use Illuminate\Database\Eloquent\Model;

class mDealerCode extends Model
{
    protected $table      = 'db_wuling_as.api_dealer_code';
    protected $primaryKey = 'dealer_code';
    protected $keyType    = 'string';
    public    $timestamps = false;

    public function toPerusahaan()
    {
        return $this->belongsTo(ModelPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
