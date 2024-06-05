<?php

namespace app\models\elo\aftersales;

use app\models\elo\kmg\ModelKaryawan;
use Illuminate\Database\Eloquent\Model;

class mUsers extends Model
{
    protected $table        = 'db_wuling.users';
    protected $primaryKey   = 'id_user';
    protected $keyType      = 'integer';

    public function toKaryawan()
    {
        return $this->hasOne(ModelKaryawan::class, 'nik', 'nik');
    }
}
