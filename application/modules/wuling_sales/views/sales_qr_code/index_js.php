<script>
	$(document).ready(function() {
		$.ajax({
			url: "<?= site_url('sales_qr_code/get'); ?>",
			dataType: 'JSON',
			success: function(res) {
				let det = res.detail;
				$('.txt-nama-lengkap').html(det.nama_karyawan);
				$('.txt-nik').html(det.nik_karyawan);
				$('.txt-cabang').html(det.cabang);
				$('.txt-jabatan').html(det.jabatan);
				$('.txt-nama-perusahaan').html(det.nama_perusahaan);
				$('.txt-handphone').html(det.handphone);
				$('.img-qr-code').attr("src",res.qrcode);
				$('.btn-copy').data('id', res.url);
			}
		});
	}); //ready 

	$(document).on('click', '.btn-copy', function() {
		// let url = $('.txt-url').data('id');
		let url = $(this).data('id');
		navigator.clipboard.writeText(url);
		peringatan('Sukses', 'Url Copied', 'success');
	});


</script>
