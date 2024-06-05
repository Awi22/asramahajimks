<script>
	$(document).ready(function() {
		//vars
		role_id = null;
		is_update = false;
		is_copy = false;


		$("#btn-simpan-menu").html('<i class="icon-save"></i> Simpan').prop('disabled', true);


		table_role = $("#table_role").DataTable({
			processing: true,
			ajax: {
				url: "<?= site_url('wuling_adm_menu_role/get') ?>",
			},
			language: {},
			columns: [{
					data: "role_name",
				},
				{
					data: "role_id",
					searchable: false,
					orderable: false,
					className: "text-center",
					render: function(data, type, row, meta) {
						let html = '';
						html = `
								<button class="btn btn-icon btn-active-light-primary w-30px h-30px btn-edit" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_tambah_role" title="Edit role">
									<i class="bi bi-pencil fs-4"></i>
								</button>
								<button class="btn btn-icon btn-active-light-primary w-30px h-30px btn-assign-menu" data-id="${data}" data-bs-toggle="modal" data-bs-target="#modal_assign_menu" title="Assign Menu">
									<i class="bi bi-menu-button fs-4"></i>
								</button>
								<button class="btn btn-icon btn-active-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus role">
									<i class="bi bi-trash fs-4"></i>
								</button>
							`;
						return html
					}
				}
			],
		}).on('error.dt', function(e, settings, techNote, message) {
			pesan('error', message);
			console.log('Error DataTables: ', message);
		});; //table_role

		//fill option role ke select2
		$.ajax({
			url: "<?= site_url('wuling_adm_user_global/select2_group_menu'); ?>",
			dataType: 'JSON',
			success: function(result) {
				$("#opt_role_group").select2({
					placeholder: "Pilih Group Menu",
					dropdownParent: $('#modal_assign_menu'),
					data: result,
				}).change(function() {
					//$('#btn-lihat').click();
				});
			}
		});

	}); //ready 


	//* proses role *//
	//klik tombol tambah
	$('.btn-tambah').click(function() {
		is_update = false;
		is_copy = false;

		$(".judul-modal").text("Tambah Role");
		$("#role_name").val('');
	})

	// klik btn simpan 
	$(document).on('click', '#btn-simpan', function() {
		//init var
		let role_id = null,
			role_name = $("#role_name").val(),
			the_url = "<?= site_url('wuling_adm_menu_role/simpan'); ?>";

		if (is_update) {
			role_id = $('#btn-simpan').data('role-id');
			the_url = "<?= site_url('wuling_adm_menu_role/update'); ?>";
		}

		if (role_name.length == 0 || role_name == '') {
			pesan('warning', 'Nama role tidak boleh kosong!');
			$("#role_name").focus();
			return false;
		}

		konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: the_url,
					data: {
						role_id: role_id,
						role_name: role_name,
					},
					beforeSend: function() {
						$("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							peringatan("Sukses", response.pesan, 'success', 1500)
							table_role.ajax.reload();
							reset_form();
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_tambah_role').modal('hide');
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
		})
	});

	//klik tombol edit
	$(document).on('click', '.btn-edit', function() {
		let role_id = $(this).data('id');
		is_update = true;
		is_copy = false;
		$(".judul-modal").text("Edit Role");

		$.ajax({
			dataType: "JSON",
			url: "<?= site_url('wuling_adm_menu_role/get_role_by_id'); ?>",
			data: {
				id: role_id,
			},
			success: function(response) {
				//fill data to form
				$("#role_name").val(response.role_name);
				$('#btn-simpan').data('role-id', role_id);
			},
			error: function(xhr, status, error) {
				var err = eval("(" + xhr.responseText + ")");
				console.log(err.Message);
				pesan_swal('error', err.Message);
			}
		});
	});

	//menghapus role
	$(document).on('click', '.btn-hapus', function() {
		let role_id = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus data?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						url: "<?= site_url('wuling_adm_menu_role/hapus'); ?>",
						data: {
							id: role_id
						},
						dataType: "JSON",
						success: function(response) {
							if (response.status === true) {
								peringatan("Sukses", response.pesan, "success", 1500)
									.then(function() {
										table_role.ajax.reload(null, false);
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
	//* end proses  role *//


	//* proses assign menu *//
	// klik assign menu
	$(document).on('click', '.btn-assign-menu', function() {
		role_id = $(this).data('id');

		$.ajax({
			dataType: "JSON",
			url: "<?= site_url('wuling_adm_menu_role/get_role_by_id'); ?>",
			data: {
				id: role_id,
			},
			beforeSend: function() {},
			success: function(response) {
				//fill data to form
				$(".judul-modal").text(response.role_name);
				$('#btn-simpan-menu').data('role-id', role_id);
			},
			error: function(xhr, status, error) {
				var err = eval("(" + xhr.responseText + ")");
				console.log(err.Message);
				pesan_swal('error', err.Message);
			}
		});
	});

	// klik btn-simpan-menu untuk role 
	$(document).on('click', '#btn-simpan-menu', function() {
		let role_id = $('#btn-simpan-menu').data('role-id');
		let group_id = $('#opt_role_group').val();
		let jsTree = $(".menuList").jstree();
		let parent_id = [];
		var selected_id = $('#menuList').jstree("get_selected", true);

		$.each(selected_id, function(){
			parent_id.push(
				...this.parents
			)
		})

		konfirmasi('Anda yakin untuk menyimpan data?').then(function(e) {
			if (e.value) {
				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: "<?= site_url('wuling_adm_menu_role/assign_menu_ke_role'); ?>",
					data: {
						role_id: role_id,
						group_id: group_id,
						menu_id: jsTree.get_selected(),
						parent_id: parent_id
					},
					beforeSend: function() {
						$("#btn-simpan-menu").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							peringatan("Sukses", response.pesan, 'success', 1500)
							table_role.ajax.reload(null, false);
							$("#level").val('');
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_assign_menu').modal('hide');
						$("#btn-simpan-menu").removeAttr("data-kt-indicator").prop("disabled", false)
					},
					error: function(xhr, status, error) {
						var err = eval("(" + xhr.responseText + ")");
						pesan_swal('error', err.Message);
					}
				});
			}
		});
	});
	//* end proses assign menu *//

	//* hidden modal *//
	$('#modal_tambah_role').on('hidden.bs.modal', function() {
		// $(".table-coverage").show();
		// $(".table-coverage-edit").hide();
	});
	//* end hidden modal *//


	//* static functions *//
	reset_form = () => {
		$("#role_name").val('');
	}
	//* end static functions *//
</script>

<!-- new -->
<script src="<?= base_url() ?>public/assets/plugins/custom/jstree/jstree.bundle.js"></script>

<!-- untuk read dan assign menu ke role -->
<script>
	// $(document).ready(function() {
	$('#menuList').jstree({
		checkbox: {
			// keep_selected_style: false
			three_state : true,
			cascade: 'undetermined'
		},
		plugins: ["checkbox", "wholerow"],
		core: {
			data: {
				url: "<?= site_url('wuling_adm_menu_role/get_tree_by_group_menu') ?>",
				dataType: "JSON",
				data: function(node) {
					console.log(node);
					return {
						'group_id': $("#opt_role_group").val()
					}
				}
			},
			themes: {
				responsive: false
			},
		},
	}).bind("refresh.jstree", function(event, data) {
		$.ajax({
			url: "<?= site_url('wuling_adm_menu_role/get_checked_tree_by_role_id') ?>",
			data: {
				role_id: role_id,
			},
			success: function(data) {
				$('#menuList').jstree(true).settings.checkbox.three_state = true;
				$('#menuList').jstree(true).settings.checkbox.cascade = 'undetermined';
				$('#menuList').jstree(true).select_node(data);
			}
		});
	});

	$("#opt_role_group").on('change', function() {
		$('#menuList').jstree(true).refresh();
		if ($(this).val() != '') {
			$("#btn-simpan-menu").html('<i class="icon-save"></i> Simpan').prop('disabled', false);
		}
	});

	// })//ready 
</script>
