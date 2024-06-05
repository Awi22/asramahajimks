<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-700 fw-bold fs-3 flex-column justify-content-center my-0"><?= $judul ?></h1>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
            </div>
        </div>
    </div>
    <!--end::Toolbar-->


    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid py-3">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="d-flex flex-column">
                <div class="flex-column flex-column-auto w-100 mb-10">
                    <div class="card mb-5 mb-xl-12">
                        <div class="card-body p-5">
                            <table id="table_kpi_by_mom" class="table align-middle table-striped table-row-bordered gy-2">
                                <thead>
                                    <tr class="fw-semibold fs-7 text-gray-800">
                                        <th colspan="14" class="text-end" style="background-color: #134f5c; color: white; padding-right: 10px;">Month (Bulan) / Group Score</th>
                                    </tr>
                                    <tr class="fw-semibold fs-7 text-gray-800">
                                        <th rowspan="2" class="text-center align-middle" style="background-color: #00838f; color: white; padding-left: 10px;">Area</th>
                                        <th rowspan="2" class="text-center align-middle" style="background-color: #00838f; color: white; padding-left: 10px;">Group</th>
                                        <?php foreach ($array_head['month'] as $key => $value) { ?>
                                            <th class="text-center" style="padding-right: 10px;"><?= $value ?></th>
                                        <?php } ?>
                                    </tr>
                                    <tr class="fw-semibold fs-7 text-gray-800">
                                        <?php foreach ($array_head['score'] as $key => $value) { ?>
                                            <th class="text-center" style="background-color: #c8e6c9; padding-left: 10px;"><?= $value ?></th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <?php $dealer_name_ = ''; ?>
                                    <?php foreach ($data as $key => $value) { ?>
                                        <tr>
                                            <td class="text-center"><?= ($dealer_name_ == $value['dealer_area'] ? null : $value['dealer_area']) ?></td>
                                            <td class="text-center"><?= $value['dealer_name'] ?></td>
                                            <?php foreach ($value['dealer_score'] as $k => $v) { ?>
                                                <td class="text-center"><?= $v ?></td>
                                            <?php } ?>
                                        </tr>
                                        <?php $dealer_name_ = $value['dealer_area']; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Content-->
</div>