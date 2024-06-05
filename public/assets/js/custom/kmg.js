pesan = (status, teks) => {
	v_status = "";
	toastr.options = {
		closeButton: true,
		debug: false,
		newestOnTop: false,
		progressBar: false,
		positionClass: "toastr-top-right",
		preventDuplicates: false,
		onclick: null,
		showDuration: "1000",
		hideDuration: "1000",
		timeOut: "2500",
		extendedTimeOut: "1000",
		showEasing: "swing",
		hideEasing: "linear",
		showMethod: "fadeIn",
		hideMethod: "fadeOut",
	};
	switch (status) {
		case "success":
			toastr.success(teks);
			break;
		case "info":
			toastr.info(teks);
			break;
		case "warning":
			toastr.warning(teks);
			break;
		case "error":
			toastr.error(teks);
			break;
		default:
			toastr.error("Unknown Toastr Status");
			break;
	}
};

konfirmasi = (pesan) => {
	e = Swal.fire({
		text: pesan,
		icon: "question",
		showCancelButton: !0,
		buttonsStyling: !1,
		reverseButtons: true,
		cancelButtonText: "Batal",
		confirmButtonText: "Ya",
		customClass: {
			cancelButton: "btn btn-sm fw-bold btn-light-secondary",
			confirmButton:
				"btn btn-sm fw-bold btn-light-primary btn-active-primary",
		},
	});
	return e;
};

peringatan = (judul, pesan, icon, timer) => {
	if (timer) {
		e = Swal.fire({
			title: judul,
			text: pesan,
			icon: icon,
			timer: timer,
			showCancelButton: false,
			showConfirmButton: false,
		});
	} else {
		e = Swal.fire({
			title: judul,
			text: pesan,
			icon: icon,
			buttonsStyling: 1,
			customClass: {
				confirmButton:
					"btn btn-sm fw-bold btn-light-primary btn-active-primary",
			},
		});
	}
	return e;
};

/* Separator Harga */
function SeparatorHarga(ID) {
	var bilangan = ID;
	var reverse = bilangan.toString().split("").reverse().join(""),
		ribuan = reverse.match(/\d{1,3}/g);
	ribuan = ribuan.join(".").split("").reverse().join("");
	return ribuan;
}

/* Form Input Angka */
function angka(e) {
	if (!/^[0-9]+$/.test(e.value)) {
		e.value = e.value.substring(0, e.value.length - 1);
	}
}

/* Form Input Angka & Alert*/
function isNumber(evt) {
	evt = evt ? evt : window.event;
	var charCode = evt.which ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		pesan("warning", "Harus berupa angka!");
		return false;
	}
	return true;
}

function justAngka(e) {
	// Allow: backspace, delete, tab, escape, enter and .
	if (
		$.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		// Allow: Ctrl+A, Command+A
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		// Allow: home, end, left, right, down, up
		(e.keyCode >= 35 && e.keyCode <= 40)
	) {
		// let it happen, don't do anything
		return;
	}
	// Ensure that it is a number and stop the keypress
	if (
		(e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
		(e.keyCode < 96 || e.keyCode > 105)
	) {
		e.preventDefault();
	}
}

function hanyaAngka(evt) {
	var charCode = evt.which ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
	return true;
}

function autoseparator(Num) {
	//function to add commas to textboxes
	Num += "";
	Num = Num.replace(".", "");
	Num = Num.replace(".", "");
	Num = Num.replace(".", "");
	Num = Num.replace(".", "");
	Num = Num.replace(".", "");
	Num = Num.replace(".", "");
	x = Num.split(".");
	x1 = x[0];
	x2 = x.length > 1 ? "." + x[1] : "";
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) x1 = x1.replace(rgx, "$1" + "." + "$2");
	return x1 + x2;
}

function formatRupiah(angka, prefix) {
	var number_string = angka.replace(/[^,\d]/g, "").toString(),
		split = number_string.split(","),
		sisa = split[0].length % 3,
		rupiah = split[0].substr(0, sisa),
		ribuan = split[0].substr(sisa).match(/\d{3}/gi);
	if (ribuan) {
		separator = sisa ? "." : "";
		rupiah += separator + ribuan.join(".");
	}
	rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
	return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

/* Separator Rupiah + String Rp. */
function convertToRupiah(angka) {
	var rupiah = "";
	var angkarev = angka.toString().split("").reverse().join("");
	for (var i = 0; i < angkarev.length; i++)
		if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ".";
	return (
		"Rp. " +
		rupiah
			.split("", rupiah.length - 1)
			.reverse()
			.join("")
	);
}

function convertToRupiahjustNumber(angka) {
	var rupiah = "";
	var angkarev = angka.toString().split("").reverse().join("");
	for (var i = 0; i < angkarev.length; i++)
		if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + ",";
	return rupiah
		.split("", rupiah.length - 1)
		.reverse()
		.join("");
}

/* Menghitung Usia */
function menghitung_usia(tanggal_lahir) {
	var dateParts = tanggal_lahir.split("-");
	var date = new Date(+dateParts[2], dateParts[1] - 1, +dateParts[0]);
	if (tanggal_lahir === "") {
		pesan("warning", "Please complete the required field!");
		return false;
	} else {
		var today = new Date();
		var birthday = new Date(date);
		var year = 0;
		if (today.getMonth() < birthday.getMonth()) {
			year = 1;
		} else if (
			today.getMonth() == birthday.getMonth() &&
			today.getDate() < birthday.getDate()
		) {
			year = 1;
		}
		var age = today.getFullYear() - birthday.getFullYear() - year;

		if (age < 0) {
			age = 0;
		}
		return age + " Tahun";
	}
}

function hilangkanKarakter(e) {
	var value = e.key;
	var result = value.replace(/[^a-zA-Z0-9 ]/g, "");
	if (result != "") {
		return true;
	}
	e.preventDefault();
	return false;
}

function toAngka(rp) {
	var replaced = rp.replace(/[.,]/g, function (piece) {
		var replacements = {
			".": " ",
			",": ".",
		};
		return replacements[piece] || piece;
	});
	return replaced.split(" ").join("");
}

// document.body.style.zoom = "80%";

// function setZoom() {
// if (window.matchMedia('(min-width: 780px) and (max-width: 1280px)').matches) {
// 	document.body.style.zoom = "80%";
//   } else {
// 	document.body.style.zoom = "100%";
//   }
// }

// function onError(error) {
// 	console.log(`Error: ${error}`);
//   }

//   let setting = browser.tabs.setZoom(2);
//   setting.then(null, onError);

//password meter
// var options = {
//     minLength: 8,
//     checkUppercase: true,
//     checkLowercase: true,
//     checkDigit: true,
//     checkChar: false,
//     scoreHighlightClass: "active"
// };
// var passwordMeterElement = document.querySelector("#password_meter");
// var passwordMeter = new KTPasswordMeter(passwordMeterElement, options);
