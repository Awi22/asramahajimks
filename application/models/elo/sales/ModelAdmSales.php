<?php

// namespace app\modules\elo_models\wuling;
namespace app\models\elo\sales;

use app\models\elo\kmg\ModelJabatan;
use app\models\elo\kmg\ModelKaryawan;
use app\models\elo\kmg\ModelPerusahaan;
use Illuminate\Database\Eloquent\Model;

class ModelAdmSales extends Model
{
    protected $table = 'db_wuling.adm_sales';
    protected $primaryKey = 'id_sales';
    protected $keyType = 'integer';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toKaryawan()
    {
        return $this->hasOne(ModelKaryawan::class, 'id_karyawan', 'id_sales');
    }

	public function toJabatan()
    {
        return $this->hasOne(ModelJabatan::class, 'id_jabatan', 'id_jabatan');
    }

	public function toPerusahaan()
    {
        return $this->hasOne(ModelPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

}
