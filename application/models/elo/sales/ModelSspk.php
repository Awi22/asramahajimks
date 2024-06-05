<?php


namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelSspk extends Model
{
    protected $table        = 'db_wuling.s_spk';
    protected $primaryKey   = 'id_s_spk';
    protected $keyType      = 'integer';
    const CREATED_AT        = 'w_insert';
    const UPDATED_AT        = 'w_update';
    protected $fillable = [
        'id_prospek',
        'id_sales'
    ];
    protected $guarded = [];

    public function toCustomer()
    {
        return $this->hasOne(ModelCustomer::class, 'id_prospek', 'id_prospek');
    }

    public function toAdmSales()
    {
        return $this->hasOne(ModelAdmSales::class, 'id_sales', 'id_sales');
    }

    public function toSdo()
    {
        return $this->hasOne(ModelSdo::class, 'id_prospek', 'id_prospek');
    }

    public function toSprospek()
    {
        return $this->hasOne(ModelProspek::class, 'id_prospek', 'id_prospek');
    }

    public function toSettingTandaJadi()
    {
        return $this->hasOne(ModelSettingTandaJadi::class, 'id_perusahaan', 'id_perusahaan');
    }
}
