<script>
    $(document).ready(function() {
        area_kerja();
        tgl_awal();
        tgl_akhir();

        table_laporan_kinerja = $("#table_laporan_kinerja").DataTable({
            processing: true,
            ordering: [],
            // serverSide: true,
            ajax: {
                url: "<?= site_url('karyawan_laporan_kinerja/get') ?>",
                data: function(data) {
                    data.area_kerja = $("#opt_area_kerja").val();
                    data.tgl_awal = $("#tgl_awal").val();
                    data.tgl_akhir = $("#tgl_akhir").val();
                }
            },
            language: {},
            columns: [{
                    data: "no",
                },
                {
                    data: "tanggal",
                },
                {
                    data: "nama",
                },
                {
                    data: "ranah_kerja",
                },
                {
                    data: "uraian_pekerjaan",
                },
                {
                    data: "kendala",
                },
                {
                    data: "absensi",
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
        }).on('error.dt', function(e, settings, techNote, message) {
            pesan('error', message);
            console.log('Error DataTables: ', message);
        });; //table_laporan_kinerja

        $("#opt_area_kerja").on('change', function() {
            table_laporan_kinerja.ajax.reload(null, false);
        });

        $("#tgl_awal").on('change', function() {
            validasi_date_picker();
            table_laporan_kinerja.ajax.reload(null, false);
        });

        $("#tgl_akhir").on('change', function() {
            validasi_date_picker();
            table_laporan_kinerja.ajax.reload(null, false);
        });
    }); //ready

    // export data
    $(document).on('click', '#btn-export', function() {
        var area_kerja = $('#opt_area_kerja').val()
        var tgl_awal = $('#tgl_awal').val()
        var tgl_akhir = $('#tgl_akhir').val()
        window.location.href = `<?= base_url(); ?>karyawan_laporan_kinerja/export?area_kerja=${area_kerja}&tgl_awal=${tgl_awal}&tgl_akhir=${tgl_akhir}`;
    });

    //select2 data area kerja
    function area_kerja() {
        $.ajax({
            url: "<?= site_url('karyawan_laporan_kinerja/select2_area_kerja'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#opt_area_kerja").select2({
                    placeholder: 'Pilih Area Kerja',
                    allowClear: true,
                    data: response
                });
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi Kesalahan');
            }
        })
    }

    // tgl_awal
    function tgl_awal() {
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
    }

    // tgl_akhir
    function tgl_akhir() {
        $("#tgl_akhir").daterangepicker({
            singleDatePicker: true,
            minYear: 2024,
            maxYear: parseInt(moment().format('YYYY'), 10),
            autoApply: true,
            startDate: moment(),
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    }

    function string_to_date(v_tanggal) {
        let tgls = v_tanggal.split("-");
        return (new Date(tgls[2], (tgls[1] - 1), tgls[0]))
    }

    //* validasi date picker
    function validasi_date_picker() {
        var tgl_awal = string_to_date($("#tgl_awal").data('daterangepicker').startDate.format('DD-MM-YYYY'));
        var tgl_akhir = string_to_date($("#tgl_akhir").data('daterangepicker').startDate.format('DD-MM-YYYY'));

        if (tgl_awal.length == 0) {
            pesan('warning', 'Tanggal awal tidak boleh kosong');
            $('#tgl_awal').focus();
            return false;
        }
        if (tgl_akhir.length == 0) {
            pesan('warning', 'Tanggal akhir tidak boleh kosong');
            $("#tgl_akhir").focus();
            return false;
        }
        if (tgl_awal > tgl_akhir) {
            pesan('warning', 'Tanggal awal tidak boleh lebih besar dari akhir');
            // $('#masa-berlaku-awal').val($("#masa-berlaku-akhir").val());
            $('#tgl_awal').focus();
            return false;
        }
    }
</script>