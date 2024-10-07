<script>
    $(document).ready(function() {
        //vars
        // id_penempatan_tugas = null;
        is_update = false;
        is_copy = false;

        table_penempatan_tugas = $("#table_penempatan_tugas").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_penempatan_tugas/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama_penempatan_tugas",
                },
                {
                    data: "id_penempatan_tugas",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_penempatan_tugas" title="Edit Penempatan Tugas">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Penempatan Tugas">
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
        });; //table_penempatan_tugas
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Penempatan Tugas");
        $("#nama_penempatan_tugas").val('');
    })

    // simpan Penempatan Tugas
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_penempatan_tugas = null,
            nama_penempatan_tugas = $("#nama_penempatan_tugas").val(),
            the_url = "<?= site_url('master_penempatan_tugas/simpan'); ?>";

        if (is_update) {
            id_penempatan_tugas = $('#btn-simpan').data('id-area_kerja');
            the_url = "<?= site_url('master_penempatan_tugas/update'); ?>";
        }

        if (nama_penempatan_tugas.length == 0 || nama_penempatan_tugas == '') {
            pesan('warning', 'Nama Penempatan Tugas tidak boleh kosong!');
            $("#nama_penempatan_tugas").focus();
            return false;
        }

        konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: the_url,
                    data: {
                        id_penempatan_tugas: id_penempatan_tugas,
                        nama_penempatan_tugas: nama_penempatan_tugas,
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_penempatan_tugas.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_penempatan_tugas').modal('hide');
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

    //edit Penempatan Tugas
    $(document).on('click', '.btn-edit', function() {
        let id_penempatan_tugas = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Penempatan Tugas");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_penempatan_tugas/get_penempatan_tugas_by_id'); ?>",
            data: {
                id: id_penempatan_tugas,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-area_kerja', response.id_penempatan_tugas);
                $("#nama_penempatan_tugas").val(response.nama_penempatan_tugas);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus Penempatan Tugas
    $(document).on('click', '.btn-hapus', function() {
        let id_penempatan_tugas = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_penempatan_tugas/hapus'); ?>",
                        data: {
                            id_penempatan_tugas: id_penempatan_tugas
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_penempatan_tugas.ajax.reload();
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

    $('#modal_tambah_penempatan_tugas').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#nama_penempatan_tugas").val('');
    }
</script>