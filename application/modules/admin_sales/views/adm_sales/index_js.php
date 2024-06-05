<script>
	first_time = 1;

	$(document).ready(function() {

		// $("#modal_kode_sales_sgmw").modal('show');

		//fill data cabang to select2
		$.ajax({
			url: "<?= site_url('wuling_adm_user_global/select2_cabang'); ?>",
			dataType: 'JSON',
			success: function(response) {
				$("#opt_cabang").select2({
					placeholder: "-- SEMUA CABANG --",
					data: response,
					allowClear: true,
				}).change(function() {
					table_sales.ajax.reload();
				});
				$("#opt_status").select2({
					placeholder: "-- SEMUA SALES --",
					allowClear: true,
				}).change(function() {
					table_sales.ajax.reload();
				});
			}
		});

		//init
		$.fn.dataTable.ext.errMode = 'none';
		$.fn.DataTable.ext.pager.numbers_length = 4;
		table_sales = $("#table_sales").DataTable({
			// processing: true,
			autoWidth: true,
			serverSide: true,
			// order: [],
			ajax: {
				url: "<?= site_url('adm_sales_sales/get'); ?>", //get
				dataType: "JSON",
				data: function(data) {
					data.cabang = $("#opt_cabang").val();
					data.jenis_sales = $("#opt_status").val();
				},
			},
			language: {
				"emptyTable": "Data masih kosong..."
			},
			columns: [{
					data: "nik",
					title: "NIK",
				},
				{
					data: "kode_sales_sgmw",
					title: "Kode Sales SGMW ",
					className: "w-150px",
				},
				{
					data: "nama",
					title: "Nama Karyawan",
				},
				{
					data: "jabatan",
					title: "Jabatan",
				},
				{
					data: "jenis_sales",
					title: "Jenis Sales",
					className: "w-95px",
					render: function(data, type, row, meta) {
						let html = '';
						switch (data) {
							case 's':
								html = 'FORCE'
								break;
							case 'c':
								html = 'COUNTER'
								break;
							case 'f':
								html = 'FLEET'
								break;
							default:
								html = 'INVALID'
								break;
						}
						return html;;
					}
				},
				{
					data: "cabang",
					title: "Cabang",
				},
				{
					data: "id_sales",
					title: "Aksi",
					className: "text-center w-95px",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit-sales" data-id-sales="${data}" data-bs-toggle="modal" data-bs-target="#modal_edit_sales" title="Edit Sales">
									<i class="bi bi-pencil fs-3"></i>
								</button>`;
						return html
					}
				},
			],
			initComplete: function(settings, json) {},
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
		}); //table_sales


	}); //ready 


	//* proses edit data sales	*//
	//btn-edit click
	$(document).on('click', '.btn-edit-sales', function() {
		id_sales = $(this).data('id-sales'),
		$.ajax({
			url: "<?= site_url('adm_sales_sales/get_data_sales_by_id'); ?>",
			dataType: "JSON",
			data: {
				id_sales: id_sales
			},
			beforeSend: function() {
				$("#nik-edit").val('loading...');
				$("#kode-sgmw-edit").val('loading...');
				$("#nama-sales-edit").val('loading...');
				$("#jabatan-edit").val('loading...');
				$("#username-edit").val('loading...');
				$("#kode-sgmw-edit").val('');
				$("#opt-jenis-sales-edit").val('').trigger('change');
				$("#opt-level-edit").val('').trigger('change');
				$("#opt-status-edit").val('').trigger('change');
			},
			success: function(response) {
				if (response != null || response != '') {
					$("#nik-edit").val(response.nik);
					$("#kode-sgmw-edit").val(response.kode_sales_sgmw);
					$("#nama-sales-edit").val(response.nama);
					$("#jabatan-edit").val(response.jabatan);
					$("#username-edit").val(response.username);
					$("#opt-jenis-sales-edit").val(response.jenis_sales).trigger('change');
					$("#opt-level-edit").val(response.status_leader).trigger('change');
					$("#opt-status-edit").val(response.status_aktif).trigger('change');
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
		$('#btn-update-sales').data('id-sales', id_sales);
	});

	//saat modal_kode_sales_sgmw tampil
	$('#modal_kode_sales_sgmw').on('shown.bs.modal', function() {
		if (first_time < 3) {
			$.fn.DataTable.ext.pager.numbers_length = 4;
			tableSalesWsa = $("#table_sales_wsa").DataTable({
				autoWidth: true,
				destroy: true,
				order: [],
				pagingType: "simple",
				info: false,
				lengthMenu: [5],
				ajax: {
					url: "<?= base_url('adm_sales_sales/getDataSalesWsaApi'); ?>", //get
					dataType: "JSON",

				},
				language: {
					"processing": "Memproses, silahkan tunggu...",
					"emptyTable": "Data masih kosong..."
				},
				columns: [{
						data: "id",
						title: "Kode Sales",
						className: "center",
					},
					{
						data: "name",
						title: "Nama Sales ",
						className: "dt-head-center",
					},
					{
						data: "dealer_outlet",
						title: "Cabang",
						className: "dt-head-center",
					},
					// {
					//     data: "email",
					//     title: "Email ",
					//     className: "dt-head-center",
					// },
					// {
					//     data: "phone_number",
					//     title: "Tlpn",
					//     className: "dt-head-center",
					// },
					// {
					//     data: "role",
					//     title: "Jenis Sales",
					//     className: "center nowrap",
					// },
					// {
					//     data: "job_title",
					//     title: "Jabatan",
					//     className: "center nowrap",
					// },
					{
						data: "id",
						title: "Aksi",
						className: "text-center w-75px",
						searchable: false,
						orderable: false,
						// width: "150px",
						render: function(data, type, row, meta) {
							var html = '',
								html = `<button class="btn btn-icon btn-light-primary w-30px h-30px btn-pilih-sales-sgmw" data-id-sales="${data}" title="Pilih Sales" data-bs-dismiss="modal" >
										<i class="bi bi-box-arrow-in-down fs-3"></i>
									</button>`;
							return html
						}
					},
				],
				initComplete: function(settings, json) {},
				dom: `
					"<'row'" +
					"<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
					"<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
					">" +

					"<'table-responsive'tr>" +

					"<'row h-50px'" +
					"<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
					"<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
					">"	`,
			}).on('error.dt', function(e, settings, techNote, message) {
				pesan('error', message);
				console.log('Error DataTables: ', message);
			});
			first_time = 3;
		}
	})

	// klik tombol pilih kode sales sgmw
	$(document).on('click', '.btn-pilih-sales-sgmw', function() {
		id_sales_wsa = $(this).data('id-sales');
		$("#kode-sgmw-edit").val(id_sales_wsa);
	});

	// klik simpan/update sales
	$(document).on('click', '#btn-update-sales', function() {
		var id_sales = $('#btn-update-sales').data('id-sales'),
			jenis_sales = $("#opt-jenis-sales-edit").val(),
			status_leader = $("#opt-level-edit").val(),
			status_aktif = $("#opt-status-edit").val(),
			kode_sgmw = $("#kode-sgmw-edit").val()

		if (id_sales.length == 0 || jenis_sales.length == 0 || status_leader.length == 0 || status_aktif.length == 0) {
			pesan('error', 'Terjadi kesalahan, silahkan reload halaman');
			return false;
		}

		konfirmasi('Anda yakin untuk menyimpan data?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						dataType: "JSON",
						url: "<?= site_url('adm_sales_sales/update_sales'); ?>",
						data: {
							id_sales: id_sales,
							jenis_sales: jenis_sales,
							status_leader: status_leader,
							status_aktif: status_aktif,
							kode_sgmw: kode_sgmw,
						},
						beforeSend: function() {
							$("#btn-update-sales").attr("data-kt-indicator", "on").prop("disabled", true)
						},
						success: function(response) {
							if (response.status) {
								peringatan('Sukses', response.pesan, 'success', 1500)
							} else {
								peringatan('Error', response.pesan, 'error')
									.then(function() {
										location.reload()
									})
							}
							table_sales.ajax.reload(null, false);
							$('#modal_edit_sales').modal('hide');
							$("#btn-update-sales").removeAttr("data-kt-indicator").prop("disabled", false)
						},
						error: function(xhr, status, error) {
							var err = eval("(" + xhr.responseText + ")");
							console.log(err.Message);
							peringatan('Error', response.pesan, 'error')
								.then(function() {
									location.reload()
								})
						}
					});
				}
			})



	});

	// klik reset password
	$(document).on('click', '#btn-reset-password', function() {
		var id_sales = $('#btn-update-sales').data('id-sales'),
			username = $("#username-edit").val();

		if (id_sales.length == 0 || username.length == 0) {
			pesan('danger', 'Terjadi kesalahan, silahkan reload halaman');
			return false;
		}


		Swal.fire({
			text: `Anda yakin untuk mereset password?`,
			icon: "question",
			showCancelButton: !0,
			buttonsStyling: !1,
			reverseButtons: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Ya",
			allowOutsideClick: false,
			showLoaderOnConfirm: true,
			backdrop: true,
			customClass: {
				cancelButton: "btn btn-sm fw-bold btn-light-secondary",
				confirmButton: "btn btn-sm fw-bold btn-light-primary btn-active-primary",
			},
			allowOutsideClick: () => !Swal.isLoading(),
			preConfirm: function(e) {
				return $.ajax({
					type: "POST",
					dataType: "JSON",
					url: "<?= site_url('adm_sales_sales/reset_password'); ?>",
					data: {
						id_sales: id_sales,
						username: username,
					},
					beforeSend: function() {
						$("#btn-reset-password").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							peringatan('Sukses', response.pesan, 'success', 1500)
						} else {
							peringatan('Error', response.pesan, 'error')
								.then(function() {
									location.reload()
								})
						}
						table_sales.ajax.reload(null, false);
						$("#btn-reset-password").removeAttr("data-kt-indicator").prop("disabled", false)
						$('#modal_edit_sales').modal('hide');
					},
					error: function(xhr, status, error) {
						var err = eval("(" + xhr.responseText + ")");
						console.log(err.Message);
						peringatan('Error', response.pesan, 'error')
							.then(function() {
								location.reload()
							})
					}
				});
			}
		})
	});
	//* end proses edit data sales *//

	//* proses download data sales dari hrd *//
    $('.btn-download-data-sales').click(function() {
        $.ajax({
            dataType: "JSON",
            url: "<?= site_url('adm_sales_sales/download'); ?>",
            beforeSend: function() {
				$(".btn-download-data-sales").attr("data-kt-indicator", "on").prop("disabled", true)
            },
            success: function(response) {
                console.log(status);
                if (response.status) {
                    pesan('success', response.pesan);
                } else {
                    pesan('error', response.pesan);
                }
                table_sales.ajax.reload(null, false);
				$(".btn-download-data-sales").attr("data-kt-indicator", "off").prop("disabled", false)
            },
            error: function(xhr, status, error) {
                var err = eval("(" + xhr.responseText + ")");
                console.log(err.Message);
                pesan('error', 'Terjadi kesalahan');
				$(".btn-download-data-sales").attr("data-kt-indicator", "off").prop("disabled", false)
            }
        });
    });
	//* end proses download data sales dari hrd *//
</script>


<script>
	// untuk stacked modal
	// mau dikonversi ke jQuery ini
	var elements = Array.prototype.slice.call(document.querySelectorAll("[data-bs-stacked-modal]"));

	if (elements && elements.length > 0) {
		elements.forEach((element) => {
			if (element.getAttribute("data-kt-initialized") === "1") {
				return;
			}
			element.setAttribute("data-kt-initialized", "1");
			element.addEventListener("click", function(e) {
				e.preventDefault();
				const modalEl = document.querySelector(this.getAttribute("data-bs-stacked-modal"));
				if (modalEl) {
					const modal = new bootstrap.Modal(modalEl);
					modal.show();
				}
			});
		});
	}
</script>
