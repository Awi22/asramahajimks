<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelNJadwalSales extends Model
{
    protected $table = 'db_wuling.n_jadwal_sales';
    protected $primaryKey = 'id_provinsi';
    protected $keyType = 'integer';

    public function toCustomer()
    {
        return $this->hasOne(ModelCustomer::class, 'id_prospek', 'id_prospek');
    }
}
