<?php

namespace app\models\elo\sales;

use Illuminate\Database\Eloquent\Model;

class ModelEventLokasi extends Model
{
    protected $table        = 'db_wuling.event_lokasi';
    protected $primaryKey   = 'id_event_lokasi';
    protected $keyType      = 'integer';

    public function toEventArea()
    {
        return $this->hasOne(ModelEventArea::class, 'id_event_area', 'id_event_area');
    }
}
