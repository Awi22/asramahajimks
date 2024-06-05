<?php

namespace app\models\elo\aftersales;

use app\models\elo\kmg\ModelKaryawan;
use Illuminate\Database\Eloquent\Model;

class mWoPaketProgress extends Model
{
    protected $table        = 'db_wuling_as.wo_paket_progress';
    protected $primaryKey   = 'id';
    protected $keyType      = 'integer';

    public function toKaryawan()
    {
        return $this->hasOne(ModelKaryawan::class, 'id_karyawan', 'mekanik');
    }

    public function toPaket()
    {
        return $this->hasOne(mWoPaket::class, 'id_paket', 'id');
    }
}
