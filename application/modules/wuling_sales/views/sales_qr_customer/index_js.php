<script>
	$(document).ready(function() {
		$("#tgl_suspect_tambah").flatpickr();
		$("#kunjungan_berikut_tambah").flatpickr({
			minDate: "today"
		});
		$("#tgl_walk_in").flatpickr({
			minDate: "today"
		});

		$.ajax({
			url: "<?= base_url('sales_qr_customer/select2_unit') ?>",
			dataType: "json",
			success: function(data) {
				$('#opt_model_diminati').select2({
					placeholder: "Pilih Unit",
					data: data,
					allowClear: true,
					dropdownParent: $('#modal_tambah_customer'),
				});
			}
		});

		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>sales_pofil_customer/getDataSumberProspek",
			// data: {
			//     id_sumber_prospek: id_sumber_prospek,
			// },
			dataType: "json",
			success: function(data) {
				$('#opt_sumber_prospek').select2({
					placeholder: "Pilih Sumber Prospek",
					data: data,
					allowClear: true,
					dropdownParent: $('#modal_tambah_customer'),
				}).on('change.select2', function() {
					idSumberProspek = $(this).val();
					getShowHideSumberProspek(idSumberProspek);
					getAktivitas(idSumberProspek)
				});
			}
		});

		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>sales_pofil_customer/getDataProvinsi",
			dataType: "json",
			success: function(data) {
				$('.provinsi').select2({
					placeholder: "Pilih Provinsi",
					data: data,
					allowClear: true,
					dropdownParent: $('#modal_tambah_customer'),
				}).on('change.select2', function() {
					idProvinsi = $(this).val();

					$(".kabupaten").empty();
					$(".kabupaten").append('<option></option>');
					$(".kabupaten").select2({
						placeholder: "Pilih Kabupaten",
					});

					$(".kecamatan").empty();
					$(".kecamatan").append('<option></option>');
					$(".kecamatan").select2({
						placeholder: "Pilih Kecamatan",
					});

					$(".kelurahan").empty();
					$(".kelurahan").append('<option></option>');
					$(".kelurahan").select2({
						placeholder: "Pilih Kelurahan",
					});

					$.ajax({
						type: "POST",
						url: "<?= base_url() ?>sales_pofil_customer/getDataKabupaten",
						data: {
							id_provinsi: idProvinsi,
							// id_kabupaten: id_kabupaten,
						},
						dataType: "json",
						success: function(data) {
							$('.kabupaten').select2({
								placeholder: "Pilih Kabupaten",
								data: data,
								allowClear: true,
								dropdownParent: $('#modal_tambah_customer'),
							}).on('change.select2', function() {
								idKabupaten = $(this).val();

								$(".kecamatan").empty();
								$(".kecamatan").append('<option></option>');
								$(".kecamatan").select2({
									placeholder: "Pilih Kecamatan",
								});

								$(".kelurahan").empty();
								$(".kelurahan").append('<option></option>');
								$(".kelurahan").select2({
									placeholder: "Pilih Kelurahan",
								});

								$.ajax({
									type: "POST",
									url: "<?= base_url() ?>sales_pofil_customer/getDataKecamatan",
									data: {
										id_kabupaten: idKabupaten,
										// id_kecamatan: id_kecamatan,
									},
									dataType: "json",
									success: function(data) {
										$('.kecamatan').select2({
											placeholder: "Pilih Kecamatan",
											data: data,
											allowClear: true,
											dropdownParent: $('#modal_tambah_customer'),
										}).on('change.select2', function() {
											idKecamatan = $(this).val();

											$(".kelurahan").empty();
											$(".kelurahan").append('<option></option>');
											$(".kelurahan").select2({
												placeholder: "Pilih Kelurahan",
											});

											$.ajax({
												type: "POST",
												url: "<?= base_url() ?>sales_pofil_customer/getDataKelurahan",
												data: {
													id_kecamatan: idKecamatan,
													// id_kelurahan: id_kelurahan,
												},
												dataType: "json",
												success: function(data) {
													$('.kelurahan').select2({
														placeholder: "Pilih Kelurahan",
														data: data,
														allowClear: true,
														dropdownParent: $('#modal_tambah_customer'),
													});
												}
											});
										});

										$(".kelurahan").empty();
										$(".kelurahan").append('<option></option>');
										$(".kelurahan").select2({
											placeholder: "Pilih Kelurahan",
										});


									}
								});
							});

							$(".kecamatan").empty();
							$(".kecamatan").append('<option></option>');
							$(".kecamatan").select2({
								placeholder: "Pilih Kecamatan",
							});

							$(".kelurahan").empty();
							$(".kelurahan").append('<option></option>');
							$(".kelurahan").select2({
								placeholder: "Pilih Kelurahan",
							});
						}
					});
				});

				$(".kabupaten").empty();
				$(".kabupaten").append('<option></option>');
				$(".kabupaten").select2({
					placeholder: "Pilih Kabupaten",
				});

				$(".kecamatan").empty();
				$(".kecamatan").append('<option></option>');
				$(".kecamatan").select2({
					placeholder: "Pilih Kecamatan",
				});

				$(".kelurahan").empty();
				$(".kelurahan").append('<option></option>');
				$(".kelurahan").select2({
					placeholder: "Pilih Kelurahan",
				});
			}
		});

		//init
		// $.fn.dataTable.ext.errMode = 'none';
		table_customer = $("#table_customer").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			order: [],
			// autoWidth: false,
			ajax: {
				url: "<?= site_url('sales_qr_customer/get') ?>",
				// data: function(data) {
				// 	data.status = $("#opt_status").val();
				// 	data.cabang = $("#opt_cabang").val();
				// }
			},
			language: {},
			columns: [{
					title: "Tgl Input",
					data: "tgl_input",
				},
				{
					title: "Nama Customer",
					data: "nama",
				},
				{
					title: "Alamat Customer",
					data: "alamat",
				},
				{
					title: "No Handphone",
					data: "handphone",
				},
				{
					title: "Model Diminati",
					data: "model",
				},
				{
					title: "Waktu Dihubungi",
					data: "waktu_dihubungi",
				},
				{
					title: "Request Test Drive",
					data: "testdrive",
				},
				{
					title: "Aksi",
					data: "id",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						let status = row.status;
						if (status == '0') {
							html = `<td class="text-end">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-tambah" data-id="${data}" title="Simpan Customer">
									<i class="fa fa-check fs-3"></i>
								</button>
								<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Customer">
									<i class="bi bi-trash fs-3"></i>
								</button>
							</td>`;
						}
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
		});; //table_customer


	}); //ready 


	//* proses simpan user *//
	// klik btn simpan 
	$(document).on('click', '#btn-siddmpan', function() {
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
								table_customer.ajax.reload();
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


	//* hidden modal *//
	$('#modal_tambah_customer').on('hidden.bs.modal', function() {
		$("#add_customer")[0].reset();
		$(".provinsi").val("").trigger('change');
		$("#opt_model_diminati").val("").trigger('change');
		$("#opt_sumber_prospek").val("").trigger("change");

		$("#opt_sumber_prospek_survai").val("").trigger("change");
		$("#opt_telp_valid").val("").trigger("change");
		$("#opt_promo_product").val("").trigger("change");
		$("#opt_info_dokumen").val("").trigger("change");
	});
	//* end hidden modal *//


	//* fungsi tambah customer *//
	$(document).on('click', '.btn-tambah', function() {
		let id = $(this).data('id');
		//set id to hidden input
		$('#id_customer_qr').val($(this).data('id'));
		$.ajax({
			url: "<?= base_url('sales_qr_customer/get_customer_by_id') ?>",
			data: {
				'id': id,
			},
			dataType: "JSON",
			success: function(res) {
				if (!$.trim(res)) {
					alert("Data Kosong!!")
				} else {
					$('#modal_tambah_customer').modal('show');
					$("#id_prospek").val(res.id_prospek);
					$("#nama_customer").val(res.nama);
					$("#alamat_customer").val(res.alamat);
					$("#tlpn").val(res.handphone);
					$('#opt_model_diminati').val(res.model).trigger('change');

				}
			}
		});

	});
	//* end fungsi tambah customer *//

	//* fungsi simpan customer *//
	$(document).on('click', '#btn_simpan_customer', function() {
		$('#modal_survai_proses').modal('show');
	})

	$(document).on('click', '#btn_simpan_survai_proses', function() {
		var dataCusomer = $('#add_customer').serialize();
		var dataSurvaiProses = $('#add_survai_proses').serialize();

		var customer = new URLSearchParams(dataCusomer);
		var formDataCusomer = Object.fromEntries(customer.entries());
		// formDataCusomer.append(id_customer_qr,id_customer_qr);

		var survai = new URLSearchParams(dataSurvaiProses);
		var formDataSurvaiProses = Object.fromEntries(survai.entries());

		$.ajax({
			type: "POST",
			url: "<?= base_url() ?>sales_qr_customer/simpan",
			data: {
				...formDataCusomer,
				...formDataSurvaiProses,
			},
			dataType: "json",
			success: function(data) {
				if (data.status === true) {
					peringatan("Sukses", data.pesan, "success", 1500).then(function() {
						table_customer.ajax.reload();
						$("#modal_tambah_customer").modal('hide');
						$("#modal_survai_proses").modal('hide');
						$("#btn_simpan_survai_proses").removeAttr("data-kt-indicator").prop("disabled", false)
					})
				} else {
					if (typeof data.pesan == "string") {
						peringatan("Error", data.pesan, "error").then(function() {
							location.reload();
						})
					} else if (typeof data.pesan == "object") {
						obj = data.pesan
						// if ("error" in response && response.error != '') {
						// 	your code to execute
						// 	if the response is of type object
						// }
						for(var key in obj){
							pesan("error", obj[key])
							// alert(key+': '+ obj[key])
						}
						$('#modal_survai_proses').modal('hide');
					}
					
				}
			},
			beforeSend: function() {
				$("#btn_simpan_customer").attr("data-kt-indicator", "on").prop("disabled", true)
			},
		});
	});
	//* end fungsi simpan customer *//

	//* fungsi hapus customer *//
	$(document).on('click', '.btn-hapus', function() {
		let id = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus customer?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						url: "<?= site_url('sales_qr_customer/hapus'); ?>",
						data: {
							id: id
						},
						dataType: "JSON",
						success: function(response) {
							if (response.status === true) {
								peringatan("Sukses", response.pesan, "success", 1500)
									.then(function() {
										table_customer.ajax.reload(null, false);
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
	//* end fungsi hapus customer *//

	//* static functions *//
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

	getShowHideSumberProspek = (id_sumber) => {
		if (id_sumber == '2' || id_sumber == '5' || id_sumber == '6') {
			$('#form_aktivitas').show();
			$('#form_egent').hide();
			$('#form_sales_digital').hide();
			$('#form_stnk_norak').hide();
			$('#form_walk').hide();
			$('#form_referensi').hide();
		} else if (id_sumber == '8') {
			$('#form_egent').show();
			$('#form_aktivitas').hide();
			$('#form_sales_digital').hide();
			$('#form_stnk_norak').hide();
			$('#form_walk').hide();
			$('#form_referensi').hide();
		} else if (id_sumber == '15') {
			$('#form_sales_digital').show();
			$('#form_aktivitas').hide();
			$('#form_egent').hide();
			$('#form_stnk_norak').hide();
			$('#form_walk').hide();
			$('#form_referensi').hide();
		} else if (id_sumber == '26') {
			$('#form_stnk_norak').show();
			$('#form_aktivitas').hide();
			$('#form_egent').hide();
			$('#form_sales_digital').hide();
			$('#form_walk').hide();
			$('#form_referensi').hide();
		} else if (id_sumber == '31' || id_sumber == '32') {
			$('#form_walk').show();
			$('#form_aktivitas').hide();
			$('#form_egent').hide();
			$('#form_sales_digital').hide();
			$('#form_stnk_norak').hide();
			$('#form_referensi').hide();
		} else if (id_sumber == '33') {
			$('#form_referensi').show();
			$('#form_aktivitas').hide();
			$('#form_egent').hide();
			$('#form_sales_digital').hide();
			$('#form_stnk_norak').hide();
			$('#form_walk').hide();
		} else {
			$('#form_aktivitas').hide();
			$('#form_egent').hide();
			$('#form_sales_digital').hide();
			$('#form_stnk_norak').hide();
			$('#form_walk').hide();
			$('#form_referensi').hide();
		}
	}

	getAktivitas = (id_sumber_prospek) => {
		$.ajax({
			type: "method",
			url: "<?= base_url() ?>sales_pofil_customer/getDataAktivitas",
			data: {
				id_sumber_prospek: id_sumber_prospek,
			},
			dataType: "json",
			success: function(response) {

			}
		});
	}
	//* end static functions *//
</script>
