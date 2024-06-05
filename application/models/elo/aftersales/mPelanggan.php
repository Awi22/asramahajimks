<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mPelanggan extends Model
{
    protected $table = 'db_wuling_sp.pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $keyType = 'integer';

    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toGroupPelanggan()
    {
        return $this->hasOne(mGroupPelanggan::class, "kode_group_pelanggan", "kode_group_pelanggan");
    }
}
