"use strict";
var KTAuthNewPassword = (function () {
	var t,
		e,
		r,
		o,
		p,
		n = function () {
			return o.getScore() > 90;
		};
	var passwordMeterElement = document.querySelector("#password_meter");
	return {
		init: function () {
			(t = document.querySelector("#form_ganti_password")),
				(e = document.querySelector("#btn_simpan_password")),
				((p = document.querySelector("#password_meter")),
				(o = new KTPasswordMeter(passwordMeterElement, {
					minLength: 8,
					checkUppercase: true,
					checkLowercase: true,
					checkDigit: true,
					checkChar: false,
					scoreHighlightClass: "active",
				}))),
				(r = FormValidation.formValidation(t, {
					fields: {
						password: {
							validators: {
								notEmpty: {
									message: "Password tidak boleh kosong",
								},
								callback: {
									message: "Password tidak valid",
									callback: function (t) {
										if (t.value.length > 0) return n();
									},
								},
							},
						},
						"confirm-password": {
							validators: {
								notEmpty: {
									message: "Ulangi password",
								},
								identical: {
									compare: function () {
										return t.querySelector(
											'[name="password"]'
										).value;
									},
									message: "Password tidak sama!",
								},
							},
						},
					},
					plugins: {
						trigger: new FormValidation.plugins.Trigger({
							event: { password: !1 },
						}),
						bootstrap: new FormValidation.plugins.Bootstrap5({
							rowSelector: ".fv-row",
							eleInvalidClass: "",
							eleValidClass: "",
						}),
					},
				})),
				t
					.querySelector('input[name="password"]')
					.addEventListener("input", function () {
						this.value.length > 0 &&
							r.updateFieldStatus("password", "NotValidated");
					}),
				!(function (t) {
					try {
						return new URL(t), !0;
					} catch (t) {
						return !1;
					}
				})(t.getAttribute("action"));
			e.addEventListener("click", function (o) {
				o.preventDefault(),
					r.revalidateField("password"),
					r.validate().then(function (r) {
						"Valid" == r
							? (e.setAttribute("data-kt-indicator", "on"),
							  (e.disabled = !0),
							  axios
									.post(
										e
											.closest("form")
											.getAttribute("action"),
										new FormData(t)
									)
									.then(function (res) {
										if(res.data) {
											if (res.data.status==true) {
												peringatan("Sukses",res.data.pesan,'success',1500)
												.then(function(){
													t.reset();
													const e = t.getAttribute(
														"data-kt-redirect-url"
														);
														e && (location.href = e);
												});
											} else { 
												peringatan("Error",res.data.pesan,'error')
												.then(function(){
													t.reset();
												});
											}
										} else {
											console.log(e);
											peringatan("Error",'Unknown Error','error')
												.then(function(){
													t.reset();
												});
										}
									})
									.catch(function (t) {
										Swal.fire({
											text: "Sorry, looks11 like there are some errors detected, please try again.",
											icon: "error",
											buttonsStyling: !1,
											confirmButtonText: "OK",
											customClass: {
												confirmButton:
													"btn btn-primary",
											},
										});
									})
									.then(() => {
										e.removeAttribute("data-kt-indicator"),
											(e.disabled = !1);
									}))
							: Swal.fire({
									text: "Password tidak valid atau terjadi kesalahan, silahkan coba kembali.",
									icon: "error",
									buttonsStyling: !1,
									confirmButtonText: "OK",
									customClass: {
										confirmButton: "btn btn-primary",
									},
							  });
					});
			});
		},
	};
})();
KTUtil.onDOMContentLoaded(function () {
	KTAuthNewPassword.init();
});
