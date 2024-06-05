<?php

// namespace app\modules\elo_models\wuling;
namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelCustomer extends Model
{
    protected $table = 'db_wuling.s_customer';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toSuspect()
    {
        return $this->hasOne(ModelSuspect::class, 'id_prospek', 'id_prospek');
    }

    public function toProspek()
    {
        return $this->hasOne(ModelProspek::class, 'id_prospek', 'id_prospek');
    }

    public function toHotProspek()
    {
        return $this->hasOne(ModelHotProspek::class, 'id_prospek', 'id_prospek');
    }

    public function toSspk()
    {
        return $this->hasOne(ModelSspk::class, 'id_prospek', 'id_prospek');
    }

    public function toHistoryFollowupSales()
    {
        return $this->hasMany(ModelHistoryFollowupSales::class, 'id_prospek', 'id_prospek');
    }

    public function toTestDrive()
    {
        return $this->hasOne(ModelTestDrive::class, 'id_prospek', 'id_prospek');
    }

    public function toJadwalSales()
    {
        return $this->hasOne(ModelJadwalSales::class, 'id_prospek', 'id_prospek');
    }
}
