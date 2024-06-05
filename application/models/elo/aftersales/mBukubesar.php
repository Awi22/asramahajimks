<?php

namespace app\models\elo\aftersales;

use Illuminate\Database\Eloquent\Model;

class mBukuBesar extends Model
{
    protected $table        = 'db_wuling.buku_besar';
    protected $primaryKey   = 'id';
    protected $keyType      = 'integer';
    protected $fillable     = ["kode_module", "no_transaksi", "tgl", "kode_akun", "id_perusahaan", "id_bank", "dk", "jumlah", "keterangan", "w_insert", "user", "jb", "journal", "no_clearing", "tgl_clearing", "user_clearing", "dept", "no_ref", "closing"];
    const CREATED_AT        = 'w_insert';
    const UPDATED_AT        = 'w_update';


    public function toInvoiceAfterSales()
    {
        return $this->hasOne(mInvoiceAfterSales::class, 'no_invoice', 'no_transaksi');
    }

    public function toPenerimaanBengkel()
    {
        return $this->hasOne(mPenerimaanBengkel::class, 'no_penerimaan', 'no_transaksi');
    }

    public function toPenerimaanBengkelNoRef()
    {
        return $this->hasMany(mPenerimaanBengkel::class, 'no_ref', 'no_transaksi');
    }

    public function toPengeluaranBengkelNoRef()
    {
        return $this->hasMany(mPengeluaranBengkel::class, 'no_ref', 'no_transaksi');
    }

    public function toNomorEFaktur()
    {
        return $this->hasOne(mNomorEFaktur::class, 'no_transaksi', 'no_transaksi');
    }

    public function toWorkOrderNoInv()
    {
        return $this->hasOne(mWorkOrder::class, 'no_wo', 'no_transaksi');
    }

    public function toWorkOrderNoRef()
    {
        return $this->hasOne(mWorkOrder::class, 'no_wo', 'no_ref');
    }

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, 'no_transaksi', 'no_transaksi');
    }

    public function toInvoiceAfterSalesArray()
    {
        return $this->hasMany(mInvoiceAfterSales::class, 'no_invoice', 'no_transaksi');
    }

    public function toUser()
    {
        return $this->hasOne(mUsers::class, 'id_user', 'user');
    }
}
