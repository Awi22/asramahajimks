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
					table_pengajuan_biaya.ajax.reload();
				});
				$("#opt_cabang_modal").select2({
					placeholder: "-- PILIH CABANG --",
					dropdownParent: $('#modal_tambah_coa'),
					data: response,
				}).change(function() {
					//$('#btn-lihat').click();
				});
			}
		});

		

		//get data datatable
		table_pengajuan_biaya = $("#table_pengajuan_biaya").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			order: [],
			paginate: false,
			info: false,
			ajax: {
				url: "<?= site_url('daftar_pengajuan_biaya/get_budget_po_by_id') ?>",
				// data: function(data) {
				// 	data.cabang = $("#opt_cabang_datatable").val();
				// 	data.tahun = $("#opt_tahun_datatable").val();
				// }
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
				{
					title: "Aksi",
					data: "id",
					className: "dt-head-center dt-body-center",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_coa" title="Edit Data">
									<i class="bi bi-pencil fs-3"></i>
								</button>
							</td>`;
							//* disable hapus, berbahaya kayaknya
							// <button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Planning">
							// 	<i class="bi bi-trash fs-3"></i>
							// </button>
						return html
					}
				}
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

		// $("#tgl_po").daterangepicker({
		// 	singleDatePicker: true,
		// 	minYear: 2024,
		// 	maxYear: parseInt(moment().format('YYYY'),10),
		// 	autoApply: true,
		// 	locale: {
		// 		format: 'DD-MM-YYYY'
		// 	}
		// });

	}); //ready 

	$(document).on('click', '.btn-tambah', function() {
		$('.judul-modal').text('Tambah Pengajuan');
	});

	//* proses simpan data *//
	$(document).on('click', '#btn-simpan', function() {
		let url = "<?= site_url('tambah_pengajuan_biaya/simpan'); ?>";
		let id = $("#btn-simpan").data('id'),
			diajukan_oleh = $("#diajukan_oleh").val(), 
			coa_budget = $("#opt_coa_budget").val(),
			qty = $("#qty").val(),
			pengajuan = $("#pengajuan").val(),
			total = $("#total").val(),
			keterangan = $("#keterangan").val();

		if (diajukan_oleh.length == 0 || diajukan_oleh == '') {
			pesan('error', 'Diajukan oleh tidak boleh kosong!');
			$("#diajukan_oleh").focus();
			return false;
		}
		if (coa_budget.length == 0 || coa_budget == '') {
			pesan('error', 'Coa budget kosong, silahkan pilih kategori!');
			$("#opt_coa_budget").select2('open');
			return false;
		}
		if (qty.length == 0 || qty == '' || qty == 0) {
			pesan('error', 'Qty kosong!');
			$("#qty").focus();
			return false;
		}
		if (pengajuan.length == 0 || pengajuan == '') {
			pesan('error', 'Pengajuan masih kosong!');
			$("#pengajuan").focus();
			return false;
		}
		// console.log('Kode Akun values:', kodeAkunArray);
		konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: "<?= site_url('tambah_pengajuan_biaya/simpan'); ?>",
					data: {
						id: id,
						diajukan_oleh: diajukan_oleh,
						coa_budget: coa_budget,
						qty: qty,
						pengajuan: pengajuan,
						total: total,
						keterangan: keterangan,
					},
					beforeSend: function() {
						$("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							peringatan('Sukses', response.pesan, 'success', 1500)
						} else {
							peringatan('Error', response.pesan, 'error').then(function() {
								location.reload()
							})
						}
						table_pengajuan_biaya.ajax.reload(null, false);
						$('#modal_tambah_coa').modal('hide');
						$("#btn-simpan").removeAttr("data-kt-indicator").prop("disabled", false)
					},
					error: function(xhr, status, error) {
						var err = eval("(" + xhr.responseText + ")");
						console.log(err.Message);
						peringatan('Error', response.pesan, 'error').then(function() {
							location.reload()
						})
					}
				});
			}
		});
	});
	//* end proses simpan data *//

	//* fungsi edit data *//	
	$(document).on('click', '.btn-edit', function() {
		$('.judul-modal').text('Edit Pengajuan');
		id = $(this).data('id'),
		$.ajax({
			url: "<?= site_url('tambah_pengajuan_biaya/get_pengajuan_biaya_by_id'); ?>",
			dataType: "JSON",
			data: {
				id: id
			},
			beforeSend: function() {
			},
			success: function(res) {
				if (res != null || res != '') {
					$("#diajukan_oleh").val(res.diajukan_oleh);
					// $("#sisa_budget_bulan").val(res.kode_sales_sgmw);
					// $("#sisa_budget_tahun").val(res.nama);
					$("#qty").val(res.qty);
					$("#pengajuan").val(autoseparator(res.pengajuan));
					$("#total").val(autoseparator(res.total));
					$("#keterangan").val(res.keterangan);
					$("#opt-status-edit").val(res.status_aktif).trigger('change');
					let cabang = res.cabang;
					$.ajax({
						url: "<?= site_url('tambah_pengajuan_biaya/select2_coa_budget'); ?>",
						dataType: 'JSON',
						data: {
							cabang:cabang,
						},
						success: function(response) {
							$("#opt_coa_budget").select2({
								placeholder: "-- PILIH COA BUDGET --",
								data: response,
								dropdownParent: $('#modal_tambah_coa'),
								allowClear: true,
							})
							$("#opt_coa_budget").on('change', function() {
								var coa_budget = $(this).val();
								if (coa_budget !== '' && coa_budget !== null) {
									$.ajax({
										url: "<?= site_url('tambah_pengajuan_biaya/get_planning_budget_from_coa'); ?>",
										data: {
											coa_budget: coa_budget,
											cabang: cabang
										},
										dataType: 'JSON',
										success: function(res) {
											$("#sisa_budget_bulan").val(autoseparator(res.budget_bulan));
											$("#sisa_budget_tahun").val(autoseparator(res.budget_tahun));
											$("#sisa_budget_total").val(autoseparator(res.budget_total));
										}
									});
								}
							});
							$("#opt_coa_budget").val(res.coa_budget).trigger('change');
						}
					});
				} else {
					pesan('error', 'Terjadi kesalahan saat mengambil data sales');
				}
			},
			error: function(xhr, status, error) {
				var err = eval("(" + xhr.responseText + ")");
				console.log(err.Message);
				pesan('error', 'Terjadi kesalahan');
			}
		});
		// $("#modal_edit_sales").modal('show');
		$('#btn-simpan').data('id', id);
	});
	//* end fungsi edit data *//

	//* fungsi simpan po *//
	$(document).on('click', '#btn-simpan-po', function() {
		let url = "<?= site_url('daftar_pengajuan_biaya/update_po_budget'); ?>";
		let no_po = $("#no_po").val(),
			tgl_po = $("#tgl_po").val(), 
			total_budget = $("#total_budget").val();

		// console.log('Kode Akun values:', kodeAkunArray);
		konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: url,
					data: {
						no_po: no_po,
						tgl_po: tgl_po,
						total_budget: total_budget,
					},
					beforeSend: function() {
						$("#btn-simpan-po").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							peringatan('Sukses', response.pesan, 'success', 1500).then(function(){
								window.location.replace("<?= site_url('daftar_pengajuan_biaya'); ?>");
							});
						} else {
							peringatan('Error', response.pesan, 'error').then(function() {
								location.reload()
							})
						}
					},
					error: function(xhr, status, error) {
						var err = eval("(" + xhr.responseText + ")");
						console.log(err.Message);
						peringatan('Error', response.pesan, 'error').then(function() {
							location.reload()
						})
					}
				});
			}
		});
	});
	//* end fungsi simpan po *//

	//** hapus po *//
	$(document).on('click', '.btn-hapus', function() {
		let id = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus data?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						url: "<?= site_url('tambah_pengajuan_biaya/hapus'); ?>",
						data: {
							id: id
						},
						dataType: "JSON",
						success: function(response) {
							if (response.status === true) {
								peringatan("Sukses", response.pesan, "success", 1500)
									.then(function() {
										table_pengajuan_biaya.ajax.reload(null, false);
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
	//* end hapus po *//

	//* hidden modal *//
	$('#modal_tambah_coa').on('hidden.bs.modal', function() {
		$("#diajukan_oleh").val('');
		$("#opt_coa_budget").val('').trigger('change');
		$("#qty").val('');
		$("#sisa_budget_bulan").val('');
		$("#sisa_budget_tahun").val('');
		$("#pengajuan").val('');
		$("#total").val('');
		$("#keterangan").val('');
	})
	//* end hidden modal *//


	//* start static function *//
	hitung_pengajuan = () => {
		let total = 0;
		let qty = $("#qty").val();
		let v_pengajuan = $("#pengajuan").val();

		if (v_pengajuan.length != 0) {
			let pengajuan = v_pengajuan.replace(/\./g, '');
			total = Math.round(qty * pengajuan),
				$("#total").val(autoseparator(total));
			$("#pengajuan").val(autoseparator(pengajuan));
		}
	}
	//* end static functions *//

</script>
