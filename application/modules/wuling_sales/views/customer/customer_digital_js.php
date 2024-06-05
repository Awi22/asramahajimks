<script>
    $(document).ready(function() {

        $("#tgl_suspect_tambah").flatpickr();
        $("#kunjungan_berikut_tambah").flatpickr();

        TableCustomerDigital = $('#table_customer_digital').DataTable({
            processing: true,
            // order: [],
            // autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_customer_dgital/getDataCsutomerDigital",
                // data: function(data) {
                //     data.id_varian = $("#opt_varian").val();

                // },
            },
            language: {
                "processing": "Memproses, silahkan tunggu..."
            },
            columns: [{
                    data: "no",
                    title: "No",
                    className: "center"
                },
                {
                    data: "id_customer_digital",
                    title: "Kode Customer",
                    className: "center",
                },
                {
                    data: "customer",
                    title: "Customer",
                },
                {
                    data: "alamat",
                    title: "Alamat",
                    className: "center",
                },
                {
                    data: "tlpn",
                    title: "No Telepon",
                    className: "center",
                },
                {
                    data: "kota",
                    title: "Kota",
                    className: "center",
                },
                {
                    data: "dealer",
                    title: "Dealer",
                    className: "center",
                },
                {
                    data: "pekerjaan",
                    title: "Pekerjaan",
                    className: "center",
                },
                {
                    data: "type_mobil",
                    title: "Mobil dminati",
                    className: "center",
                },
                {
                    data: "brand_lain",
                    title: "Brand Lain",
                    className: "center",
                },
                {
                    data: 'status',
                    title: "Status",
                    className: "center",
                },
                {
                    data: null,
                    title: "Aksi",
                    orderable: false,
                    render: function(data, type, full, meta) {

                        return `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-tambah" data-id_customer_digital="${full.id_customer_digital}"  data-customer="${full.customer}" data-alamat="${full.alamat}" data-tlpn="${full.tlpn}" title="Tambah Customer">
									<i class="bi bi-pencil fs-3"></i>
								</button>
								</td>`;
                    },
                    className: "center"
                },
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
            initComplete: function(settings, json) {
                $("#table_customer_digital").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });
    });



    $(document).on('click', '.btn-tambah', function() {
        $('#modal_tambah_customer').modal('show');
        id_customer_digital = $(this).data('id_customer_digital');
        customer = $(this).data('customer');
        alamat = $(this).data('alamat');
        tlpn = $(this).data('tlpn');

        $('#digital_customer').val(id_customer_digital);
        $('#nama_customer').val(customer);
        $('#alamat_customer').val(alamat);
        $('#tlpn').val(tlpn);

        getProvinsi(null);
        getSumberProspek(null);
        getUnit(null);
    });

    function getProvinsi(id_provinsi) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataProvinsi",
            data: {
                id_provinsi: id_provinsi,
            },
            dataType: "json",
            success: function(data) {
                $('.provinsi').select2({
                    placeholder: "Pilih Provinsi",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_tambah_customer'),
                }).on('change.select2', function() {
                    idProvinsi = $(this).val();
                    getKabupaten(idProvinsi, null);

                    $(".kabupaten").empty();
                    $(".kabupaten").append('<option></option>');
                    $(".kabupaten").select2({
                        placeholder: "Pilih Kabupaten",
                    });

                    $(".kecamatan").empty();
                    $(".kecamatan").append('<option></option>');
                    $(".kecamatan").select2({
                        placeholder: "Pilih Kecamatan",
                    });

                    $(".kelurahan").empty();
                    $(".kelurahan").append('<option></option>');
                    $(".kelurahan").select2({
                        placeholder: "Pilih Kelurahan",
                    });
                });

                $('#opt_provinsi_suspect').select2({
                    placeholder: "Pilih Provinsi",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                }).on('change.select2', function() {
                    idProvinsi = $(this).val();
                    getKabupaten(idProvinsi, null);

                    $("#opt_kabupaten_suspect").empty();
                    $("#opt_kabupaten_suspect").append('<option></option>');
                    $("#opt_kabupaten_suspect").select2({
                        placeholder: "Pilih Kabupaten",
                    });

                    $("#opt_kecamatan_suspect").empty();
                    $("#opt_kecamatan_suspect").append('<option></option>');
                    $("#opt_kecamatan_suspect").select2({
                        placeholder: "Pilih Kecamatan",
                    });

                    $("#opt_kelurahan_suspect").empty();
                    $("#opt_kelurahan_suspect").append('<option></option>');
                    $("#opt_kelurahan_suspect").select2({
                        placeholder: "Pilih Kelurahan",
                    });
                });

                $(".kabupaten").empty();
                $(".kabupaten").append('<option></option>');
                $(".kabupaten").select2({
                    placeholder: "Pilih Kabupaten",
                });

                $(".kecamatan").empty();
                $(".kecamatan").append('<option></option>');
                $(".kecamatan").select2({
                    placeholder: "Pilih Kecamatan",
                });

                $(".kelurahan").empty();
                $(".kelurahan").append('<option></option>');
                $(".kelurahan").select2({
                    placeholder: "Pilih Kelurahan",
                });
            }
        });
    }

    function getKabupaten(id_provinsi, id_kabupaten) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataKabupaten",
            data: {
                id_provinsi: id_provinsi,
                id_kabupaten: id_kabupaten,
            },
            dataType: "json",
            success: function(data) {
                $('.kabupaten').select2({
                    placeholder: "Pilih Kabupaten",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_tambah_customer'),
                }).on('change.select2', function() {
                    idKabupaten = $(this).val();
                    getKacamatan(idKabupaten, null);

                    $(".kecamatan").empty();
                    $(".kecamatan").append('<option></option>');
                    $(".kecamatan").select2({
                        placeholder: "Pilih Kecamatan",
                    });

                    $(".kelurahan").empty();
                    $(".kelurahan").append('<option></option>');
                    $(".kelurahan").select2({
                        placeholder: "Pilih Kelurahan",
                    });

                });

                $('#opt_kabupaten_suspect').select2({
                    placeholder: "Pilih Kabupaten",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                }).on('change.select2', function() {
                    idKabupaten = $(this).val();
                    getKacamatan(idKabupaten, null);

                    $("#opt_kecamatan_suspect").empty();
                    $("#opt_kecamatan_suspect").append('<option></option>');
                    $("#opt_kecamatan_suspect").select2({
                        placeholder: "Pilih Kecamatan",
                    });

                    $("#opt_kelurahan_suspect").empty();
                    $("#opt_kelurahan_suspect").append('<option></option>');
                    $("#opt_kelurahan_suspect").select2({
                        placeholder: "Pilih Kelurahan",
                    });

                });


                $(".kecamatan").empty();
                $(".kecamatan").append('<option></option>');
                $(".kecamatan").select2({
                    placeholder: "Pilih Kecamatan",
                });

                $(".kelurahan").empty();
                $(".kelurahan").append('<option></option>');
                $(".kelurahan").select2({
                    placeholder: "Pilih Kelurahan",
                });
            }
        });
    }

    function getKacamatan(id_kabupaten, id_kecamatan) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataKecamatan",
            data: {
                id_kabupaten: id_kabupaten,
                id_kecamatan: id_kecamatan,
            },
            dataType: "json",
            success: function(data) {
                $('.kecamatan').select2({
                    placeholder: "Pilih Kecamatan",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_tambah_customer'),
                }).on('change.select2', function() {
                    idKecamatan = $(this).val();
                    getKelurahan(idKecamatan, null);

                    $(".kelurahan").empty();
                    $(".kelurahan").append('<option></option>');
                    $(".kelurahan").select2({
                        placeholder: "Pilih Kelurahan",
                    });

                });

                $('#opt_kecamatan_suspect').select2({
                    placeholder: "Pilih Kecamatan",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                }).on('change.select2', function() {
                    idKecamatan = $(this).val();
                    getKelurahan(idKecamatan, null);

                    $("#opt_kelurahan_suspect").empty();
                    $("#opt_kelurahan_suspect").append('<option></option>');
                    $("#opt_kelurahan_suspect").select2({
                        placeholder: "Pilih Kelurahan",
                    });

                });

                $(".kelurahan").empty();
                $(".kelurahan").append('<option></option>');
                $(".kelurahan").select2({
                    placeholder: "Pilih Kelurahan",
                });
            }
        });
    }

    function getKelurahan(id_kecamatan, id_kelurahan) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataKelurahan",
            data: {
                id_kecamatan: id_kecamatan,
                id_kelurahan: id_kelurahan,
            },
            dataType: "json",
            success: function(data) {
                $('.kelurahan').select2({
                    placeholder: "Pilih Kelurahan",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_tambah_customer'),
                });

                $('#opt_kelurahan_suspect').select2({
                    placeholder: "Pilih Kelurahan",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });
            }
        });
    }

    function getUnit(kode_unit) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataUnit",
            data: {
                kode_unit: kode_unit,
            },
            dataType: "json",
            success: function(data) {
                $('#opt_model_diminati').select2({
                    placeholder: "Pilih Unit",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_tambah_customer'),
                });

                $('#opt_model_diminati_suspect').select2({
                    placeholder: "Pilih Unit",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });
            }
        });
    }

    function getSumberProspek(id_sumber_prospek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataSumberProspek",
            data: {
                id_sumber_prospek: id_sumber_prospek,
            },
            dataType: "json",
            success: function(data) {
                $('#opt_sumber_prospek').select2({
                    placeholder: "Pilih Sumber Prospek",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_tambah_customer'),
                }).on('change.select2', function() {
                    idSumberProspek = $(this).val();
                    getShowHideSumberProspek(idSumberProspek);
                    getAktivitas(idSumberProspek)
                });

                $('#opt_sumber_prospek_suspect').select2({
                    placeholder: "Pilih Sumber Prospek",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                }).on('change', function() {
                    idSumberProspek = $(this).val();
                    getShowHideSumberProspekSuspect(idSumberProspek);
                });
            }
        });
    }

    function getAktivitas(id_sumber_prospek) {
        $.ajax({
            type: "method",
            url: "<?= base_url() ?>sales_pofil_customer/getDataAktivitas",
            data: {
                id_sumber_prospek: id_sumber_prospek,
            },
            dataType: "json",
            success: function(response) {

            }
        });
    }
    $(document).on('click', '#btn_simpan_customer', function() {
        var dataCusomer = $('#add_customer').serialize();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanDataCustomer",
            data: dataCusomer,
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
                $('#modal_tambah_customer').modal('hide');
                $("#btn_simpan_customer").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_customer").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    })

    function getShowHideSumberProspek(id_sumber) {
        if (id_sumber == '2' || id_sumber == '5' || id_sumber == '6') {
            $('#form_aktivitas').show();
            $('#form_egent').hide();
            $('#form_sales_digital').hide();
            $('#form_stnk_norak').hide();
            $('#form_walk').hide();
            $('#form_referensi').hide();
        } else if (id_sumber == '8') {
            $('#form_egent').show();
            $('#form_aktivitas').hide();
            $('#form_sales_digital').hide();
            $('#form_stnk_norak').hide();
            $('#form_walk').hide();
            $('#form_referensi').hide();
        } else if (id_sumber == '15') {
            $('#form_sales_digital').show();
            $('#form_aktivitas').hide();
            $('#form_egent').hide();
            $('#form_stnk_norak').hide();
            $('#form_walk').hide();
            $('#form_referensi').hide();
        } else if (id_sumber == '26') {
            $('#form_stnk_norak').show();
            $('#form_aktivitas').hide();
            $('#form_egent').hide();
            $('#form_sales_digital').hide();
            $('#form_walk').hide();
            $('#form_referensi').hide();
        } else if (id_sumber == '31' || id_sumber == '32') {
            $('#form_walk').show();
            $('#form_aktivitas').hide();
            $('#form_egent').hide();
            $('#form_sales_digital').hide();
            $('#form_stnk_norak').hide();
            $('#form_referensi').hide();
        } else if (id_sumber == '33') {
            $('#form_referensi').show();
            $('#form_aktivitas').hide();
            $('#form_egent').hide();
            $('#form_sales_digital').hide();
            $('#form_stnk_norak').hide();
            $('#form_walk').hide();
        } else {
            $('#form_aktivitas').hide();
            $('#form_egent').hide();
            $('#form_sales_digital').hide();
            $('#form_stnk_norak').hide();
            $('#form_walk').hide();
            $('#form_referensi').hide();
        }
    }
</script>