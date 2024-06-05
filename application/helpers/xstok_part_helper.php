<?php

/**
 * created by AL
 * IMPORTANT DON'T REMOVE AND UPDATE!
 * helper ini berfungsi untuk meminimalisir perulangan fungsi yang digunakan pada module honda_admin_sp
 * - lokasi part
 * - menambah part
 * - mengurangi part
 */


// untuk mengambil lokasi part
if (!function_exists('part_location')) {
    function part_location($kode_gudang, $id_perusahaan, $lokasi, $rak, $kolom, $baris, $nomor_binbox)
    {
        $ci = get_instance();

        $get_gudang = $ci->db_honda_sp->query("SELECT nama_gudang, label_gudang FROM gudang_new WHERE kode_gudang = '$kode_gudang' AND id_perusahaan = '$id_perusahaan'")->row('label_gudang');

        // gudang baru
        $get_lokasi    = $ci->db_honda_sp->query("SELECT lokasi FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$lokasi'")->row('lokasi');
        $get_rak       = $ci->db_honda_sp->query("SELECT rak FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$rak'")->row('rak');
        $get_kolom     = $ci->db_honda_sp->query("SELECT kolom FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$kolom'")->row('kolom');
        $get_baris     = $ci->db_honda_sp->query("SELECT baris FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$baris'")->row('baris');
        $get_no_binbox = $ci->db_honda_sp->query("SELECT no_binbox FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$nomor_binbox'")->row('no_binbox');

        $lokasi_part = "{$get_gudang} {$get_lokasi}{$get_rak}-{$get_baris}-{$get_kolom}-{$get_no_binbox}";

        return $lokasi_part;
    }
}

if (!function_exists('warehouse_location')) {
    function warehouse_location($id_perusahaan, $id_gudang_lokasi)
    {
        $ci = get_instance();

        $row = $ci->db_honda_sp->query("SELECT gudang_lokasi_new.id_gudang_lokasi, gudang_lokasi_new.id_perusahaan, gudang_new.kode_gudang, gudang_new.nama_gudang, gudang_new.label_gudang, jenis_part.nama AS jenis_part, jenis_rak.nama AS jenis_rak, gudang_lokasi_new.lokasi, gudang_lokasi_new.rak, gudang_lokasi_new.kolom, gudang_lokasi_new.baris, gudang_lokasi_new.nomor_binbox FROM gudang_lokasi_new LEFT JOIN gudang_detail_new ON gudang_lokasi_new.id_gudang_detail = gudang_detail_new.id_gudang_detail LEFT JOIN gudang_new ON gudang_detail_new.id_gudang = gudang_new.id_gudang LEFT JOIN jenis_part ON gudang_detail_new.id_jenis_part = jenis_part.id_jenis_part LEFT JOIN jenis_rak ON gudang_detail_new.id_jenis_rak = jenis_rak.id_jenis_rak WHERE gudang_lokasi_new.id_perusahaan = '$id_perusahaan' AND gudang_lokasi_new.id_gudang_lokasi = '$id_gudang_lokasi'")->row();
        if ($row !== null) {
            return part_location($row->kode_gudang, $id_perusahaan, $row->lokasi, $row->rak, $row->kolom, $row->baris, $row->nomor_binbox);
        } else {
            return '- - - -';
        }
    }
}

// untuk mengambil lokasi part dalam array terpisah
if (!function_exists('part_location_array')) {
    function part_location_array($kode_gudang, $id_perusahaan, $lokasi, $rak, $kolom, $baris, $nomor_binbox)
    {
        $ci = get_instance();

        $lokasi_part['gudang'] = $ci->db_honda_sp->query("SELECT nama_gudang FROM gudang_new WHERE kode_gudang = '$kode_gudang' AND id_perusahaan = '$id_perusahaan'")->row('nama_gudang');

        // gudang baru
        $lokasi_part['lokasi']    = $ci->db_honda_sp->query("SELECT lokasi FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$lokasi'")->row('lokasi');
        $lokasi_part['rak']       = $ci->db_honda_sp->query("SELECT rak FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$rak'")->row('rak');
        $lokasi_part['kolom']     = $ci->db_honda_sp->query("SELECT kolom FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$kolom'")->row('kolom');
        $lokasi_part['baris']     = $ci->db_honda_sp->query("SELECT baris FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$baris'")->row('baris');
        $lokasi_part['no_binbox'] = $ci->db_honda_sp->query("SELECT no_binbox FROM gudang_detail_lokasi_new WHERE id_gudang_detail_lokasi = '$nomor_binbox'")->row('no_binbox');

        return $lokasi_part;
    }
}

