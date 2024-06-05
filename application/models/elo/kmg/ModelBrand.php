<?php

namespace app\models\elo\kmg;

use Illuminate\Database\Eloquent\Model;

class ModelBrand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'id_brand';
    protected $keyType = 'integer';

    public function toPerusahaan()
    {
        return $this->hasMany(mPerusahaan::class, 'id_brand', 'id_brand');
    }
}
