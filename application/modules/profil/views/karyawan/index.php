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
            <div class="d-flex flex-column flex-xl-row">
                <div class="flex-column flex-lg-row-auto w-100  mb-10">
                    <div class="card mb-5 mb-xl-8">
                        <div class="card-title border p-5">
                            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary py-5 me-6 active" data-bs-toggle="tab" href="#FotoProfil">Foto Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-active-primary py-5 me-6" data-bs-toggle="tab" href="#DataProfil">Data Profil</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="FotoProfil" role="tabpanel">
                                <div class="card-body p-10 pt-5">
                                    <form action="<?= base_url('profil/upload_foto_karyawan') ?>" id="formFotoKaryawan" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                            <div class="col-sm-6 col-xxl-3">
                                                <div class="card card-flush h-xl-100">
                                                    <div class="card-body text-center pb-5">
                                                        <style>
                                                            .image-input-placeholder {
                                                                background-image: url('<?= base_url("public/assets/media/svg/avatars/blank.svg") ?>');
                                                            }

                                                            [data-bs-theme="dark"] .image-input-placeholder {
                                                                background-image: url('<?= base_url("public/assets/media/svg/avatars/blank-dark.svg") ?>');
                                                            }
                                                        </style>
                                                        <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url(<?= base_url() . 'public/upload/images/foto_profil/' . $foto ?>)">
                                                            <div class="image-input-wrapper w-200px h-200px h-md-250px w-md-250px" style="background-image: url(<?= base_url() . 'public/upload/images/foto_profil/' . $foto ?>)"></div>
                                                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Ganti Foto Profil">
                                                                <i class="ki-duotone ki-pencil fs-6">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <input type="file" name="photo_file[]" accept=".png, .jpg, .jpeg, .webp" />
                                                                <input type="hidden" name="avatar_remove" />
                                                            </label>
                                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Cancel avatar">
                                                                <i class="ki-outline ki-cross fs-3"></i>
                                                            </span>
                                                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Remove avatar">
                                                                <i class="ki-outline ki-cross fs-3"></i>
                                                            </span>
                                                        </div>
                                                        <div class="d-flex align-items-end flex-stack mt-2">
                                                            <div class="text-start">
                                                                <span class="fw-bold text-gray-700 fs-6 d-block">Foto Profil</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer d-flex flex-end p-4">
                                                        <button type="submit" class="btn btn-sm btn-light-primary">Apply</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="DataProfil" role="tabpanel">
                                <div class="card-body p-10 pt-5">
                                    <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                                        <!--  -->
                                        <div class="col-sm-6 col-xxl-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row fv-row mb-5">
                                                        <label class="required col-sm-4 col-form-label">Nama Lengkap</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Nama Lengkap" name="nama_karyawan" id="nama_karyawan" autocomplete="off" disabled readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row fv-row mb-5">
                                                        <label class="required col-sm-4 col-form-label">Kode Karyawan</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Kode Karyawan" name="kode_karyawan" id="kode_karyawan" autocomplete="off" disabled readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row fv-row mb-5">
                                                        <label class="required col-sm-4 col-form-label">Jabatan</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Jabatan" name="jabatan" id="jabatan" autocomplete="off" disabled readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row fv-row mb-5">
                                                        <label class="required col-sm-4 col-form-label">Area Kerja</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Area Kerja" name="area_kerja" id="area_kerja" autocomplete="off" disabled readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row fv-row mb-5">
                                                        <label class="required col-sm-4 col-form-label">Penempatan Tugas</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Penempatan Tugas" name="penempatan_tugas" id="penempatan_tugas" autocomplete="off" disabled readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row fv-row mb-5">
                                                        <label class="required col-sm-4 col-form-label">Status Aktif</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Status Aktif" name="status_aktif" id="status_aktif" autocomplete="off" disabled readonly />
                                                        </div>
                                                    </div>
                                                    <div class="row fv-row mb-5">
                                                        <label class="required col-sm-4 col-form-label">Jenis Kelamin</label>
                                                        <div class="input-group-sm col-sm-8 d-flex">
                                                            <div class="form-check form-check-custom form-check me-9">
                                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="male" value="L" />
                                                                <label class="form-check-label">
                                                                    Laki - Laki
                                                                </label>
                                                            </div>
                                                            <div class=" form-check form-check-custom form-check">
                                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="female" value="P" />
                                                                <label class="form-check-label">
                                                                    Perempuan
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row fv-row mb-3">
                                                        <label class="required col-sm-4 col-form-label">Agama</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <select class="form-select form-select-sm" data-placeholder="Pilih Agama" id="agama" name="agama">
                                                                <option value=""></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <div class="col-sm-6 col-xxl-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row fv-row mb-5">
                                                        <label class="col-sm-4 col-form-label">Email</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Email" name="email" id="email" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row fv-row mb-5">
                                                        <label class="col-sm-4 col-form-label">Alamat</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <textarea rows="3" class="form-control" aria-label="With textarea" placeholder="Alamat" name="alamat" id="alamat"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row fv-row mb-5">
                                                        <label class="col-sm-4 col-form-label">Tempat Lahir</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Tempat Lahir" name="tempat_lahir" id="tempat_lahir" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row fv-row mb-5">
                                                        <label class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <i class="ki-duotone ki-calendar position-absolute ms-2 mb-1 mt-2 fs-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                                <span class="path4"></span>
                                                                <span class="path5"></span>
                                                                <span class="path6"></span>
                                                            </i>
                                                            <input class="form-control form-control-sm ps-10" placeholder="<?= date('Y-m-d') ?>" name="tgl_lahir" id="tgl_lahir" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row fv-row mb-5">
                                                        <label class="col-sm-4 col-form-label">Nomor Telepon</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Nomor Telepon" name="no_telepon" id="no_telepon" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row fv-row mb-5">
                                                        <label class="col-sm-4 col-form-label">Handphone</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <input type="text" class="form-control form-control-sm" placeholder="Handphone" name="handphone" id="handphone" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row fv-row mb-5">
                                                        <label class="col-sm-4 col-form-label">Status Menikah</label>
                                                        <div class="input-group-sm col-sm-8">
                                                            <select class="form-select form-select-sm" data-control="select2" data-hide-search="true" data-placeholder="Status Menikah" name="status" id="status">
                                                                <option></option>
                                                                <option value="Belum Menikah">Belum Menikah</option>
                                                                <option value="Menikah">Menikah</option>
                                                                <option value="Bercerai">Bercerai</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex flex-end p-4">
                                        <button type="button" id="btn-simpan" class="btn btn-sm btn-light-primary">
                                            <span class="indicator-label">Simpan</span>
                                            <span class="indicator-progress">Menyimpan...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Content-->
</div>