<script>
    $(document).ready(function() {
        //vars
        is_update = false;
        is_copy = false;

        table_agama = $("#table_agama").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_agama/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama_agama",
                },
                {
                    data: "id_agama",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_agama" title="Edit Agama">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Agama">
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
        });; //table_agama
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Agama");
        $("#nama_agama").val('');
    })

    // simpan agama
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_agama = null,
            nama_agama = $("#nama_agama").val(),
            the_url = "<?= site_url('master_agama/simpan'); ?>";

        if (is_update) {
            id_agama = $('#btn-simpan').data('id-agama');
            the_url = "<?= site_url('master_agama/update'); ?>";
        }

        if (nama_agama.length == 0 || nama_agama == '') {
            pesan('warning', 'Nama agama tidak boleh kosong!');
            $("#nama_agama").focus();
            return false;
        }

        konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: the_url,
                    data: {
                        id_agama: id_agama,
                        nama_agama: nama_agama,
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_agama.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_agama').modal('hide');
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

    //edit agama
    $(document).on('click', '.btn-edit', function() {
        let id_agama = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Agama");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_agama/get_agama_by_id'); ?>",
            data: {
                id: id_agama,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-agama', response.id_agama);
                $("#nama_agama").val(response.nama_agama);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus agama
    $(document).on('click', '.btn-hapus', function() {
        let id_agama = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_agama/hapus'); ?>",
                        data: {
                            id_agama: id_agama
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_agama.ajax.reload();
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

    $('#modal_tambah_agama').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#nama_agama").val('');
    }
</script>