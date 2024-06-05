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


		var currentYear = new Date().getFullYear();
		var startYear = currentYear;
		var endYear = currentYear + 10;

		// dropdown tahun modal
		for (var year = startYear; year <= endYear; year++) {
			var option = new Option(year, year);
			$("#opt_tahun_modal").append(option);
		}

		//dropdown tahun datatable
		for (var year = startYear; year <= endYear; year++) {
			var option = new Option(year, year);
			$("#opt_tahun_datatable").append(option);
		}

		// Initialize Select2 on the dropdown
		$("#opt_tahun_modal").select2({
			placeholder: "-- PILIH TAHUN --",
		}).change(function(){
			// enable the inputs after selecting year
			toggleInputs(1);
		});

		$("#opt_tahun_datatable").select2({
			placeholder: "-- PILIH TAHUN --",
		}).change(function() {
			table_planning_budget.ajax.reload();
		});;

		//fill data cabang to select2
		$.ajax({
			url: "<?= site_url('wuling_adm_user_global/select2_cabang'); ?>",
			dataType: 'JSON',
			success: function(response) {
				$("#opt_cabang_datatable").select2({
					placeholder: "-- SEMUA CABANG --",
					data: response,
					allowClear: true,
				}).change(function() {
					table_planning_budget.ajax.reload();
				});
				$("#opt_cabang_modal").select2({
					placeholder: "-- PILIH CABANG --",
					data: response,
				}).change(function() {
				});
			}
		});

		table_planning_budget = $("#table_planning_budget").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			// order: [],
			// autoWidth: false,
			ajax: {
				url: "<?= site_url('edit_planning_budget/get') ?>",
				data: function(data) {
					data.cabang = $("#opt_cabang_datatable").val();
					data.tahun  = $("#opt_tahun_datatable").val();
				}
			},
			language: {},
			columns: [
				{
					data: "no",
				},
				{
					data: "cabang",
				},
				{
					data: "tahun",
				},
				{
					data: "kategori",
				},
				{
					data: "sub_kategori",
				},
				{
					data: "coa_budget",
				},
				{
					data: "nama",
				},
				{
					data: "biaya",
					render: function (data, type, row, meta) {
						let html = '';
							html = `Rp. ${formatRupiah(data)}`;
						return html;
					},
				},
				{
					data: "status_approve",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						switch (data) {
							case "y":
								html = `<span class="badge py-2 px-2 me-5 badge-light-success">Approved</span>`;
								break;
							case "n":
								html = `<span class="badge py-2 px-2 me-5 badge-light-primary">Belum Approve</span>`;
								break;
							case "r":
								html = `<span class="badge py-2 px-2 me-5 badge-light-danger">Reject</span>`;
						}
						return html;
					}	
				},
				{
					data: "id_budget",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						let approved = row.status_approve;
						if (approved=="y") {
							html = ``;
						} else {
							html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_coa" title="Edit Data">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Planning">
										<i class="bi bi-trash fs-3"></i>
									</button>
								</td>`;
						}
						return html
					}
				}
			
			],
			dom: `
				"<'row'" +
				"<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
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
		});; //table_planning_budget
		
	
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
					var total_tahun = parseInt(response); 
					var perbulan = total_tahun / 12;
					var roundperbulan = round500_rupiah(perbulan);
					disabledMonthInputs.val(formatRupiah(roundperbulan.toString()));
					monthInputs.val(formatRupiah(roundperbulan.toString()));
					$('#jumlah_biaya').val(formatRupiah(total_tahun.toString()));
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
					case "average_pertahun":
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


	//* proses update data *//
	// klik btn update
	$(document).on('click', '#btn-update', function() {
		let	url = "<?= site_url('edit_planning_budget/update_data_planning'); ?>";
		id_budget = $(this).data('id_budget');

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
		}else if (set_biaya == "average_pertahun"){
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
			pesan('warning', 'Cabang tidak boleh kosong!');
			$("#opt_cabang_modal").select2('open');
			return false;
		}
		if (kategori.length == 0 || kategori == '') {
			pesan('warning', 'Kategori kosong, silahkan pilih kategori!');
			$("#kategori").select2('open');
			return false;
		}
		if (sub_kategori.length == 0 || sub_kategori == '') {
			pesan('warning', 'Sub kategori kosong, silahkan pilih sub kategori!');
			$("#sub_kategori").select2('open');
			return false;
		}
		if (sub_kategori.length == 0 || sub_kategori == '') {
			pesan('warning', 'Sub kategori kosong, silahkan pilih sub kategori!');
			$("#sub_kategori").select2('open');
			return false;
		}
		if (nama.length == 0) {
			pesan('warning', 'Nama Planning tidak boleh kosong!');
			return false;
		}
		if (jumlah.length == 0) {
			pesan('warning', 'Jumlah tidak boleh kosong!');
			return false;
		}
	
		if (tahun.length == 0) {
			pesan('warning', 'Tahun tidak boleh kosong!');
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
						id_budget: id_budget,
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
						$("#btn-update").attr("data-kt-indicator", "on").prop("disabled", true)
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
								table_planning_budget.ajax.reload();
								// reset_form();
							})
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_tambah_coa').modal('hide');
						$("#btn-update").removeAttr("data-kt-indicator").prop("disabled", false)
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
	//* end proses update data *//

	//* fungsi edit data *//
	$(document).on('click', '.btn-edit', function() {
		id_budget = $(this).data('id');
		$(".judul-modal").text("Edit Planning Budget");

		$.ajax({
			url: "<?= site_url('edit_planning_budget/get_data_by_id'); ?>",
			data: {
				id_budget: id_budget
			}, 
			dataType: 'JSON',
			method: "POST",
			success: function (response) {
				var data_budget = response.data_budget;
				$("#opt_cabang_modal").val(data_budget.id_perusahaan).trigger('change');

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

							// if (selectedKategori) {
							// 	$("#sub_kategori_plan").prop("disabled", false);
							// 	loadSubKategori(selectedKategori);
							// } else {
							// 	$("#sub_kategori_plan").prop("disabled", true);
							// }
						});
						$("#kategori_plan").val(data_budget.kategori).trigger('change');

						$.ajax({
							url: "<?= site_url('tambah_planning_budget/select2_sub_kategori'); ?>",
							data: {
								kategori: data_budget.kategori
							},
							dataType: 'JSON',
							method: "POST",
							success: function(sub_kategori_response) {
								$("#sub_kategori_plan").select2({
									data: sub_kategori_response,
									dropdownParent: $('#modal_tambah_coa'),
								}).change(function() {
									$("#coa_budget").empty().append('<option value="">-- PILIH COA BUDGET --</option>').trigger('change');
									$.ajax({
										url: "<?= site_url('tambah_planning_budget/select2_coa_budget'); ?>",
										data: {
											sub_kategori: $("#sub_kategori_plan").val()
										},
										dataType: 'JSON',
										method: "POST",
										success: function(coa_budget_response) {
											$("#coa_budget").select2({
												placeholder: "-- PILIH COA BUDGET --",
												data: coa_budget_response,
												dropdownParent: $('#modal_tambah_coa'),
											});
											$("#coa_budget").val(data_budget.coa_budget).trigger('change');
										}
									});
								});
								$("#sub_kategori_plan").val(data_budget.sub_kategori).trigger('change');
							}
						});

					}
				});

				$("#nama_planning").val(data_budget.nama);
				$("#opt_tahun_modal").val(data_budget.tahun).trigger('change');

				var set_biaya = data_budget.set_biaya;
				switch (set_biaya) {
					case "1":
						set_biaya = "manual_per_bulan";
						break;
					case "2":
						set_biaya = "average_pertahun";
						break;
					case "3": 
						set_biaya = "average_tahunlalu";
						break;
				}

				$('input[name="set_biaya"]').filter(`[value="${set_biaya}"]`).prop('checked', true);

				$("#jumlah_biaya").val(formatRupiah( data_budget.jumlah)).trigger('change');

				$('input[name="input-januari"]').val(formatRupiah(data_budget.januari));
				$('input[name="input-februari"').val(formatRupiah(data_budget.februari));
				$('input[name="input-maret"').val(formatRupiah(data_budget.maret));
				$('input[name="input-april"').val(formatRupiah(data_budget.april));
				$('input[name="input-mei"').val(formatRupiah(data_budget.mei));
				$('input[name="input-juni"').val(formatRupiah(data_budget.juni));
				$('input[name="input-juli"').val(formatRupiah(data_budget.juli));
				$('input[name="input-agustus"').val(formatRupiah(data_budget.agustus));
				$('input[name="input-september"').val(formatRupiah(data_budget.september));
				$('input[name="input-oktober"').val(formatRupiah(data_budget.oktober));
				$('input[name="input-november"').val(formatRupiah(data_budget.november));
				$('input[name="input-desember"').val(formatRupiah(data_budget.desember));

				//get total tahun lalu
				$.ajax({
					url: "<?= site_url('tambah_planning_budget/get_total_tahun_lalu'); ?>",
					data: {
						cabang: data_budget.id_perusahaan,
						coa_budget: data_budget.coa_budget,
						tahun: data_budget.tahun
					}, 
					dataType: 'JSON',
					method: "POST",
					success: function (response) {
						var total_tahun = parseInt(response); 
						var perbulan = total_tahun / 12;
						var roundperbulan = round500_rupiah(perbulan);
						$('.disabled_inputan_bulan').val(formatRupiah(roundperbulan.toString()));
					}
				});
			}
		});

		$('#btn-update').data('id_budget',  id_budget);
	});
	//* end fungsi edit data *//

	//* fungsi hapus data *//
	$(document).on('click', '.btn-hapus', function() {
		let id_budget = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus data?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						url: "<?= site_url('edit_planning_budget/hapus_data'); ?>",
						data: {
							id_budget: id_budget
						},
						dataType: "JSON",
						success: function(response) {
							if (response.status === true) {
								peringatan("Sukses", response.pesan, "success", 1500)
									.then(function() {
										table_planning_budget.ajax.reload(null, false);
									})
							} else {
								peringatan("Error", response.pesan, "error")
									.then(function() {
										location.reload()
									})
							}
						},
						error: function(xhr, status, error) {
							var err = eval("(" + xhr.responseText + ")");
							console.log(err.Message);
							pesan('error', 'Terjadi kesalahan');
						},
					});
				}
			});
	});
	//* end fungsi hapus data *//

	$(document).on('click', '#btn-ekspor', function() {
		var cabang = $('#opt_cabang_datatable').val()
		var tahun = $("#opt_tahun_datatable").val();
		window.location.href = `<?= base_url(); ?>edit_planning_budget/eksport_data?cabang=${cabang}&tahun=${tahun}`;
		// $.ajax({
		// 	type: "POST",
		// 	url: "<?= site_url('edit_planning_budget/eksport_data'); ?>",
		// 	data: {
		// 		cabang : $("#opt_cabang_datatable").val(),
		// 		tahun  : $("#opt_tahun_datatable").val()
		// 	},
		// 	// dataType: "JSON",
		// 	success: function(response) {
			
		// 		window.open(`<?= site_url('edit_planning_budget/eksport_data'); ?>`)
		// 		alert("Sukses Eksport")
		// 	},
		// 	error: function(xhr, status, error) {
		// 		var err = eval("(" + xhr.responseText + ")");
		// 		console.log(err.Message);
		// 		pesan('error', 'Terjadi kesalahan');
		// 	},
		// });
	});
	//* end fungsi eksport data *//

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

	
</script>
