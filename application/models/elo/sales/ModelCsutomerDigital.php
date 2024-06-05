<?php

namespace app\models\elo\sales;

use app\models\elo\kmg\ModelPerusahaan;
use Illuminate\Database\Eloquent\Model;

class ModelCsutomerDigital extends Model
{
    protected $table = 'db_wuling.digital_leads_customer';
    protected $primaryKey = 'id_dl_customer';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toPerusahaan()
    {
        return $this->hasOne(ModelPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
