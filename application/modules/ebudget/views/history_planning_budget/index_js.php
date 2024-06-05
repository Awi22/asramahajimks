<script>
	function round500_rupiah(value) {
		return Math.floor(value / 500) * 500;
	}

	// Helper function to get the month name based on the month number
	function getMonthName(monthNumber) {
		const monthNames = ["januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember"];
		return monthNames[monthNumber - 1];
	};

	$(document).ready(function() {
		$('#jumlah_biaya').keyup(function() {
			$(this).val(formatRupiah($(this).val()));
		});

		$('.inputan_bulan').keyup(function() {
			$(this).val(formatRupiah($(this).val()));
		});

		$("#sub_kategori_plan").select2({
			placeholder: "-- PILIH SUB KATEGORI --"
		});
		$("#coa_budget").select2({
			placeholder: "-- PILIH COA BUDGET --"
		});

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
					dropdownParent: $('#modal_tambah_coa'),
					data: response,
					// allowClear: true,

				}).change(function() {
					//$('#btn-lihat').click();
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
					allowClear: true,
					dropdownParent: $('#modal_tambah_coa'),
				}).change(function() {
					var selectedKategori = $(this).val();
					$("#sub_kategori_plan").empty().trigger('change');
					$("#coa_budget").empty().trigger('change');
					// console.log(selectedKategori);

					if (selectedKategori) {
						$("#sub_kategori_plan").prop("disabled", false);
						loadSubKategori(selectedKategori);
					} else {
						$("#sub_kategori_plan").prop("disabled", true);
					}
				});
			}
		});

		// select sub kategori
		function loadSubKategori(selectedKategori) {
			$.ajax({
				url: "<?= site_url('tambah_planning_budget/select2_sub_kategori'); ?>",
				data: {
					kategori: selectedKategori
				}, // Pass selected kategori as a parameter
				dataType: 'JSON',
				method: "POST",
				success: function(response) {
					$("#sub_kategori_plan").empty().append('<option value="" selected>-- PILIH SUB KATEGORI --</option>').trigger('change');
					$("#sub_kategori_plan").select2({
						placeholder: "-- PILIH SUB KATEGORI --",
						data: response,
						dropdownParent: $('#modal_tambah_coa'),

					}).change(function() {
						var selectedSubKategori = $(this).val();
						$("#coa_budget").empty().trigger('change');
						// console.log(selectedKategori);
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
				data: {
					sub_kategori: selectedSubKategori
				}, // Pass selected kategori as a parameter
				dataType: 'JSON',
				method: "POST",
				success: function(response) {
					$("#coa_budget").empty().append('<option value="" selected>-- PILIH COA BUDGET--</option>').trigger('change');
					$("#coa_budget").select2({
						placeholder: "-- PILIH COA BUDGET --",
						data: response,
						dropdownParent: $('#modal_tambah_coa'),
						// allowClear: true,

					})
				}
			});
		}

		var currentYear = new Date().getFullYear();
		var startYear = 2022;
		var endYear = currentYear + 1;

		// dropdown tahun modal
		for (var year = startYear; year <= endYear; year++) {
			// Create an option element
			var option = new Option(year, year);

			// Append the option to the select element
			$("#opt_tahun_modal").append(option);
		}

		//dropdown tahun datatable
		for (var year = startYear; year <= endYear; year++) {
			// Create an option element
			var option = new Option(year, year);

			// Append the option to the select element
			$("#opt_tahun_datatable").append(option);
		}

		// Initialize Select2 on the dropdown
		$("#opt_tahun_modal").select2({
			placeholder: "-- PILIH TAHUN --",
		});

		$("#opt_tahun_datatable").select2({
			placeholder: "-- PILIH TAHUN --",
		}).change(function() {
			table_planning_budget.ajax.reload();
		});;

		// Initial check for radio button state on page load
		toggleMonthInputs();
		calculateJumlahBiaya();

		// Handle radio button changes
		$('input[name="set_biaya"]').change(function() {
			toggleMonthInputs();
			calculateJumlahBiaya();
		});

		// Handle month inputs change
		$('.form-months input[type="text"]').on('input', function() {
			calculateJumlahBiaya();
		});

		// Handle Jumlah Biaya input change
		$('#jumlah_biaya').on('input', function() {
			calculateJumlahBiaya();
		});

		function toggleMonthInputs() {
			// Get the selected value of the radio button
			var selectedValue = $('input[name="set_biaya"]:checked').val();

			// Find the month inputs container
			var monthInputs = $('.form-months input[type="text"]');

			// Enable or disable month inputs based on the selected radio button
			if (selectedValue === "manual_perbulan") {
				monthInputs.prop('disabled', false);
			} else {
				monthInputs.prop('disabled', true);
			}
		}

		function calculateJumlahBiaya() {
			// Find the month inputs container
			var monthInputs = $('.form-months input[type="text"]');

			// Get the selected value of the radio button
			var selectedValue = $('input[name="set_biaya"]:checked').val();

			if (selectedValue === "manual_perbulan") {
				// Calculate the sum of the values entered in the month inputs
				var totalBiaya = 0;
				monthInputs.each(function() {
					var inputValue = toAngka($(this).val());
					console.log(inputValue);
					totalBiaya += parseInt(inputValue) || 0;
				});

				console.log(totalBiaya);
				var rp_totalbiaya = formatRupiah(totalBiaya.toString());
				// Update the Jumlah Biaya input with the calculated result
				$('#jumlah_biaya').val(rp_totalbiaya);
			} else if (selectedValue === "average_pertaun") {
				// Clear all month inputs
				monthInputs.val(0);

				var inputTotal = toAngka($('#jumlah_biaya').val())

				// Get the value entered in the Jumlah Biaya input after clearing month inputs
				var totalBiaya = parseInt(inputTotal);

				var averageValue = totalBiaya / 12;
				var roundaveragevalue = round500_rupiah(averageValue);

				// Set the same average value for each month input
				monthInputs.val(formatRupiah(roundaveragevalue.toString()));


			} else {
				let cabang = $("#opt_cabang_modal").val(),
					coa_budget = $("#coa_budget").val(),
					tahun = $("#opt_tahun_modal").val();
				$.ajax({
					url: "<?= site_url('tambah_planning_budget/get_total_tahun_lalu'); ?>",
					data: {
						cabang: cabang,
						coa_budget: coa_budget,
						tahun: tahun
					},
					dataType: 'JSON',
					method: "POST",
					success: function(response) {
						var total_tahun = parseInt(response);
						// console.log(total_tahun);
						var perbulan = total_tahun / 12;
						var roundperbulan = round500_rupiah(perbulan);

						monthInputs.val(formatRupiah(roundperbulan.toString()));
						$('#jumlah_biaya').val(formatRupiah(total_tahun.toString()));
					}
				});
			}
		}

		//get data datatable
		// $(".table-coverage-edit").hide();
		table_planning_budget = $("#table_planning_budget").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			// order: [],
			// autoWidth: false,
			ajax: {
				url: "<?= site_url('history_planning_budget/get') ?>",
				data: function(data) {
					data.cabang = $("#opt_cabang_datatable").val();
					data.tahun = $("#opt_tahun_datatable").val();
				}
			},
			language: {},
			columns: [{
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
					render: function(data, type, row, meta) {
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
			],
			footerCallback: function(row, data, start, end, display) {
				let api = this.api();
				let intVal = function(i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
						i :
						0;
				};

				// Total over all pages
				total = api
					.column(7)
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);

				// Total over this page
				pageTotal = api
					.column(7, {
						page: 'current'
					})
					.data()
					.reduce((a, b) => intVal(a) + intVal(b), 0);

				// Update footer
				api.column(8).footer().innerHTML = 'Total:  Rp ' + formatRupiah(total.toString());
			},
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



	}); //ready 


	//* proses tambah coa *//
	$('.btn-tambah').click(function() {
		is_update = false;
		is_copy = false;

		$(".judul-modal").text("Tambah Planning");
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
			columns: [{
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
					render: function(data, type, row, meta) {
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
		let url = "<?= site_url('tambah_planning_budget/tambah_planning'); ?>";
		let cabang = $("#opt_cabang_modal").val(),
			kategori = $("#kategori_plan").val(),
			sub_kategori = $("#sub_kategori_plan").val(),
			coa_budget = $("#coa_budget").val(),
			nama = $("#nama_planning").val(),
			jumlah = $("#jumlah_biaya").val(),
			tahun = $("#opt_tahun_modal").val();

		var set_biaya = $("input[name='set_biaya']:checked").val();
		if (set_biaya == "manual_perbulan") {
			set_biaya = "1";
		} else if (set_biaya == "average_pertaun") {
			set_biaya = "2";
		} else {
			set_biaya = "3"
		}

		let bulan = {};

		for (let i = 1; i <= 12; i++) {
			let monthName = getMonthName(i);
			let monthValue = toAngka($(`input[name="${monthName}"]`).val());
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
						cabang: cabang,
						kategori: kategori,
						sub_kategori: sub_kategori,
						coa_budget: coa_budget,
						nama: nama,
						set_biaya: set_biaya,
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
								table_planning_budget.ajax.reload();
								reset_form();
							})
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_tambah_coa').modal('hide');
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



	//* hidden modal *//
	$('#modal_tambah_coa').on('hidden.bs.modal', function() {
		$('.sw-all').prop('checked', false);
	});
	//* end hidden modal *//

	reset_form = () => {
		$("#opt_coa").val('').trigger('change');
	}

	//* end static functions *//
</script>
