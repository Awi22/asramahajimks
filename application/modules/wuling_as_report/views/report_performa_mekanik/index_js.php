<script>
    let awal = $('#tgl_awal')
    let akhir = $('#tgl_akhir')
    let perusahaan = $('#perusahaan')
    let list_mekanik = $('#list_mekanik')
    let modal = $('#modal')
    let mekanik = $('#mekanik')

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

        // $("perusahaan").select2({
        //     placeholder: 'Pilih Cabang'
        // });

        // $("list_mekanik").select2({
        //     placeholder: 'All'
        // });

        perusahaan.select2({
            placeholder: 'Pilih Cabang'
        });

        list_mekanik.select2({
            placeholder: 'All'
        });

        $.ajax({
            url: '<?= base_url('performa_mekanik/get_cabang') ?>',
            data: {
                modtype: 'initData'
            },
            dataType: 'json',
            success: function(response) {
                perusahaan.select2({
                    data: response.cabang,
                    placeholder: 'Pilih Cabang',
                    allowClear: true
                });
            }
        })

        perusahaan.on('change', function() {
            list_mekanik.empty().trigger('change');
            $.ajax({
                url: '<?= base_url('performa_mekanik/get_mekanik') ?>',
                data: {
                    modtype: 'initData',
                    perusahaan: $(this).val()
                },
                dataType: 'json',
                success: function(response) {
                    list_mekanik.select2({
                        data: response.mekanik,
                        placeholder: 'All',
                        allowClear: true
                    });
                }
            })
        })
    }); //ready 

    // untuk lihat laporan
    var untukLihatLaporan = function() {
        $("#btn-lihat").click(function() {
            var awal = $("#tgl_awal").val();
            var akhir = $("#tgl_akhir").val();
            var perusahaan = $("#perusahaan").val();
            var list_mekanik = $("#list_mekanik").val();

            $.ajax({
                type: "post",
                url: "<?= site_url('performa_mekanik/lihat_data'); ?>",
                data: {
                    awal: awal,
                    akhir: akhir,
                    perusahaan: perusahaan,
                    list_mekanik: list_mekanik
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