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
                    <div class="card-header justify-content-start gap-6 p-6">
                        <div class="mb-5 col-12 col-sm-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Tanggal Awal</label>
                            <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_awal" id="tgl_awal" value="<?= date('Y-m-01') ?>" readonly />
                        </div>
                        <div class="mb-5 col-12 col-sm-3">
                            <label class="form-label fw-bold fs-6 text-gray-700">Tanggal Akhir</label>
                            <input type="text" class="form-control form-control-sm form-control-solid" name="tgl_akhir" id="tgl_akhir" value="<?= date('Y-m-d') ?>" readonly />
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="tabel_followup_customer" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr>
                                    <th rowspan="2">Sales</th>
                                    <th rowspan="2">Harus Difollow Up</th>
                                    <th rowspan="2">Total Difollow Up</th>
                                    <th colspan="6">Tahapan Sales</th>
                                </tr>
                                <tr>
                                    <th>Suspect</th>
                                    <th>Prospek</th>
                                    <th>Hot Prospek</th>
                                    <th>Spk</th>
                                    <th>DO</th>
                                    <th>Test Drive</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>