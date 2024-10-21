<script>
    $(document).ready(function() {
        //vars
        is_update = false;
        is_copy = false;

        table_karyawan = $("#table_karyawan").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_karyawan/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama_karyawan",
                },
                {
                    data: "jabatan",
                },
                {
                    data: "area_kerja",
                },
                {
                    data: "penempatan_tugas",
                },
                {
                    data: "id_karyawan",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_karyawan" title="Edit Karyawan">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Karyawan">
										<i class="bi bi-trash fs-3"></i>
									</button>
								</td>`;
                        return html
                    }
                }
            ],
            dom: `
				"<'row'" +
				"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
				"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
				">" +

				"<'table-responsive'tr>" +

				"<'row'" +
				"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
				"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
				">"	`,
        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });; //table_karyawan

        getJabatan();
        getAreaKerja();
        getPenempatanTugas();
        getAgama();
        $("#tgl_lahir").flatpickr();
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Karyawan");
        reset_form();
    })

    // simpan karyawan
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_karyawan = null,
            kode_karyawan = $("#kode_karyawan").val(),
            nama_karyawan = $("#nama_karyawan").val(),
            jabatan = $("#opt_id_jabatan").val(),
            area_kerja = $("#opt_id_area_kerja").val(),
            tugas = $("#opt_id_penempatan_tugas").val(),
            jenis_kelamin = $('input[name="jenis_kelamin"]:checked').val(),
            agama = $("#opt_id_agama").val(),
            email = $("#email").val(),
            alamat = $("#alamat").val(),
            tempat_lahir = $("#tempat_lahir").val(),
            tgl_lahir = $("#tgl_lahir").val(),
            no_telepon = $("#no_telepon").val(),
            handphone = $("#handphone").val(),
            status = $("#status").val(),
            the_url = "<?= site_url('master_karyawan/simpan'); ?>";

        if (is_update) {
            id_karyawan = $('#btn-simpan').data('id-karyawan');
            the_url = "<?= site_url('master_karyawan/update'); ?>";
        }

        if (kode_karyawan.length == 0 || kode_karyawan == '') {
            pesan('warning', 'Kode karyawan tidak boleh kosong!');
            $("#kode_karyawan").focus();
            return false;
        }

        if (nama_karyawan.length == 0 || nama_karyawan == '') {
            pesan('warning', 'Nama karyawan tidak boleh kosong!');
            $("#nama_karyawan").focus();
            return false;
        }

        if (jabatan.length == 0 || jabatan == '') {
            pesan('warning', 'Jabatan tidak boleh kosong!');
            $("#opt_id_jabatan").focus();
            return false;
        }

        if (area_kerja.length == 0 || area_kerja == '') {
            pesan('warning', 'Area kerja tidak boleh kosong!');
            $("#opt_id_area_kerja").focus();
            return false;
        }

        if (tugas.length == 0 || tugas == '') {
            pesan('warning', 'Penempatan tugas tidak boleh kosong!');
            $("#opt_id_penempatan_tugas").focus();
            return false;
        }

        if (jenis_kelamin == null) {
            pesan('warning', 'Jenis Kelamin tidak boleh kosong!');
            $("#male").focus();
            return false;
        }

        if (agama.length == 0 || agama == '') {
            pesan('warning', 'Agama tidak boleh kosong!');
            $("#opt_id_agama").focus();
            return false;
        }

        konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: the_url,
                    data: {
                        kode_karyawan: kode_karyawan,
                        id_karyawan: id_karyawan,
                        nama_karyawan: nama_karyawan,
                        jabatan: jabatan,
                        area_kerja: area_kerja,
                        tugas: tugas,
                        jenis_kelamin: jenis_kelamin,
                        agama: agama,
                        email: email,
                        alamat: alamat,
                        tempat_lahir: tempat_lahir,
                        tgl_lahir: tgl_lahir,
                        no_telepon: no_telepon,
                        handphone: handphone,
                        status: status
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_karyawan.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_karyawan').modal('hide');
                        $("#btn-simpan").removeAttr("data-kt-indicator").prop("disabled", false)
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                        pesan("error", "Terjadi Kesalahan");
                        location.reload();
                    }
                });
            }
        })
    });

    //edit karyawan
    $(document).on('click', '.btn-edit', function() {
        let id_karyawan = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Karyawan");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_karyawan/get_karyawan_by_id'); ?>",
            data: {
                id: id_karyawan,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-karyawan', response.id_karyawan);
                $("#kode_karyawan").val(response.kode_karyawan);
                $("#nama_karyawan").val(response.nama_karyawan);
                $("#opt_id_jabatan").val(response.id_jabatan).trigger('change');
                $("#opt_id_area_kerja").val(response.id_area_kerja).trigger('change');
                $("#opt_id_penempatan_tugas").val(response.id_tugas).trigger('change');
                var jkl = response.jenis_kelamin;
                if (jkl == 'L') {
                    $('#male').prop('checked', true);
                }
                if (jkl == 'P') {
                    $('#female').prop('checked', true);
                }
                $("#opt_id_agama").val(response.id_agama).trigger('change');
                $("#email").val(response.email);
                $("#alamat").val(response.alamat);
                $("#tempat_lahir").val(response.tempat_lahir);
                $("#tgl_lahir").val(response.tgl_lahir);
                $("#no_telepon").val(response.no_telepon);
                $("#handphone").val(response.handphone);
                $("#status").val(response.status).trigger('change');
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus karyawan
    $(document).on('click', '.btn-hapus', function() {
        let id_karyawan = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_karyawan/hapus'); ?>",
                        data: {
                            id_karyawan: id_karyawan
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_karyawan.ajax.reload();
                                    })
                            } else {
                                peringatan("Error", response.pesan, 'error')
                                    .then(function() {
                                        location.reload();
                                    })
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            console.log(err.Message);
                            pesan('error', 'Terjadi Kesalahan');
                        }
                    })
                }
            })
    });

    $('#modal_tambah_karyawan').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#kode_karyawan").val(getKodekaryawan());
        $("#nama_karyawan").val('');
        $("#opt_id_jabatan").val(null).trigger('change');
        $("#opt_id_area_kerja").val(null).trigger('change');
        $("#opt_id_penempatan_tugas").val(null).trigger('change');
        $('#male').prop('checked', false);
        $('#female').prop('checked', false);
        $("#opt_id_agama").val(null).trigger('change');
        $("#email").val('');
        $("#alamat").val('');
        $("#tempat_lahir").val('');
        $("#tgl_lahir").val('');
        $("#no_telepon").val('');
        $("#handphone").val('');
        $("#status").val(null).trigger('change');
        $("#modal_tambah_karyawan_lanjutan").collapse('hide');
    }

    //select2 data jabatan
    function getJabatan() {
        $.ajax({
            url: "<?= site_url('master_karyawan/select2_jabatan'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#opt_id_jabatan").select2({
                    placeholder: 'Pilih Jabatan',
                    dropdownParent: $('#modal_tambah_karyawan'),
                    allowClear: true,
                    data: response
                });
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi Kesalahan');
            }
        })
    }

    //select2 data area kerja
    function getAreaKerja() {
        $.ajax({
            url: "<?= site_url('master_karyawan/select2_area_kerja'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#opt_id_area_kerja").select2({
                    placeholder: 'Pilih Area Kerja',
                    dropdownParent: $('#modal_tambah_karyawan'),
                    allowClear: true,
                    data: response
                });
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi Kesalahan');
            }
        })
    }

    //select2 data penempatan tugas
    function getPenempatanTugas() {
        $.ajax({
            url: "<?= site_url('master_karyawan/select2_penempatan_tugas'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#opt_id_penempatan_tugas").select2({
                    placeholder: 'Pilih Penempatan Tugas',
                    dropdownParent: $('#modal_tambah_karyawan'),
                    allowClear: true,
                    data: response
                });
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi Kesalahan');
            }
        })
    }

    //select2 data agama
    function getAgama() {
        $.ajax({
            url: "<?= site_url('master_asn/select2_agama'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#opt_id_agama").select2({
                    placeholder: 'Pilih Agama',
                    dropdownParent: $('#modal_tambah_karyawan'),
                    allowClear: true,
                    data: response
                });
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi Kesalahan');
            }
        })
    }

    function getKodekaryawan() {
        $.ajax({
            url: "<?= site_url('master_karyawan/getKodeKaryawan'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#kode_karyawan").val(response);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi Kesalahan');
            }
        })
    }
</script>