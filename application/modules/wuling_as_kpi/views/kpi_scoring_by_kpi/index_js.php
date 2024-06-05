<!-- <script src="https://raw.githubusercontent.com/ashl1/datatables-rowsgroup/master/dataTables.rowsGroup.js"></script> -->
<script src="<?=base_url()?>public/assets/js/datatables/dataTables.rowsGroup.js"></script>

<script>
	$(document).ready(function() {
		//init
		// $.fn.dataTable.ext.errMode = 'none';
		table_scoring = $("#table_scoring").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			ordering: false, //disable sorting
			searching: false, //searching
			lengthChange: false, //menu kolom di kiri atas
			paginate : false,//disable paginate,
			filter : false, //disable filter/search
			info: false, //disable info row kiri bawah
			ajax: {
				url: "<?= site_url('wuling_as_kpi_scoring_by_kpi/get') ?>",
				// data: function(data) {
					// data.status = $("#opt_status").val();
					// data.cabang = $("#opt_cabang").val();
				// }
			},
			language: {},
			columns: [
				{
					title: "KPI",
					data: "kategori",
				},
				{
					title: "KPI GM, ASM, SM, SPV",
					data: "name",
				},
				{
					title: "Bobot 1",
					data: "bobot1",
					className: "text-center",
					render: function(data){
						return `${data}%`
					}
				},
				{
					title: "Bobot 2",
					data: "bobot2",
					className: "text-center",
					render: function(data){
						return `${data}%`
					}
				},
				{
					title: "Bobot 3",
					data: "bobot3",
					className: "text-center",
					render: function(data){
						return `${data}%`
					}
				},
				{
					title: "Bobot 4",
					data: "bobot4",
					className: "text-center",
					render: function(data){
						return `${data}%`
					}
				},
			],
			rowsGroup: [0,2,3],
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		});; //table_scoring

	});
</script>
