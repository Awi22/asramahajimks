<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelEvent extends Model
{
    protected $table        = 'db_wuling.event';
    protected $primaryKey   = 'id_event';
    protected $keyType      = 'integer';

    public function toEventLokasi()
    {
        return $this->hasOne(ModelEventLokasi::class, 'id_event_lokasi', 'id_event_lokasi');
    }

    public function toEventJenis()
    {
        return $this->hasOne(ModelEventJenis::class, 'id_event_jenis', 'id_event_jenis');
    }
}
