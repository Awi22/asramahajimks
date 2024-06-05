<script>
    $(document).ready(function() {
        getVarian();


        TablePricelist = $('#table_pricelist').DataTable({
            processing: true,
            order: [],
            autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_pricelist_unit/getDataPricelistUnit",
                data: function(data) {
                    data.id_varian = $("#opt_varian").val();

                },
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
                    data: "cabang",
                    title: "Cabang",
                    className: "center",
                },
                {
                    data: "varian",
                    title: "Varian",
                    className: "center",
                },
                {
                    data: "jenis_warna",
                    title: "Jenis Warna",
                },
                {
                    data: "harga_off",
                    title: "Harga Off",
                    className: "center",
                },
                {
                    data: "harga_on",
                    title: "Harga On",
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
                $("#table_pricelist").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });
    });

    function getVarian() {
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pricelist_unit/getDataVarian",
            // data: "data",
            dataType: "json",
            success: function(data) {
                $('#opt_varian').select2({
                    placeholder: "Pilih Varian",
                    data: data,
                    allowClear: true,
                }).on('change.select2', function() {
                    TablePricelist.ajax.reload()
                });
            }
        });
    }
</script>