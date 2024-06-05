<script>
    $(document).ready(function() {
        TableSurvaiDo = $('#tabel_survai_do').DataTable({
            processing: true,
            order: [],
            // autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_survai_do/getDataSurvaiDO",
            },
            language: {
                "processing": "Memproses, silahkan tunggu..."
            },
            columns: [{
                    data: "id_prospek",
                    title: "Id Prospek",
                    className: "flex-center",
                },
                {
                    data: "tgl_do",
                    title: "Tanggal DO",
                    className: "center",
                },
                {
                    data: "customer",
                    title: "Customer",
                },
                {
                    data: "kode_unit",
                    title: "Type Unit",
                    className: "center",
                },
                {
                    data: "cara_bayar",
                    title: "Cara Bayar",
                    className: "center",
                },
                {
                    data: "no_rangka",
                    title: "No Rangka",
                    className: "center",
                },
                {
                    data: null,
                    title: "Upload Foto DO",
                    render: function(data, type, full, meta) {
                        return `<img src=${full.payment_foto} style="width:80%";higth:80%>`
                    },
                    className: "center",
                },
                {
                    data: "status",
                    title: "Status",
                    className: "center",
                },

                {
                    data: null,
                    title: "WSA Suspect",
                    render: function(data, type, full, meta) {
                        var wsa = '';
                        if (full.cutoff == false) {
                            if (full.wsa == false) {
                                wsa = `<a style="text-decoration:none; margin-right:5px;" class="grey" href="#modal-edit-suspect" data-toggle="modal" onclick="edit_suspect('${full.id_prospek}')" title="WSA Suspect"><i class="icon-pencil icon-large"></i></a>`;
                            } else {
                                wsa = `<i class="bi bi-check-lg green fs-3"></i>`;
                            }
                        } else {
                            wsa = '';
                        }

                        return wsa;
                    },
                    className: "center",
                },
                {
                    data: null,
                    title: "Status WSA",
                    render: function(data, type, full, meta) {
                        var wsa = '';
                        if (full.cutoff == false) {
                            if (full.wsa == false) {
                                wsa = 'Belum ada data Suspect / Prospek ke WSA';
                            } else {
                                wsa = 'Sudah ada data Suspect / Prospek ke WSA';
                            }
                        } else {
                            wsa = '';
                        }

                        return wsa;
                    },
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
                $("#tabel_survai_do").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });
    });
</script>