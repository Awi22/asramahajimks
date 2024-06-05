<script>
    $(document).ready(function() {
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
            TableTestDrive.ajax.reload();
        });;

        $("#opt_tahun").select2({
            data: arrTahun,
        }).val(tahun).trigger('change').on('change.select2', function() {
            TableTestDrive.ajax.reload();
        });;

        TableTestDrive = $('#table_test_drive').DataTable({
            processing: true,
            order: [],
            autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_test_drive/getDataTestDrive",
                data: function(data) {
                    data.tahun = $("#opt_tahun").val();
                    data.bulan = $("#opt_bulan").val();
                    data.status = $("#opt_status").val();

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
                    data: "tahapan",
                    title: "Tahapan",
                    className: "center",
                },
                {
                    data: "customer",
                    title: "Nama Customer",
                    className: "center",
                },
                {
                    data: "telepone",
                    title: "Telepon",
                },
                {
                    data: "model",
                    title: "Model",
                    className: "center",
                },
                {
                    data: "model_diminati",
                    title: "Model yang di minati",
                    className: "center",
                },
                {
                    data: "waktu",
                    title: "Waktu Test Drive",
                    className: "center",
                },
                {
                    data: "tempat",
                    title: "Lokasi",
                    className: "center",
                },
                {
                    data: "prospect_id",
                    title: "WSA Suspect",
                    render: function(data, type, full, meta) {
                        if (full.prospect_id == null || full.prospect_id == '') {
                            direct = `<a style="text-decoration:none; margin-right:5px;" class="grey" href="#modal-edit-suspect" data-toggle="modal" title="WSA Suspect"><i class="icon-pencil icon-large"></i></a>`;
                        } else {
                            direct = `<i class="bi bi-check-lg green fs-3"></i>`;
                        }

                        return direct;
                    },
                    className: "center",
                },
                {
                    data: null,
                    title: "Test Drive",
                    orderable: false,
                    render: function(data, type, full, meta) {

                        var gembok = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-formulir" data-id_prospek="${full.id_prospek}" title="Edit Customer">
									<i class="bi bi-pencil fs-3"></i>
								</button>
								
								</td>`
                        return gembok;

                    },
                    className: "center",
                },
                {
                    data: "status",
                    title: "Status",
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
                $("#table_test_drive").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });

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

        $('#plan_beli').select2({
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
    });

    $(document).on('click', '.btn-formulir', function() {
        $('#modal_test_drive').modal('show');
        id_prospek = $(this).data('id_prospek');
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_test_drive/getDataDetailTestDrive",
            data: {
                id_prospek: id_prospek,
            },
            dataType: "json",
            success: function(data) {
                $('#id_prospek').val(id_prospek);
                $('#nama').val(data.customer);
                $('#tlpn').val(data.telepone);
                $('#alamat').val(data.alamat);
                $('#email').val(data.email);
                $('#pekerjaan_sampingan').val(data.pekerjaan_sampingan);
                $('#tempat_test_drive').val(data.tempat).trigger('change');

                getUnit(data.kode_unit);
                getPekerjaan(data.pekerjaan);

                foto_sim = data.foto_sim == null ? "<?= base_url() ?>./public/upload/images/test_drive/no_image_available.jpg" : "<?= base_url() ?>./public/upload/images/test_drive/foto_sim/" + data.foto_sim;
                $('#backgoud_image_sim').css('background-image', 'url(' + foto_sim + ')');

                cabin = data.cabin == null ? "<?= base_url() ?>./public/upload/images/test_drive/no_image_available.jpg" : "<?= base_url() ?>./public/upload/images/test_drive/cabin/" + data.cabin;
                $('#backgoud_image_cabin').css('background-image', 'url(' + cabin + ')');

            }
        });
    })

    function getUnit(kode_unit) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_test_drive/getDataUnit",
            data: {
                kode_unit: kode_unit,
            },
            dataType: "json",
            success: function(data) {
                $('#model_minati').select2({
                    placeholder: "Pilih Unit",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_test_drive'),
                });


            }
        });
    }

    function getPekerjaan(pekerjaan) {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_test_drive/getDataPekerjaan",
            data: {
                pekerjaan: pekerjaan,
            },
            dataType: "json",
            success: function(data) {
                $('#pekerjaan_utama').select2({
                    placeholder: "Pilih Pekerjaan",
                    data: data,
                    allowClear: true,
                    dropdownParent: $('#modal_test_drive'),
                });


            }
        });
    }
</script>