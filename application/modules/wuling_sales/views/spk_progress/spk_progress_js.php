<script>
    $(document).ready(function() {
        TableSpkProgress = $('#table_spk_progress').DataTable({
            processing: true,
            order: [],
            // autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_spk_progress/getDataSpk",
            },

            language: {
                "processing": "Memproses, silahkan tunggu..."
            },
            columns: [{
                    data: "no_spk",
                    className: "flex-center",
                },

                {
                    data: "customer",
                },
                {
                    data: "unit",
                    className: "center",
                },
                {
                    data: null,
                    render: function(data, type, full, meta) {
                        let primary, success, input_spk, validasi_spk, app_diskon, no_rangka, ado, v_do;
                        success = 'badge-light-success';
                        primary = 'badge-light-primary';
                        html = '';

                        input_spk = `<span class="badge py-3 px-4 fs-6 me-5 ${success}">Input SPK</span>`;

                        validasi_spk = `<span class="badge py-3 px-4 fs-6 me-5 ${primary}">Validasi SPK</span>`;
                        app_diskon = `<span class="badge py-3 px-4 fs-6 me-5 ${primary}">Aproval Diskon</span>`;
                        no_rangka = `<span class="badge py-3 px-4 fs-6 me-5 ${primary}">No Rangka</span>`;
                        ado = `<span class="badge py-3 px-4 fs-6 me-5 ${primary}">Approval DO</span>`;
                        v_do = `<span class="badge py-3 px-4 fs-6 me-5 ${primary}"> DO</span>`;

                        if (full.tgl_setor != '' || full.tgl_setor != null) {
                            validasi_spk = `<span class="badge py-3 px-4 fs-6 me-5 ${success}">Validasi SPK</span>`;
                        }
                        if (full.diskon != 0) {
                            app_diskon = `<span class="badge py-3 px-4 fs-6 me-5 ${success}">Aproval Diskon</span>`;
                        }
                        if (full.no_rangka != null && full.no_rangka != '') {
                            no_rangka = `<span class="badge py-3 px-4 fs-6 me-5 ${success}">No Rangka</span>`;
                        }
                        if (full.status == 'ado' || full.status == 'do') {
                            ado = `<span class="badge py-3 px-4 fs-6 me-5 ${success}">Approval DO</span>`;
                        }
                        if (full.status == 'ado' || full.status == 'do') {
                            v_do = `<span class="badge py-3 px-4 fs-6 me-5 ${success}"> DO</span>`;
                        }

                        html = input_spk + validasi_spk + app_diskon + no_rangka + ado + v_do;
                        return html;
                    },
                    // className: "d-flex flex-center",
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
                $("#table_spk_progress").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });
    });
</script>