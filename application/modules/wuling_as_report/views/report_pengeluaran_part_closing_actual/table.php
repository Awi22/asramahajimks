<div class="card-body p-6">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th rowspan="2">Part Number</th>
                <th rowspan="2">Kode Item</th>
                <th rowspan="2">Nama Item</th>
                <th colspan="5">Awal Bulan</th>
                <th colspan="2">Inbound</th>
                <th colspan="2">Outbond</th>
                <th rowspan="2">Net</th>
                <th colspan="5">Akhir Bulan</th>
                <th rowspan="2">Selisih</th>
            </tr>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Stok</th>
                <th>Alokasi</th>
                <th>WIP</th>
                <th>Aktual</th>
                <th>Ready</th>
                <th>Trans. IB</th>
                <th>Qty</th>
                <th>Trans. OB</th>
                <th>Qty</th>
                <th>Stok</th>
                <th>Alokasi</th>
                <th>WIP</th>
                <th>Aktual</th>
                <th>Ready</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) > 0) { ?>
                <?php foreach ($data as $key => $value) : ?>
                    <tr>
                        <td class="center"><?= $value['part_number'] ?></td>
                        <td class="center"><?= $value['kode_item'] ?></td>
                        <td class="center"><?= $value['nama_item'] ?></td>
                        <td class="center"><?= $value['stok_awal'] ?></td>
                        <td class="center"><?= $value['stok_alokasi_awal'] ?></td>
                        <td class="center"><?= $value['stok_wip_awal'] ?></td>
                        <td class="center"><?= $value['stok_aktual_awal'] ?></td>
                        <td class="center"><?= $value['stok_ready_awal'] ?></td>
                        <td class="center"><?= $value['in_trans'] ?></td>
                        <td class="center"><?= $value['in_stok'] ?></td>
                        <td class="center"><?= $value['out_trans'] ?></td>
                        <td class="center"><?= $value['out_stok'] ?></td>
                        <td class="center"><?= $value['net'] ?></td>
                        <td class="center"><?= $value['stok_akhir'] ?></td>
                        <td class="center"><?= $value['stok_alokasi_akhir'] ?></td>
                        <td class="center"><?= $value['stok_wip_akhir'] ?></td>
                        <td class="center"><?= $value['stok_aktual_akhir'] ?></td>
                        <td class="center"><?= $value['stok_ready_akhir'] ?></td>
                        <td class="center"><?= $value['selisih'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php } else { ?>
                <tr>
                    <td class="center" colspan="15">Tidak Ada Data!</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>