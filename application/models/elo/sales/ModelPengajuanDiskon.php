<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelPengajuanDiskon extends Model
{
    protected $table        = 'db_wuling.pengajuan_diskon';
    protected $primaryKey   = 'no_spk';
    protected $keyType      = 'varchar';
    const CREATED_AT        = 'w_insert';
    const UPDATED_AT        = 'w_update';
    protected $fillable     = [
        'no_spk',
        'diskon',
        'id_sales'
    ];

    public function toSspk()
    {
        return $this->hasOne(ModelSspk::class, 'no_spk', 'no_spk');
    }
}
