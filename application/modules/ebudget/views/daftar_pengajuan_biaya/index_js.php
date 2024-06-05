<script>
	$(document).ready(function() {
		//fill data cabang to select2
		$.ajax({
			url: "<?= site_url('tambah_pengajuan_biaya/select2_cabang'); ?>",
			dataType: 'JSON',
			success: function(response) {
				$("#opt-cabang").select2({
					placeholder: "-- SEMUA CABANG --",
					data: response,
					allowClear: true,
				}).change(function() {
					table_pengajuan_biaya.ajax.reload();
				});
			}
		});

		$("#opt-status").select2({
			// placeholder: "-- SEMUA CABANG --",
			data: [
				{id: "1", text: "Approve"}, 
				{id: "2", text: "Reject"}, 
				// {id: "3", text: "Done"}
			],
			allowClear: true,
		}).change(function() {
			table_pengajuan_biaya.ajax.reload();
		});
		//get data datatable
		table_pengajuan_biaya = $("#table_pengajuan_biaya").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			order: [],
			ajax: {
				url: "<?= site_url('daftar_pengajuan_biaya/get') ?>",
				data: function(data) {
					data.status = $("#opt-status").val();
					data.cabang = $("#opt-cabang").val();
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
									html = `<span class="badge py-3 px-4 fs-7 badge-light-warning">Belum Cek ASM</span>`;
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
					className: "dt-head-center dt-body-center w-100px",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="text-end">`;
						switch (row.approval_sm) {
							case '1':
							case '2':
								html += `<td class="text-end"><button class="btn btn-icon btn-light-primary w-30px h-30px btn-detail" data-id="${data}" title="Detail Data" data-bs-toggle="modal" data-bs-target="#modal_detail"><i class="bi bi-eye fs-3"></i></button> `;
								if(row.approval_sm=='2'||row.approval_asm=='2'||row.approval_gm=='2'){
									html += `<td class="text-end"><button class="btn btn-icon btn-light-primary w-30px h-30px btn-reset-status" data-id="${data}" title="Reset Status"><i class="bi bi-repeat fs-3"></i></button> `;
									html += `<td class="text-end"><button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Data"><i class="bi bi-trash fs-3"></i></button> `;
								}
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
	}); //ready 

	//* fungsi edit data *//	
	$(document).on('click', '.btn-edit', function() {
		$('.judul-modal').text('Edit Pengajuan');
		id = $(this).data('id');
		window.location.replace("<?= site_url('daftar_pengajuan_biaya/'); ?>"+id);
	});
	//* end fungsi edit data *//

	//* fungsi reset status  *//	
	$(document).on('click', '.btn-reset-status', function() {
		id = $(this).data('id');
		$.ajax({
			url: "<?= site_url('daftar_pengajuan_biaya/reset_status_by_id'); ?>",
			dataType: "JSON",
			method: "POST",
			data: {
				id: id
			},
			beforeSend: function() {
			},
			success: function(res) {
				if (res.status==true) {
					pesan('success', res.pesan);
					table_pengajuan_biaya.ajax.reload(null, false);
				} else {
					pesan('error', res.pesan);
				}
			},
			error: function(xhr, status, error) {
				var err = eval("(" + xhr.responseText + ")");
				console.log(err.Message);
				pesan('error', 'Terjadi kesalahan');
			}
		});
	});
	//* end fungsi reset status *//

	//* fungsi hapus  *//	
	$(document).on('click', '.btn-hapus', function() {
		id = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus data?').then(function(e) {
			if (e.value) {
				$.ajax({
					url: "<?= site_url('daftar_pengajuan_biaya/hapus_by_id'); ?>",
					dataType: "JSON",
					method: "POST",
					data: {
						id: id
					},
					beforeSend: function() {
					},
					success: function(res) {
						if (res.status==true) {
							pesan('success', res.pesan);
							table_pengajuan_biaya.ajax.reload(null, false);
						} else {
							pesan('error', res.pesan);
						}
					},
					error: function(xhr, status, error) {
						var err = eval("(" + xhr.responseText + ")");
						console.log(err.Message);
						pesan('error', 'Terjadi kesalahan');
					}
				});
			}
		});
	});
	//* end fungsi hapus *//

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
				url: "<?= site_url('daftar_pengajuan_biaya/get_budget_po_by_id') ?>",
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
</script>
