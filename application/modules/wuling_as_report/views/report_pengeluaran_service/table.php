<?php
function _cari_hpp($part_number)
{
    $CI = &get_instance();
    $data = $CI->db->query("SELECT db_wuling_sp.item.het_now, db_wuling_sp.p_class_item.discount, db_wuling_sp.kategori_pembelian.nama_kategori FROM db_wuling_sp.item LEFT JOIN db_wuling_sp.p_class_item ON db_wuling_sp.item.class_item = db_wuling_sp.p_class_item.nama_class LEFT JOIN db_wuling_sp.kategori_pembelian ON db_wuling_sp.p_class_item.id_kategori_pembelian = db_wuling_sp.kategori_pembelian.id_kategori_pembelian WHERE db_wuling_sp.item.part_number = '" . $part_number . "' AND db_wuling_sp.p_class_item.id_kategori_pembelian = '2'")->result();
    if (empty($data[0])) {
        return 0;
    } else {
        $diskon_rp = $data[0]->discount / 100 * $data[0]->het_now;
        $hpp = $data[0]->het_now - $diskon_rp;
        return $hpp;
    }
}

$penjualan = [];
foreach ($data->result() as $row) {
    $qty[$row->no_invoice][] = $row->qty;

    if ($filter == 'show') {
        $sub_total         = $row->harga_jual * $row->qty;
        $total_sebelum_ppn = $sub_total - $row->diskon_rp;
        $ppn               = floor(get_tax('ppn', date('Y-m-d', strtotime($row->invoice_date)), $total_sebelum_ppn));
        $total             = $total_sebelum_ppn + $ppn;
        $bayar[$row->no_invoice][$row->no_wo][] = $total;

        $penjualan[$row->no_invoice][] = [
            'no_invoice'      => $row->no_invoice,
            'tanggal_invoice' => date('d-m-Y', strtotime($row->invoice_date)),
            'no_wo'           => $row->no_wo,
            'tanggal_wo'      => date('d-m-Y', strtotime($row->tgl_service)),
            'nama_customer'   => $row->nama,
            'no_polisi'       => $row->no_polisi,
            'supply_slip'     => global_supply_slip_number('db_wuling_as', $row->no_wo, $row->kode_item),
            'kode_item'       => $row->kode_item,
            'part_number'     => $row->part_number,
            'nama_item'       => $row->nama_item,
            'qty'             => $row->qty,
            'hpp'             => separator_harga($hpp_satuan = _cari_hpp($row->part_number)),
            'total_hpp'       => separator_harga($hpp_satuan * $row->qty),
            'harga_jual'      => separator_harga($row->harga_jual),
            'diskon_rp'       => separator_harga($row->diskon_rp),
            'jumlah'          => separator_harga($total_sebelum_ppn),
            'ppn'             => separator_harga($ppn),
            'total'           => separator_harga($total),
            'sales_person'    => $row->nama_karyawan,
        ];
    } else {
        if ($row->claim == 'n') {
            $sub_total         = $row->harga_jual * $row->qty;
            $total_sebelum_ppn = $sub_total - $row->diskon_rp;
            $ppn               = floor(get_tax('ppn', date('Y-m-d', strtotime($row->invoice_date)), $total_sebelum_ppn));
            $total             = $total_sebelum_ppn + $ppn;
            $bayar[$row->no_invoice][$row->no_wo][] = $total;

            $penjualan[$row->no_invoice][] = [
                'no_invoice'      => $row->no_invoice,
                'tanggal_invoice' => date('d-m-Y', strtotime($row->invoice_date)),
                'no_wo'           => $row->no_wo,
                'tanggal_wo'      => date('d-m-Y', strtotime($row->tgl_service)),
                'nama_customer'   => $row->nama,
                'no_polisi'       => $row->no_polisi,
                'supply_slip'     => global_supply_slip_number('db_wuling_as', $row->no_wo, $row->kode_item),
                'kode_item'       => $row->kode_item,
                'part_number'     => $row->part_number,
                'nama_item'       => $row->nama_item,
                'qty'             => $row->qty,
                'hpp'             => separator_harga($hpp_satuan = _cari_hpp($row->part_number)),
                'total_hpp'       => separator_harga($hpp_satuan * $row->qty),
                'harga_jual'      => separator_harga($row->harga_jual),
                'diskon_rp'       => separator_harga($row->diskon_rp),
                'jumlah'          => separator_harga($total_sebelum_ppn),
                'ppn'             => separator_harga($ppn),
                'total'           => separator_harga($total),
                'sales_person'    => $row->nama_karyawan,
            ];
        } else {
            $bayar[$row->no_invoice][$row->no_wo][] = 0;

            $penjualan[$row->no_invoice][] = [
                'no_invoice'      => $row->no_invoice,
                'tanggal_invoice' => date('d-m-Y', strtotime($row->invoice_date)),
                'no_wo'           => $row->no_wo,
                'tanggal_wo'      => date('d-m-Y', strtotime($row->tgl_service)),
                'nama_customer'   => $row->nama,
                'no_polisi'       => $row->no_polisi,
                'supply_slip'     => global_supply_slip_number('db_wuling_as', $row->no_wo, $row->kode_item),
                'kode_item'       => $row->kode_item,
                'part_number'     => $row->part_number,
                'nama_item'       => $row->nama_item,
                'qty'             => $row->qty,
                'hpp'             => 0,
                'total_hpp'       => 0,
                'harga_jual'      => 0,
                'diskon_rp'       => 0,
                'jumlah'          => 0,
                'ppn'             => 0,
                'total'           => 0,
                'sales_person'    => $row->nama_karyawan,
            ];
        }
    }
}
?>

