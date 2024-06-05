<script>
	// Helper function to get the month name based on the month number
	function getMonthName(monthNumber) {
		const monthNames = ["januari", "februari", "maret", "april", "mei", "juni", "juli", "agustus", "september", "oktober", "november", "desember"];
		return monthNames[monthNumber - 1];
	};


	$(document).ready(function() {
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

		var currentYear = new Date().getFullYear();
		var startYear = 2022;
		var endYear = currentYear + 1;

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


		//get data datatable
		// $(".table-coverage-edit").hide();
		table_planning_budget = $("#table_planning_budget").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			// order: [],
			// autoWidth: false,
			ajax: {
				url: "<?= site_url('approve_planning_budget/get') ?>",
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
						let status_over = row.status_over;
						let number = DataTable.render.number('.', ',', 0, 'Rp ','').display(data);
						// if(type==='display'){
							if(status_over==true){
								html = `<span class="badge py-2 px-2 fs-7 me-5 badge-light-danger">${number}</span>`;
							} else {
								html = `<span class="badge py-2 px-2 fs-7 me-5 badge-light-success">${number}</span>`;
							}
							// return html;
						// }
						return html;
					},
				},
				{
					data: "biaya_tahun_lalu",
					render: function(data, type, row, meta) {
						let number = DataTable.render.number('.', ',', 0, 'Rp ','').display(data);
						// let html = '';
						// html = `Rp. ${autoseparator(data)}`;
						return number;
					},
				},
				{
					data: "id_budget",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-approve" data-id="${data}" data-status_over=${row.status_over} title="Approve Planning">
									<i class="fa fa-check fs-4"></i>
								</button>
								<button class="btn btn-icon btn-light-danger w-30px h-30px btn-reject" data-id="${data}" data-status_over=${row.status_over} title="Reject Planning">
									<i class="fa fa-x fs-4"></i>
								</button>
							</td>`;
						return html
					}
				}

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

	//* fungsi approve data *//
	$(document).on('click', '.btn-approve', function() {
		let id_budget = $(this).data('id');
		let status_over = $(this).data('status_over');
		let overbudget = '';
		if(status_over==true){
			overbudget = 'overbudget';
		}
		//average biaya coa ini untuk tahun lalu adalah sebesar
		konfirmasi(`Anda yakin untuk approve planning ${overbudget}?`).then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					url: "<?= site_url('approve_planning_budget/approve_data'); ?>",
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
	//* end fungsi approve data *//

	//* fungsi reject data *//
	$(document).on('click', '.btn-reject', function() {
		let id_budget = $(this).data('id');

		konfirmasi(`Anda yakin untuk reject planning?`).then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					url: "<?= site_url('approve_planning_budget/reject_data'); ?>",
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
	//* end fungsi reject data *//
</script>
