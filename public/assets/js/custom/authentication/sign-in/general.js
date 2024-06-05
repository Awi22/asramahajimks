"use strict";

var KTSigninGeneral = (function () {
	var t, e, r;
	return {
		init: function () {
			(t = document.querySelector("#formLogin")),
				(e = document.querySelector("#btn-submit")),
				(r = FormValidation.formValidation(t, {
					fields: {
						username: {
							validators: {
								notEmpty: {
									message: "Username is required",
								},
							},
						},
						password: {
							validators: {
								notEmpty: {
									message: "The password is required",
								},
							},
						},
					},
					plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						bootstrap: new FormValidation.plugins.Bootstrap5({
							rowSelector: ".fv-row",
							eleInvalidClass: "",
							eleValidClass: "",
						}),
					},
				})),
				!(function (t) {
					try {
						return new URL(t), !0;
					} catch (t) {
						return !1;
					}
				})
				e.addEventListener("click", function (i) {
					i.preventDefault(),
						r.validate().then(function (r) {
							"Valid" == r
								? (e.setAttribute("data-kt-indicator", "on"),
									(e.disabled = !0),
								  	setTimeout(function () {
										axios
											.post(
												e
													.closest("form")
													.getAttribute(
														"action"
													),
												new FormData(t),
												{}
											)
											.then(function (e) {
												console.log(e);
												if (
													e.data.status ==
													true
												) {
													const the_url =
														e.data.url;
													// t.reset(),
														the_url &&
															(location.href =
																the_url);
												} else {
													Swal.fire({
														text: e.data.pesan,
														icon: "error",
														buttonsStyling: !1,
														confirmButtonText: "Ok, got it!",
														customClass: {
															confirmButton:
																"btn btn-primary",
														},
													});
												}
											})
											.catch(function (error) {
												console.log(error);
												Swal.fire({
													text: "Terjadi kesalahan, silahkan coba lagi.",
													icon: "error",
													buttonsStyling: !1,
													confirmButtonText:
														"Ok, got it!",
													customClass: {
														confirmButton:
															"btn btn-primary",
													},
												});
											})
											.then(() => {
												e.removeAttribute(
													"data-kt-indicator"
												),
													(e.disabled = !1);
											});
									}, 250))
								: Swal.fire({
										text: "Sorry, looks like there are some errors detected, please try again.",
										icon: "error",
										buttonsStyling: !1,
										confirmButtonText:
											"Ok, got it!",
										customClass: {
											confirmButton:
												"btn btn-primary",
										},
								});
						});
			});
		},
	};
})();
KTUtil.onDOMContentLoaded(function () {
	KTSigninGeneral.init();
});
