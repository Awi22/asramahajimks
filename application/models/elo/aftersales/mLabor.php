<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mLabor extends Model
{
    protected $table        = 'db_wuling_as.labor';
    protected $primaryKey   = 'id';
    protected $keyType      = 'integer';

    public function toPTipe()
    {
        return $this->hasOne(mPTipe::class, 'id_type', 'id_type');
    }
}
