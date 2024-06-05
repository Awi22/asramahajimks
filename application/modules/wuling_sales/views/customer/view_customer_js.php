<script>
    $(document).ready(function() {
        $("#tgl_suspect").flatpickr();
        $("#tgl_prospek").flatpickr();
        $("#tgl_hot_prospek").flatpickr();

        var arrBulan = [{
                id: 1,
                text: 'Januari',
            },
            {
                id: 2,
                text: 'Februari'
            },
            {
                id: 3,
                text: 'Maret'
            },
            {
                id: 4,
                text: 'April'
            },
            {
                id: 5,
                text: 'Mei'
            },
            {
                id: 6,
                text: 'Juni'
            },
            {
                id: 7,
                text: 'Juli'
            },
            {
                id: 8,
                text: 'Agustus'
            },
            {
                id: 9,
                text: 'September'
            },
            {
                id: 10,
                text: 'Oktober'
            },
            {
                id: 11,
                text: 'November'
            },
            {
                id: 12,
                text: 'Desember'
            },
        ];

        var d = new Date(),
            bulan = d.getMonth();

        $('#kebutuhan_prospek').select2({
            placeholder: 'Pilih Kebutuhan',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            data: [{
                    "id": "1",
                    "text": "Bulan ini",
                },
                {
                    "id": "2",
                    "text": "Bulan Depan",
                },
                {
                    "id": "3",
                    "text": " > 2 tapi < 6 bulan ",
                },
                {
                    "id": "4",
                    "text": "> 6 tapi < 12 bulan",
                },
                {
                    "id": "5",
                    "text": "> 12 bulan",
                },
            ]
        });

        $("#kebutuhan_bulan").select2({
            placeholder: 'Pilih Bulan',
            data: arrBulan,
            allowClear: true,
        }).val(bulan + 1).trigger('change');

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataCustomerProses",
            data: {
                id_prospek: $('#id_prospek').val(),
            },
            dataType: "json",
            success: function(data) {
                $('#nama_customer').val(data.nama_customer);
                $('#alamat').val(data.alamat_customer);
                $('#code_digital').val(data.id_cus_digital);
                $('#tgl_suspect').val(data.tgl_suspect);
                $('#kode_pos').val(data.kode_pos);
                $('#tlpn').val(data.telepone);
                $('#tgl_prospek').val(data.tgl_prospek);
                $('#mobil_dipakai').val(data.dipakai);
                $('#rute').val(data.rute);
                $('#jml_anggota').val(data.jml_keluarga);
                $('#decision_maker').val(data.decision);
                $('#kebutuhan_prospek').val(data.kebutuhan).trigger('change');
                $('#kebutuhan_bulan').val(data.bln).trigger('change');
                $('#tgl_hot_prospek').val(data.tgl_hot_prospek);
                $('#tdp').val(data.tdp);
                $('#cicilan').val(data.cicilan);

                var cb = data.cara_bayar;
                if (cb == 'k') {
                    $('#kredit_hot_prospek').prop('checked', true);
                }
                if (cb == 'c') {
                    $('#cash_hot_prospek').prop('checked', true);
                }
                getProvinsi(data.id_provinsi);
                getKabupaten(data.id_provinsi, data.id_kabupaten);
                getKacamatan(data.id_kabupaten, data.id_kecamatan);
                getKelurahan(data.id_kecamatan, data.id_kelurahan);
                getUnit(data.kode_unit);
                getSumberProspek(data.id_sumber_prospek);
                getMediaMotivator(data.id_media);
            }
        });


        $('#tabel_fu_history').DataTable({
            processing: true,
            order: [],
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
            initComplete: function(settings, json) {
                $("#tabel_fu_history").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },
        });
    });

    function getProvinsi(id_provinsi) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataProvinsi",
            data: {
                id_provinsi: id_provinsi,
            },
            dataType: "json",
            success: function(data) {
                $('#provinsi').select2({
                    placeholder: "Pilih Provinsi",
                    data: data,
                    allowClear: true,
                }).on('change.select2', function() {
                    idProvinsi = $(this).val();
                    getKabupaten(idProvinsi, null);

                    $("#kabupaten").empty();
                    $("#kabupaten").append('<option></option>');
                    $("#kabupaten").select2({
                        placeholder: "Pilih Kabupaten",
                    });

                    $("#kecamatan").empty();
                    $("#kecamatan").append('<option></option>');
                    $("#kecamatan").select2({
                        placeholder: "Pilih Kecamatan",
                    });

                    $("#kelurahan").empty();
                    $("#kelurahan").append('<option></option>');
                    $("#kelurahan").select2({
                        placeholder: "Pilih Kelurahan",
                    });
                });

            }
        });
    }

    function getKabupaten(id_provinsi, id_kabupaten) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataKabupaten",
            data: {
                id_provinsi: id_provinsi,
                id_kabupaten: id_kabupaten,
            },
            dataType: "json",
            success: function(data) {
                $('#kabupaten').select2({
                    placeholder: "Pilih Kabupaten",
                    data: data,
                    allowClear: true,

                }).on('change.select2', function() {
                    idKabupaten = $(this).val();
                    getKacamatan(idKabupaten, null);

                    $("#kecamatan").empty();
                    $("#kecamatan").append('<option></option>');
                    $("#kecamatan").select2({
                        placeholder: "Pilih Kecamatan",
                    });

                    $("#kelurahan").empty();
                    $("#kelurahan").append('<option></option>');
                    $("#kelurahan").select2({
                        placeholder: "Pilih Kelurahan",
                    });

                });
            }
        });
    }

    function getKacamatan(id_kabupaten, id_kecamatan) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataKecamatan",
            data: {
                id_kabupaten: id_kabupaten,
                id_kecamatan: id_kecamatan,
            },
            dataType: "json",
            success: function(data) {
                $('#kecamatan').select2({
                    placeholder: "Pilih Kecamatan",
                    data: data,
                    allowClear: true,

                }).on('change.select2', function() {
                    idKecamatan = $(this).val();
                    getKelurahan(idKecamatan, null);

                    $("#kelurahan").empty();
                    $("#kelurahan").append('<option></option>');
                    $("#kelurahan").select2({
                        placeholder: "Pilih Kelurahan",
                    });

                });
            }
        });
    }

    function getKelurahan(id_kecamatan, id_kelurahan) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataKelurahan",
            data: {
                id_kecamatan: id_kecamatan,
                id_kelurahan: id_kelurahan,
            },
            dataType: "json",
            success: function(data) {
                $('#kelurahan').select2({
                    placeholder: "Pilih Kelurahan",
                    data: data,
                    allowClear: true,

                });
            }
        });
    }

    function getUnit(kode_unit) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataUnit",
            data: {
                kode_unit: kode_unit,
            },
            dataType: "json",
            success: function(data) {
                $('#opt_model_diminati').select2({
                    placeholder: "Pilih Unit",
                    data: data,
                    allowClear: true,
                });


            }
        });
    }

    function getSumberProspek(id_sumber_prospek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataSumberProspek",
            data: {
                id_sumber_prospek: id_sumber_prospek,
            },
            dataType: "json",
            success: function(data) {
                $('#opt_sumber_prospek').select2({
                    placeholder: "Pilih Sumber Prospek",
                    data: data,
                    allowClear: true,
                }).on('change.select2', function() {
                    idSumberProspek = $(this).val();
                });
            }
        });

    }

    function getMediaMotivator(id_media) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_getDataMediaMotivaor",
            data: {
                id_media: id_media,
            },
            dataType: "json",
            success: function(data) {
                $('#opt_media_motivator').select2({
                    placeholder: "Pilih Media Motivator",
                    data: data,
                    allowClear: true,
                });
            }
        });
    }

    $(document).on('click', '#btn_simpan', function() {
        formEdit = $('#form_edit').serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_profil_customer_view_edit_editCustomerProspek",
            data: formEdit,
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success", 1500)
                        .then(function() {
                            location.reload();
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_simpan").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    })
</script>