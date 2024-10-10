<script>
    $(document).ready(function() {
        //vars
        is_update = false;
        is_copy = false;

        table_jenis_asn = $("#table_jenis_asn").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('master_jenis_asn/get') ?>",
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "nama",
                },
                {
                    data: "deskripsi",
                },
                {
                    data: "id_jenis_asn",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_jenis_asn" title="Edit Jenis ASN">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Jenis ASN">
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
        });; //table_jenis_asn
    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Jenis ASN");
        $("#nama").val('');
        $("#deskripsi").val('');
    })

    // simpan Jenis ASN
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id_jenis_asn = null,
            nama = $("#nama").val(),
            deskripsi = $("#deskripsi").val(),
            the_url = "<?= site_url('master_jenis_asn/simpan'); ?>";

        if (is_update) {
            id_jenis_asn = $('#btn-simpan').data('id-jenis_asn');
            the_url = "<?= site_url('master_jenis_asn/update'); ?>";
        }

        if (nama.length == 0 || nama == '') {
            pesan('warning', 'Nama Jenis ASN tidak boleh kosong!');
            $("#nama").focus();
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
                        id_jenis_asn: id_jenis_asn,
                        nama: nama,
                        deskripsi: deskripsi,
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_jenis_asn.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_jenis_asn').modal('hide');
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

    //edit Jenis ASN
    $(document).on('click', '.btn-edit', function() {
        let id_jenis_asn = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Jenis ASN");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('master_jenis_asn/get_jenis_asn_by_id'); ?>",
            data: {
                id: id_jenis_asn,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id-jenis_asn', response.id_jenis_asn);
                $("#nama").val(response.nama);
                $("#deskripsi").val(response.deskripsi);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus Jenis ASN
    $(document).on('click', '.btn-hapus', function() {
        let id_jenis_asn = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('master_jenis_asn/hapus'); ?>",
                        data: {
                            id_jenis_asn: id_jenis_asn
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_jenis_asn.ajax.reload();
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

    $('#modal_tambah_jenis_asn').on('hidden.bs.modal', function() {
        // $(".table-coverage").show();
    });

    reset_form = () => {
        $("#nama").val('');
        $("#deskripsi").val('');
    }
</script>