<script>
    $(document).ready(function() {
        //vars
        is_update = false;
        is_copy = false;

        table_pegawai = $("#table_pegawai").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_asn/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama_pegawai",
                },
                {
                    data: "nip",
                },
                {
                    data: "jenis_asn",
                },
                {
                    data: "jabatan",
                },
                {
                    data: "id_pegawai",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_pegawai" title="Edit Pegawai">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Pegawai">
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
        });; //table_pegawai

        getJenisASN();
        getJabatan();
        getAgama();
        $("#tgl_lahir").flatpickr();
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Pegawai");
        reset_form();
    })

    // simpan pegawai
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_pegawai = null,
            nama_pegawai = $("#nama_pegawai").val(),
            nip = $("#nip").val(),
            opt_id_jenis_asn = $("#opt_id_jenis_asn").val(),
            opt_id_jabatan = $("#opt_id_jabatan").val(),
            email = $("#email").val(),
            jenis_kelamin = $('input[name="jenis_kelamin"]:checked').val(),
            opt_id_agama = $("#opt_id_agama").val(),
            alamat = $("#alamat").val(),
            tempat_lahir = $("#tempat_lahir").val(),
            tgl_lahir = $("#tgl_lahir").val(),
            no_telepon = $("#no_telepon").val(),
            handphone = $("#handphone").val(),
            status = $("#status").val(),
            the_url = "<?= site_url('master_asn/simpan'); ?>";

        if (is_update) {
            id_pegawai = $('#btn-simpan').data('id-pegawai');
            the_url = "<?= site_url('master_asn/update'); ?>";
        }

        if (nama_pegawai.length == 0 || nama_pegawai == '') {
            pesan('warning', 'Nama pegawai tidak boleh kosong!');
            $("#nama_pegawai").focus();
            return false;
        }

        if (nip.length == 0 || nip == '') {
            pesan('warning', 'NIP tidak boleh kosong!');
            $("#nip").focus();
            return false;
        }

        if (opt_id_jenis_asn.length == 0 || opt_id_jenis_asn == '') {
            pesan('warning', 'Jenis ASN tidak boleh kosong!');
            $("#opt_id_jenis_asn").focus();
            return false;
        }

        if (opt_id_jabatan.length == 0 || opt_id_jabatan == '') {
            pesan('warning', 'Jabatan tidak boleh kosong!');
            $("#opt_id_jabatan").focus();
            return false;
        }

        if (email.length == 0 || email == '') {
            pesan('warning', 'Email tidak boleh kosong!');
            $("#email").focus();
            return false;
        }

        if (jenis_kelamin == null) {
            pesan('warning', 'Jenis Kelamin tidak boleh kosong!');
            $("#male").focus();
            return false;
        }

        if (opt_id_agama.length == 0 || opt_id_agama == '') {
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
                        nip: nip,
                        id_pegawai: id_pegawai,
                        id_jenis_asn: opt_id_jenis_asn,
                        nama_pegawai: nama_pegawai,
                        id_jabatan: opt_id_jabatan,
                        email: email,
                        jenis_kelamin: jenis_kelamin,
                        agama: opt_id_agama,
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
                            table_pegawai.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_pegawai').modal('hide');
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

    //edit pegawai
    $(document).on('click', '.btn-edit', function() {
        let id_pegawai = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Pegawai");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_asn/get_asn_by_id'); ?>",
            data: {
                id: id_pegawai,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-pegawai', response.id_pegawai);
                $("#nip").val(response.nip);
                $("#opt_id_jenis_asn").val(response.id_jenis_asn).trigger('change');
                $("#nama_pegawai").val(response.nama_pegawai);
                $("#opt_id_jabatan").val(response.id_jabatan).trigger('change');
                $("#email").val(response.email);
                var jkl = response.jenis_kelamin;
                if (jkl == 'L') {
                    $('#male').prop('checked', true);
                }
                if (jkl == 'P') {
                    $('#female').prop('checked', true);
                }
                $("#opt_id_agama").val(response.id_agama).trigger('change');
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

    //hapus pegawai
    $(document).on('click', '.btn-hapus', function() {
        let id_pegawai = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_asn/hapus'); ?>",
                        data: {
                            id_pegawai: id_pegawai
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_pegawai.ajax.reload();
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

    $('#modal_tambah_pegawai').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#nama_pegawai").val('');
        $("#nip").val('');
        $("#opt_id_jenis_asn").val(null).trigger('change');
        $("#opt_id_jabatan").val(null).trigger('change');
        $("#email").val('');
        $('#male').prop('checked', false);
        $('#female').prop('checked', false);
        $("#opt_id_agama").val(null).trigger('change');
        $("#alamat").val('');
        $("#tempat_lahir").val('');
        $("#tgl_lahir").val('');
        $("#no_telepon").val('');
        $("#handphone").val('');
        $("#status").val(null).trigger('change');
        $("#modal_tambah_pegawai_lanjutan").collapse('hide');
    }

    //select2 data jenis asn
    function getJenisASN() {
        $.ajax({
            url: "<?= site_url('master_asn/select2_jenisASN'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#opt_id_jenis_asn").select2({
                    placeholder: 'Pilih Jenis ASN',
                    dropdownParent: $('#modal_tambah_pegawai'),
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

    //select2 data jabatan
    function getJabatan() {
        $.ajax({
            url: "<?= site_url('master_asn/select2_jabatan'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#opt_id_jabatan").select2({
                    placeholder: 'Pilih Jabatan',
                    dropdownParent: $('#modal_tambah_pegawai'),
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
                    dropdownParent: $('#modal_tambah_pegawai'),
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
</script>