<script>
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
    }); //ready 

    // untuk lihat laporan
    var untukLihatLaporan = function() {
        $("#btn-lihat").click(function() {
            var tgl_awal = $("#tgl_awal").val();
            var tgl_akhir = $("#tgl_akhir").val();

            $.ajax({
                type: "post",
                url: "<?= site_url('pengeluaran_part_counter/lihat_data'); ?>",
                data: {
                    tgl_awal: tgl_awal,
                    tgl_akhir: tgl_akhir,
                },
                beforeSend: function() {
                    $("#btn-lihat").html('<i class="icon-spinner"></i>&nbsp;Menunggu...');
                    $("#btn-lihat").prop('disabled', true);
                },
                success: function(data) {
                    $("#show").html(data)

                    $("#btn-lihat").html('<i class="icon-eye-open"></i>&nbsp;Lihat');
                    $("#btn-lihat").prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    var err = eval(xhr.responseText);
                    alert(err.Message);
                }
            });
        });
    }();
</script>