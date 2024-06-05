<div class="card-body p-6">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Tanggal Pesanan</th>
                <th>No. PO</th>
                <th>No. Order ID</th>
                <th>Supplier</th>
                <th>Kategori</th>
                <th>Kode Item</th>
                <th>Part Number</th>
                <th>Nama Item</th>
                <th>Order</th>
                <th>Masuk</th>
                <th>Sisah</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Total Diskon</th>
                <th>Total HPP</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) > 0) { ?>
                <?php foreach ($data as $key => $row) {
                    $order[$key] = 0;
                    $masuk[$key] = 0;
                    $sisah[$key] = 0;
                    $total[$key] = 0;
                ?>
                    <tr>
                        <td class="center" style="vertical-align: top" rowspan="<?= $row['detail']->num_rows() + 1 ?>"><?= $row['tgl'] ?></td>
                        <td class="center" style="vertical-align: top" rowspan="<?= $row['detail']->num_rows() + 1 ?>"><?= $row['no_po'] ?></td>
                        <td class="center" style="vertical-align: top" rowspan="<?= $row['detail']->num_rows() + 1 ?>"><?= $row['no_order_id'] ?></td>
                        <td class="center" style="vertical-align: top" rowspan="<?= $row['detail']->num_rows() + 1 ?>"><?= $row['supplier'] ?></td>
                        <td class="center" style="vertical-align: top" rowspan="<?= $row['detail']->num_rows() + 1 ?>"><?= $row['kategori'] ?></td>
                        <?php foreach ($row['detail']->result() as $value) {
                            $order[$key] += $value->jumlah;
                            $masuk[$key] += $value->masuk;
                            $sisah[$key] += ($value->jumlah - $value->masuk);
                            $total[$key] += $value->total;
                        ?>
                    <tr>
                        <td class="center"><?= $value->kode_item ?></td>
                        <td class="center"><?= $value->part_number ?></td>
                        <td class="center"><?= $value->nama_item ?></td>
                        <td class="center"><?= $value->jumlah ?></td>
                        <td class="center"><?= $value->masuk ?></td>
                        <td class="center"><?= ($value->jumlah - $value->masuk) ?></td>
                        <td class="center"><?= separator_harga($value->harga_tebus_dpp) ?></td>
                        <td class="center"><?= $value->diskon ?></td>
                        <td class="center"><?= separator_harga($value->diskon_rp) ?></td>
                        <td class="center"><?= separator_harga($value->total) ?></td>
                    </tr>
                <?php } ?>
                </tr>
                <tr>
                    <td colspan="8"></td>
                    <td class="center"><?= $order[$key] ?></td>
                    <td class="center"><?= $masuk[$key] ?></td>
                    <td class="center"><?= $sisah[$key] ?></td>
                    <td colspan="3"></td>
                    <td class="center"><?= separator_harga($total[$key]) ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td class="center" colspan="15">Tidak Ada Data!</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>