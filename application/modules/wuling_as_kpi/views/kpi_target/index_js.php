<script>
	$(document).ready(function() {
		var arrBulan = [{
				id: 1,
				text: 'Januari',
			},
			{
				id: 2,
				text: 'Februari'
			},
			{
				id: 3,
				text: 'Maret'
			},
			{
				id: 4,
				text: 'April'
			},
			{
				id: 5,
				text: 'Mei'
			},
			{
				id: 6,
				text: 'Juni'
			},
			{
				id: 7,
				text: 'Juli'
			},
			{
				id: 8,
				text: 'Agustus'
			},
			{
				id: 9,
				text: 'September'
			},
			{
				id: 10,
				text: 'Oktober'
			},
			{
				id: 11,
				text: 'November'
			},
			{
				id: 12,
				text: 'Desember'
			},
		];
		var d = new Date(),
			bulan = d.getMonth(),
			tahun = d.getFullYear();
		var curTahun = new Date().getFullYear();
		var arrTahun = [];
		for (var i = curTahun; i >= 2018; i--) {
			let j = {
				"id": i,
				"text": i
			};
			arrTahun.push(j);
		}
		$("#opt_bulan").select2({
			data: arrBulan,
		}).val(bulan + 1).trigger('change');

		$("#opt_tahun").select2({
			data: arrTahun,
		}).val(tahun).trigger('change');

		$("#modal_opt_bulan").select2({
			data: arrBulan,
		}).val(bulan + 1).trigger('change');
		$("#modal_opt_tahun").select2({
			data: arrTahun,
		}).val(tahun).trigger('change');


		//vars
		is_update = false;

		$.ajax({
			url: "<?= site_url('wuling_as_kpi_target/select2_key_kategori'); ?>",
			dataType: 'JSON',
			success: function(result) {
				$("#modal_opt_key_kategori").select2({
					dropdownParent: $('#modal_upload'),
					data: result,
				}).change(function() {
				});
			}
		});

		$.ajax({
			url: "<?= site_url('wuling_adm_user_global/select2_cabang'); ?>",
			dataType: 'JSON',
			success: function(response) {
				$("#opt_cabang").select2({
					data: response,
					allowClear: true,
				}).change(function() {
					table_kategori.ajax.reload();
				});
			}
		});

		table_kategori = $("#table_kategori").DataTable({
			processing: true,
			// ordering: false,
			ajax: {
				url: "<?= site_url('wuling_as_kpi_target/get') ?>",
				data: function(data) {
					data.tahun = $("#opt_tahun").val();
					data.bulan = $("#opt_bulan").val();
					data.cabang = $("#opt_cabang").val();
				}
			},
			language: {},
			columns: [
				{
					title: "Key Area",
					data: "name",
				},
				{
					title: "Cabang",
					data: "cabang",
				},
				{
					title: "Target",
					data: "target",
					className: "text-center",
				},
				// {
				// 	data: "id",
				// 	title: "Aksi",
				// 	className: "text-center w-150px ",
				// 	searchable: false,
				// 	orderable: false,
				// 	render: function(data, type, row, meta) {
				// 		let html = '';
				// 		let aksi = row.method;
				// 		switch (aksi) {
				// 			case 'upload':
				// 				html = `<td class="text-end">
				// 						<button class="btn btn-icon btn-light-primary w-30px h-30px btn-upload" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_upload" title="Upload">
				// 							<i class="bi bi-upload fs-3"></i>
				// 						</button>
				// 					</td>`;
				// 				break;
				// 			case 'api':
				// 				html = `<td class="text-end">
				// 						<button class="btn btn-icon btn-light-primary w-30px h-30px btn-aksi" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_api" title="Get API Data">
				// 							<i class="bi bi-repeat fs-3"></i>
				// 						</button>
				// 					</td>`;
				// 				break;
				// 			default:
				// 				break;
				// 		}
				// 		return html
				// 	}
				// }
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
			initComplete: function(settings, json) {
				$("#opt_tahun").change(function(){
					table_kategori.ajax.reload(null, false)
				})
				$("#opt_bulan").change(function(){
					table_kategori.ajax.reload(null, false)
				})
			},
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		
		});; //table_kategori

		
	}) //ready

	$(document).on('click', '#btn-simpan', function(e) {
		e.preventDefault();
	
		let id_kategori = $('#btn-simpan').data('id'),
			tahun = $("#modal_opt_tahun").val(),
			bulan = $("#modal_opt_bulan").val(),
			key_kategori = $("#modal_opt_key_kategori").val(),
			upload_file = $("[name='uploadFile']")[0].files[0],
			form_data = new FormData(),
			url = "<?= site_url('wuling_as_kpi_target/import_excel'); ?>";
			form_data.append('upload_file', upload_file);
			form_data.append('id', key_kategori);
			form_data.append('tahun', tahun);
			form_data.append('bulan', bulan);

		if (key_kategori.length==0||key_kategori==''){
			pesan('error', 'Kategori belum dipilih!');
			return false;
		}

		if ($("[name='uploadFile']")[0].files.length === 0) {
			pesan('error', 'File upload kosong!');
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
					contentType: false,
					processData: false,
					url: url,
					data : form_data,
					beforeSend: function() {
						$("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
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
						$('#modal_upload').modal('hide');
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

	$('#modal_upload').on('hidden.bs.modal', function() {
		reset_form();
	});

	reset_form = () => {
		$("[name='uploadFile']").val(null);
		$("#modal_opt_key_kategori").val('').trigger('change');
	}
</script>
