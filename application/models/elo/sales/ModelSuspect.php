<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelSuspect extends Model
{
    protected $table = 'db_wuling.s_suspect';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toCustomer()
    {
        return $this->hasOne(ModelCustomer::class, 'id_prospek', 'id_prospek');
    }

    public function toProspek()
    {
        return $this->hasOne(ModelProspek::class, 'id_prospek', 'id_prospek');
    }

    public function toWsaSuspect()
    {
        return $this->hasOne(ModelWsaDataSuspect::class, 'id_prospek', 'id_prospek');
    }

    public function toSurvaiProses()
    {
        return $this->hasOne(ModelSsurvaiProses::class, 'id_prospek', 'id_prospek');
    }
}
