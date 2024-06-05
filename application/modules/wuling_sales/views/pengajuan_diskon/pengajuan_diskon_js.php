<script>
    $(document).ready(function() {
        TablePengajuanDiskon = $('#table_pengajuan_diskon').DataTable({
            processing: true,
            order: [],
            autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_pengajuan_diskon/getDataPengajuanDiskon",
            },
            language: {
                "processing": "Memproses, silahkan tunggu..."
            },
            columns: [{
                    data: "no_spk",
                    title: "No SPk",
                    className: "center"
                },
                {
                    data: "customer",
                    title: "Nama Customer",
                    className: "center",
                },
                {
                    data: "diskon",
                    title: "Diskon",
                },
                {
                    data: "approve_diskon",
                    title: "Approved Diskon",
                    className: "center",
                },
                {
                    data: "checked",
                    title: "Status",
                    orderable: false,
                    render: function(data, type, full, meta) {
                        if (full.checked == 'n') {
                            var status = 'Belum Proses';
                        } else {
                            var status = 'Approved Diskon';
                        }
                        return status;

                    },
                    className: "center",
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
                $("#table_pengajuan_diskon").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });
    });
</script>