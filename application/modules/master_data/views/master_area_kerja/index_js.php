<script>
    $(document).ready(function() {
        //vars
        // id_area_kerja = null;
        is_update = false;
        is_copy = false;

        table_area_kerja = $("#table_area_kerja").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_area_kerja/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama_area_kerja",
                },
                {
                    data: "id_area_kerja",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_area_kerja" title="Edit Area Kerja">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Area Kerja">
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
        });; //table_area_kerja
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Area Kerja");
        $("#nama_area_kerja").val('');
    })

    // simpan area kerja
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_area_kerja = null,
            nama_area_kerja = $("#nama_area_kerja").val(),
            the_url = "<?= site_url('master_area_kerja/simpan'); ?>";

        if (is_update) {
            id_area_kerja = $('#btn-simpan').data('id-area_kerja');
            the_url = "<?= site_url('master_area_kerja/update'); ?>";
        }

        if (nama_area_kerja.length == 0 || nama_area_kerja == '') {
            pesan('warning', 'Nama area kerja tidak boleh kosong!');
            $("#nama_area_kerja").focus();
            return false;
        }

        konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: the_url,
                    data: {
                        id_area_kerja: id_area_kerja,
                        nama_area_kerja: nama_area_kerja,
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_area_kerja.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_area_kerja').modal('hide');
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

    //edit area kerja
    $(document).on('click', '.btn-edit', function() {
        let id_area_kerja = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Area Kerja");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_area_kerja/get_area_kerja_by_id'); ?>",
            data: {
                id: id_area_kerja,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-area_kerja', response.id_area_kerja);
                $("#nama_area_kerja").val(response.nama_area_kerja);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus area kerja
    $(document).on('click', '.btn-hapus', function() {
        let id_area_kerja = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_area_kerja/hapus'); ?>",
                        data: {
                            id_area_kerja: id_area_kerja
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_area_kerja.ajax.reload();
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

    $('#modal_tambah_area_kerja').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#nama_area_kerja").val('');
    }
</script>