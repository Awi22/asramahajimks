<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
	const cabang = $('#opt_cabang');
	const varian = $('#opt_varian');
	const agama = $('#opt_agama');
	const tahun = $('#opt_tahun');
	const w_insert = $('#opt_insert_time');

	$(document).ready(function() {
		//fill data cabang to select2
		$.ajax({
			url: "<?= site_url('wuling_adm_user_global/select2_cabang'); ?>",
			dataType: 'JSON',
			success: function(response) {
				cabang.select2({
					data: response,
					allowClear: true,
				}).change(function() {
					// table_customer.ajax.reload();
				});
			}
		});

		$.ajax({
			url: '<?= base_url('report_as_customer_entry/select2_varian') ?>',
			data: {
				modtype: 'initData'
			},
			dataType: 'json',
			success: function(response) {
				varian.select2({
					data: response,
				})
			}
		});

		$.ajax({
			url: '<?= base_url('report_as_customer_entry/select2_agama') ?>',
			data: {
				// modtype: 'initData'
			},
			dataType: 'json',
			success: function(response) {
				agama.select2({
					data: response,
				})
			}
		})

		tahun.datepicker({
			format: "yyyy",
			startView: "years",
			minViewMode: "years",
		});

		w_insert.datepicker({
			format: "yyyy-mm",
			startView: "months",
			minViewMode: "months",
		});

		$("#btn-ekspor").attr("disabled", true);
	}); //ready 

	$(document).on('click', '#btn-lihat', function(e) {
		e.preventDefault()
		table_customer = $("#table_customer").DataTable({
			processing: true,
			serverSide: true,
			//destroy: true,
			order: [],
			// autoWidth: false,
			retrieve: true,
			ajax: {
				url: "<?= site_url('report_as_customer_entry/get') ?>",
				data: function(data) {
					data.modtype = 'main';
					data.perusahaan = cabang.val();
					data.varian =varian.val();
					data.agama = agama.val();
					data.w_insert = w_insert.val();
					data.tahun = tahun.val();
				}
			},
			columns: [{
					data: 'no',
					title: 'No.',
					orderable: false,
					className: 'center borderLeftTop'
				},
				{
					data: 'w_insert',
					title: 'Tgl. Input',
					className: 'center borderLeftTop'
				},
				{
					data: 'id_customer',
					title: 'ID Customer',
					className: 'center borderLeftTop'
				},
				{
					data: 'no_rangka',
					title: 'No. Rangka',
					className: 'center borderLeftTop'
				},
				{
					data: 'ktp',
					title: 'No. Ktp',
					className: 'center borderLeftTop'
				},
				{
					data: 'nama',
					title: 'Nama',
					className: 'center borderLeftTop'
				},
				{
					data: 'telepon',
					title: 'Telepon',
					className: 'center borderLeftTop'
				},
				{
					data: 'keterangan_cus',
					title: 'Keterangan',
					className: 'center borderLeftTop'
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
		}).on( 'xhr', function () {
			var json = table_customer.ajax.json();    
			if(json.recordsTotal == 0) {            
				$("#btn-ekspor").prop('disabled', true);                
			} else {
				$("#btn-ekspor").prop('disabled', false);                
			}
		} );;; //table_customer
		table_customer.draw();
	})

	$(document).on('click', '#btn-ekspor', function() {
		let cabang = $('#opt_cabang').val();
		let varian = $('#opt_varian').val();
		let agama = $('#opt_agama').val();
		let tahun = $('#opt_tahun').val();
		let w_insert = $('#opt_insert_time').val();
		window.location.href = `<?= base_url(); ?>report_as_customer_entry/ekspor?perusahaan=${cabang}&varian=${varian}&agama=${agama}&tahun=${tahun}&w_insert=${w_insert}`;
	});
</script>

