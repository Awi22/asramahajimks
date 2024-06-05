<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mItem extends Model
{
    protected $table        = 'db_wuling_sp.item';
    protected $primaryKey   = 'id_item';
    protected $keyType      = 'integer';

    public function toTypeItemNon()
    {
        return $this->hasOne(mTypeItemNon::class, 'id_p_type_item_non', 'tipe_item');
    }

    public function toStokItem()
    {
        return $this->hasOne(mStokItem::class, 'kode_item', 'kode_item');
    }

    // public function toPClassItem()
    // {
    //     return $this->hasMany(mPClassItem::class, 'nama_class', 'class_item');
    // }

    //Double salah nama karena sudah terlanjur terpakai
    public function toItemMasuk()
    {
        return $this->hasOne(mItemMasukDetail::class, 'kode_item', 'kode_item');
    }

    public function toItemMasukDetail()
    {
        return $this->hasMany(mItemMasukDetail::class, 'kode_item', 'kode_item');
    }

    public function toItemMasukNon()
    {
        return $this->hasMany(mItemMasukNon::class, 'kode_item', 'kode_item');
    }

    public function toPembelian()
    {
        return $this->hasMany(mPembelian::class, 'kode_item', 'kode_item');
    }

    public function toBagDetail()
    {
        return $this->hasMany(mBagDetail::class, 'kode_item', 'kode_item');
    }
}
