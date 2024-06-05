<script>
	$(document).ready(function() {
		//vars
		is_update = false;
		is_copy = false;

		//init
		$(".table-coverage-edit").hide();

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
					table_user.ajax.reload();
				});
				$("#user_opt_cabang").select2({
					placeholder: "-- PILIH CABANG --",
					dropdownParent: $('#modal_tambah_user'),
					data: response,
				}).change(function() {
					//$('#btn-lihat').click();
				});
			}
		});

		//fill data role to select2
		$.ajax({
			url: "<?= site_url('wuling_adm_user_global/select2_role'); ?>",
			dataType: 'JSON',
			success: function(result) {
				$("#user_opt_role").select2({
					placeholder: "-- PILIH ROLE --",
					dropdownParent: $('#modal_tambah_user'),
					data: result,
				}).change(function() {});
			}
		});

		$("#opt_status").select2({
			placeholder: "-- SEMUA STATUS --",
			allowClear: true,
		}).change(function() {
			table_user.ajax.reload();
		});

		//init
		// $.fn.dataTable.ext.errMode = 'none';
		table_user = $("#table_user").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			// order: [],
			// autoWidth: false,
			ajax: {
				url: "<?= site_url('wuling_adm_user/get') ?>",
				data: function(data) {
					data.status = $("#opt_status").val();
					data.cabang = $("#opt_cabang").val();
				}
			},
			language: {},
			columns: [{
					data: "cabang",
				},
				{
					data: "jabatan",
				},
				{
					data: "nik",
				},
				{
					data: "nama_lengkap",
				},
				{
					data: "username",
				},
				{
					data: "role",
				},
				{
					data: "status_aktif",
					className: "d-flex flex-center",
					render: function(data, type, row, meta) {
						let html = '';
						if (data == 'on') {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${row.id_user}" class="form-check-input h-20px w-30px sw-status" type="checkbox" value="1" checked="checked" />
							</label>`
						} else {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${row.id_user}" class="form-check-input h-20px w-30px sw-status" type="checkbox" value="0" />
							</label>`
						}
						return html;
					},
				},
				{
					data: "time_login",
					className: "text-end"
				},
				{
					data: "id_user",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_user" title="Edit User">
									<i class="bi bi-pencil fs-3"></i>
								</button>
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-copy" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_user" title="Duplicate User">
									<i class="bi bi-copy fs-3"></i>
								</button>
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-reset" data-id="${data}" data-username="${row.username}"title="Reset Password">
									<i class="bi bi-repeat fs-3"></i>
								</button>
								<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus User">
									<i class="bi bi-trash fs-3"></i>
								</button>
							</td>`;
						return html
					}
				}
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
		});; //table_user

		table_coverage = $("#table_coverage").DataTable({
			scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false, //searching
			lengthChange: false, //menu kolom di kiri atas
			paginate: false, //disable paginate,
			info: false, //disable info row kiri bawah  
			ordering: false,
			ajax: {
				url: "<?= site_url('wuling_adm_user_global/get_coverage'); ?>",
				dataType: "JSON",
			},
			language: {
				"emptyTable": "Data masih kosong..."
			},
			columns: [{
					data: "lokasi",
					width: "w-250px",
				},
				{
					data: "id_perusahaan",
					className: "d-flex flex-center",
					width: "w-50px",
					render: function(data, type, row, meta) {
						let html = '';
						if (data == 'on') {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${row.id_perusahaan}" class="form-check-input h-20px w-30px sw-coverage" type="checkbox" value="1" checked="checked" />
								</label>`
						} else {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${row.id_perusahaan}" class="form-check-input h-20px w-30px sw-coverage" type="checkbox" value="0" />
								</label>`
						}
						return html;
					},
				},
			],
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		}); //table_coverage

		table_pegawai = $("#table_pegawai").DataTable({
			searchDelay: 500,
			processing: true,
			serverSide: true,
			destroy: true,
			pagingType: "simple",
			lengthMenu: [7],
			ordering: false,
			ajax: {
				url: "<?= site_url('wuling_adm_user_global/get_data_pegawai'); ?>",
				dataType: "JSON",
			},

			language: {
				"emptyTable": "Data masih kosong..."
			},
			columns: [{
					data: "nik",
				},
				{
					data: "lokasi",
				},
				{
					data: "nama_karyawan",
				},
				{
					data: "nama_jabatan",
				},
				{
					data: null,
					width: "65px",
					render: function(data, type, row, meta) {
						html = `<button class="btn btn-sm btn-light-primary btn-pilih-pegawai" data-nik="${row.nik}" data-nama="${row.nama_karyawan}" data-jabatan="${row.nama_jabatan}" title="Pilih Karyawan" data-rel="tooltip">Pilih</button>`;
						return html
					},
				},
			],
			dom: `
				"<'row'" +
				"<'col-sm-6 d-flex align-items-center justify-conten-start'>" +
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
		}); //table-pegawai

		//cari pegawai
		$('.btn-cari-pegawai').click(function() {
			let cabang = $("#user_opt_cabang").val();
			if (cabang == '') {
				pesan('warning', 'Cabang belum dipilih');
				$("#user_opt_cabang").select2('open');
				return false;
			}
			// table_pegawai.ajax.reload();
			$("#modal_tambah_user").modal('hide');
			$("#modal_cari_pegawai").modal('show');
		});
	}); //ready 


	//* proses tambah user *//
	$('.btn-tambah').click(function() {
		is_update = false;
		is_copy = false;
		$("#table_coverage").show();
		$("#table_coverage_edit").hide();

		$("#id-table-coverage").show();
		$("#id-table-coverage-edit").hide();

		$(".judul-modal").text("Tambah User");
		//$("#btn-cari-nik").prop('disabled', false);
		//reset form 		
		$("#user_opt_cabang").val('').trigger('change');
		$("#user_nik").val('');
		$("#user_nama_lengkap").val('');
		$("#user_name").val('');
		$("#user_opt_role").val('').trigger('change');
		$(".sw-coverage:checked", table_coverage.nodes()).each(function() {
			$(this).click();
		});
		table_pegawai.search('').draw();
	})

	//pilih pegawai 	
	$(document).on('click', '.btn-pilih-pegawai', function() {
		let nama = $(this).data('nama'),
			nik = $(this).data('nik'),
			jabatan = $(this).data('jabatan');
		$("#user_nik").val(nik);
		$("#user_nama_lengkap").val(nama);
		$("#user_jabatan").val(jabatan);
		generate_username("#user_name");
		$("#modal_tambah_user").modal('show');
		$("#modal_cari_pegawai").modal('hide');
	});

	//pilih level
	$(document).on('change', '#user_opt_role', function() {
		generate_username("#user_name");
	})

	//pilih cabang
	$(document).on('change', '#user_opt_cabang', function() {
		generate_username("#user_name");
	})
	//custom username
	$(document).on('dblclick', '#user_name', function() {
		$('#user_name').prop('readonly', false);
	})
	//* end proses tambah user *//


	//* proses simpan user *//
	// klik btn simpan 
	$(document).on('click', '#btn-simpan', function() {
		//init var
		let id_user = null,
			cabang = $("#user_opt_cabang").val(),
			nik = $("#user_nik").val(),
			nama = $("#user_nama_lengkap").val(),
			username = $("#user_name").val(),
			role = $("#user_opt_role").val(),
			password = generate_password(),
			coverage = [],
			coverage_edit = [],
			url = "<?= site_url('wuling_adm_user/tambah_user'); ?>",
			i = 0,
			i_edit = 0;

		$(".sw-coverage:checked", table_coverage.nodes()).each(function() {
			coverage[i++] = $(this).data('id');
		});

		if (is_update) {
			id_user = $('#btn-simpan').data('id-user');
			$(".sw-coverage:checked", table_coverage_edit.nodes()).each(function() {
				coverage[i_edit++] = $(this).data('id');
			});

			if (is_copy) {
				url = "<?= site_url('wuling_adm_user/copy_user'); ?>";
			} else {
				url = "<?= site_url('wuling_adm_user/update_user'); ?>";
			}

			if (coverage.length == 0) {
				pesan('warning', 'Coverage tissdak boleh kosong!');
				return false;
			}
		} else {
			if (coverage.length == 0) {
				pesan('warning', 'Coverage tidak boleh kosong!');
				return false;
			}
		}

		if (cabang.length == 0 || cabang == '') {
			pesan('warning', 'Cabang tidak boleh kosong!');
			$("#user_opt_cabang").select2('open');
			return false;
		}
		if (nik.length == 0 || nik == '') {
			pesan('warning', 'NIK kosong, silahkan pilih karyawan!');
			return false;
		}
		if (nama.length == 0) {
			pesan('warning', 'Nama tidak boleh kosong!');
			return false;
		}
		if (role.length == 0) {
			pesan('warning', 'Role tidak boleh kosong!');
			$("#user_opt_role").select2('open');
			return false;
		}


		Swal.fire({
			text: `Anda yakin untuk menyimpan data?`,
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
					url: url,
					data: {
						id: id_user,
						cabang: cabang,
						nik: nik,
						username: username,
						role: role,
						coverage: coverage,
						password: password,
					},
					beforeSend: function() {
						$("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							let pesan = '';
							if (is_update) {
								if (is_copy) {
									pesan = `Nama Lengkap: ${response.nama}<br>Username: ${response.username}`;
								} else {
									pesan = "";
								}
							} else {
								pesan = `Nama Lengkap: ${response.nama}<br>Username: ${response.username} <br>Password: ${response.password}`;
							}
							Swal.fire({
								title: response.pesan, //"Berhasil",
								html: pesan,
								icon: "success",
								confirmButtonText: "OK",
								customClass: {
									confirmButton: "btn btn-sm fw-bold btn-primary"
								},
							}).then(function() {
								table_user.ajax.reload();
								reset_form();
							})
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_tambah_user').modal('hide');
						$("#btn-simpan").removeAttr("data-kt-indicator").prop("disabled", false)
					},
					error: function(xhr, status, error) {
						var err = eval("(" + xhr.responseText + ")");
						console.log(err.Message);
						pesan("error", "Terjadi Kesalahan");
						location.reload();
					}
				});
			}
		});
	});
	//* end proses simpan user *//


	//* fungsi enable-disable user *//
	$(document).on('change', '.sw-status', function() {
		let id_user = $(this).data('id'),
			//status = $(this).is(':checked');
			status = $(this).is(':checked') === true ? 'on' : 'off';
		$.ajax({
			type: "POST",
			url: "<?= base_url('wuling_adm_user/set_status') ?>",
			data: {
				'id_user': id_user,
				'status': status,
			},
			dataType: "JSON",
			success: function(result) {
				if (result.status === true) {
					peringatan('Sukses', result.pesan, 'success', 1500)
				} else {
					peringatan('Error', result.pesan, 'error', 1500)
				}
				//table_user.ajax.reload(null, false);
			}
		});
	});
	//* end funsi enable-disable user *//

	//* fungsi edit user *//
	$(document).on('click', '.btn-edit', function() {
		id_user = $(this).data('id');
		is_update = true;
		is_copy = false;
		table_pegawai.search('').draw();
		$(".judul-modal").text("Edit User");

		$("#id-table-coverage-edit").show();
		$("#id-table-coverage").hide();

		table_coverage_edit = $("#table_coverage").DataTable({
			destroy: true,
			scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false, //searching
			lengthChange: false, //menu kolom di kiri atas
			paginate: false, //disable paginate,
			info: false, //disable info row kiri bawah    
			ordering: false,
			ajax: {
				type: "POST",
				url: "<?= site_url('wuling_adm_user/get_user_by_id'); ?>",
				dataType: "JSON",
				data: {
					id: id_user
				},
			},
			language: {
				"emptyTable": "Data masih kosong..."
			},
			columns: [{
					data: "lokasi",
				},
				{
					data: "id_perusahaan",
					className: "d-flex flex-center",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						if (row.coverage == data) {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${data}" class="form-check-input h-20px w-30px sw-coverage" type="checkbox" value="1" checked="checked" />
								</label>`
						} else {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${data}" class="form-check-input h-20px w-30px sw-coverage" type="checkbox" value="0" />
								</label>`
						}
						return html;
					},
				},
			],
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		}).on('xhr', function() {
			var json = table_coverage_edit.ajax.json();
			if (json.user != null) {
				$("#user_opt_cabang").val(json.user.id_cabang).trigger('change');
				$("#user_nik").val(json.user.nik);
				$("#user_jabatan").val(json.user.jabatan);
				$("#user_nama_lengkap").val(json.user.nama_lengkap);
				$("#user_name").val(json.user.username);
				$("#user_opt_role").val(json.user.id_role).trigger('change');
				//disable tombol cari nik
				//$("#btn-cari-nik").prop('disabled', true);
			} else {
				peringatan('Error', 'Data user kosong', 'error')
					.then(function() {
						location.reload();
					});
			}
		}); //table_coverage_edit  
		//simpan id user ke button
		$('#btn-simpan').data('id-user', id_user);
	});
	//* end fungsi edit user *//

	//* fungsi copy user *//
	$(document).on('click', '.btn-copy', function() {
		id_user = $(this).data('id');
		is_update = true;
		is_copy = true;
		$(".judul-modal").text("Duplikasi User");

		table_coverage_edit = $("#table_coverage").DataTable({
			destroy: true,
			scrollY: "400px",
			scrollCollapse: true,
			paging: false,
			searching: false, //searching
			lengthChange: false, //menu kolom di kiri atas
			paginate: false, //disable paginate,
			info: false, //disable info row kiri bawah    
			ordering: false,
			ajax: {
				type: "POST",
				url: "<?= site_url('wuling_adm_user/get_user_by_id'); ?>",
				dataType: "JSON",
				data: {
					id: id_user
				},
			},
			language: {
				"emptyTable": "Data masih kosong..."
			},
			columns: [{
					data: "lokasi",
				},
				{
					data: "id_perusahaan",
					className: "d-flex flex-center",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						if (row.coverage == data) {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${data}" class="form-check-input h-20px w-30px sw-coverage" type="checkbox" value="1" checked="checked" />
								</label>`
						} else {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${data}" class="form-check-input h-20px w-30px sw-coverage" type="checkbox" value="0" />
								</label>`
						}
						return html;
					},
				},
			],
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		}).on('xhr', function() {
			var json = table_coverage_edit.ajax.json();
			if (json.user != null) {
				$("#user_opt_cabang").val(json.user.id_cabang).trigger('change');
				$("#user_nik").val(json.user.nik);
				$("#user_jabatan").val(json.user.jabatan);
				$("#user_nama_lengkap").val(json.user.nama_lengkap);
				$("#user_name").val(json.user.username);
				$("#user_opt_role").val(json.user.id_role).trigger('change');
			} else {
				peringatan('Error', 'Data user kosong', 'error')
					.then(function() {
						location.reload();
					});
			}
		}); //table_coverage_edit  
		//simpan id user ke button
		$('#btn-simpan').data('id-user', id_user);
	});
	//* end fungsi copy user *//


	//* fungsi reset user *//
	$(document).on('click', '.btn-reset', function() {
		let id_user = $(this).data('id'),
			username = $(this).data('username'),
			password = generate_password();

		Swal.fire({
			text: `Anda yakin ingin mereset password untuk user ${username}?`,
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
						url: "<?= site_url('wuling_adm_user/reset_user'); ?>",
						data: {
							id: id_user,
							password: password,
						},
						dataType: "JSON",
						beforeSend: function() {
							// $("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled",true)
						},
						success: function(response) {
							if (response.status === true) {
								// $('#modal_tambah_user').modal('hide');
								let pesan = `Nama Lengkap: ${response.nama}<br>Username: ${response.username} <br>Password: ${response.password}`;
								Swal.fire({
									title: response.pesan, //"Berhasil",
									html: pesan,
									icon: "success",
									confirmButtonText: "OK",
									customClass: {
										confirmButton: "btn btn-sm fw-bold btn-primary"
									},
								}).then(function() {
									table_user.ajax.reload();
									reset_form();
								})
							} else {
								peringatan("Error", response.pesan, "error")
									.then(function() {
										location.reload();
									});
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
	//* end fungsi enable-disable user *//


	//* hidden modal *//
	$('#modal_tambah_user').on('hidden.bs.modal', function() {
		$('.sw-all').prop('checked', false);
		// $(".table-coverage").show();
		// $(".table-coverage-edit").hide();
	});
	//* end hidden modal *//

	//* fungsi hapus user *//
	$(document).on('click', '.btn-hapus', function() {
		let id_user = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus data?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						url: "<?= site_url('wuling_adm_user/hapus_user'); ?>",
						data: {
							id: id_user
						},
						dataType: "JSON",
						success: function(response) {
							if (response.status === true) {
								peringatan("Sukses", response.pesan, "success", 1500)
									.then(function() {
										table_user.ajax.reload(null, false);
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
	//* end fungsi hapus user *//

	//* static functions *//
	function generate_username(element) {
		let nama_lengkap = $("#user_nama_lengkap").val().toLowerCase().trim(),
			suku_kata = nama_lengkap.split(" "),
			nik = $('#user_nik').val(),
			username = '';
		if ($('#user_opt_role').val() == 0 || $('#user_opt_role').val().length === 0) {
			kode_level = '';
		} else {
			kode_level = $('#user_opt_role').select2('data')[0].kode;
		}
		if ($('#user_opt_cabang').val() == 0 || $('#user_opt_cabang').val() === null || $('#user_opt_cabang').val().length === 0) {
			kode_perusahaan = '';
		} else {
			kode_perusahaan = $('#user_opt_cabang').select2('data')[0].id;
		}

		if (nama_lengkap != '') {
			switch (suku_kata.length) {
				case 1:
					username = nama_lengkap.substring(0, 3);
					break;
				case 2:
					username = suku_kata[0].substring(0, 1) + suku_kata[1].substring(0, 2);
					break;
				case 3:
				case 4:
				case 5:
				case 6:
					username = suku_kata[0].substring(0, 1) + suku_kata[1].substring(0, 1) + suku_kata[2].substring(0, 1);
					break;
				default:
					username = 'wrong';
					break;
			}
		}
		//$(element).val(username+nik+kode_level+kode_perusahaan);
		$(element).val(nik + kode_level + kode_perusahaan);
	}

	generate_password = () => {
		let karakter = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
			panjang_password = 8,
			password = "";
		for (var i = 0; i <= panjang_password; i++) {
			var randomNumber = Math.floor(Math.random() * karakter.length);
			password += karakter.substring(randomNumber, randomNumber + 1);
		}
		return password;
	}

	reset_form = () => {
		$("#user_opt_cabang").val('').trigger('change');
		$("#user_nik").val('');
		$("#user_nama_lengkap").val('');
		$("#user_name").val('');
		$("#user_opt_role").val('').trigger('change');
		$(".sw-coverage:checked", table_coverage.nodes()).each(function() {
			$(this).click();
		});
		table_pegawai.search('').draw();
	}
	//check semua coverage
	$(document).on('click', '.sw-all', function() {
		$("input:checkbox.sw-coverage").prop('checked', this.checked);
	});
	//* end static functions *//
</script>
