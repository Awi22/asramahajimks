<?php
function _cari_hpp($part_number)
{
    $CI = &get_instance();
    $data = $CI->db->query("SELECT db_wuling_sp.item.het_now, db_wuling_sp.p_class_item.discount, db_wuling_sp.kategori_pembelian.nama_kategori FROM db_wuling_sp.item LEFT JOIN db_wuling_sp.p_class_item ON db_wuling_sp.item.class_item = db_wuling_sp.p_class_item.nama_class LEFT JOIN db_wuling_sp.kategori_pembelian ON db_wuling_sp.p_class_item.id_kategori_pembelian = db_wuling_sp.kategori_pembelian.id_kategori_pembelian WHERE db_wuling_sp.item.part_number = '" . $part_number . "' AND db_wuling_sp.p_class_item.id_kategori_pembelian = '2'")->result()[0];
    $diskon_rp = $data->discount / 100 * $data->het_now;
    $hpp = $data->het_now - $diskon_rp;
    return $hpp;
}

$penjualan = [];
foreach ($data->result() as $row) {
    $hpp_                        = _cari_hpp($row->part_number);
    $total_hpp_                  = $hpp_ * $row->qty;
    $total_harga_sebelum_diskon_ = ($row->harga_jual * $row->qty);

    $penjualan[$row->no_transaksi][] = [
        'tgl'                        => $row->tgl_invoice,
        'customer'                   => $row->nama_pelanggan,
        'no_invoice'                 => (empty($row->no_invoice)) ? 'Belum cetak invoice' : $row->no_invoice,
        'no_transaksi'               => $row->no_transaksi,
        'no_part'                    => $row->part_number,
        'nama_part'                  => $row->nama_item,
        'qty'                        => $row->qty,
        'hpp'                        => $hpp_,
        'total_hpp'                  => $total_hpp_,
        'harga'                      => $row->harga_jual,
        'total_harga_sebelum_diskon' => $total_harga_sebelum_diskon_,
        'diskon'                     => $row->diskon,
        'ongkir'                     => floor($row->ongkir_rp),
        'sales_person'               => $row->nama_lengkap,
    ];
}
?>

<div class="card-body p-6">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>TANGGAL</th>
                <th>CUSTOMER</th>
                <th>NO. INVOICE</th>
                <th>NO. SALES ORDER</th>
                <th>NO. PART</th>
                <th>NAMA PART</th>
                <th>QTY</th>
                <th>HPP</th>
                <th>TOTAL HPP</th>
                <th>HARGA</th>
                <th>TOTAL</th>
                <th>SUB TOTAL</th>
                <th>DISKON</th>
                <th>TOTAL SETELAH DISKON</th>
                <th>ONGKIR</th>
                <th>PPN</th>
                <th>TOTAL</th>
                <th>SALES PERSON</th>
            </tr>
        </thead>
        <tbody>
            <?php $no_transaksi_ = ''; ?>
            <?php foreach ($penjualan as $no_order => $data) : ?>
                <?php foreach ($data as $key => $row) : ?>
                    <?php
                    if ($no_transaksi_ != $row['no_transaksi']) {
                        $diskon_rp            = $row['diskon'];
                        $ongkir_rp            = $row['ongkir'];
                        $sub_total            = array_sum(array_column($penjualan[$no_order], 'total_harga_sebelum_diskon'));
                        $total_setelah_diskon = ($sub_total - $diskon_rp);
                        $total_setelah_ongkir = ($total_setelah_diskon + $ongkir_rp);
                        $ppn_rp               = floor(get_tax('ppn', $row['tgl'], $total_setelah_ongkir));
                        $jumlah_rp            = $total_setelah_ongkir + $ppn_rp;
                    }
                    ?>
                    <tr>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : tgl_sql($row['tgl'])); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : $row['customer']); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : $row['no_invoice']); ?></td>
                        <td class="center"><?= $row['no_transaksi']; ?></td>
                        <td class="center"><?= $row['no_part']; ?></td>
                        <td class="center"><?= $row['nama_part']; ?></td>
                        <td class="center"><?= $row['qty']; ?></td>
                        <td class="center"><?= separator_harga($row['hpp']); ?></td>
                        <td class="center"><?= separator_harga($row['total_hpp']); ?></td>
                        <td class="center"><?= separator_harga($row['harga']); ?></td>
                        <td class="center"><?= separator_harga($row['total_harga_sebelum_diskon']); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : separator_harga($sub_total)); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : separator_harga($row['diskon'])); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : separator_harga($total_setelah_diskon)); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : separator_harga($ongkir_rp)); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : separator_harga($ppn_rp)); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : separator_harga($jumlah_rp)); ?></td>
                        <td class="center"><?= ($no_transaksi_ == $row['no_transaksi'] ? null : $row['sales_person']); ?></td>
                    </tr>
                    <?php $no_transaksi_ = $row['no_transaksi'] ?>
                    <?php if ($key == count($data) - 1) : ?>
                        <tr>
                            <td class="center" colspan="6"><strong>Jumlah QTY</strong></td>
                            <td class="center"><?= array_sum(array_column($penjualan[$no_order], 'qty')); ?></td>
                            <td class="center" colspan="11"></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>