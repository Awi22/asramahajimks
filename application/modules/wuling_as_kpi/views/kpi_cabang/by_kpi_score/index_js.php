<!-- <script src="https://raw.githubusercontent.com/ashl1/datatables-rowsgroup/master/dataTables.rowsGroup.js"></script> -->
<script src="<?= base_url() ?>public/assets/js/datatables/dataTables.rowsGroup.js"></script>

<script>
	$(document).ready(function() {
		CallMethod();
		// month select2
		var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		let month_array = [];
		for (let i = 0; i < months.length; i++) {
			month_array.push({
				id: i + 1,
				text: months[i]
			})
		}
		$('#opt_month').select2({
			placeholder: 'Select Month...',
			data: month_array
		}).change(function() {
			CallMethod();
		});

		$('#opt_range').select2({
			minimumResultsForSearch: Infinity,
			placeholder: 'Select Range...',
		}).change(function() {
			CallMethod();
		});
	});

	function CallMethod() {
		$("#body-card-view-table").html('<div class="text-center d-flex flex-center flex-column h-500px"><div class="spinner-border justify-content-center" role="status"><span class="visually-hidden">Loading...</span></div></div>');
		$.ajax({
			url: "<?= site_url('wuling_as_kpi_scoring_by_kpi/get_view_table') ?>",
			data: {
				month: $('#opt_month').val(),
				range: $('#opt_range').val(),
			},
			success: function(data) {
				$("#body-card-view-table").html(data);
			}
		});
	}
</script>