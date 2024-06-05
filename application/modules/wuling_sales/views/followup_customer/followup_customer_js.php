<script>
    $(document).ready(function() {
        $("#tgl_awal").flatpickr();
        $("#tgl_akhir").flatpickr();

        $('#tgl_awal').on('change', function() {
            TableFu.ajax.reload();
        })

        $('#tgl_akhir').on('change', function() {
            TableFu.ajax.reload();
        })

        TableFu = $('#tabel_followup_customer').DataTable({
            processing: true,
            order: [],
            // autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_followup_customer/getDataFuSales",
                data: function(data) {
                    data.tgl_awal = $("#tgl_awal").val();
                    data.tgl_akhir = $("#tgl_akhir").val();

                },
            },
            language: {
                "processing": "Memproses, silahkan tunggu..."
            },
            columns: [{
                    data: null,
                    render: function(data, type, full, meta) {

                        return `<td class="text-end">
								<a href="#" class="btn_detail" data-id_sales="${full.id_sales}" title="Detail Followup Customer">
									${full.sales}
								</a></td>`;
                    },
                    className: "flex-center",
                },
                {
                    data: "tot_customer",
                    className: "center",
                },
                {
                    data: "tot_fu",
                    className: "center",
                },
                {
                    data: "tot_suspect",
                    className: "center",
                },
                {
                    data: "tot_prospek",
                    className: "center",
                },
                {
                    data: "tot_h_prospek",
                    className: "center",
                },
                {
                    data: "tot_spk",
                    className: "center",
                },
                {
                    data: "tot_do",
                    className: "center",
                },
                {
                    data: "tot_test_drive",
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
                $("#tabel_followup_customer").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });

    });

    $(document).on('click', '.btn_detail', function() {
        var id_sales = $(this).data('id_sales');
        var tgl_awal = $('#tgl_awal').val();
        var tgl_akhir = $('#tgl_akhir').val();
        var link = location.replace('<?= base_url(); ?>sales_followup_customer/detail?tgl_awal=' + tgl_awal + '&tgl_akhir=' + tgl_akhir);
    })
</script>