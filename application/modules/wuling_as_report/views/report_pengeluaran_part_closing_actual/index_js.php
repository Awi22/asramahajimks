<script>
    $(document).ready(function() {
        var arrBulan = [{
                id: 1,
                text: 'Januari',
            },
            {
                id: 2,
                text: 'Februari'
            },
            {
                id: 3,
                text: 'Maret'
            },
            {
                id: 4,
                text: 'April'
            },
            {
                id: 5,
                text: 'Mei'
            },
            {
                id: 6,
                text: 'Juni'
            },
            {
                id: 7,
                text: 'Juli'
            },
            {
                id: 8,
                text: 'Agustus'
            },
            {
                id: 9,
                text: 'September'
            },
            {
                id: 10,
                text: 'Oktober'
            },
            {
                id: 11,
                text: 'November'
            },
            {
                id: 12,
                text: 'Desember'
            },
        ];

        var d = new Date();
        var bulan = d.getMonth();
        var tahun = d.getFullYear();

        var curTahun = new Date().getFullYear();
        var arrTahun = [];
        for (var i = curTahun; i >= 2018; i--) {
            let j = {
                "id": i,
                "text": i
            };
            arrTahun.push(j);
        }

        $("#filter").select2({
            placeholder: "Pilih Filter",
        });

        $("#tahun").select2({
            placeholder: "Pilih Filter",
            data: arrTahun,
        }).val(tahun).trigger("change");

        $("#bulan").select2({
            placeholder: "Pilih Filter",
            data: arrBulan,
        }).val(bulan + 1).trigger("change");
    }); //ready 

    // untuk lihat laporan
    var untukLihatLaporan = function() {
        $("#btn-lihat").click(function() {
            var jenis_part = $("#filter").val();
            var tahun = $("#tahun").val();
            var bulan = $("#bulan").val();

            $.ajax({
                type: "post",
                url: "<?= site_url('pengeluaran_part_closing_actual/lihat_data'); ?>",
                data: {
                    jenis_part: jenis_part,
                    tahun: tahun,
                    bulan: bulan,
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