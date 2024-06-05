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
                <div class="card-header justify-content-start gap-6 p-6">
                    <div class="mb-5 col-12 col-sm-3">
                        <label class="form-label fw-bold fs-6 text-gray-700">Varian</label>
                        <select name="opt_varian" id="opt_varian" class="form-select form-select-sm">
                            <option value=""></option>
                        </select>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_pricelist" class="table align-middle table-row-dashed fs-6 gy-5">

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>