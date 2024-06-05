<?php

namespace app\models\elo\kmg;

use Illuminate\Database\Eloquent\Model;

class ModelPerusahaan extends Model
{
    protected $table = 'kmg.perusahaan';
    protected $primaryKey = 'id_perusahaan';
    protected $keyType = 'integer';
}
