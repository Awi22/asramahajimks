<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid py-3 d-flex flex-center">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card">
                <div class="card-body d-flex flex-center">
                    <div class="row w-md-800px">
                        <form action="" id="form_edit">
                            <div class="col-md-12">
                                <div class="form-group row fv-row mb-2">
                                    <label class="required  col-sm-4 col-md-4 col-form-label">ID Prospek</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid " name="id_prospek" id="id_prospek" value="<?= $id_prospek ?>" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Tanggal Suspect</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid " name="tgl_suspect" id="tgl_suspect" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Code Customer Digital</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid " name="code_digital" id="code_digital" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Nama Customer</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="nama_customer" id="nama_customer" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Alamat</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <textarea class="form-control" aria-label="With textarea" name="alamat" id="alamat" disabled></textarea>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Provinsi</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="provinsi" id="provinsi" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Kabupaten</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="kabupaten" id="kabupaten" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Kecamatan</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="kecamatan" id="kecamatan" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Kelurahan</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="kelurahan" id="kelurahan" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Kode Pos</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="kode_pos" id="kode_pos" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Telephone</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="tlpn" id="tlpn" disabled />
                                    </div>
                                </div>

                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Sumber Prospek</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="opt_sumber_prospek" id="opt_sumber_prospek" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Tanggal Prospek</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid " name="tgl_prospek" id="tgl_prospek" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Media Motivator</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="opt_media_motivator" id="opt_media_motivator" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Model Diminati</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="opt_model_diminati" id="opt_model_diminati" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Kebutuhan</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="kebutuhan_prospek" id="kebutuhan_prospek" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="col-sm-4 col-md-4 col-form-label">&nbsp;</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <select class="form-select form-select-sm" name="kebutuhan_bulan" id="kebutuhan_bulan" disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Mobil dipakai oleh</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="mobil_dipakai" id="mobil_dipakai" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Rute Sehari-hari</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="rute" id="rute" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Jumlah Anggota Keluarga</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="number" class="form-control form-control-sm form-control-solid" name="jml_anggota" id="jml_anggota" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Decision Maker</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid" name="decision_maker" id="decision_maker" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Tanggal Hot Prospek</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid " name="tgl_hot_prospek" id="tgl_hot_prospek" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Pilihan cara Bayar</label>
                                    <div class="form-check form-check-custom form-check-solid me-6 col-sm-1">
                                        <input class="form-check-input" type="radio" name="cara_bayar" id="cash_hot_prospek" value="c" disabled />
                                        <label class="form-check-label">
                                            Cash
                                        </label>
                                    </div>
                                    <div class=" form-check form-check-custom form-check-solid me-6 col-sm-1">
                                        <input class="form-check-input" type="radio" name="cara_bayar" id="kredit_hot_prospek" value="k" disabled />
                                        <label class="form-check-label">
                                            Kredit
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">TDP</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid " name="tdp" id="tdp" placeholder="0" disabled />
                                    </div>
                                </div>
                                <div class="form-group row fv-row mb-2">
                                    <label class="required col-sm-4 col-md-4 col-form-label">Cicilan</label>
                                    <div class="input-group-sm col-sm-8 col-md-8">
                                        <input type="text" class="form-control form-control-sm form-control-solid " name="cicilan" id="cicilan" placeholder="0" disabled />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="table-responsive">
                        <table id="tabel_fu_history" class="table table-bordered align-middle table-row-dashed fs-6 gy-5">
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