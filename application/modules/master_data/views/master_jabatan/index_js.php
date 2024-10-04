<script>
    $(document).ready(function() {
        //vars
        // id_jabatan = null;
        is_update = false;
        is_copy = false;

        table_jabatan = $("#table_jabatan").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_jabatan/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama_jabatan",
                },
                {
                    data: "deskripsi",
                },
                {
                    data: "id_jabatan",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_jabatan" title="Edit Jabatan">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Jabatan">
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
        });; //table_jabatan
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Jabatan");
        $("#nama_jabatan").val('');
        $("#deskripsi").val('');
    })

    // simpan jabatan
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_jabatan = null,
            nama_jabatan = $("#nama_jabatan").val(),
            deskripsi = $("#deskripsi").val(),
            the_url = "<?= site_url('master_jabatan/simpan'); ?>";

        if (is_update) {
            id_jabatan = $('#btn-simpan').data('id-jabatan');
            the_url = "<?= site_url('master_jabatan/update'); ?>";
        }

        if (nama_jabatan.length == 0 || nama_jabatan == '') {
            pesan('warning', 'Nama jabatan tidak boleh kosong!');
            $("#nama_jabatan").focus();
            return false;
        }

        if (deskripsi.length == 0 || deskripsi == '') {
            pesan('warning', 'Deskripsi tidak boleh kosong!');
            $("#deskripsi").focus();
            return false;
        }

        konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: the_url,
                    data: {
                        id_jabatan: id_jabatan,
                        nama_jabatan: nama_jabatan,
                        deskripsi: deskripsi,
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_jabatan.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_jabatan').modal('hide');
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

    //edit jabatan
    $(document).on('click', '.btn-edit', function() {
        let id_jabatan = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Jabatan");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_jabatan/get_jabatan_by_id'); ?>",
            data: {
                id: id_jabatan,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-jabatan', response.id_jabatan);
                $("#nama_jabatan").val(response.nama_jabatan);
                $("#deskripsi").val(response.deskripsi);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus jabatan
    $(document).on('click', '.btn-hapus', function() {
        let id_jabatan = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_jabatan/hapus'); ?>",
                        data: {
                            id_jabatan: id_jabatan
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_jabatan.ajax.reload();
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

    $('#modal_tambah_jabatan').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#nama_jabatan").val('');
        $("#deskripsi").val('');
    }
</script>