// untuk mengubah stok pada tabel stok item (+)
if (!function_exists('update_part_stok_added')) {
    function update_part_stok_added($id_perusahaan, $kode_item, $stok)
    {
        $ci = get_instance();

        // untuk mengecek data pada item stock
        $where = ['id_perusahaan' => $id_perusahaan, 'kode_item' => $kode_item];
        $query = $ci->db_honda_sp->select('*')->where($where)->get('stok_item');
        $count = $query->num_rows();
        $value = $query->row();

        if ($count > 0) {
            // untuk update stok item
            $item_stock = [
                'stok' => ($value->stok + $stok),
            ];
            // untuk proses update stok item
            $ci->db_honda_sp->where($where)->update('stok_item', $item_stock);
        }
    }
}

// untuk mengubah stok pada tabel stok item (-)
if (!function_exists('update_part_stok_reduced')) {
    function update_part_stok_reduced($id_perusahaan, $kode_item, $stok)
    {
        $ci = get_instance();

        // untuk mengecek data pada item stock
        $where = ['id_perusahaan' => $id_perusahaan, 'kode_item' => $kode_item];
        $query = $ci->db_honda_sp->select('*')->where($where)->get('stok_item');
        $count = $query->num_rows();
        $value = $query->row();

        if ($count > 0) {
            // untuk update stok item
            $item_stock = [
                'stok' => ($value->stok - $stok),
            ];
            // untuk proses update stok item
            $ci->db_honda_sp->where($where)->update('stok_item', $item_stock);
        }
    }
}

// untuk harga beli berdasarkan harga jual
if (!function_exists('purchase_price_by_class')) {
    function purchase_price_by_class($harga_jual, $class_item)
    {
        $ci = get_instance();

        $result = [];
        $get_kategori_pembelian = $ci->db_honda_sp->from('kategori_pembelian')->order_by('id_kategori_pembelian', 'ASC')->get();
        foreach ($get_kategori_pembelian->result() as $row_kategori_pembelian) {
            $get_class_item = $ci->db_honda_sp->from('p_class_item As ci')->join('kategori_pembelian kp', 'kp.id_kategori_pembelian = ci.id_kategori_pembelian', 'left')->where('ci.id_kategori_pembelian', $row_kategori_pembelian->id_kategori_pembelian)->where('ci.nama_class', $class_item)->get();
            foreach ($get_class_item->result() as $row_class_item) {
                $harga_beli_kategori = (int) $harga_jual * ((int) $row_class_item->discount / 100);
                $harga_beli_potong   = (int) $harga_jual - $harga_beli_kategori;

                $result[$row_kategori_pembelian->id_kategori_pembelian] = $harga_beli_potong;
            }
        }
        return $result;
    }
}

// untuk ambil supply slip number
if (!function_exists('supply_slip_number')) {
    function supply_slip_number($no_transaksi, $kode_item)
    {
        $ci = get_instance();

        $get    = $ci->db_honda_as->query("SELECT * FROM supply_slip ss WHERE ss.no_transaksi = '$no_transaksi' AND ss.kode_item = '$kode_item'");
        $row    = $get->row();
        $result = $row->no_supply_slip ?? 'Supply Slip Tidak Ditemukan';

        return $result;
    }
}

// untuk ambil hpp terakhir
if (!function_exists('get_hpp')) {
    function get_hpp($id_perusahaan, $kode_item, $stok)
    {
        $ci = get_instance();

        $get = $ci->db_honda_sp->query("SELECT * FROM mutasi_part AS mp WHERE mp.kode_item = '$kode_item' AND mp.id_perusahaan = '$id_perusahaan' ORDER BY mp.w_insert DESC LIMIT 1");
        $num = $get->num_rows();
        $row = $get->row();

        if ($num > 0) {
            $result = ($stok * $row->hpp);
        } else {
            $get_i = $ci->db_honda_sp->query("SELECT * FROM stok_item AS si WHERE si.kode_item = '$kode_item' AND si.id_perusahaan = '$id_perusahaan'");
            $num_i = $get_i->num_rows();
            $row_i = $get_i->row();

            if ($num_i > 0) {
                $result = ($stok * $row_i->hpp);
            } else {
                $result = 0;
            }
        }

        return $result;
    }
}
