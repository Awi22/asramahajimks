<script>
    $(document).ready(function() {
        //vars
        is_update = false;
        is_copy = false;

        tgl_awal();
        tgl_akhir();

        table_kinerja_karyawan = $("#table_kinerja_karyawan").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('karyawan_daftar_kinerja/get') ?>",
                data: function(data) {
                    data.tgl_awal = $("#tgl_awal").val();
                    data.tgl_akhir = $("#tgl_akhir").val();
                }
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "tanggal",
                },
                {
                    data: "nama",
                },
                {
                    data: "ranah_kerja",
                },
                {
                    data: "uraian_pekerjaan",
                },
                {
                    data: "kendala",
                },
                {
                    data: "absensi",
                },
                {
                    data: "id",
                    searchable: false,
                    orderable: false,
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_kinerja_karyawan" title="Edit Kinerja">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Kinerja">
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
        });; //table_kinerja_karyawan

        $("#tgl_awal").on('change', function() {
            validasi_date_picker();
            table_kinerja_karyawan.ajax.reload(null, false);
        });

        $("#tgl_akhir").on('change', function() {
            validasi_date_picker();
            table_kinerja_karyawan.ajax.reload(null, false);
        });

        $("#tgl_kinerja").daterangepicker({
            singleDatePicker: true,
            minYear: 2024,
            autoApply: true,
            startDate: moment(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

    }); //ready

    // klik tombol tambah
    $('.btn-tambah').click(function() {
        is_update = false;
        is_copy = false;

        $(".judul-modal").text("Tambah Kinerja");
        reset_form();
    })

    // simpan kinerja
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let id = null,
            kode_karyawan = $("#kode_karyawan").val(),
            nama_karyawan = $("#nama_karyawan").val(),
            tgl_kinerja = $("#tgl_kinerja").val(),
            ranah_kerja = $("#ranah_kerja").val(),
            uraian = $("#uraian_pekerjaan").val(),
            kendala = $("#kendala").val(),
            absensi = $("#absensi").val(),
            the_url = "<?= site_url('karyawan_daftar_kinerja/simpan'); ?>";

        if (is_update) {
            id = $('#btn-simpan').data('id');
            the_url = "<?= site_url('karyawan_daftar_kinerja/update'); ?>";
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

        if (tgl_kinerja.length == 0 || tgl_kinerja == '') {
            pesan('warning', 'Tanggal tidak boleh kosong!');
            $("#tgl_kinerja").focus();
            return false;
        }

        if (ranah_kerja.length == 0 || ranah_kerja == '') {
            pesan('warning', 'Ranah kerja tidak boleh kosong!');
            $("#ranah_kerja").focus();
            return false;
        }

        if (uraian.length == 0 || uraian == '') {
            pesan('warning', 'Uraian pekerjaan tidak boleh kosong!');
            $("#uraian_pekerjaan").focus();
            return false;
        }

        konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: the_url,
                    data: {
                        id: id,
                        kode_karyawan: kode_karyawan,
                        nama_karyawan: nama_karyawan,
                        tgl_kinerja: tgl_kinerja,
                        ranah_kerja: ranah_kerja,
                        uraian: uraian,
                        kendala: kendala,
                        absensi: absensi,
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            table_kinerja_karyawan.ajax.reload();
                            reset_form();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $('#modal_tambah_kinerja_karyawan').modal('hide');
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

    //edit kinerja
    $(document).on('click', '.btn-edit', function() {
        let id_kinerja = $(this).data('id');
        is_update = true;
        is_copy = false;

        $(".judul-modal").text("Edit Kinerja");

        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('karyawan_daftar_kinerja/get_by_id'); ?>",
            data: {
                id: id_kinerja,
            },
            success: function(response) {
                //fill data to form
                $("#btn-simpan").data('id', response.id_kinerja);
                $("#kode_karyawan").val(response.kode_karyawan);
                $("#nama_karyawan").val(response.nama_karyawan);
                $("#tgl_kinerja").val(response.tanggal);
                $("#ranah_kerja").val(response.ranah_kerja);
                $("#uraian_pekerjaan").val(response.uraian);
                $("#kendala").val(response.kendala);
                $("#absensi").val(response.absensi);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    });

    //hapus kinerja
    $(document).on('click', '.btn-hapus', function() {
        let id_kinerja = $(this).data('id');
        konfirmasi('Anda yakin ingin menghapus data ini?')
            .then(function(e) {
                if (e.value) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('karyawan_daftar_kinerja/hapus'); ?>",
                        data: {
                            id: id_kinerja
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.status) {
                                peringatan("Sukses", response.pesan, 'success', 1500)
                                    .then(function() {
                                        table_kinerja_karyawan.ajax.reload();
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

    reset_form = () => {
        $("#kode_karyawan").val(get_KodeKaryawan());
        $("#nama_karyawan").val(get_NamaKaryawan());
        $("#tgl_kinerja").daterangepicker({
            singleDatePicker: true,
            minYear: 2024,
            autoApply: true,
            startDate: moment(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
        $("#ranah_kerja").val('');
        $("#uraian_pekerjaan").val('');
        $("#kendala").val('');
        $("#absensi").val('');
    }

    // tgl_awal
    function tgl_awal() {
        $("#tgl_awal").daterangepicker({
            singleDatePicker: true,
            minYear: 2024,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            startDate: moment().startOf('month'),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    }

    // tgl_akhir
    function tgl_akhir() {
        $("#tgl_akhir").daterangepicker({
            singleDatePicker: true,
            minYear: 2024,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            startDate: moment(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    }

    function string_to_date(v_tanggal) {
        let tgls = v_tanggal.split("-");
        return (new Date(tgls[2], (tgls[1] - 1), tgls[0]))
    }

    //* validasi date picker
    function validasi_date_picker() {
        var tgl_awal = string_to_date($("#tgl_awal").data('daterangepicker').startDate.format('DD-MM-YYYY'));
        var tgl_akhir = string_to_date($("#tgl_akhir").data('daterangepicker').startDate.format('DD-MM-YYYY'));

        if (tgl_awal.length == 0) {
            pesan('warning', 'Tanggal awal tidak boleh kosong');
            $('#tgl_awal').focus();
            return false;
        }
        if (tgl_akhir.length == 0) {
            pesan('warning', 'Tanggal akhir tidak boleh kosong');
            $("#tgl_akhir").focus();
            return false;
        }
        if (tgl_awal > tgl_akhir) {
            pesan('warning', 'Tanggal awal tidak boleh lebih besar dari akhir');
            // $('#masa-berlaku-awal').val($("#masa-berlaku-akhir").val());
            $('#tgl_awal').focus();
            return false;
        }
    }

    function get_KodeKaryawan() {
        $.ajax({
            url: "<?= site_url('karyawan_daftar_kinerja/get_KodeKaryawan'); ?>",
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

    function get_NamaKaryawan() {
        $.ajax({
            url: "<?= site_url('karyawan_daftar_kinerja/get_NamaKaryawan'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#nama_karyawan").val(response);
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi Kesalahan');
            }
        })
    }
</script>