<div class="card-body p-6">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>No</th>
                <th>Tanggal</th>
                <th>No PO</th>
                <th>No WO</th>
                <th>No Pengeluaran</th>
                <th>No BKU</th>
                <th>Nama Vendor</th>
                <th>Harga</th>
                <th>PPN</th>
                <th>Total</th>
                <th>Nilai Hutang</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) > 0) { ?>
                <?php foreach ($data as $key => $value) : ?>
                    <tr>
                        <td class="center"><?= $value['no'] ?></td>
                        <td class="center"><?= $value['tanggal'] ?></td>
                        <td class="center"><?= $value['no_po'] ?></td>
                        <td class="center"><?= $value['no_wo'] ?></td>
                        <td class="center"><?= $value['no_pengeluaran'] ?></td>
                        <td class="center"><?= $value['no_bukti_bku'] ?></td>
                        <td class="center"><?= $value['nama_vendor'] ?></td>
                        <td class="center"><?= $value['harga'] ?></td>
                        <td class="center"><?= $value['ppn'] ?></td>
                        <td class="center"><?= $value['total'] ?></td>
                        <td class="center"><?= $value['hutang'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php } else { ?>
                <tr>
                    <td class="center" colspan="15">Tidak Ada Data!</td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: left;">Total</td>
                <td id="total-harga">0</td>
                <td id="total-ppn">0</td>
                <td id="total">0</td>
                <td class="total-hutang">0</td>
            </tr>
            <tr>
                <td colspan="10" class="borderLeftTop">Total Hutang</td>
                <td class="center borderLeftTop total-hutang">0</td>
            </tr>
        </tfoot>
    </table>
</div>