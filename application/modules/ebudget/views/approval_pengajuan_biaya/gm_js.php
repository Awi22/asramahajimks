<script>
	$(document).ready(function() {
		$.ajax({
			url: "<?= site_url('tambah_pengajuan_biaya/select2_cabang'); ?>",
			dataType: 'JSON',
			success: function(response) {
				$("#opt-cabang").select2({
					placeholder: "-- SEMUA CABANG --",
					data: response,
					allowClear: true,
				}).change(function() {
					table_approval_po.ajax.reload();
				});
			}
		});

		//get data datatable
		table_approval_po = $("#table_approval_po").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			order: [],
			ajax: {
				url: "<?= site_url('approval_pengajuan_biaya_gm/get') ?>",
				data: function(data) {
					data.cabang = $("#opt-cabang").val();
				// 	data.tahun = $("#opt_tahun_datatable").val();
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
								html = `<span class="badge py-3 px-4 fs-7 badge-light-success">Sudah Approve ASM</span>`;
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
					data: "alasan",
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
					className: "dt-head-center dt-body-center",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-detail" data-id="${data}" title="Detail Data" data-bs-toggle="modal" data-bs-target="#modal_detail"><i class="bi bi-eye fs-3"></i></button> `;
						if(row.approval_sm=='1' && row.approval_asm=='1'){
							switch (row.approval_gm) {
								case '1':
								case '2':
									break;
								default:
									if(row.status=='0'){
										html += `<button class="btn btn-icon btn-light-success w-30px h-30px btn-approve" data-id="${data}" title="Approve"><i class="fa fa-check fs-3"></i></button>
												<button class="btn btn-icon btn-light-danger w-30px h-30px btn-reject" data-id="${data}" title="Reject"><i class="fa fa-x fs-3"></i></button>`;
									}
									break;
							}
						}
						html += `</td>`;
							// <button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Planning">
							// 	<i class="bi bi-trash fs-3"></i>
							// </button>
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
		});; //table_approval_po

	}); //ready 

	//* fungsi detail *//
	$(document).on('click', '.btn-detail', function() {
		id = $(this).data('id');
		$(".judul-modal").text("Detail Pengajuan");

		table_pengajuan_biaya = $("#table_pengajuan_biaya").DataTable({
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
				$("#total_budget").val(autoseparator(total))
			},
			initComplete: function(settings, json) {
				$("#no_po").val(json.no_po);
				$("#tgl_po").val(json.tgl_po);
			},
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		});; //table_pengajuan_biaya

		// $('#btn-update').data('id_budget',  id_budget);
	});
	//* end fungsi detail *//

	//* fungsi approve  *//
	$(document).on('click', '.btn-approve', function() {
		let id = $(this).data('id');
		konfirmasi('Anda yakin untuk approve?').then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					url: "<?= site_url('approval_pengajuan_biaya_gm/approve'); ?>",
					data: {
						id: id
					},
					dataType: "JSON",
					success: function(response) {
						if (response.status === true) {
							peringatan("Sukses", response.pesan, "success", 1500)
								.then(function() {
									table_approval_po.ajax.reload(null, false);
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
	//* end fungsi approve  *//

	//* fungsi reject *//
	$(document).on('click', '.btn-reject', async function() {
		let id = $(this).data('id');
		let { value: alasan } = await Swal.fire({
			// title: 'Anda yakin untuk reject?',
			text: 'Anda yakin untuk reject?',
			icon: "question",
			showCancelButton: !0,
			buttonsStyling: !1,
			reverseButtons: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Ya",
			allowOutsideClick: false,
			backdrop: true,
			input: "text",
			inputPlaceholder: "Masukkan alasan reject",
			inputValidator: (value) => {
				if (!value) {
				return "Alasan reject tidak boleh kosong!";
				}
			},
			customClass: {
				cancelButton: "btn btn-sm fw-bold btn-light-secondary",
				confirmButton: "btn btn-sm fw-bold btn-light-primary btn-active-primary",
			},
		});
		if(alasan) {
			$.ajax({
				type: "POST",
				url: "<?= site_url('approval_pengajuan_biaya_gm/reject'); ?>",
				data: {
					id: id,
					alasan: alasan
				},
				dataType: "JSON",
				success: function(response) {
					if (response.status === true) {
						peringatan("Sukses", response.pesan, "success", 1500)
							.then(function() {
								table_approval_po.ajax.reload(null, false);
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
	//* end fungsi approve data *//

</script>
