<script>
    let datatable

    const totalHarga = $('#total-harga')
    const totalPpn = $('#total-ppn')
    const total = $('#total')
    const totalHutang = $('.total-hutang')

    const awal = $('#tgl_awal')
    const akhir = $('#tgl_akhir')
    const perusahaan = $('#perusahaan')
    const status = $('#status')

    let options = {
        processing: true,
        serverSide: true,
        order: [1, 'DESC'],
        responsive: true,
        language: {
            processing: '<i class="fa fa-spinner fa-4x fa-spin"></i>'
        },
        ajax: {
            url: `<?= base_url('hutang_vendor_lokal/lihat_data') ?>`,
            data: function(data) {
                data.perusahaan = perusahaan.val()
                data.awal = awal.val()
                data.akhir = akhir.val()
                data.status = status.val()
            }
        },
        columns: [{
                data: 'no'
            },
            {
                data: 'tanggal'
            },
            {
                data: 'no_po'
            },
            {
                data: 'no_wo'
            },
            {
                data: 'no_pengeluaran'
            },
            {
                data: 'no_bukti_bku'
            },
            {
                data: 'nama_vendor'
            },
            {
                data: 'harga'
            },
            {
                data: 'ppn'
            },
            {
                data: 'total'
            },
            {
                data: 'hutang'
            }
        ],
        columnDefs: [{
            targets: [0],
            className: 'center borderLeftTop',
            width: '0%',
            orderable: false
        }, {
            targets: [2, 3, 4, 5, 6],
            className: 'center borderLeftTop',
            orderable: false
        }, {
            targets: [1, 7, 8, 9, 10],
            className: 'center borderLeftTop',
            width: '7%',
            orderable: false
        }],
        drawCallback: function(settings) {
            let api = this.api()
            let json = api.ajax.json()
            totalHarga.html(json.summary.totalHarga ?? 0)
            totalPpn.html(json.summary.totalPpn ?? 0)
            total.html(json.summary.total ?? 0)
            totalHutang.html(json.summary.totalHutang ?? 0)
        }
    }

    $(document).ready(function() {

        $("#tgl_awal").daterangepicker({
            singleDatePicker: true,
            minYear: 2024,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            startDate: moment().startOf('month'),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $("#tgl_akhir").daterangepicker({
            singleDatePicker: true,
            minYear: 2024,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });

        $('#perusahaan').select2({
            placeholder: 'Pilih Cabang'
        });

        $.ajax({
            url: '<?= base_url('hutang_vendor_lokal/get_cabang') ?>',
            data: {
                modtype: 'initData'
            },
            dataType: 'json',
            success: function(response) {
                $('#perusahaan').select2({
                    data: response.cabang,
                    placeholder: 'Pilih Cabang',
                    allowClear: true
                });
            }
        });

        $('#status').select2({});

        datatable = $('#datatable').DataTable(options)
        $('#datatable_filter input').unbind().bind('keyup', function(event) {
            datatable.settings()[0].jqXHR.abort()
            datatable.search(this.value).draw()
        });
    }); //ready

    $(document).on('click', '#btn-lihat', function(event) {
        event.preventDefault()
        datatable.draw()
    })

    // untuk lihat laporan
    // var untukLihatLaporan = function() {
    //     $("#btn-lihat").click(function() {
    //         var tgl_awal = $("#tgl_awal").val();
    //         var tgl_akhir = $("#tgl_akhir").val();
    //         var perusahaan = $("#perusahaan").val();
    //         var status = $("#status").val();

    //         $.ajax({
    //             type: "post",
    //             url: "<?= site_url('hutang_vendor_lokal/lihat_data'); ?>",
    //             data: {
    //                 tgl_awal: tgl_awal,
    //                 tgl_akhir: tgl_akhir,
    //                 perusahaan: perusahaan,
    //                 status: status
    //             },
    //             beforeSend: function() {
    //                 $("#btn-lihat").html('<i class="icon-spinner"></i>&nbsp;Menunggu...');
    //                 $("#btn-lihat").prop('disabled', true);
    //             },
    //             success: function(data) {
    //                 $("#show").html(data)

    //                 $("#btn-lihat").html('<i class="icon-eye-open"></i>&nbsp;Lihat');
    //                 $("#btn-lihat").prop('disabled', false);
    //             },
    //             error: function(xhr, status, error) {
    //                 var err = eval(xhr.responseText);
    //                 alert(err.Message);
    //             }
    //         });

    //         // drawCallback: function(settings) {
    //         //     let api = this.api()
    //         //     let json = api.ajax.json()
    //         //     totalHarga.html(json.summary.totalHarga ?? 0)
    //         //     totalPpn.html(json.summary.totalPpn ?? 0)
    //         //     total.html(json.summary.total ?? 0)
    //         //     totalHutang.html(json.summary.totalHutang ?? 0)
    //         // }
    //     });
    // }();
</script>