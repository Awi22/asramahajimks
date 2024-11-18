<script>
    $(document).ready(function(e) {

        $("#formFotoKaryawan").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    //$("#preview").fadeOut();
                    // $("#err").fadeOut();
                },
                success: function(data) {
                    if (data.status == true) {
                        peringatan('Sukses', data.pesan, 'success', 1500)
                            .then(function() {
                                location.reload();
                            })
                    } else {
                        peringatan('Error', data.pesan, 'error')
                            .then(function() {
                                location.reload();
                            })
                    }
                    // if (data == 'invalid') {
                    // 	// invalid file format.
                    // 	$("#err").html("Invalid File !").fadeIn();
                    // } else {
                    // 	// view uploaded file.
                    // 	$("#preview").html(data).fadeIn();
                    // 	$("#form")[0].reset();
                    // }
                },
                error: function(e) {
                    alert('Unknown error!');
                    console.log(e);
                }
            });
            this.reset();
        }));

        //vars
        is_update = true;

        getKaryawan();
        getAgama();
        $("#tgl_lahir").flatpickr();

    }); //ready

    // simpan profil
    $(document).on('click', '#btn-simpan', function() {
        //init var
        let // id_karyawan = $('#btn-simpan').data('id-karyawan'),
            kode_karyawan = $("#kode_karyawan").val(),
            jenis_kelamin = $('input[name="jenis_kelamin"]:checked').val(),
            agama = $("#agama").val(),
            email = $("#email").val(),
            alamat = $("#alamat").val(),
            tempat_lahir = $("#tempat_lahir").val(),
            tgl_lahir = $("#tgl_lahir").val(),
            no_telepon = $("#no_telepon").val(),
            handphone = $("#handphone").val(),
            status = $("#status").val(),
            the_url = "<?= site_url('profil/update_karyawan'); ?>";

        if (kode_karyawan.length == 0 || kode_karyawan == '') {
            pesan('warning', 'Kode Karyawan tidak boleh kosong!');
            $("#kode_karyawan").focus();
            return false;
        }

        if (jenis_kelamin == null) {
            pesan('warning', 'Jenis Kelamin tidak boleh kosong!');
            $("#male").focus();
            return false;
        }

        if (agama.length == 0 || agama == '') {
            pesan('warning', 'Agama tidak boleh kosong!');
            $("#agama").focus();
            return false;
        }

        // if (email.length == 0 || email == '') {
        //     pesan('warning', 'Email tidak boleh kosong!');
        //     $("#email").focus();
        //     return false;
        // }

        konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
            if (e.value) {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: the_url,
                    data: {
                        // id_karyawan: id_karyawan,
                        kode_karyawan: kode_karyawan,
                        jenis_kelamin: jenis_kelamin,
                        agama: agama,
                        email: email,
                        alamat: alamat,
                        tempat_lahir: tempat_lahir,
                        tgl_lahir: tgl_lahir,
                        no_telepon: no_telepon,
                        handphone: handphone,
                        status: status
                    },
                    beforeSend: function() {
                        $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
                    },
                    success: function(response) {
                        if (response.status) {
                            peringatan("Sukses", response.pesan, 'success', 1500)
                            getKaryawan();
                            // Re-activate the "Link 2" tab to show the updated content
                            // let link2Tab = document.querySelector('a[href="#DataProfil"]');
                            // let bootstrapTab = new bootstrap.Tab(link2Tab);
                            // bootstrapTab.show();
                        } else {
                            peringatan("Error", response.pesan, 'error')
                                .then(function() {
                                    location.reload();
                                });
                        }
                        $("#btn-simpan").removeAttr("data-kt-indicator").prop("disabled", false)
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err.Message);
                        pesan("error", "Terjadi Kesalahan");
                        location.reload();
                    }
                });
            }
        })
    });

    //select2 data agama
    function getAgama() {
        $.ajax({
            url: "<?= site_url('master_karyawan/select2_agama'); ?>",
            dataType: "JSON",
            success: function(response) {
                $("#agama").select2({
                    placeholder: 'Pilih Agama',
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

    function getKaryawan() {
        $.ajax({
            url: "<?= site_url('profil/get_karyawan'); ?>",
            dataType: "JSON",
            success: function(response) {
                //fill data to form
                $("#nama_karyawan").val(response.nama_karyawan);
                $("#kode_karyawan").val(response.kode_karyawan);
                $("#jabatan").val(response.jabatan);
                $("#area_kerja").val(response.area_kerja);
                $("#penempatan_tugas").val(response.tugas);
                $("#status_aktif").val(response.status_aktif);
                var jkl = response.jenis_kelamin;
                if (jkl == 'L') {
                    $('#male').prop('checked', true);
                }
                if (jkl == 'P') {
                    $('#female').prop('checked', true);
                }
                $("#agama").val(response.id_agama).trigger('change');
                $("#email").val(response.email);
                $("#alamat").val(response.alamat);
                $("#tempat_lahir").val(response.tempat_lahir);
                $("#tgl_lahir").val(response.tgl_lahir);
                $("#no_telepon").val(response.no_telepon);
                $("#handphone").val(response.handphone);
                $("#status").val(response.status).trigger('change');
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan_swal('error', err.Message);
            }
        });
    }
</script>