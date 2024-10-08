<script>
    $(document).ready(function() {
        //vars
        // id_status_pegawai = null;
        is_update = false;
        is_copy = false;

        table_status_pegawai = $("#table_status_pegawai").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_status_pegawai/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama_status_pegawai",
                },
                {
                    data: "deskripsi",
                },
                {
                    data: "id_status_pegawai",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_status_pegawai" title="Edit Status Pegawai">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Status Pegawai">
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
        });; //table_status_pegawai
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Status Pegawai");
        $("#nama_status_pegawai").val('');
        $("#deskripsi").val('');
    })

    // simpan status pegawai
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_status_pegawai = null,
            nama_status_pegawai = $("#nama_status_pegawai").val(),
            deskripsi = $("#deskripsi").val(),
            the_url = "<?= site_url('master_status_pegawai/simpan'); ?>";

        if (is_update) {
            id_status_pegawai = $('#btn-simpan').data('id-status_pegawai');
            the_url = "<?= site_url('master_status_pegawai/update'); ?>";
        }

        if (nama_status_pegawai.length == 0 || nama_status_pegawai == '') {
            pesan('warning', 'Nama status pegawai tidak boleh kosong!');
            $("#nama_status_pegawai").focus();
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
                        id_status_pegawai: id_status_pegawai,
                        nama_status_pegawai: nama_status_pegawai,
                        deskripsi: deskripsi,
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_status_pegawai.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_status_pegawai').modal('hide');
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

    //edit status pegawai
    $(document).on('click', '.btn-edit', function() {
        let id_status_pegawai = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Status Pegawai");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_status_pegawai/get_status_pegawai_by_id'); ?>",
            data: {
                id: id_status_pegawai,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-status_pegawai', response.id_status_pegawai);
                $("#nama_status_pegawai").val(response.nama_status_pegawai);
                $("#deskripsi").val(response.deskripsi);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus status pegawai
    $(document).on('click', '.btn-hapus', function() {
        let id_status_pegawai = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_status_pegawai/hapus'); ?>",
                        data: {
                            id_status_pegawai: id_status_pegawai
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_status_pegawai.ajax.reload();
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

    $('#modal_tambah_status_pegawai').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#nama_status_pegawai").val('');
        $("#deskripsi").val('');
    }
</script>