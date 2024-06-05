<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelTestDrive extends Model
{
    protected $table        = 'db_wuling.s_test_drive';
    protected $primaryKey   = 'id_test_drive';
    protected $keyType      = 'integer';
    protected $fillable     = [
        'id_prospek',
        'id_model',
        'id_varian',
        'tgl_jam',
        'tempat',
        'id_perusahaan',
        'tahapan',
        'status',
    ];
    const CREATED_AT        = 'w_insert';
    const UPDATED_AT        = 'w_update';

    public function toCustomer()
    {
        return $this->hasOne(ModelCustomer::class, 'id_prospek', 'id_prospek');
    }

    public function toTestDriveDetail()
    {
        return $this->hasOne(ModelTestDriveDetail::class, 'id_test_drive', 'id_test_drive');
    }

    public function toWsaDataSuspect()
    {
        return $this->hasOne(ModelWsaDataSuspect::class, 'id_prospek', 'id_prospek');
    }

    public function toWsaDataTestDrive()
    {
        return $this->hasOne(ModelWsaDataTestDrive::class, 'id_prospek', 'id_prospek');
    }

    public function toProspek()
    {
        return $this->hasOne(ModelProspek::class, 'id_prospek', 'id_prospek');
    }

    public function toPVarian()
    {
        return $this->hasOne(ModelVarian::class, 'id_varian', 'id_varian');
    }
}
