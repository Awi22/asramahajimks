<script>
	$(document).ready(function(e) {
		$("#formUpload").on('submit', (function(e) {
			e.preventDefault();
			$.ajax({
				url: $(this).attr('action'),
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function() {
					//$("#preview").fadeOut();
					// $("#err").fadeOut();
				},
				success: function(data) {
					if(data.status==true) {
						peringatan('Sukses',data.pesan,'success',1500)
						.then(function(){
							location.reload();
						})
					} else {
						peringatan('Error',data.pesan,'error')
						.then(function(){
							location.reload();
						})
					}
					// if (data == 'invalid') {
					// 	// invalid file format.
					// 	$("#err").html("Invalid File !").fadeIn();
					// } else {
					// 	// view uploaded file.
					// 	$("#preview").html(data).fadeIn();
					// 	$("#form")[0].reset();
					// }
				},
				error: function(e) {
					alert('Unknown error!');
					console.log(e);
				}
			});
			this.reset();

		}));
	});
</script>
