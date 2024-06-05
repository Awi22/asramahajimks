<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mHistoryProgressJasa  extends Model
{
    protected $table      = 'db_wuling_as.history_progress_jasa';
    protected $primaryKey = 'id_history_jasa';
    protected $keyType    = 'integer';
    const CREATED_AT      = 'w_insert';
    const UPDATED_AT      = 'w_update';

    protected $fillable = ['id_detail_jasa_wo', 'id_detail_jasa_wo_bp', 'foreman', 'id_mekanik', 'ts_foreman', 'ks_foreman', 'status'];

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, "id_karyawan", "id_mekanik");
    }

    public function toDetailJasa()
    {
        return $this->belongsTo(mWoDetailJasa::class, 'id_detail_jasa_wo', 'id_detail_jasa_wo');
    }

    // public function toDetailJasaBp()
    // {
    //     return $this->belongsTo(mWoDetailJasaBp::class, 'id_detail_jasa_wo_bp', 'id_detail_jasa_wo_bp');
    // }
}
