<div class="card-body p-6">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>No</th>
                <th>Nama Mekanik</th>
                <th>Tanggal</th>
                <th>No. WO</th>
                <th>No. Invoice</th>
                <th>Nama Jasa</th>
                <th>Total Jasa</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Lama Pengerjaan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) > 0) { ?>
                <?php foreach ($data as $key => $value) : ?>
                    <tr>
                        <td class="center"><?= $value['no'] ?></td>
                        <td class="center"><?= $value['nama_mekanik'] ?></td>
                        <td class="center"><?= $value['tgl_service'] ?></td>
                        <td class="center"><?= $value['no_wo'] ?></td>
                        <td class="center"><?= $value['no_invoice'] ?></td>
                        <td class="center"><?= $value['nama_jasa'] ?></td>
                        <td class="center"><?= $value['total_jasa'] ?></td>
                        <td class="center"><?= $value['ts_mekanik'] ?></td>
                        <td class="center"><?= $value['tf_mekanik'] ?></td>
                        <td class="center"><?= $value['total_jam'] ?></td>
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