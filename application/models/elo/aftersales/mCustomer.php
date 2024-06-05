<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mCustomer extends Model
{
    protected $table        = 'db_wuling_as.customer';
    protected $primaryKey   = 'id_customer';
    protected $keyType      = 'string';
    const CREATED_AT        = 'w_insert';

    public function toDetailUnit()
    {
        return $this->belongsTo(mDetailUnitCustomer::class, 'id_customer', 'id_customer');
    }

    public function toDetailUnitKtp()
    {
        return $this->hasMany(mDetailUnitCustomer::class, 'id_customer', 'id_customer');
    }

    public function toCustomerPks()
    {
        return $this->belongsTo(mCustomerPks::class, 'id_customer', 'id_customer');
    }

    public function toBookingServ()
    {
        return $this->belongsTo(mBookingServ::class, 'id_customer', 'id_customer');
    }
}
