<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelJadwalSales extends Model
{
    protected $table = 'db_wuling.n_jadwal_sales';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';
    protected $fillable = [
        'id_prospek',
        'tgl_selanjutnya',
        'last_update',
        'sales'
    ];


    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    // public function toSuspect()
    // {
    //     return $this->hasOne(mSsuspect::class, 'id_prospek', 'id_prospek');
    // }

    // public function toNoSpk()
    // {
    //     return $this->hasOne(mNoSpk::class, 'id_prospek', 'id_prospek');
    // }
    // public function toSpk()
    // {
    //     return $this->hasOne(mSspk::class, 'id_prospek', 'id_prospek');
    // }

    // public function toDataPerusahaan()
    // {
    //     return $this->hasOne(mDataPerusahaan::class, 'id_prospek', 'id_prospek');
    // }

    // public function toDataPesanUnit()
    // {
    //     return $this->hasMany(mPesananUnit::class, 'id_prospek', 'id_prospek');
    // }

    // public function toTestDrive()
    // {
    //     return $this->hasMany(mTesDrive::class, 'id_prospek', 'id_prospek');
    // }
}
