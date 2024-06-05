<script>
	$(document).ready(function() {
		table_kategori_budget = $("#table_kategori_budget").DataTable({
			processing: true,
			ajax: {
				url: "<?= site_url('master_kategori_budget/get') ?>",
			},
			language: {},
			columns: [
				
				{
					data: null,
					render: function(data, type, row, meta) {
						let html = '';
						html =
								`<p>600000 - Biaya Operasional</p>`
						return html;
					}, 
				},
			
				{
					data: "sub_kategori",
				},
				{
					data: "coa_budget",
				},
				{
					data: "sub_coa_budget",
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
		});; //table_kategori_budget

	}); //ready 

</script>
