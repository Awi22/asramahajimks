<script>

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

		for (var year = startYear; year <= endYear; year++) {
			var option = new Option(year, year);
			$("#opt_tahun_datatable").append(option);
		}

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
				url: "<?= site_url('final_planning_budget/get') ?>",
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
						let number = DataTable.render.number('.', ',', 0, 'Rp ','').display(data);
						return number;
					},
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

				// Update footer
				api.column(7).footer().innerHTML = 'Total:  Rp ' + formatRupiah(total.toString());
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

	$(document).on('click', '#btn-ekspor', function() {
		var cabang = $('#opt_cabang_datatable').val()
		var tahun = $("#opt_tahun_datatable").val();
		window.location.href = `<?= base_url(); ?>final_planning_budget/eksport_data?cabang=${cabang}&tahun=${tahun}`;
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
</script>
