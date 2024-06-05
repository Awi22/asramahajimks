<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel_detail_history" class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr>
                                    <th class="center">ID Prospek</th>
                                    <th class="center">Nama</th>
                                    <th class="center">Alamat</th>
                                    <th class="center">Telepone</th>
                                    <th class="center">Status</th>
                                    <th class="center">Follow Up</th>
                                    <th class="center">Test Drive</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($history as $key => $value) : ?>
                                    <tr>
                                        <td style="vertical-align:top"><?= $value->id_prospek ?></td>
                                        <td style="vertical-align:top"><?= $value->nama ?></td>
                                        <td style="vertical-align:top"><?= $value->alamat ?></td>
                                        <td style="vertical-align:top"><?= $value->telepone ?></td>
                                        <td style="vertical-align:top"><?= $value->status ?></td>
                                        <td>
                                            <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Hasil</th>
                                                        <th>Keterangan</th>
                                                        <th>Tgl Followup</th>
                                                        <th>Tgl Berikutnya</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($value->toHistoryFollowupSales as $key => $dt) : ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?= $dt['hasil'] == 'y' ? 'Good' : 'Bed' ?></td>
                                                            <td><?= $dt['keterangan']  ?></td>
                                                            <td><?= $dt['tgl_followup']  ?></td>
                                                            <td><?= $dt['tgl_selanjutnya']  ?></td>
                                                        </tr>
                                                    <? endforeach ?>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="vertical-align:top">
                                            <?php if ($value->toTestDrive == null) : ?>
                                                <span class="badge py-3 px-4 fs-6 me-5 badge-light-primary">
                                                    <?= 'Belum Test Drive' ?>
                                                </span>
                                            <?php else : ?>
                                                <table class=" table table-bordered align-middle table-row-dashed fs-6 gy-5">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tahapan</th>
                                                            <th>Varian</th>
                                                            <th>Waktu Test Drive</th>
                                                            <th>Lokasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $noTestDrive = 1;
                                                        switch ($value->toTestDrive->tempat) {
                                                            case 'd':
                                                                $tempat = 'Dealer';
                                                                break;
                                                            case 'r':
                                                                $tempat = 'Rumah';
                                                                break;
                                                            case 'p':
                                                                $tempat = 'Publicarea';
                                                                break;
                                                            case 'l':
                                                                $tempat = 'Lain - Lain';
                                                                break;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= $noTestDrive++ ?></td>
                                                            <td><?= $value->toTestDrive->tahapan ?></td>
                                                            <td><?= $value->toTestDrive->toPVarian['varian']  ?></td>
                                                            <td><?= $value->toTestDrive->tgl_jam  ?></td>
                                                            <td><?= $tempat  ?></td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table id="tabel_detail_jadwal" class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr>
                                    <th class="center">ID Prospek</th>
                                    <th class="center">Nama</th>
                                    <th class="center">Alamat</th>
                                    <th class="center">Telepone</th>
                                    <th class="center">Status</th>
                                    <th class="center">Follow Up</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jadwal as $key => $value) : ?>
                                    <tr>
                                        <td style="vertical-align:top"><?= $value->id_prospek ?></td>
                                        <td style="vertical-align:top"><?= $value->nama ?></td>
                                        <td style="vertical-align:top"><?= $value->alamat ?></td>
                                        <td style="vertical-align:top"><?= $value->telepone ?></td>
                                        <td style="vertical-align:top"><?= $value->status ?></td>
                                        <td>
                                            <table class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Hasil</th>
                                                        <th>Keterangan</th>
                                                        <th>Tgl Followup</th>
                                                        <th>Tgl Berikutnya</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($value->toHistoryFollowupSales as $key => $dt) : ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?= $dt['hasil'] == 'y' ? 'Good' : 'Bed' ?></td>
                                                            <td><?= $dt['keterangan']  ?></td>
                                                            <td><?= $dt['tgl_followup']  ?></td>
                                                            <td><?= $dt['tgl_selanjutnya']  ?></td>
                                                        </tr>
                                                    <? endforeach ?>
                                                </tbody>
                                            </table>
                                        </td>

                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table id="tabel_detail_new" class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr>
                                    <th class="center">ID Prospek</th>
                                    <th class="center">Nama</th>
                                    <th class="center">Alamat</th>
                                    <th class="center">Telepone</th>
                                    <th class="center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($new as $key => $value) : ?>
                                    <tr>
                                        <td style="vertical-align:top"><?= $value->id_prospek ?></td>
                                        <td style="vertical-align:top"><?= $value->nama ?></td>
                                        <td style="vertical-align:top"><?= $value->alamat ?></td>
                                        <td style="vertical-align:top"><?= $value->telepone ?></td>
                                        <td style="vertical-align:top"><?= $value->status ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>