<script>
    $(document).ready(function() {
        TablePengajuanAr = $('#tabel_pengajuan_ar').DataTable({
            processing: true,
            order: [],
            // autoWidth: false,
            ajax: {
                type: 'POST',
                url: "<?= base_url() ?>sales_pengajuan_ar/getDataCustomerRequestAr",
            },
            language: {
                "processing": "Memproses, silahkan tunggu..."
            },
            columns: [{
                    data: "id_prospek_no_spk",
                    title: "Id Prospek ( No Spk )",
                    className: "flex-center",
                },
                {
                    data: "nama",
                    title: "Customer",
                    className: "center",
                },

                {
                    data: "tdp",
                    title: "TDP",
                    className: "center",
                },
                {
                    data: "requst_ar",
                    title: "Pengajuan Ar",
                    className: "center",
                },
                {
                    data: null,
                    title: "Status",
                    render: function(data, type, full, meta) {
                        var status = 'Belum di konfirmasi';
                        if (full.status_sales == '2' && full.status_spv == '1') {
                            status = 'Dalam Peninjauan SPV';
                        } else if (full.status_spv == '2' && full.status_sm == '1') {
                            status = full.requst_ar + 'Approved';
                        } else if (full.status_sm == '2' && full.status_admin_keuangan == '1') {
                            status = 'Dalam Peninjauan Admin Keuangan';
                        } else if (full.status_sales == '3' && full.status_spv == '3' && full.status_sm == '3' && full.status_admin_keuangan == '3') {
                            status = 'Transaksi Selesai';
                        }

                        return status;

                    },
                    className: "center",
                },



                {
                    data: null,
                    title: "Aksi",
                    orderable: false,
                    render: function(data, type, full, meta) {
                        if (full.status_sales == null) {
                            var aksi = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id_prospek="${full.id_prospek}" data-id_spv ="${full.id_spv}"  title="Pengajuan AR">
									<i class="bi bi-pencil fs-3"></i>
								</button>
								</td>`;
                        } else {
                            var aksi = `<i class="bi bi-lock-fill fs-3"></i> `
                        }
                        return aksi;
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
                $("#tabel_pengajuan_ar").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
            },

        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });

        $('#pengajuan_ar').keyup(function(e) {
            $(this).val(formatRupiah($(this).val()));
        });
    });

    $(document).on('click', '.btn-edit', function() {
        $('#modal_pengajuan_ar').modal('show');
        id_prospek = $(this).data('id_prospek');
        id_spv = $(this).data('id_spv');

    })

    $('#btn_simpan_pengajuan_ar').on('click', function() {
        var pengajuan_ar = $('#pengajuan_ar').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>sales_pengajuan_ar/simpanPengajuanAr",
            data: {
                id_prospek: id_prospek,
                id_spv: id_spv,
                pengajuan_ar: pengajuan_ar,

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
                $("#btn_simpan_customer").removeAttr("data-kt-indicator").prop("disabled", false)
            },
            beforeSend: function() {
                $("#btn_simpan_customer").attr("data-kt-indicator", "on").prop("disabled", true)
            },
        });
    })
</script>