<div class="card-body p-6">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>NO. INVOICE</th>
                <th>TANGGAL INVOICE</th>
                <th>NO. WO</th>
                <th>TANGGAL WO</th>
                <th>NAMA CUSTOMER</th>
                <th>NO. POLISI</th>
                <th>NO. SUPPLY SLIP</th>
                <th>KODE ITEM</th>
                <th>NO. PART</th>
                <th>NAMA PART</th>
                <th>QTY</th>
                <th>HPP</th>
                <th>TOTAL HPP</th>
                <th>HARGA JUAL</th>
                <th>DISKON</th>
                <th>JUMLAH</th>
                <th>PPN</th>
                <th>TOTAL</th>
                <th>SALES PERSON</th>
                <th>TOTAL BAYAR</th>
            </tr>
        </thead>
        <tbody>
            <?php $no_invoice_ = ''; ?>
            <?php $no_wo_ = ''; ?>
            <?php foreach ($penjualan as $key => $value) : ?>
                <?php for ($x = 0; $x < count($value); $x++) : ?>
                    <tr>
                        <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : $value[$x]['no_invoice']) ?></td>
                        <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : $value[$x]['tanggal_invoice']) ?></td>
                        <td class="center"><?= ($no_wo_ == $value[$x]['no_wo'] ? null : $value[$x]['no_wo']) ?></td>
                        <td class="center"><?= ($no_wo_ == $value[$x]['no_wo'] ? null : $value[$x]['tanggal_wo']) ?></td>
                        <td class="center"><?= ($no_wo_ == $value[$x]['no_wo'] ? null : $value[$x]['nama_customer']) ?></td>
                        <td class="center"><?= ($no_wo_ == $value[$x]['no_wo'] ? null : $value[$x]['no_polisi']) ?></td>
                        <td class="center"><?= $value[$x]['supply_slip'] ?></td>
                        <td class="center"><?= $value[$x]['kode_item'] ?></td>
                        <td class="center"><?= $value[$x]['part_number'] ?></td>
                        <td class="center"><?= $value[$x]['nama_item'] ?></td>
                        <td class="center"><?= $value[$x]['qty'] ?></td>
                        <td class="center">Rp. <?= $value[$x]['hpp'] ?></td>
                        <td class="center">Rp. <?= $value[$x]['total_hpp'] ?></td>
                        <td class="center">Rp. <?= $value[$x]['harga_jual'] ?></td>
                        <td class="center">Rp. <?= $value[$x]['diskon_rp'] ?></td>
                        <td class="center">Rp. <?= $value[$x]['jumlah'] ?></td>
                        <td class="center">Rp. <?= $value[$x]['ppn'] ?></td>
                        <td class="center">Rp. <?= $value[$x]['total'] ?></td>
                        <td class="center"><?= ($no_wo_ == $value[$x]['no_wo'] ? null : $value[$x]['sales_person']) ?></td>
                        <td class="center"><?= ($no_wo_ == $value[$x]['no_wo'] ? null : 'Rp. ' . separator_harga(array_sum($bayar[$value[$x]['no_invoice']][$value[$x]['no_wo']]))) ?></td>
                    </tr>
                    <?php $no_wo_ = $value[$x]['no_wo'] ?>
                    <?php $no_invoice_ = $value[$x]['no_invoice'] ?>
                    <?php
                    if ($x + 1 == count($value)) {
                    ?>
                        <tr>
                            <td class="center" colspan="10"><strong>Jumlah QTY</strong></td>
                            <td class="center"><?= array_sum($qty[$value[$x]['no_invoice']]) ?></td>
                            <td class="center" colspan="9"></td>
                        </tr>
                    <?php } ?>
                <?php endfor; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>