<script>
	$(document).ready(function() {

		$("#tgl_awal").daterangepicker({
			singleDatePicker: true,
			minYear: 2024,
			maxYear: parseInt(moment().format('YYYY'),10),
			autoApply: true,
			startDate: moment().startOf('month'),
			locale: {
				format: 'DD-MM-YYYY'
			}
		});
		$("#tgl_akhir").daterangepicker({
			singleDatePicker: true,
			minYear: 2024,
			maxYear: parseInt(moment().format('YYYY'),10),
			autoApply: true,
			locale: {
				format: 'DD-MM-YYYY'
			}
		});

		//get data datatable
		table_pengajuan_biaya = $("#table_pengajuan_biaya").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			order: [],
			ajax: {
				url: "<?= site_url('realisasi_pengajuan_biaya/get') ?>",
				data: function(data) {
					data.tgl_awal = $("#tgl_awal").data('daterangepicker').startDate.format('DD-MM-YYYY');
					data.tgl_akhir = $("#tgl_akhir").data('daterangepicker').startDate.format('DD-MM-YYYY');
				}
			},
			language: {},
			columns: [
				{
					title: "Tgl Pengajuan",
					// className: "dt-head-center",
					data: "tgl_po",
				},
				{
					title: "PO",
					// className: "dt-head-center",
					data: "no_po",
				},
				{
					title: "Approval SM",
					data: "approval_sm",
					render: function(data, type, row, meta) {
						let html = '';
						switch (data) {
							case '1':
								html = `<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Approve SM</span>`;
								break;
							case '2':
								html = `<span class="badge py-3 px-4 fs-7 badge-light-danger">Reject</span>`;
								break;
							default:
								html = `<span class="badge py-3 px-4 fs-7 badge-light-warning">Belum Cek SM</span>`;
								break;
						}
						return html;
					},
				},
				{
					title: "Approval ASM",
					data: "approval_asm",
					render: function(data, type, row, meta) {
						let html = '';
						switch (data) {
							case '1':
								html = `<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Approve GM</span>`;
								break;
							case '2':
								html = `<span class="badge py-3 px-4 fs-7 badge-light-danger">Reject</span>`;
								break;
							default:
								if (row.status=='1') {
									html = `<span class="badge py-3 px-4 fs-7 badge-light-success"><i class="fa fa-check text-success"></i></span>`;
								} else {
									html = `<span class="badge py-3 px-4 fs-7 badge-light-warning">Belum Cek ASM</span>`;
								}
								break;
						}
						return html;
					},
				},
				{
					title: "Approval GM",
					data: "approval_gm",
					render: function(data, type, row, meta) {
						let html = '';
						switch (data) {
							case '1':
								html = `<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Approve GM</span>`;
								break;
							case '2':
								html = `<span class="badge py-3 px-4 fs-7 badge-light-danger">Reject</span>`;
								break;
							default:
								if (row.status=='1') {
									html = `<span class="badge py-3 px-4 fs-7 badge-light-success"><i class="fa fa-check text-success"></i></span>`;
								} else {
									html = `<span class="badge py-3 px-4 fs-7 badge-light-warning">Belum Cek GM</span>`;
								}
								break;
						}
						return html;
					},
				},
				{
					title: "Alasan",
					data: "alasan"
				},
				{
					title: "Total",
					data: "total",
					// className: "dt-head-center dt-body-right",
					render: $.fn.DataTable.render.number('.', ',', 0, 'Rp ',''),
				},
				{
					title: "Aksi",
					data: "id",
					className: "dt-head-center dt-body-center w-80px",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="text-end">`;
						switch (row.approval_sm) {
							case '1':
							case '2':
								if(row.approval_sm=='2'||row.approval_asm=='2'||row.approval_gm=='2'){
									html += `<td class="text-end"><button class="btn btn-icon btn-light-primary w-30px h-30px btn-reset-status" data-id="${data}" title="Reset Status"><i class="bi bi-repeat fs-3"></i></button> `;
								}
								html += `<td class="text-end"><button class="btn btn-icon btn-light-primary w-30px h-30px btn-detail" data-id="${data}" title="Detail Data" data-bs-toggle="modal" data-bs-target="#modal_detail"><i class="bi bi-eye fs-3"></i></button> `;
								html += `<td class="text-end"><button class="btn btn-icon btn-light-primary w-30px h-30px btn-cetak" data-id="${data}" title="Cetak Data"><i class="bi bi-printer fs-3"></i></button> `;
								break;
							default:
								html += `<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" title="Edit Data">
									<i class="bi bi-pencil fs-3"></i>
								</button>`;
								break;
						}
						html += `</td>`;
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
			footerCallback: function(row, data, start, end, display) {
			},
			initComplete: function(settings, json) {
			},
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		});; //table_pengajuan_biaya

		$("#tgl_awal").on('change', function(){
			validasi_date_picker();
			table_pengajuan_biaya.ajax.reload(null, false);
		});
		$("#tgl_akhir").on('change', function(){
			validasi_date_picker();
			table_pengajuan_biaya.ajax.reload(null, false);
		})
		
	}); //ready 

	//* fungsi detail *//
	$(document).on('click', '.btn-detail', function() {
		id = $(this).data('id');
		$(".judul-modal").text("Detail Pengajuan");

		table_pengajuan_biaya_detail = $("#table_pengajuan_biaya_detail").DataTable({
			processing: true,
			//serverSide: true,
			destroy: true,
			order: [],
			paginate: false,
			info: false,
			ajax: {
				url: "<?= site_url('realisasi_pengajuan_biaya/get_budget_po_by_id') ?>",
				data: {
					id: id
				}
			},
			language: {},
			columns: [
				{
					title: "COA",
					// className: "dt-head-center",
					data: "coa",
				},
				{
					title: "QTY",
					// className: "dt-head-center",
					data: "qty",
				},
				{
					title: "Pengajuan",
					data: "pengajuan",
					// className: "dt-head-center dt-body-right",
					render: $.fn.DataTable.render.number('.', ',', 0, 'Rp ',''),
				},
				{
					title: "Total",
					data: "total",
					// className: "dt-head-center dt-body-right",
					render: $.fn.DataTable.render.number('.', ',', 0, 'Rp ',''),
				},
				{
					title: "Keterangan",
					data: "keterangan",
					// className: "dt-head-center",
				},
				
			],
			// dom: `
			// 	"<'row'" +
			// 	"<'col-sm-6 d-flex align-items-center justify-content-start'l>" +
			// 	"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
			// 	">" +

			// 	"<'table-responsive'tr>" +

			// 	"<'row'" +
			// 	"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
			// 	"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
			// 	">"	`,
			footerCallback: function(row, data, start, end, display) {
				var api = this.api(),
					data;

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === "string" ?
						i.replace(/[\$,]/g, "") * 1 :
						typeof i === "number" ?
						i : 0;
				};

				// Total over all pages
				var total = api
					.column(3)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Update footer
				// $(api.column(0).footer()).html(
				// 	"Total Rp " + autoseparator(total)
				// );
				// $("#total_budget").val(autoseparator(total))
			},
			initComplete: function(settings, json) {
				// $("#no_po").val(json.no_po);
				// $("#tgl_po").val(json.tgl_po);
			},
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		});; //table_pengajuan_biaya

		// $('#btn-update').data('id_budget',  id_budget);
	});
	//* end fungsi detail *//

	//* fungsi cetak *//
	$(document).on('click', '.btn-cetak', function() {
		let id = btoa($(this).data('id'));
		let no_po = $(this).data('no_po');
		let	url = `realisasi_pengajuan_biaya/cetak?id=${id}`;
		window.open("<?= site_url(); ?>" + url, '_blank');
	});
	//* end fungsi cetak *//

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
