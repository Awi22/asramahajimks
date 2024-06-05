<script>
	$(document).ready(function() {
		$('#jumlah_biaya').keyup(function() {
            $(this).val(formatRupiah($(this).val()));
        });

		$('.inputan_bulan').keyup(function() {
            $(this).val(formatRupiah($(this).val()));
        });

		$("#sub_kategori_plan").select2({placeholder: "-- PILIH SUB KATEGORI --"});
		$("#coa_budget").select2({placeholder: "-- PILIH COA BUDGET --"});

		//fill data cabang to select2
		$.ajax({
			url: "<?= site_url('wuling_adm_user_global/select2_cabang'); ?>",
			dataType: 'JSON',
			success: function(response) {
				$("#opt_cabang_modal").select2({
					placeholder: "-- PILIH CABANG --",
					data: response,
				}).change(function() {
				});
			}
		});

		//select kategori
		$.ajax({
			url: "<?= site_url('tambah_planning_budget/select2_kategori'); ?>",
			dataType: 'JSON',
			success: function(response) {
				$("#kategori_plan").select2({
					placeholder: "-- PILIH KATEGORI --",
					data: response,
					// allowClear: true,
				}).change(function() {
					var selectedKategori = $(this).val();
					$("#sub_kategori_plan").empty().trigger('change');
					$("#coa_budget").empty().trigger('change'); 

					if (selectedKategori) {
						$("#sub_kategori_plan").prop("disabled", false);
						loadSubKategori(selectedKategori);
					} else {
						$("#sub_kategori_plan").prop("disabled", true);
					}
				});
				$("#kategori_plan").val("600000").trigger('change');
			}
		});

		// select sub kategori
		function loadSubKategori(selectedKategori) {
			$.ajax({
				url: "<?= site_url('tambah_planning_budget/select2_sub_kategori'); ?>",
				data: { kategori: selectedKategori }, 
				dataType: 'JSON',
				method: "POST",
				success: function (response) {
					$("#sub_kategori_plan").empty().append('<option value="" selected>-- PILIH SUB KATEGORI --</option>').trigger('change');
					$("#sub_kategori_plan").select2({
						placeholder: "-- PILIH SUB KATEGORI --",
						data: response,
					}).change(function() {
					var selectedSubKategori = $(this).val();
					$("#coa_budget").empty().trigger('change');
					if (selectedSubKategori) {
						$("#coa_budget").prop("disabled", false);
						loadCoaBudget(selectedSubKategori);
					} else {
						$("#coa_budget").prop("disabled", true);
					}
				});;
				}
			});
		}

		// select coa budget
		function loadCoaBudget(selectedSubKategori) {
			$.ajax({
				url: "<?= site_url('tambah_planning_budget/select2_coa_budget'); ?>",
				data: { sub_kategori: selectedSubKategori }, 
				dataType: 'JSON',
				method: "POST",
				success: function (response) {
					$("#coa_budget").empty().append('<option value="" selected>-- PILIH COA BUDGET--</option>').trigger('change');
					$("#coa_budget").select2({
						placeholder: "-- PILIH COA BUDGET --",
						data: response,
					})
				}
			});
		}

		var currentYear = new Date().getFullYear();
		var startYear = 2022;
		var endYear = currentYear + 1;

		for (var year = startYear; year <= endYear; year++) {
			var option = new Option(year, year);
			$("#opt_tahun_modal").append(option);
		}

		$("#opt_tahun_modal").select2({
			placeholder: "-- PILIH TAHUN --",
		}).change(function(){
			// enable the inputs after selecting year
			toggleInputs(1);
		});

		
	
        toggleInputs(0);
		// toggleMonthInputs();
        // calculateJumlahBiaya();

		
        // Handle radio button changes
        $('input[name="set_biaya"]').click(function () {
			if ($("#opt_cabang_modal").val()=='') {
				pesan('error','Silahkan pilih cabang terlebih dahulu');
				$("#opt_cabang_modal").select2('open');
				return false;
			}
			if ($("#kategori_plan").val()=='') {
				pesan('error','Silahkan pilih kategori plan terlebih dahulu');
				$("#kategori_plan").select2('open');
				return false;
			}
			if ($("#sub_kategori_plan").val()=='') {
				pesan('error','Silahkan pilih sub kategori plan terlebih dahulu');
				$("#sub_kategori_plan").select2('open');
				return false;
			}
			if ($("#coa_budget").val()=='') {
				pesan('error','Silahkan pilih coa budget terlebih dahulu');
				$("#coa_budget").select2('open');
				return false;
			}
			if ($("#opt_tahun_modal").val()=='') {
				pesan('error','Silahkan pilih tahun terlebih dahulu');
				$("#opt_tahun_modal").select2('open');
				return false;
			}
            toggleInputs(1);
            calculateJumlahBiaya();
        });

        // Handle month inputs change
        $('.form-months input[type="text"]').on('input', function () {
            calculateJumlahBiaya();
        });

        function toggleInputs(rev) {
			if(rev==1){
				$('input[name="set_biaya"]').prop('disabled',false);
				$('#jumlah_biaya').prop('disabled',false);
				$('.inputan_bulan').prop('disabled',false);
			} else {
				$('input[name="set_biaya"]').prop('disabled',true);
				$('#jumlah_biaya').prop('disabled',true);
				$('.inputan_bulan').prop('disabled',true);
			}
            var selectedValue = $('input[name="set_biaya"]:checked').val();
            var monthInputs = $('.form-months');

            // Enable or disable month inputs based on the selected radio button
            // if (selectedValue === "manual_perbulan") {
                // monthInputs.prop('disabled', false);
            // } else {
                monthInputs.prop('disabled', true);
            // }
        }

        function calculateJumlahBiaya() {
            var monthInputs = $('.inputan_bulan');
			var disabledMonthInputs = $('.disabled_inputan_bulan');
            var selectedValue = $('input[name="set_biaya"]:checked').val();
			var cabang = $("#opt_cabang_modal").val(),
				coa_budget = $("#coa_budget").val(),
				tahun = $("#opt_tahun_modal").val();

			// if(!selectedValue){
			// 	pesan('error','Silahkan pilih set biaya terlebih dahulu');
			// 	return false;
			// }
			$.ajax({
				url: "<?= site_url('tambah_planning_budget/get_total_tahun_lalu'); ?>",
				data: {
					cabang: cabang,
					coa_budget: coa_budget ,
					tahun: tahun
				}, 
				dataType: 'JSON',
				method: "POST",
				success: function (response) {
					var max_budget = response.max_budget;
					var total_tahun = parseInt(response.total); 
					var perbulan = total_tahun / 12;
					var roundperbulan = round500_rupiah(perbulan);
					
					if(max_budget==0){
						// toggleInputs(0);
						$('input[name="set_biaya"]').prop('disabled',false);
						disabledMonthInputs.val(formatRupiah(roundperbulan.toString()));
						monthInputs.val(formatRupiah(roundperbulan.toString()));
						$('#jumlah_biaya').val(formatRupiah(total_tahun.toString()));
					} else {
						// toggleInputs(1);
						$('input[name="set_biaya"]').prop('disabled',true);
						monthInputs.val(formatRupiah(max_budget));
						disabledMonthInputs.val(formatRupiah(max_budget));
						$('#jumlah_biaya').val(formatRupiah(max_budget));
					}
				}
			});

			// setTimeout(function() {
			switch (selectedValue) {
				case "manual_perbulan":
					$('#jumlah_biaya').prop('readonly',true).addClass('form-control-solid');
					monthInputs.prop('readonly', false).removeClass('form-control-solid');;
					monthInputs.on('input', function() {
						var totalBiaya = 0;
						monthInputs.each(function () {
							var inputValue = toAngka($(this).val());
							totalBiaya += parseInt(inputValue) || 0;
						});
						var rp_totalbiaya = formatRupiah(totalBiaya.toString());
						$('#jumlah_biaya').val(rp_totalbiaya);
					});
					
					break;
				case "average_pertaun":
					$('#jumlah_biaya').prop('readonly',false).removeClass('form-control-solid');
					monthInputs.prop('readonly', true).addClass('form-control-solid');
					$('#jumlah_biaya').on('input', function () {
						let inputTotal = toAngka($('#jumlah_biaya').val()),
						totalBiaya = parseInt(inputTotal),
						averageValue = totalBiaya / 12,
						roundaveragevalue = round500_rupiah(averageValue);
					monthInputs.val(formatRupiah(roundaveragevalue.toString()));
					// $('#jumlah_biaya').val(0).change();
					});
					break
				case "average_tahunlalu":
					$('#jumlah_biaya').prop('readonly',true).addClass('form-control-solid');;
					monthInputs.prop('readonly', true).addClass('form-control-solid');;
					let cabang = $("#opt_cabang_modal").val(),
					coa_budget = $("#coa_budget").val(),
					tahun = $("#opt_tahun_modal").val();
					break;
				default:
					// pesan('error', 'Unknown Set Biaya!')
					break;
			}
			// }, 250);
			
			
        }
	}); //ready 


	//* proses tambah coa *//
	$('.btn-tambah').click(function() {

		$("#opt_coa").val('').trigger('change');
	
			table_pilih_akun = $("#table_pilih_akun").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			// order: [],
			// autoWidth: true,
    		// responsive: true,
			destroy: true,
			ajax: {
				url: "<?= site_url('master_coa_budget/get_pilih_akun') ?>",
			},
			language: {},
			columns: [
				{
					data: "no",
				},
				{
					data: "kode_akun",
				},
				{
					data: "nama_akun",
				},
				{
					data: "departemen",
				},
				// {
				// 	data: "status",
				// },
				{
					data: "exist",
					render: function (data, type, row, meta) {
						let html = '';

						// Check if 'exist' is 'ya' (yes), and conditionally set the checkbox to checked
						if (data === 'ya') {
							html =
								`<label class="form-check form-check-custom form-check-solid">
									<input data-id="${row.kode_akun}" class="form-check-input h-20px w-30px cb-exist" type="checkbox" value="1" checked />
								</label>`;
						} else {
							html =
								`<label class="form-check form-check-custom form-check-solid">
									<input data-id="${row.kode_akun}" class="form-check-input h-20px w-30px cb-exist" type="checkbox" value="0" />
								</label>`;
						}
						return html;
					},
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
		});; //table_pilih_akun
		
	})

	//* proses simpan coa *//
	// klik btn simpan 
	$(document).on('click', '#btn-simpan', function() {
		let	url = "<?= site_url('tambah_planning_budget/tambah_planning'); ?>";
		let cabang = $("#opt_cabang_modal").val(),
			kategori = $("#kategori_plan").val(),
			sub_kategori = $("#sub_kategori_plan").val(),
			coa_budget = $("#coa_budget").val(),
			nama = $("#nama_planning").val(),
			jumlah = $("#jumlah_biaya").val(),
			tahun = $("#opt_tahun_modal").val();

		var set_biaya = $("input[name='set_biaya']:checked").val();
		if(set_biaya == "manual_perbulan"){
			set_biaya = "1";
		}else if (set_biaya == "average_pertaun"){
			set_biaya = "2";
		}else{
			set_biaya = "3"
		}

		let bulan = {};

		for(let i = 1; i <=12;i++){
			let monthName = getMonthName(i);
			let monthValue = toAngka($(`input[name="input-${monthName}"]`).val());
			bulan[monthName] = parseInt(monthValue) || 0;
		}

		if (cabang.length == 0 || cabang == '') {
			pesan('error', 'Cabang tidak boleh kosong!');
			$("#opt_cabang_modal").select2('open');
			return false;
		}
		if (kategori.length == 0 || kategori == '') {
			pesan('error', 'Kategori kosong, silahkan pilih kategori!');
			$("#kategori").select2('open');
			return false;
		}
		if (sub_kategori.length == 0 || sub_kategori == '') {
			pesan('error', 'Sub kategori kosong, silahkan pilih sub kategori!');
			$("#sub_kategori").select2('open');
			return false;
		}
		if (sub_kategori.length == 0 || sub_kategori == '') {
			pesan('error', 'Sub kategori kosong, silahkan pilih sub kategori!');
			$("#sub_kategori").select2('open');
			return false;
		}
		if (nama.length == 0) {
			pesan('error', 'Nama Planning tidak boleh kosong!');
			return false;
		}
		if (jumlah.length == 0) {
			pesan('error', 'Jumlah tidak boleh kosong!');
			return false;
		}
	
		if (tahun.length == 0) {
			pesan('error', 'Tahun tidak boleh kosong!');
			return false;
		}
		// console.log('Kode Akun values:', kodeAkunArray);
	
		Swal.fire({
			text: `Anda yakin untuk menyimpan data?`,
			icon: "question",
			showCancelButton: !0,
			buttonsStyling: !1,
			reverseButtons: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Ya",
			allowOutsideClick: false,
			showLoaderOnConfirm: true,
			backdrop: true,
			customClass: {
				cancelButton: "btn btn-sm fw-bold btn-light-secondary",
				confirmButton: "btn btn-sm fw-bold btn-light-primary btn-active-primary",
			},
			allowOutsideClick: () => !Swal.isLoading(),
			preConfirm: function(e) {
				return $.ajax({
					type: "POST",
					dataType: "JSON",
					url: url,
					data: {
						cabang: cabang,
						kategori : kategori,
						sub_kategori : sub_kategori,
						coa_budget : coa_budget,
						nama: nama,
						set_biaya : set_biaya,
						jumlah: toAngka(jumlah),
						tahun: tahun,
						bulan: bulan

					},
					beforeSend: function() {
						$("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						// console.log(data)
						if (response.status) {
							let pesan = '';
						
							Swal.fire({
								title: response.pesan, //"Berhasil",
								html: pesan,
								icon: "success",
								confirmButtonText: "OK",
								customClass: {
									confirmButton: "btn btn-sm fw-bold btn-primary"
								},
							}).then(function() {
								location.reload();
							})
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
		});
	});
	//* end proses simpan coa *//


	//* static functions *//
	function formatRupiah(e) {
		var number_string = e.replace(/[^,\d]/g, '').toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			r = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);
		if (ribuan) {
			separator = sisa ? '.' : '';
			r += separator + ribuan.join('.');
		}
		return r;
	}

	function toAngka(rp) {
		var replaced = rp.replace(/[.,]/g,
			function(piece) {
				var replacements = {
					".": ' ',
					",": "."
				};
				return replacements[piece] || piece;
			});
		return replaced.split(' ').join("");
	}

	function round500_rupiah(value) {
		return Math.floor(value / 500) * 500;
	}

	function getMonthName(monthNumber) {
		const monthNames = ["januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember"];
		return monthNames[monthNumber - 1];
	} ;
	//* end static functions *//
</script>
