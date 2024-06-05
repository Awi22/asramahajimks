<?php
$pembelian = [];
foreach ($data->result() as $row) {
    $qty[$row->no_invoice][] = $row->total_item_item_masuk;

    $sub_total         = $row->harga_tebus_dpp * $row->total_item_item_masuk;
    $diskon_rp         = ($row->diskon / 100 * $sub_total);
    $total_sebelum_ppn = $diskon_rp;
    $ppn               = floor(get_tax('ppn', $row->tanggal_invoice, $total_sebelum_ppn));
    $total             = $total_sebelum_ppn + $ppn;
    $jumlah[$row->no_invoice][] = $total_sebelum_ppn;

    $pembelian[$row->no_invoice][] = [
        'tanggal_inbound' => $row->tanggal_item_masuk,
        'tanggal_invoice' => $row->tanggal_invoice,
        'no_invoice'      => $row->no_invoice,
        'kategori'        => strtoupper($row->nama_kategori),
        'vendor'          => $row->nama_supplier,
        'kode_item'       => $row->kode_item,
        'part_number'     => $row->part_number,
        'nama_item'       => $row->nama_item,
        'qty'             => $row->total_item_item_masuk,
        'harga'           => separator_harga($row->harga_tebus_dpp),
        'diskon'          => $row->diskon,
        'diskon_rp'       => separator_harga($diskon_rp),
        'jumlah'          => separator_harga($total_sebelum_ppn),
        'ppn'             => separator_harga($ppn),
        'total'           => separator_harga($total),
    ];
}
?>

<div class="card-body p-6">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>TANGGAL INBOUND</th>
                <th>TANGGAL INVOICE</th>
                <th>INVOICE PEMBELIAN</th>
                <th>KATEGORI PEMBELIAN</th>
                <th>VENDOR</th>
                <th>PART NUMBER</th>
                <th>KODE ITEM</th>
                <th>NAMA ITEM</th>
                <th>QTY</th>
                <th>HARGA</th>
                <th>DISKON (%)</th>
                <th>DISKON (RP)</th>
                <th>JUMLAH</th>
                <th>PPN</th>
                <th>TOTAL</th>
                <th>TOTAL INVOICE</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($pembelian) > 0) { ?>
                <?php $no_invoice_ = ''; ?>
                <?php foreach ($pembelian as $key => $value) : ?>
                    <?php for ($x = 0; $x < count($value); $x++) : ?>
                        <?php
                        $sebelum_ppn = array_sum($jumlah[$value[$x]['no_invoice']]);
                        $ppn         = round(get_tax('ppn', $value[$x]['tanggal_invoice'], $sebelum_ppn));
                        $total       = $sebelum_ppn + $ppn;
                        ?>
                        <tr>
                            <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : $value[$x]['tanggal_inbound']) ?></td>
                            <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : $value[$x]['tanggal_invoice']) ?></td>
                            <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : $value[$x]['no_invoice']) ?></td>
                            <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : $value[$x]['kategori']) ?></td>
                            <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : $value[$x]['vendor']) ?></td>
                            <td class="center"><?= $value[$x]['part_number'] ?></td>
                            <td class="center"><?= $value[$x]['kode_item'] ?></td>
                            <td class="center"><?= $value[$x]['nama_item'] ?></td>
                            <td class="center"><?= $value[$x]['qty'] ?></td>
                            <td class="center">Rp. <?= $value[$x]['harga'] ?></td>
                            <td class="center"><?= $value[$x]['diskon'] ?></td>
                            <td class="center">Rp. <?= $value[$x]['diskon_rp'] ?></td>
                            <td class="center">Rp. <?= $value[$x]['jumlah'] ?></td>
                            <td class="center">Rp. <?= $value[$x]['ppn'] ?></td>
                            <td class="center">Rp. <?= $value[$x]['total'] ?></td>
                            <td class="center"><?= ($no_invoice_ == $value[$x]['no_invoice'] ? null : 'Rp. ' . separator_harga($sebelum_ppn)) ?></td>
                        </tr>
                        <?php $no_invoice_ = $value[$x]['no_invoice'] ?>
                        <?php
                        if ($x + 1 == count($value)) {
                        ?>
                            <tr>
                                <td class="center" colspan="8"><strong>Jumlah QTY</strong></td>
                                <td class="center"><?= array_sum($qty[$value[$x]['no_invoice']]) ?></td>
                                <td class="center" colspan="7"></td>
                            </tr>
                        <?php } ?>
                    <?php endfor; ?>
                <?php endforeach; ?>
            <?php } else { ?>
                <tr>
                    <td class="center" colspan="16">Tidak Ada Data!</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>