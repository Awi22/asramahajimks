<script>
	$(document).ready(function() {
		//vars
		is_update = false;

		$.ajax({
			url: "<?= site_url('wuling_as_kpi_bobot/select2_kategori'); ?>",
			dataType: 'JSON',
			success: function(result) {
				$("#modal_opt_kategori").select2({
					dropdownParent: $('#modal_tambah_kategori'),
					data: result,
				}).change(function() {
				});

				$("#opt_kategori").select2({
					data: result,
					allowClear: true,
				}).change(function() {
					table_kategori.ajax.reload(null, false);
				});
			}
		});

		table_kategori = $("#table_kategori").DataTable({
			processing: true,
			ordering: [],
			ajax: {
				url: "<?= site_url('wuling_as_kpi_bobot/get') ?>",
				data: function(data) {
				data.kategori = $("#opt_kategori").val();
				}
			},
			language: {},
			columns: [{
					title: "Kategori",
					data: "kategori",
				},
				{
					title: "Nama",
					data: "name",
				},
				{
					title: "Bobot 2",
					data: "bobot2",
					className: "text-center",
					render: function(data) {
						return `${data}%`
					}
				},
				{
					title: "Bobot 3",
					data: "bobot3",
					className: "text-center",
					render: function(data) {
						return `${data}%`
					}
				},
				{
					title: "Bobot 4",
					data: "bobot4",
					className: "text-center",
					render: function(data) {
						return `${data}%`
					}
				},
				{
					data: "id",
					title: "Aksi",
					className: "text-center w-150px ",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="text-end">
									<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_kategori" title="Edit Item">
										<i class="bi bi-pencil fs-3"></i>
									</button>
									<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus Item">
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
		});; //table_kategori

	}) //ready

	$('.btn-tambah').click(function(){
		is_update = false;
		$(".judul-modal").text("Tambah Kategori");
	})

	$(document).on('click', '#btn-simpan-kategori', function(e) {
		e.preventDefault();
	
		let id_kategori = null,
			kategori = $("#modal_opt_kategori").val(),
			nama = $("#modal_nama_kategori").val(),
			bobot_2 = $("#modal_bobot_dua").val(),
			bobot_3 = $("#modal_bobot_tiga").val(),
			bobot_4 = $("#modal_bobot_empat").val(),
			url = "<?= site_url('wuling_as_kpi_bobot/simpan'); ?>";


		if (is_update) {
			id_kategori = $('#btn-simpan-kategori').data('id');
		}


		if (kategori.length == 0 || kategori == '') {
			pesan('warning', 'Kategori tidak boleh kosong!');
			$("#modal_opt_kategori").select2('open');
			return false;
		}
		if (nama.length == 0 || nama == '') {
			pesan('warning', 'Nama tidak boleh kosong!');
			return false;
		}

		konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: url,
					data: {
						id: id_kategori,
						kategori: kategori,
						nama: nama,
						bobot_2: bobot_2,
						bobot_3: bobot_3,
						bobot_4: bobot_4,
					},
					beforeSend: function() {
						$("#btn-simpan-kategori").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							peringatan("Sukses", response.pesan, 'success', 1500)
							table_kategori.ajax.reload();
							reset_form();
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_tambah_kategori').modal('hide');
						$("#btn-simpan-kategori").removeAttr("data-kt-indicator").prop("disabled", false)
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

	$(document).on('click', '.btn-edit', function() {
		id_kategori = $(this).data('id');
		is_update = true;
		$(".judul-modal").text("Edit Kategori");
		$('#btn-simpan-kategori').data('id', id_kategori);

		$.ajax({
			url: "<?= site_url('wuling_as_kpi_bobot/get_kategori_by_id'); ?>",
			dataType: "JSON",
			data: {
				id: id_kategori
			},
			success: function(r) {
				if (r != null || r != '') {
					$("#modal_opt_kategori").val(r.kategori).trigger('change');
					$("#modal_nama_kategori").val(r.name);
					$("#modal_bobot_dua").val(r.bobot2);
					$("#modal_bobot_tiga").val(r.bobot3);
					$("#modal_bobot_empat").val(r.bobot4);
				} else {
					pesan('error', 'Terjadi kesalahan saat mengambil data');
				}

			},
			error: function(xhr, status, error) {
				var err = eval("(" + xhr.responseText + ")");
				console.log(err.Message);
				pesan('error', 'Terjadi kesalahan');
			}
		});
	});

	$(document).on('click', '.btn-hapus', function() {
		let id_kategori = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus data?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						url: "<?= site_url('wuling_as_kpi_bobot/hapus'); ?>",
						data: {
							id: id_kategori
						},
						dataType: "JSON",
						success: function(response) {
							if (response.status === true) {
								peringatan("Sukses", response.pesan, "success", 1500)
									.then(function() {
										table_kategori.ajax.reload(null, false);
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

	reset_form = () => {
		$("#modal_opt_kategori").val('').trigger('change');
		$("#modal_nama_kategori").val('');
		$("#modal_bobot_dua").val('');
		$("#modal_bobot_tiga").val('');
		$("#modal_bobot_empat").val('');
		table_kategori.search('').draw();
	}
</script>
