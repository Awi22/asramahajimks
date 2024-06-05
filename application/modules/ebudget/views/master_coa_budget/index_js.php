<script>
	$(document).ready(function() {
		//init

		$('#max_budget').keyup(function() {
            $(this).val(formatRupiah($(this).val()));
        });
		// $.fn.dataTable.ext.errMode = 'none';
		table_coa_budget = $("#table_coa_budget").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			// order: [],
			// autoWidth: false,
			ajax: {
				url: "<?= site_url('master_coa_budget/get') ?>",
			},
			language: {},
			columns: [
				{
					data: "no",
				},
				{
					data: "kode_akun",
				},
				{
					data: "nama_akun",
				},
				{
					data: "departemen",
				},
				{
					data: "p_sm",
					render: function(data, type, row, meta){
						let html = '';
						if(data=='0') {
							html = `<span class="badge badge-light-danger"><i class="fa fa-x fs-6 text-danger"></i><span class="me-3"></span>0%</span>`
						} else {
							html = `<span class="badge badge-light-success"><i class="fa fa-check fs-6 text-success"></i><span class="me-3"></span>${data}%</span>`
						}
						return html;
					},
				},
				{
					data: "p_asm",
					render: function(data, type, row, meta){
						let html = '';
						if(data=='0') {
							html = `<span class="badge badge-light-danger"><i class="fa fa-x fs-6 text-danger"></i><span class="me-3"></span>0%</span>`
						} else {
							html = `<span class="badge badge-light-success"><i class="fa fa-check fs-6 text-success"></i><span class="me-3"></span>${data}%</span>`
						}
						return html;
					}
				},
				{
					data: "p_gm",
					render: function(data, type, row, meta){
						let html = '';
						if(data=='0') {
							html = `<span class="badge badge-light-danger"><i class="fa fa-x fs-6 text-danger"></i><span class="me-3"></span>0%</span>`
						} else {
							html = `<span class="badge badge-light-success"><i class="fa fa-check fs-6 text-success"></i><span class="me-3"></span>${data}%</span>`
						}
						return html;
					}
				},
				{
					data: "status",
					className: "d-flex flex-center",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						if (data == 'on') {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${row.id_coa}" class="form-check-input h-20px w-30px sw-status" type="checkbox" value="1" checked="checked" />
								</label>`
						} else {
							html =
								`<label class="form-check form-switch form-check-custom form-check-solid">
								<input data-id="${row.id_coa}" class="form-check-input h-20px w-30px sw-status" type="checkbox" value="0" />
								</label>`
						}
						return html;
					},
				},
				{
					data: "id_coa",
					searchable: false,
					orderable: false,
					render: function(data, type, row, meta) {
						let html = '';
						html = `<td class="d-flex flex-center">
								<button class="btn btn-icon btn-light-primary w-30px h-30px btn-edit" data-id="${data}" title="Edit COA">
									<i class="bi bi-pencil fs-3"></i>
								</button>
								<button class="btn btn-icon btn-light-danger w-30px h-30px btn-hapus" data-id="${data}" title="Hapus COA">
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
		});; //table_coa_budget	

	}); //ready 


	//* proses tambah coa *//
	$('.btn-tambah').click(function() {
		$(".judul-modal").text("Tambah COA");	
		$("#opt_coa").val('').trigger('change');
	
			table_pilih_akun = $("#table_pilih_akun").DataTable({
			processing: true,
			//serverSide: true,
			//destroy: true,
			// order: [],
			// autoWidth: true,
    		// responsive: true,
			destroy: true,
			ajax: {
				url: "<?= site_url('master_coa_budget/get_pilih_akun') ?>",
			},
			language: {},
			columns: [
				{
					data: "no",
				},
				{
					data: "kode_akun",
				},
				{
					data: "nama_akun",
				},
				{
					data: "departemen",
				},
				{
					data: "exist",
					render: function (data, type, row, meta) {
						let html = '';
						// Check if 'exist' is 'ya' (yes), and conditionally set the checkbox to checked
						if (data === 'ya') {
							html =
								`<label class="form-check form-check-custom form-check-solid">
									<input data-id="${row.kode_akun}" class="form-check-input cb-exist" type="checkbox" value="1" checked />
								</label>`;
						} else {
							html =
								`<label class="form-check form-check-custom form-check-solid">
									<input data-id="${row.kode_akun}" class="form-check-input cb-exist" type="checkbox" value="0" />
								</label>`;
						}

						return html;
					},
				},
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
		});; //table_pilih_akun
		
	})

	//* proses simpan coa *//
	// klik btn simpan 
	$(document).on('click', '#btn-simpan', function() {
		let	url = "<?= site_url('master_coa_budget/tambah_coa'); ?>";
		var checkedCheckboxes = $('.cb-exist:checked');
		var kodeAkunArray = checkedCheckboxes.map(function () {
			return $(this).data('id');
		}).get();

		if (checkedCheckboxes.length === 0) {
            pesan('warning', 'Pilih setidaknya satu COA!');
            return false;
        }
		
		konfirmasi('Anda yakin untuk menyimpan data?').then((e) => {
			if(e.value){
				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: url,
					data: {
						coa: kodeAkunArray,
					},
					beforeSend: function() {
						$("#btn-simpan").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							let pesan = '';
							peringatan("Sukses", response.pesan, 'success', 1500).then(function(){
								table_coa_budget.ajax.reload();
								reset_form();
							})
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_tambah_coa').modal('hide');
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
	//* end proses simpan coa *//


	//* fungsi set status akun *//
	$(document).on('change', '.sw-status', function() {
		let id_coa = $(this).data('id'),
			//status = $(this).is(':checked');
			status = $(this).is(':checked') === true ? 'on' : 'off';
		$.ajax({
			type: "POST",
			url: "<?= base_url('master_coa_budget/set_status') ?>",
			data: {
				'id_coa': id_coa,
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
	//* end fungsi status akun *//


	//* fungsi hapus coa *//
	$(document).on('click', '.btn-hapus', function() {
		let id_coa = $(this).data('id');
		konfirmasi('Anda yakin untuk menghapus data?')
			.then(function(e) {
				if (e.value) {
					$.ajax({
						type: "POST",
						url: "<?= site_url('master_coa_budget/hapus_coa'); ?>",
						data: {
							id: id_coa
						},
						dataType: "JSON",
						success: function(response) {
							if (response.status === true) {
								peringatan("Sukses", response.pesan, "success", 1500)
									.then(function() {
										table_coa_budget.ajax.reload(null, false);
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
	//* end fungsi hapus coa *//

	//* fungsi set approval *//
	$(document).on('click', '.btn-edit', function() {
		let id = $(this).data('id');
		$("#modal_edit_coa").modal('show');
		$(".judul-modal").text('Edit Approval per COA');
		$('#btn-simpan-approval').data('id', id);

		var sw_sm = $('#sw_sm'), p_sm = $('#persen_sm'),
			sw_asm = $('#sw_asm'), p_asm = $('#persen_asm'),
			sw_gm = $('#sw_gm'), p_gm = $('#persen_gm'),
			max_budget = $('#max_budget');

		sw_sm.change(function() {
			p_sm.prop('disabled', !this.checked);
			if(!this.checked){
				p_sm.val(0);
			}
		});

		sw_asm.change(function() {
			p_asm.prop('disabled', !this.checked);
			if(!this.checked){
				p_asm.val(0);
			}
		});

		sw_gm.change(function() {
			p_gm.prop('disabled', !this.checked);
			if(!this.checked){
				p_gm.val(0);
			}
		});

		$.ajax({
			url: "<?= base_url('master_coa_budget/get_approval_coa_by_id'); ?>",
			data: {
				id: id
			},
			dataType: "JSON",
			success: function(res) {
				if(res.p_sm!="0" && res.p_sm!=null){
					p_sm.val(res.p_sm);
					sw_sm.prop('checked',true).trigger('change');
				}
				if(res.p_asm!="0" && res.p_asm!=null){
					p_asm.val(res.p_asm);
					sw_asm.prop('checked',true).trigger('change');
				}
				if(res.p_gm!="0" && res.p_gm!=null){
					p_gm.val(res.p_gm);
					sw_gm.prop('checked',true).trigger('change');
				}
				max_budget.val(formatRupiah(res.max_budget));
			}
		});
	})
	//* end fungsi set approval *//

	//* simpan approval *//
	$(document).on('click', '#btn-simpan-approval', function() {
		let id = $(this).data('id');
		let	url = "<?= site_url('master_coa_budget/update_approval'); ?>";
		let p_sm = $('#persen_sm').val(), p_asm = $('#persen_asm').val(), p_gm = $('#persen_gm').val(), max_budget = $('#max_budget').val();
		
		konfirmasi('Anda yakin untuk menyimpan data?').then((e) => {
			if(e.value){
				$.ajax({
					type: "POST",
					dataType: "JSON",
					url: url,
					data: {
						id:id,
						p_sm:p_sm,
						p_asm:p_asm,
						p_gm:p_gm,
						max_budget: max_budget
					},
					beforeSend: function() {
						$("#btn-simpan-approval").attr("data-kt-indicator", "on").prop("disabled", true)
					},
					success: function(response) {
						if (response.status) {
							let pesan = '';
							peringatan("Sukses", response.pesan, 'success', 1500).then(function(){
								table_coa_budget.ajax.reload();
								reset_form();
							})
						} else {
							peringatan("Error", response.pesan, 'error')
								.then(function() {
									location.reload();
								});
						}
						$('#modal_edit_coa').modal('hide');
						$("#btn-simpan-approval").removeAttr("data-kt-indicator").prop("disabled", false)
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
	//* end simpan approval **/

	
	//* hidden modal *//
	$('#modal_tambah_coa').on('hidden.bs.modal', function() {
		$('.sw-all').prop('checked', false);
	});
	$('#modal_edit_coa').on('hidden.bs.modal', function() {
		$('#sw_sm').prop('checked', false);
		$('#sw_asm').prop('checked', false);
		$('#sw_gm').prop('checked', false);
		$('#persen_sm').val(0).prop('disabled', true);
		$('#persen_asm').val(0).prop('disabled', true);
		$('#persen_gm').val(0).prop('disabled', true);
	});
	//* end hidden modal *//


	reset_form = () => {
		$("#opt_coa").val('').trigger('change');
	}

	formatRupiah = (e) => {
		var number_string = e.replace(/[^,\d]/g, '').toString(),
			split = number_string.split(','),
			sisa = split[0].length % 3,
			r = split[0].substr(0, sisa),
			ribuan = split[0].substr(sisa).match(/\d{3}/gi);
		if (ribuan) {
			separator = sisa ? '.' : '';
			r += separator + ribuan.join('.');
		}
		return r;
	}

	//* end static functions *//
</script>
