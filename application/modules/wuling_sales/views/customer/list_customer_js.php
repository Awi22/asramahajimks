<script>
    $(document).ready(function() {

        $("#tgl_suspect_tambah").flatpickr();
        $("#kunjungan_berikut_tambah").flatpickr();
        $("#kunjungan_berikut_suspect").flatpickr();
        $("#tgl_selanjutnya_fu").flatpickr();
        $("#kunjungan_berikut_prospek").flatpickr();
        $("#kungjungan_berikut_hot_prospek").flatpickr();
        $("#tgl_aktivitas").flatpickr();
        $("#tgl_walk_in").flatpickr();

        $("#tgl_test_drive").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

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
            bulan = d.getMonth(),
            tahun = d.getFullYear();
        var curTahun = new Date().getFullYear();
        var arrTahun = [];
        for (var i = curTahun; i >= 2018; i--) {
            let j = {
                "id": i,
                "text": i
            };
            arrTahun.push(j);
        }

        $("#opt_bulan").select2({
            data: arrBulan,
        }).val(bulan + 1).trigger('change').on('change.select2', function() {
            TableCustomer.ajax.reload();
        });;

        $("#opt_tahun").select2({
            data: arrTahun,
        }).val(tahun).trigger('change').on('change.select2', function() {
            TableCustomer.ajax.reload();
        });;

        $('#opt_status').select2({
            placeholder: 'Pilih Status',
            allowClear: true,
            data: [{
                    "id": "suspect",
                    "text": "Suspect",
                },
                {
                    "id": "prospek",
                    "text": "Prospek",
                },
                {
                    "id": "hot prospek",
                    "text": "Hot Prospek",
                },
                {
                    "id": "spk",
                    "text": "SPK",
                },
                {
                    "id": "do",
                    "text": "DO",
                },
            ]
        }).on('change', function() {
            TableCustomer.ajax.reload();
        });

        $('#opt_source').on('change', function() {
            TableCustomer.ajax.reload();
        });

        $('#opt_sumber_prospek_survai').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });

        $('#opt_telp_valid').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });

        $('#opt_promo_product').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });

        $('#opt_info_dokumen').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });


        $.fn.dataTable.ext.errMode = 'none';
        TableCustomer = $('#table_customer').DataTable({
            processing: true,
            order: [],
            autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_pofil_customer/getDataCustomer",
                data: function(data) {
                    data.tahun = $("#opt_tahun").val();
                    data.bulan = $("#opt_bulan").val();
                    data.status = $("#opt_status").val();
                    data.source = $("#opt_source").val();
                },
            },
            language: {
                "processing": "Memproses, silahkan tunggu..."
            },
            columns: [{
                    data: "id_prospek",
                    title: "ID Prospek",
                    className: "center"
                },
                {
                    data: "tgl_suspect",
                    title: "Tgl Suspect",
                    className: "center",
                },
                {
                    data: "tgl_kunjungan",
                    title: "Tgl Kunjungan",
                    className: "center",
                },
                {
                    data: "nama",
                    title: "Nama Customer",
                },
                {
                    data: "tlpn",
                    title: "Phone",
                    className: "center",
                },
                {
                    data: "status",
                    title: "Status",
                    className: "center",
                },
                {
                    data: "status_customer",
                    title: "Source Customer",
                    className: "center",
                },
                {
                    data: null,
                    title: "Aksi",
                    orderable: false,
                    render: function(data, type, full, meta) {

                        var gembok = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id_prospek="${full.id_prospek}" data-status="${full.status}"  title="Edit Customer">
									<i class="bi bi-pencil fs-3"></i>
								</button>
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-view"  data-id_prospek="${full.id_prospek}" data-status="${full.status}" title="View Cutomer">
									<i class="bi bi-eye fs-3"></i>
								</button>
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-reset" data-id_prospek="${full.id_prospek}" data-status="${full.status}" title="Edit Customer">
								  	<i class="bi bi-copy fs-3"></i>
								</button>
								</td>`
                        return gembok;

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
                $("#table_customer").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });



        //** For Data Suspect */
        $('#modal_suspect').on('hidden.bs.modal', function(e) {
            location.reload();
        });

        $('#kebutuhan_wsa').select2({
            placeholder: 'Pilih Kebutuhan',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modal_suspect'),
            data: [{
                    "id": "0-3 Months",
                    "text": "0-3 Months",
                },
                {
                    "id": "3-6 Months",
                    "text": "3-6 Months",
                },
                {
                    "id": "6 Months",
                    "text": "6 Months",
                },

            ]
        });

        $('#penawaran_harga_wsa').select2({
            placeholder: 'Pilih Penawaran Harga',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modal_suspect'),
            data: [{
                    "id": "Yes",
                    "text": "Ya",
                },
                {
                    "id": "No",
                    "text": "Tidak",
                },
            ]
        });

        $('#opt_fu_survai').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modal_suspect'),
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });

        $('#opt_test_drive_survai').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modal_suspect'),
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });

        $('#opt_fitur_survai').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modal_suspect'),
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });

        $('#opt_estimasi_survai').select2({
            placeholder: '-',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modal_suspect'),
            data: [{
                    "id": "y",
                    "text": "Ya",
                },
                {
                    "id": "n",
                    "text": "Tidak",
                },
            ]
        });

        //** For Folloup WSA */
        $('#buy_plan_fu').select2({
            placeholder: 'Pilih Buy Plan',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            dropdownParent: $('#modal_fu'),
            data: [{
                    "id": "0-3 Months",
                    "text": "0-3 Months",
                },
                {
                    "id": "3-6 Months",
                    "text": "3-6 Months",
                },
                {
                    "id": ">6 Months",
                    "text": ">6 Months",
                },

            ]
        });

        //** For Test Drive */
        $('#tempat_test_drive').select2({
            placeholder: 'Pilih tempat test drive',
            allowClear: true,
            minimumResultsForSearch: Infinity,
            data: [{
                    "id": "d",
                    "text": "Dealer",
                },
                {
                    "id": "r",
                    "text": "Rumah Customer",
                },
                {
                    "id": "k",
                    "text": "Kantor",
                },
                {
                    "id": "p",
                    "text": "Area Public",
                },
                {
                    "id": "l",
                    "text": "Lain - lain",
                },
            ]
        });

        //** For Prospek */
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


        //** For SPK */

        $('#pengajuan_diskon').keyup(function(e) {
            $(this).val(formatRupiah($(this).val()));
        });

        $('#tanda_jadi').keyup(function(e) {
            $(this).val(formatRupiah($(this).val()));
        });

    });


    $(document).on('click', '.btn-edit', function() {
        var id_prospek = $(this).data('id_prospek')
        status = $(this).data('status')
        switch (status) {
            case 'Suspect':
                $('#modal_suspect').modal('show');
                getSuspect(id_prospek);
                break;
            case 'Prospek':
                $('#modal_prospek').modal('show');
                getProspek(id_prospek);
                break;
            case 'Hot prospek':
                $('#modal_hot_prospek').modal('show');
                getHotProspek(id_prospek);
                break;
            case 'Spk':
                $('#modal_suspect').modal('show');
                getSuspect(id_prospek);
                // getSpk(id_prospek);
                break;
            case 'Do':
                peringatan("Error", "Maaf data sudah DO", "error")
                    .then(function() {
                        location.reload()
                    })
                break;
        }
    })

    $(document).on('click', '.btn-tambah', function() {
        getProvinsi(null);
        getSumberProspek(null);
        getUnit(null);
    });

    $(document).on('click', '.btn-reset', function() {
        var id_prospek = $(this).data('id_prospek')
        status = $(this).data('status')

        if (status == 'Hot prospek' || status == 'Spk') {
            location.replace('<?= base_url() ?>sales_profil_customer_view_edit/' + id_prospek);

        } else {
            peringatan("Error", "Data dengan ID Prospek " + id_prospek + "  Hanya bisa edit pada tahapan Hot Prospect", "error")
                .then(function() {
                    location.reload()
                })
        }
    })

    $(document).on('click', '.btn-view', function() {
        var id_prospek = $(this).data('id_prospek')
        status = $(this).data('status')
        location.replace('<?= base_url() ?>sales_profil_customer_view_edit_view/' + id_prospek);

    })

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

                $('#model_minat_wsa').select2({
                    placeholder: "Pilih Unit",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });

                $('#opt_model_diminati_prospek').select2({
                    placeholder: "Pilih Unit",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_prospek'),
                }).on('change.select2', function() {
                    kodeUnit = $(this).val();
                    cekStokUnit(kodeUnit, null);
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
                    $("#opt_aktivitas").empty();
                    $("#opt_aktivitas").append('<option></option>');
                    $("#opt_aktivitas").select2({
                        placeholder: "Pilih Aktivitas",
                    });
                    getAktivitas(idSumberProspek, null, null)
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

                $("#tgl_aktivitas").val('');
                $("#opt_aktivitas").empty();
                $("#opt_aktivitas").append('<option></option>');
                $("#opt_aktivitas").select2({
                    placeholder: "Pilih Aktivitas",
                });
            }
        });
    }

    $(document).on('change', '#tgl_aktivitas', function() {
        tgl_aktivitas = $('#tgl_aktivitas').val();
        idSumberProspek = $('#opt_sumber_prospek').val();
        $("#opt_aktivitas").empty();
        $("#opt_aktivitas").append('<option></option>');
        $("#opt_aktivitas").select2({
            placeholder: "Pilih Aktivitas",
        });
        getAktivitas(idSumberProspek, tgl_aktivitas, null)
    });

    function getAktivitas(id_sumber_prospek, tgl_aktivitas, id_aktivitas) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataAktivitas",
            data: {
                id_sumber_prospek: id_sumber_prospek,
                tgl_aktivitas: tgl_aktivitas,
                id_aktivitas: id_aktivitas,
            },
            dataType: "json",
            success: function(data) {
                $('#opt_aktivitas').select2({
                    placeholder: "Pilih Aktivitas",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_tambah_customer'),
                });

                $('#opt_aktivitas_suspect').select2({
                    placeholder: "Pilih Aktivitas",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });

            }
        });
    }
    $(document).on('click', '#btn_simpan_customer', function() {
        $('#modal_survai_proses').modal('show');
    })

    $(document).on('click', '#btn_simpan_survai_proses', function() {
        var dataCusomer = $('#add_customer').serialize();
        var dataSurvaiProses = $('#add_survai_proses').serialize();

        //** Data Customer */
        var customer = new URLSearchParams(dataCusomer);
        var formDataCusomer = Object.fromEntries(customer.entries());

        //** Data Survai Proses */
        var survai = new URLSearchParams(dataSurvaiProses);
        var formDataSurvaiProses = Object.fromEntries(survai.entries());

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanDataCustomer",
            data: {
                ...formDataCusomer,
                ...formDataSurvaiProses,
            },
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
                $("#btn_simpan_survai_proses").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_survai_proses").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    });

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



    //** Data Suspect */
    function getSuspect(id_prospek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataSuspect",
            data: {
                id_prospek: id_prospek
            },
            dataType: "json",
            success: function(data) {
                $('#id_prospek_suspect').val(data.id_prospek);
                $('.status_customer').val(data.status_suspect);
                $('#tgl_suspect').val(data.tgl_suspect);
                $('#customer_suspect').val(data.nama_customer);
                $('#alamat_suspect').val(data.alamat_customer);
                $('#kode_pos_suspect').val(data.kode_pos);
                $('#tlpn_suspect').val(data.telepone);
                $('#kunjungan_berikut_suspect').val(data.tgl_kunjungan);
                $('#ket_suspect').val(data.keterangan);
                $('#email_wsa').val(data.email);
                getProvinsi(data.id_provinsi);
                getKabupaten(data.id_provinsi, data.id_kabupaten);
                getKacamatan(data.id_kabupaten, data.id_kecamatan);
                getKelurahan(data.id_kecamatan, data.id_kelurahan);
                getUnit(data.kode_unit);
                getSumberProspek(data.id_sumber_prospek);
                getAktivitas(data.id_sumber_prospek, data.tgl_event, data.id_event);
                getShowHideSumberProspekSuspect(data.id_sumber_prospek);
                $('#tgl_aktivitas_suspect').val(data.tgl_event);
                $('#nama_agent_suspect').val(data.nama_agent);
                $('#tlpn_agent_suspect').val(data.telepon_agent);
                $('#opt_sales_digital_suspect').val('');
                $('#nama_stnk_sumber_suspect').val(data.nama_stnk);
                $('#norak_sumber_prospek_suspect').val(data.no_rangka_repeat_order);
                $('#norak_sumber_prospek_suspect').val();
                $('#tgl_walk_in_suspect').val(data.tgl_walk_in);
                $('#nama_refrensi_suspect').val(data.nama_refrensi);
                $('#tlpn_refrensi_suspect').val(data.tlpn_refrensi);
                getFormWsa(data.form_id);
                getOccupationsWsa(data.occupation_id);
                getCannelsWsa(data.channel_id);
                getNasonalEventWsa(data.national_event_id);
                getDealer(data.dealer_id);
                var jkl = data.jenis_kelamin;
                var cb = data.cara_bayar;
                if (jkl == 'Laki-Laki') {
                    $('#male_wsa').prop('checked', true);
                }
                if (jkl == 'Perempuan') {
                    $('#famale_wsa').prop('checked', true);
                }
                if (cb == 'k') {
                    $('#kredit').prop('checked', true);
                }
                if (cb == 'c') {
                    $('#cash').prop('checked', true);
                }
                $('#kebutuhan_wsa').val(data.plan_to_buy).trigger('change');
                $('#penawaran_harga_wsa').val(data.price_offering).trigger('change');
                $('#opt_fu_survai').val(data.respon_fu).trigger('change');
                $('#opt_test_drive_survai').val(data.test_drive).trigger('change');
                $('#opt_fitur_survai').val(data.fitur).trigger('change');
                $('#opt_estimasi_survai').val(data.estimasi).trigger('change');
            }
        });
    }

    function getShowHideSumberProspekSuspect(id_sumber) {
        if (id_sumber == '2' || id_sumber == '5' || id_sumber == '6') {
            $('#form_aktivitas_suspect').show();
            $('#form_egent_suspect').hide();
            $('#form_sales_digital_suspect').hide();
            $('#form_stnk_norak_suspect').hide();
            $('#form_walk_suspect').hide();
            $('#form_referensi_suspect').hide();
        } else if (id_sumber == '8') {
            $('#form_egent_suspect').show();
            $('#form_aktivitas_suspect').hide();
            $('#form_sales_digital_suspect').hide();
            $('#form_stnk_norak_suspect').hide();
            $('#form_walk_suspect').hide();
            $('#form_referensi_suspect').hide();
        } else if (id_sumber == '15') {
            $('#form_sales_digital_suspect').show();
            $('#form_aktivitas_suspect').hide();
            $('#form_egent_suspect').hide();
            $('#form_stnk_norak_suspect').hide();
            $('#form_walk_suspect').hide();
            $('#form_referensi_suspect').hide();
        } else if (id_sumber == '26') {
            $('#form_stnk_norak_suspect').show();
            $('#form_aktivitas_suspect').hide();
            $('#form_egent_suspect').hide();
            $('#form_sales_digital_suspect').hide();
            $('#form_walk_suspect').hide();
            $('#form_referensi_suspect').hide();
        } else if (id_sumber == '31' || id_sumber == '32') {
            $('#form_walk_suspect').show();
            $('#form_aktivitas_suspect').hide();
            $('#form_egent_suspect').hide();
            $('#form_sales_digital_suspect').hide();
            $('#form_stnk_norak_suspect').hide();
            $('#form_referensi_suspect').hide();
        } else if (id_sumber == '33') {
            $('#form_referensi_suspect').show();
            $('#form_aktivitas_suspect').hide();
            $('#form_egent_suspect').hide();
            $('#form_sales_digital_suspect').hide();
            $('#form_stnk_norak_suspect').hide();
            $('#form_walk_suspect').hide();
        } else {
            $('#form_aktivitas_suspect').hide();
            $('#form_egent_suspect').hide();
            $('#form_sales_digital_suspect').hide();
            $('#form_stnk_norak_suspect').hide();
            $('#form_walk_suspect').hide();
            $('#form_referensi_suspect').hide();
        }
    }


    $(document).on('click', '#btn_simpan_suspect', function() {
        $('#modal_fu').modal('show');
        id_prospek_suspect = $('#id_prospek_suspect').val();
        $('#id_prospek_fu').val(id_prospek_suspect);
        getStatusFu();
        getRemaksFu();
        getNextFu();

    })


    function getFormWsa(form_id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataFormWsa",
            data: {
                form_id: form_id,
            },
            dataType: "json",
            success: function(data) {
                $('#form_wsa').select2({
                    placeholder: "Pilih Form",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });
            }
        });
    }

    function getOccupationsWsa(occupation_id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getOccupationsWsa",
            data: {
                occupation_id: occupation_id,
            },
            dataType: "json",
            success: function(data) {
                $('#pekerjaan_wsa').select2({
                    placeholder: "Pilih Pekerjaan",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });
            }
        });
    }

    function getCannelsWsa(channel_id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getCannelsWsa",
            data: {
                channel_id: channel_id,
            },
            dataType: "json",
            success: function(data) {
                $('#chanel_wsa').select2({
                    placeholder: "Pilih Channel",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });
            }
        });
    }

    function getNasonalEventWsa(national_event_id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getNasonalEventWsa",
            data: {
                national_event_id: national_event_id,
            },
            dataType: "json",
            success: function(data) {
                $('#event_wsa').select2({
                    placeholder: "Pilih Nasional Event",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_suspect'),
                });
            }
        });
    }

    function getDealer(dealer_id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataDealer",
            data: {
                dealer_id: dealer_id
            },
            dataType: "json",
            success: function(data) {
                $('#cabang_sgwm_wsa').select2({
                    placeholder: "Pilih Cabang SGMW",
                    data: data,
                    allowClear: true,
                    minimumResultsForSearch: Infinity,
                    dropdownParent: $('#modal_suspect'),
                });
            }
        });
    }

    $(document).on('click', '#btn_lanjut_suspect', function() {
        id_prospek_suspect = $('#id_prospek_suspect').val();
        status_customer = 'suspect';
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanProsesLanjutTahapan",
            data: {
                id_prospek_suspect: id_prospek_suspect,
                status_customer: status_customer,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success", 1500)
                        .then(function() {
                            $('#modal_prospek').modal('show');
                            getProspek(id_prospek_suspect);
                            // $('#modal_suspect').modal('hide');
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_lanjut_suspect").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_lanjut_suspect").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });

    });
    //** Followup */

    $(document).on('click', '#btn_fu_suspect', function() {
        $('#modal_fu').modal('show');
        id_prospek_suspect = $('#id_prospek_suspect').val();
        $('#id_prospek_fu').val(id_prospek_suspect);
        getStatusFu();
        getRemaksFu();
        getNextFu();
    });

    $(document).on('click', '#btn_fu_prospek', function() {
        $('#modal_fu').modal('show');
        id_prospek_prospek = $('#id_prospek_prospek').val();
        $('#id_prospek_fu').val(id_prospek_prospek);
        getStatusFu();
        getRemaksFu();
        getNextFu();
    });

    $(document).on('click', '#btn_fu_hot_prospek', function() {
        $('#modal_fu').modal('show');
        id_prospek_hot_prospek = $('#id_prospek_hot_prospek').val();
        $('#id_prospek_fu').val(id_prospek_hot_prospek);
        getStatusFu();
        getRemaksFu();
        getNextFu();
    });

    $(document).on('click', '#btn_followup_spk', function() {
        $('#modal_fu').modal('show');
        id_prospek_spk = $('#id_prospek_spk').val();
        $('#id_prospek_fu').val(id_prospek_spk);
        getStatusFu();
        getRemaksFu();
        getNextFu();
    });

    function getStatusFu() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataStatusFu",
            dataType: "json",
            success: function(data) {
                $('#status_fu').select2({
                    placeholder: "Pilih Status Followup",
                    data: data,
                    allowClear: true,
                    minimumResultsForSearch: Infinity,
                    dropdownParent: $('#modal_fu'),
                }).on('change.select2', function() {
                    idStatusFu = $(this).val();
                    console.log(idStatusFu);
                    if (idStatusFu == '3' || idStatusFu == '5') {
                        $('#remaks_wsa').show();
                    } else {
                        $('#remaks_wsa').hide();

                    }
                });
            }
        });
    }

    function getRemaksFu() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataRemaksFu",
            dataType: "json",
            success: function(data) {
                $('#remaks_fu').select2({
                    placeholder: "Pilih Remaks",
                    data: data,
                    allowClear: true,
                    minimumResultsForSearch: Infinity,
                    dropdownParent: $('#modal_fu'),
                });
            }
        });
    }

    function getNextFu() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataNextFu",
            dataType: "json",
            success: function(data) {
                $('#next_fu').select2({
                    placeholder: "Pilih Next Followup",
                    data: data,
                    allowClear: true,
                    minimumResultsForSearch: Infinity,
                    dropdownParent: $('#modal_fu'),
                });
            }
        });
    }

    $(document).on('click', '#btn_simpan_fu', function() {
        fu = $('#form_data_followup').serialize();
        status_customer = $('.status_customer').val();
        if (status_customer == 'suspect') {

            suspect = $('#form_suspect').serialize();
            wsa = $('#form_data_wsa').serialize();

            idProspek = $('#id_prospek_suspect').val();

            //** Data Suspect */
            var dataSuspect = new URLSearchParams(suspect);
            var formDataSuspect = Object.fromEntries(dataSuspect.entries());

            //** Data Wsa */
            var dataWsa = new URLSearchParams(wsa);
            var formDataWsa = Object.fromEntries(dataWsa.entries());

            $.ajax({
                type: "POST",
                url: "<?= base_url() ?>sales_pofil_customer/simpanDataSuspect",
                data: {
                    ...formDataSuspect,
                    ...formDataWsa,
                },
                dataType: "json",
                success: function(data) {
                    if (data.status === true) {
                        peringatan("Sukses", data.pesan, "success", 1500)
                            .then(function() {
                                setWsa(idProspek, fu);
                            })
                    } else {
                        peringatan("Error", data.pesan, "error")
                            .then(function() {
                                location.reload();
                            })
                    }
                    $("#btn_simpan_fu").removeAttr("data-kt-indicator").prop("disabled", false)
                },
                beforeSend: function() {
                    $("#btn_simpan_fu").attr("data-kt-indicator", "on").prop("disabled", true)
                },
            });
        } else {
            idProspek = $('#id_prospek_prospek').val();
            idProspek = $('#id_prospek_hot_prospek').val();
            idProspek = $('#id_prospek_spk').val();
            setFu(idProspek, fu);
        }
    })

    function setWsa(idProspek, form_data_fu) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanDataWsa",
            data: {
                id_prospek: idProspek,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success")
                        .then(function() {
                            setFu(idProspek, form_data_fu);
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }


            },
            beforeSend: function() {
                $("#btn_simpan_fu").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    }

    function setFu(idProspek, form_data_fu) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanDataFolloup",
            data: form_data_fu,
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success")
                        .then(function() {
                            setFuWsa(data.id_prospek);
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
            }
        });
    }

    function setFuWsa(idProspek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanFollowupForWsa",
            data: {
                id_prospek_follow: idProspek
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success")
                        .then(function() {
                            location.reload();
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
            }
        });
    }

    //** Test Drive */

    $(document).on('click', '#btn_test_drive_suspect', function() {
        id_prospek = $('#id_prospek_suspect').val();

        $('#modal_test_drive').modal('hide');
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getCekDataProspekIdWsa",
            data: {
                id_prospek: id_prospek,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    $('#modal_test_drive').modal('show');
                    customer = $('#customer_suspect').val();
                    tlpn = $('#tlpn_suspect').val();
                    $('#id_prospek_test_drive').val(id_prospek);
                    $('#nama_test_drive').val(customer);
                    $('#no_hp_test_drive').val(tlpn);
                    getTypeUnit();
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_test_drive_suspect").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_test_drive_suspect").attr("data-kt-indicator", "on").prop("disabled", true)
            },

        });
    })

    $(document).on('click', '#btn_tes_drive_prosepk', function() {
        id_prospek = $('#id_prospek_prospek').val();
        $('#modal_test_drive').modal('hide');
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getCekDataProspekIdWsa",
            data: {
                id_prospek: id_prospek,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    $('#modal_test_drive').modal('show');
                    customer = $('#nama_prospek').val();
                    tlpn = $('#tlpn_suspect').val();
                    $('#id_prospek_test_drive').val(id_prospek);
                    $('#nama_test_drive').val(customer);
                    $('#no_hp_test_drive').val(tlpn);
                    getTypeUnit();
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_test_drive_suspect").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_test_drive_suspect").attr("data-kt-indicator", "on").prop("disabled", true)
            },

        });
    })

    $(document).on('click', '#btn_test_drive_hot_prospek', function() {
        id_prospek = $('#id_prospek_hot_prospek').val();
        $('#modal_test_drive').modal('hide');
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getCekDataProspekIdWsa",
            data: {
                id_prospek: id_prospek,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    $('#modal_test_drive').modal('show');
                    customer = $('#nama_hot_prospek').val();
                    tlpn = $('#tlpn_suspect').val();
                    $('#id_prospek_test_drive').val(id_prospek);
                    $('#nama_test_drive').val(customer);
                    $('#no_hp_test_drive').val(tlpn);
                    getTypeUnit();
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_test_drive_suspect").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_test_drive_suspect").attr("data-kt-indicator", "on").prop("disabled", true)
            },

        });
    })

    function getTypeUnit() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataType",
            // data: "data",
            dataType: "json",
            success: function(data) {
                $('#model_test_drive').select2({
                    placeholder: "Pilih Type Unit",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_test_drive'),
                }).on('change.select2', function() {
                    idType = $(this).val();
                    getVarianUnit(idType);

                    $("#varian_test_drive").empty();
                    $("#varian_test_drive").append('<option></option>');
                    $("#varian_test_drive").select2({
                        placeholder: "Pilih Varian Unit",
                    });

                });
            }
        });
    }

    function getVarianUnit(id_type) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataVarian",
            data: {
                id_type: id_type,
            },
            dataType: "json",
            success: function(data) {
                $('#varian_test_drive').select2({
                    placeholder: "Pilih Varian Unit",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_test_drive'),
                });
            }
        });
    }

    $(document).on('click', '#btn_simpan_test_drive', function() {
        testDrive = $('#form_test_drive').serialize();

        var dataTestDrive = new URLSearchParams(testDrive);
        var formTestDrive = Object.fromEntries(dataTestDrive.entries());

        status_customer = $('.status_customer').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanTestDrive",
            data: {
                ...formTestDrive,
                status_customer: status_customer,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success")
                        .then(function() {
                            setTestDrvieWsa(data.id_prospek);
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_simpan_test_drive").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_test_drive").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    });

    function setTestDrvieWsa(id_prospek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanTestDriveWsa",
            data: {
                id_prospek: id_prospek
            },
            dataType: "json",
            success: function(data) {
                if (data.success == true) {
                    peringatan("Sukses", data.message, "success", 1500)
                        .then(function() {
                            location.reload();
                        })
                } else {
                    peringatan("Error", data.message, "error")
                        .then(function() {
                            location.reload();
                        })
                }
            }
        });
    }


    //** Data Prospek */

    function getProspek(id_prospek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataProspek",
            data: {
                id_prospek: id_prospek,
            },
            dataType: "json",
            success: function(data) {
                var d = new Date(),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                if (data.tgl_prospek == null || data.tgl_prospek == '') {
                    $('#tgl_prospek').val([year, month, day].join('-'));
                } else {
                    $('#tgl_prospek').val(data.tgl_prospek);

                }
                $('#id_prospek_prospek').val(data.id_prospek);
                $('.status_customer').val(data.status_customer);
                $('#nama_prospek').val(data.nama_customer);
                $('#mobil_dipakai').val(data.dipakai);
                $('#rute').val(data.rute);
                $('#jml_anggota').val(data.jml_keluarga);
                $('#decision_maker').val(data.decision);
                $('#kunjungan_berikut_prospek').val(data.tgl_kunjungan);
                $('#ket_prospek').val(data.keterangan);
                $('#kebutuhan_prospek').val(data.kebutuhan).trigger('change');
                $('#kebutuhan_bulan').val(data.bln).trigger('change');
                getMediaMotivator(data.id_media);
                getUnit(data.kode_unit);
                cekStokUnit(data.kode_unit);
            }
        });
    }

    function getMediaMotivator(id_media) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataMediaMotivaor",
            data: {
                id_media: id_media,
            },
            dataType: "json",
            success: function(data) {
                $('#opt_media_motivator_prospek').select2({
                    placeholder: "Pilih Media Motivator",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_prospek'),
                });
            }
        });
    }

    function cekStokUnit(kode_unit) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataStockUnit",
            data: {
                kode_unit: kode_unit,
            },
            dataType: "json",
            success: function(data) {
                $('#stock_tersedia_prospek').val(data);
            }
        });
    }

    $(document).on('click', '#btn_simpan_prospek', function() {
        prospek = $('#form_prospek').serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanProspek",
            data: prospek,
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success")
                        .then(function() {
                            location.reload();
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_simpan_prospek").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_prospek").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    });

    $(document).on('click', '#btn_lanjut_prospek', function() {
        id_prospek_prospek = $('#id_prospek_prospek').val();
        status_customer = $('.status_customer').val();;
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanProsesLanjutTahapan",
            data: {
                id_prospek_prospek: id_prospek_prospek,
                status_customer: status_customer,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success", 1500)
                        .then(function() {
                            $('#modal_hot_prospek').modal('show');
                            getHotProspek(id_prospek_prospek);
                            $('#modal_prospek').modal('hide');
                            $('#modal_fu').modal('show');
                            $('#id_prospek_fu').val(id_prospek_prospek);
                            getStatusFu();
                            getRemaksFu();
                            getNextFu();
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_simpan_prospek").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_prospek").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });

    });

    //** Data Hot Prospek */ 

    function getHotProspek(id_prospek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataHotProspek",
            data: {
                id_prospek: id_prospek
            },
            dataType: "json",
            success: function(data) {
                var d = new Date(),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                if (data.tgl_hot_prospek == null || data.tgl_hot_prospek == '') {
                    $('#tgl_hot_prospek').val([year, month, day].join('-'));
                } else {
                    $('#tgl_hot_prospek').val(data.tgl_hot_prospek);

                }
                $('#id_prospek_hot_prospek').val(data.id_prospek);
                $('.status_customer').val(data.status_customer);
                $('#nama_hot_prospek').val(data.nama_customer);
                $('#kungjungan_berikut_hot_prospek').val(data.tgl_kunjungan);
                $('#ket_suspect').val(data.keterangan);
                $('#email').val(data.email);

                var jkl = data.jenis_kelamin;
                var cb = data.cara_bayar;
                if (jkl == 'Laki-Laki') {
                    $('#male').prop('checked', true);
                }
                if (jkl == 'Perempuan') {
                    $('#famale').prop('checked', true);
                }
                if (cb == 'k') {
                    $('#kredit_hot_prospek').prop('checked', true);
                }
                if (cb == 'c') {
                    $('#cash_hot_prospek').prop('checked', true);
                }

            }
        });
    }

    $(document).on('click', '#btn_simpan_hot_prospek', function() {
        hotProspek = $('#form_hot_prospek').serialize();

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanHotProspek",
            data: hotProspek,
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success")
                        .then(function() {
                            location.reload();
                        });
                } else {
                    if (data.status_customer == 'suspect') {
                        peringatan("Error", data.pesan, "error")
                            .then(function() {
                                $('#modal_hot_prospek').modal('hide');
                                $('#modal_suspect').modal('show');
                                getSuspect(data.id_prospek);
                            });

                    } else {
                        peringatan("Error", data.pesan, "error")
                            .then(function() {
                                location.reload();
                            });
                    }
                }
                $("#btn_simpan_hot_prospek").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_hot_prospek").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    })

    $(document).on('click', '#btn_lanjut_hot_prospek', function() {
        id_prospek_hot_prospek = $('#id_prospek_hot_prospek').val();
        status_customer = $('.status_customer').val();;
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanProsesLanjutTahapan",
            data: {
                id_prospek_hot_prospek: id_prospek_hot_prospek,
                status_customer: status_customer,
            },
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success", 1500)
                        .then(function() {
                            $('#modal_spk').modal('show');
                            getSpk(id_prospek_hot_prospek);
                            $('#modal_hot_prospek').modal('hide');
                        })
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        })
                }
                $("#btn_lanjut_hot_prospek").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_lanjut_hot_prospek").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });

    });
    //** Data SPK */

    function getSpk(id_prospek) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataSpk",
            data: {
                id_prospek: id_prospek,
            },
            dataType: "json",
            success: function(data) {
                var d = new Date(),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                if (data.tgl_hot_prospek == null || data.tgl_hot_prospek == '') {
                    $('#tgl_spk').val([year, month, day].join('-'));
                } else {
                    $('#tgl_spk').val(data.tgl_hot_prospek);

                }

                $('#id_prospek_spk').val(data.id_prospek);
                $('#nama_customer_spk').val(data.nama_customer);
                $('#handpone_spk').val(data.telepone);
                $('#nama_stnk').val(data.nama_stnk);
                $('#diskon').val(data.diskon);
                $('#tanda_jadi').val(data.uang_muka);
                $('#setting_tanda_jadi').html(data.setting_tanda_jadi);

                payment_foto = data.payment_foto == null ? "<?= base_url() ?>./public/assets/images/no_image_available.jpg" : "<?= base_url() ?>./public/upload/images/payment_foto/" + data.payment_foto;
                $('#backgoud_image').css('background-image', 'url(' + payment_foto + ')');
                if (data.no_spk == null) {
                    var no_spk_show = '';
                } else {
                    ada_x = data.no_spk.substring(10, data.no_spk.indexOf('x'));
                    if (ada_x == 'x') {

                        var no_spk_show = data.no_spk.substring(0, data.no_spk.indexOf('x'));
                    } else {
                        var no_spk_show = data.no_spk.substring(9, data.no_spk.indexOf('x'));
                    }
                }
                getNoSpk(no_spk_show);
                getLeasing(data.leasing);

                if (data.jenis_bayar == 't') {
                    $('#tunai').prop('checked', true);
                    $('#transfer').prop('checked', false)
                } else if (data.jenis_bayar == 'tf') {
                    $('#transfer').prop('checked', true)
                    $('#tunai').prop('checked', false);
                } else {
                    $('#transfer').prop('checked', false)
                    $('#tunai').prop('checked', false);
                }

                if ($.trim(data.form_spk)) {
                    const form_spk = data.form_spk;
                    for (var i = 0; i < form_spk.length; i++) {
                        $('#form_spk_' + form_spk[i]).prop('checked', true);
                    }
                }

                if ($.trim(data.motif_beli)) {
                    const motif_beli = data.motif_beli;
                    for (var x = 0; x < motif_beli.length; x++) {
                        $('#motif_beli_' + motif_beli[x]).prop('checked', true);
                    }
                    // $inputs = $('input[name^=motif_beli]');
                    // for (var x = 0; x < motif_beli.length; x++) {
                    //     $inputs.filter('[value=' + motif_beli[x] + ']').prop('checked', true);
                    // }
                }


            }
        });
    }

    function getNoSpk(no_spk) {
        if (no_spk.length == '') {
            // var readonly = '';
            // $('#no_spk').select2("readonly", false);
        } else {
            // $("#no_spk").select2("readonly", true);
            // var readonly = 'readonly';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataNoSpk",
            data: {
                no_spk: no_spk,
            },
            dataType: "json",
            success: function(data) {
                $('#no_spk').select2({
                    placeholder: "Pilih No Spk",
                    data: data,
                    allowClear: true,
                    // disabled: 'readonly',
                    // readonly: true,
                    dropdownParent: $('#modal_spk'),
                });
            }
        });
    }

    function getLeasing(id_leasing) {

        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/getDataLeasing",
            data: {
                id_leasing: id_leasing,
            },
            dataType: "json",
            success: function(data) {
                $('#leasing').select2({
                    placeholder: "Pilih Leasing",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_spk'),
                });
            }
        });
    }

    $(document).on('change', '#upload_foto', function(e) {
        id_prospek = $('#id_prospek_spk').val();

        files = e.target.files;
        var fd = new FormData();
        console.log(fd);
        console.log(files);

        if (files.length > 0) {
            const fsize = files.item(0).size;
            const file = Math.round((fsize / 1024));
            fd.append('file', files[0]);
            // The size of the file. 
            if (file >= 1024) {
                alert("File size too big, must lower than 1024KB");
                return false;
            } else if (file < 1) {
                alert("File size too smal!");
                return false
            } else {
                var file_data = $('#payment_foto').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('id_prospek', id_prospek);
                // form_data.append('backgoud_image', backgoud_image);

                /*untuk ajax upload*/
                $.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>sales_pofil_customer/simpanFotoPayment",
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(data) {
                        if (data.status === true) {
                            peringatan("Sukses", data.pesan, "success")
                                .then(function() {
                                    location.reload();
                                });
                        } else {
                            peringatan("Error", data.pesan, "error")
                                .then(function() {
                                    location.reload();
                                });
                        }
                    }
                });
            }
        }
    });

    $(document).on('click', '#btn_simpan_spk', function() {
        spk = $('#form_spk').serialize();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pofil_customer/simpanSpk",
            data: spk,
            dataType: "json",
            success: function(data) {
                if (data.status === true) {
                    peringatan("Sukses", data.pesan, "success")
                        .then(function() {
                            location.reload();
                        });
                } else {
                    peringatan("Error", data.pesan, "error")
                        .then(function() {
                            location.reload();
                        });
                }
                $("#btn_simpan_spk").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_spk").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    })

    $(document).on('click', '#btn_edit_prospek', function() {
        id_prospek = $('#id_prospek_spk').val();
        location.replace('<?= base_url() ?>sales_profil_customer_view_edit/' + id_prospek);
    })

    function formatRupiah(e) {
        var number_string = e.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            r = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            separator = sisa ? '.' : '';
            r += separator + ribuan.join('.');
        }
        return r;
    }

    function toAngka(rp) {
        var replaced = rp.replace(/[.,]/g,
            function(piece) {
                var replacements = {
                    ".": ' ',
                    ",": "."
                };
                return replacements[piece] || piece;
            });
        return replaced.split(' ').join("");
    }
</script>