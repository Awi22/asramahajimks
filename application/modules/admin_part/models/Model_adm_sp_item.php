<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use app\libraries\KMGDatatables;
use app\models\elo\aftersales\mClassItem;
use app\models\elo\aftersales\mItem;
use app\models\elo\aftersales\mKategori;

class Model_adm_sp_item extends CI_Model
{
    public function get()
    {
        $data         = array();
        $query_item   = mItem::with(['toTypeItemNon', 'toStokItem'])->limit(100)->get();

        foreach ($query_item as $row) {
            $harga_jual           = (int) $row->het_now;
            $harga_ppn            = floor(get_tax('ppn', date('Y-m-d'), $harga_jual));
            $harga_jual_ppn       = (int) $harga_jual + $harga_ppn;

            $harga_beli_reguler   = floor(purchase_price_by_class($row->het_now, $row->class_item)[2] ?? 0);
            $harga_beli_emergency = floor(purchase_price_by_class($row->het_now, $row->class_item)[1] ?? 0);

            $data[] = [
                'id_item'               => $row->id_item,
                'kode_item'             => $row->kode_item,
                'part_number'           => $row->part_number,
                'nama_item'             => $row->nama_item,
                'tipe_item'             => $row->toTypeItemNon->type_item_non,
                'harga_jual'            => separator_harga($harga_jual),
                'harga_jual_ppn'        => separator_harga($harga_jual_ppn),
                'harga_beli'            => separator_harga($harga_beli_reguler),
                'ongkos_kirim'          => separator_harga($row->ongkos_kirim),
                'class_item'            => $row->class_item,
                'harga_beli_reguler'    => separator_harga($harga_beli_reguler),
                'harga_beli_emergency'  => separator_harga($harga_beli_emergency),
                'satuan'                => $row->kode_satuan,
                'tipe'                  => $row->tipe,
                'merek'                 => $row->merek,
                'stock_ready'           => $row->toStokItem->stok,
                'stock_awal'            => $row->toStokItem->stok_awal,
                'stock_kritis'          => $row->toStokItem->stok_kritis,
                'hpp'                   => separator_harga($row->toStokItem->hpp),
                'ammount'               => separator_harga($row->toStokItem->ammount),
                'persediaan_awal'       => separator_harga($row->toStokItem->persediaan_awal),
            ];
        }

        return $data;
    }

    public function get_serverside($gets)
    {
        $data = $this->get();
        $datatables = new KMGDatatables($data);
        $datatables->asObject()->generate();
    }

    public function get_class()
    {
        $data   = array();
        $query  = mClassItem::groupBy('nama_class')->get();

        foreach ($query as $row) {
            $data[] = [
                'id'    => $row->id_class_item,
                'text'  => $row->nama_class
            ];
        }

        return $data;
    }

    public function get_tipe()
    {
        $data   = array();
        $query  = mItem::select('tipe')->groupBy('tipe')->get();

        foreach ($query as $row) {
            $data[] = [
                'id'    => $row->tipe,
                'text'  => $row->tipe
            ];
        }

        return $data;
    }

    public function get_kategori()
    {
        $data   = array();
        $query  = mKategori::all();

        foreach ($query as $row) {
            $data[] = [
                'id'    => $row->kode_kategori,
                'text'  => '(' . $row->kode_kategori . ') ' . $row->kategori
            ];
        }

        return $data;
    }
}
