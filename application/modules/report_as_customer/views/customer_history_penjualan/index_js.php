<script>
	const cabang = $('#opt_cabang');
	const tgl_awal = $('#tgl_awal');
	const tgl_akhir = $('#tgl_akhir');

	$(document).ready(function() {
		tgl_awal.daterangepicker({
			singleDatePicker: true,
			minYear: 2024,
			maxYear: parseInt(moment().format('YYYY'),10),
			autoApply: true,
			startDate: moment().startOf('month'),
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
		tgl_akhir.daterangepicker({
			singleDatePicker: true,
			minYear: 2024,
			maxYear: parseInt(moment().format('YYYY'),10),
			autoApply: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});

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

		$("#btn-ekspor").attr("disabled", true);
	}); //ready 

	$(document).on('click', '#btn-lihat', function(e) {
	// $("#btn-lihat").click(function(e) {
		e.preventDefault();
		validasi_date_picker();
		// $(".table-coverage-edit").hide();
		table_customer = $("#table_customer").DataTable({
			processing: true,
			// serverSide: true,
			destroy: true,
			// order: [],
			// autoWidth: false,
			// retrieve: true,
			ajax: {
				url: "<?= site_url('report_as_customer_history_penjualan/get') ?>",
				data: function(data) {
					data.perusahaan = cabang.val();
					data.tgl_awal = tgl_awal.data('daterangepicker').startDate.format('DD-MM-YYYY');
					data.tgl_akhir = tgl_akhir.data('daterangepicker').startDate.format('DD-MM-YYYY');
				},
				beforeSend: function() {
					// setTimeout(function() { 
					// 	$("#btn-lihat").find('i').removeClass('las la-list').toggleClass('spinner-border spinner-border-sm');
					// }, 500);
				},
			},
			columns: [{
					data: 'no',
					title: 'No.',
					orderable: false,
					// className: 'center'
				},
				{
					data: 'tanggal',
					title: 'Tanggal',
					// className: 'center borderLeftTop'
				},
				{
					data: 'nama',
					title: 'Nama Customer',
					// className: 'center borderLeftTop'
				},
				{
					data: 'telepone',
					title: 'Telepon',
					// className: 'center borderLeftTop'
				},
				{
					data: 'nama_stnk',
					title: 'Nama STNK',
					// className: 'center borderLeftTop'
				},
				{
					data: 'no_rangka',
					title: 'No. Rangka',
					// className: 'center borderLeftTop'
				},
				{
					data: 'no_mesin',
					title: 'No. Mesin',
					// className: 'center borderLeftTop'
				},
				{
					data: 'no_polisi',
					title: 'No. Polisi',
					// className: 'center borderLeftTop'
				},
				{
					data: 'cara_bayar',
					title: 'Cara Bayar',
					// className: 'center borderLeftTop'
				},
				{
					data: 'keterangan',
					title: 'Keterangan',
					// className: 'center borderLeftTop'
				},
				{
					data: 'history_service',
					title: 'History Service',
					// className: 'details-control',
					orderable: false,
					defaultContent: '',
					render: function(data, type, row) {
					// 	if(data==true){
					// 		// html='<span class="details-control"></span>'
					// 		className: "details-control"
					// 	} 
						return '';
					},
					createdCell: function (td, cellData, rowData, row, col) {
						if (cellData ==true) {
							$(td).addClass('details-control');
						}
					}
				},
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
		}).on('xhr', function() {
			// $("#btn-lihat").find('i').removeClass('spinner-border spinner-border-sm').toggleClass('las la-list');
			var json = table_customer.ajax.json();
			if (json.aaData.length > 0) {
				$("#btn-ekspor").prop('disabled', false);
			} else {
				$("#btn-ekspor").prop('disabled', true);
			}
		});;; //table_customer

		table_customer.on('requestChild', function (e, row) {
			row.child(format(row.data())).show();
		});

		$('#table_customer tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = table_customer.row( tr );
		
			if ( row.child.isShown() ) {
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				row.child( format(row.data()) ).show();
				tr.addClass('shown');
			}
		} );
	})

	$(document).on('click', '#btn-ekspor', function() {
		let cabang = $('#opt_cabang').val();
		let tgl_awal = $('#tgl_awal').val();
		let tgl_akhir = $('#tgl_akhir').val();
		validasi_date_picker();
		window.location.href = `<?= base_url(); ?>report_as_customer_history_penjualan/ekspor?perusahaan=${cabang}&tgl_awal=${tgl_awal}&tgl_akhir=${tgl_akhir}`;
	});

	function format (rowData) {
		var div = $('<div>')
			.addClass( 'loading' )
			.text( 'Loading...' );
		// table_detail = $("#table_detail").DataTable({
		// 	processing: true,
		// 	destroy: true,
		// 	// order: [],
		// 	// autoWidth: false,
		// 	ajax: {
		// 		url: "<?= site_url('report_as_customer_history_penjualan/details') ?>",
		// 		data: {
		// 			no_rangka: rowData.no_rangka
		// 		},
		// 	},
		// 	columns: [
		// 		{
		// 			data: 'no_wo',
		// 			title: 'No WO',
		// 			className: 'center borderLeftTop'
		// 		},
		// 		{
		// 			data: 'no_invoice',
		// 			title: 'No Invoice',
		// 			className: 'center borderLeftTop'
		// 		},
		// 		{
		// 			data: 'tgl_service',
		// 			title: 'Tgl Service',
		// 			className: 'center borderLeftTop'
		// 		},
		// 		{
		// 			data: 'total_biaya_jasa',
		// 			title: 'Total Biaya Jasa',
		// 			className: 'center borderLeftTop'
		// 		},
		// 		{
		// 			data: 'total_biaya_part',
		// 			title: 'Total Biaya Part',
		// 			className: 'center borderLeftTop'
		// 		},
		// 		{
		// 			data: 'total_biaya_lain',
		// 			title: 'Total Biaya Lain',
		// 			className: 'center borderLeftTop'
		// 		},
		// 		{
		// 			data: 'keterangan',
		// 			title: 'Keterangan',
		// 			className: 'center borderLeftTop'
		// 		},
		// 	],
		// 	dom: `
		// 		"<'row'" +
		// 		"<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
		// 		"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
		// 		">" +

		// 		"<'table-responsive'tr>" +

		// 		"<'row'" +
		// 		"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
		// 		"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
		// 		">"	`,
		// });

		$.ajax( {
			url: "<?=base_url('report_as_customer_history_penjualan/details')?>",
			data: {
				no_rangka: rowData.no_rangka
			},
			dataType: 'json',
			success: function ( json ) {
				div.html( json).removeClass( 'loading' );
			}
		} );
	
		return div;
	}	

	function string_to_date(v_tanggal) {    
        let tgls = v_tanggal.split("-");    
        return(new Date(tgls[2], (tgls[1] - 1), tgls[0]))
    }

	//* validasi date picker
    function validasi_date_picker() {
        var tgl_awal  = string_to_date($("#tgl_awal").data('daterangepicker').startDate.format('DD-MM-YYYY'));
        var tgl_akhir = string_to_date($("#tgl_akhir").data('daterangepicker').startDate.format('DD-MM-YYYY'));        

        if (tgl_awal.length == 0) {
            pesan('warning', 'Tanggal awal tidak boleh kosong');
            $('#tgl_awal').focus();
            return false;
        }
        if (tgl_akhir.length == 0) {
            pesan('warning', 'Tanggal akhir tidak boleh kosong');
            $("#tgl_akhir").focus();
            return false;
        }
        if (tgl_awal > tgl_akhir) {
            pesan('warning', 'Tanggal awal tidak boleh lebih besar dari akhir');
            // $('#masa-berlaku-awal').val($("#masa-berlaku-akhir").val());
            $('#tgl_awal').focus();
            return false;
        }    
    }
</script>
