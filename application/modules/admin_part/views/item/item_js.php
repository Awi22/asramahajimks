<script>
    $(document).ready(function() {

        // Select2 Class Item
        $.ajax({
            url: "<?= site_url('adm_sp_item/select2_class'); ?>",
            dataType: 'JSON',
            success: function(response) {
                $("#opt_class").select2({
                    data: response,
                    allowClear: true,
                }).change(function() {
                    table_item.ajax.reload();
                });
            }
        });

        // Select2 Tipe Item
        $.ajax({
            url: "<?= site_url('adm_sp_item/select2_tipe'); ?>",
            dataType: 'JSON',
            success: function(response) {
                $("#opt_tipe").select2({
                    data: response,
                    allowClear: true,
                }).change(function() {
                    table_item.ajax.reload();
                });
            }
        });

        // Select2 Kategori Item
        $.ajax({
            url: "<?= site_url('adm_sp_item/select2_kategori'); ?>",
            dataType: 'JSON',
            success: function(response) {
                $("#opt_kategori").select2({
                    data: response,
                    allowClear: true,
                }).change(function() {
                    table_item.ajax.reload();
                });
            }
        });

        // Table Item
        table_item = $("#table_item").DataTable({
            processing: true,
            ordering: false,
            ajax: {
                url: "<?= site_url('adm_sp_item/get') ?>",
            },
            language: {},
            columns: [{
                    title: "Kode Item",
                    data: "kode_item",
                },
                {
                    title: "Part Number",
                    data: "part_number",
                    className: "text-center",
                },
                {
                    title: "Nama Item",
                    data: "nama_item",
                    className: "text-center",
                },
                {
                    title: "Tipe Item",
                    data: "tipe_item",
                    className: "text-center",
                },
                {
                    title: "Harga Jual",
                    data: "harga_jual",
                    className: "text-center",
                },
                {
                    title: "Harga_jual + PPN",
                    data: "harga_jual_ppn",
                    className: "text-center",
                },
                {
                    title: "Harga Beli",
                    data: "harga_beli",
                    className: "text-center",
                },
                {
                    title: "Ongkos Kirim",
                    data: "ongkos_kirim",
                    className: "text-center",
                },
                {
                    title: "Class Item",
                    data: "class_item",
                    className: "text-center",
                },
                {
                    title: "Harga Beli Reguler (non ppn)",
                    data: "harga_beli_reguler",
                    className: "text-center",
                },
                {
                    title: "Harga Beli Emergency (non ppn)",
                    data: "harga_beli_emergency",
                    className: "text-center",
                },
                {
                    title: "satuan",
                    data: "satuan",
                    className: "text-center",
                },
                {
                    title: "Tipe",
                    data: "tipe",
                    className: "text-center",
                },
                {
                    title: "Merek",
                    data: "merek",
                    className: "text-center",
                },
                {
                    title: "Stock Ready",
                    data: "stock_ready",
                    className: "text-center",
                },
                {
                    title: "Stock Awal",
                    data: "stock_awal",
                    className: "text-center",
                },
                {
                    title: "Stock Kritis",
                    data: "stock_kritis",
                    className: "text-center",
                },
                {
                    title: "HPP",
                    data: "hpp",
                    className: "text-center",
                },
                {
                    title: "Ammount",
                    data: "ammount",
                    className: "text-center",
                },
                {
                    title: "Persediaan Awal",
                    data: "persediaan_awal",
                    className: "text-center",
                },
                {
                    data: "id_item",
                    title: "Aksi",
                    className: "text-center w-150px ",
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row, meta) {
                        let html = '';
                        html = `<button class="btn btn-icon btn-light-primary w-30px h-30px mb-3 btn-edit-item" data-id-item="${data}" data-bs-toggle="modal" data-bs-target="#modal_edit_item" title="Edit Item">
									<i class="bi bi-pencil fs-3"></i>
								</button>
                                <button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit-item" data-id-item="${data}" data-bs-toggle="modal" data-bs-target="#modal_edit_item" title="Edit Item">
									<i class="bi bi-list fs-3"></i>
								</button>`;
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
            initComplete: function(settings, json) {
                $("#opt_class").change(function() {
                    table_kategori.ajax.reload(null, false)
                })
                $("#opt_tipe").change(function() {
                    table_kategori.ajax.reload(null, false)
                })
                $("#opt_kategori").change(function() {
                    table_kategori.ajax.reload(null, false)
                })
            },
        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);

        });; //table_item
    });
</script>