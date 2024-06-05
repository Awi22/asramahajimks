<?php

namespace app\models\elo\kmg;

use Illuminate\Database\Eloquent\Model;

class ModelPSp extends Model
{
    protected $table = 'p_sp';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = array('nama_sp', 'deskripsi');
}
