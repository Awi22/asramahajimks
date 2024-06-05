"use strict";
var KTSigninTwoFactor = (function () {
	var t, e;
	return {
		init: function () {
			var n, i, o, u, r, c;
			(t = document.querySelector("#kt_sing_in_two_factor_form")),
				(e = document.querySelector(
					"#kt_sing_in_two_factor_submit"
				)).addEventListener("click", function (n) {
					n.preventDefault();
					var i = !0,
						o = [].slice.call(
							t.querySelectorAll('input[maxlength="1"]')
						);
					o.map(function (t) {
						("" !== t.value && 0 !== t.value.length) || (i = !1);
					}),
						!0 === i
							? (e.setAttribute("data-kt-indicator", "on"),
							  (e.disabled = !0),
							  setTimeout(function () {
									e.removeAttribute("data-kt-indicator"),
										(e.disabled = !1),
										Swal.fire({
											text: "You have been successfully verified!",
											icon: "success",
											buttonsStyling: !1,
											confirmButtonText: "Ok, got it!",
											customClass: {
												confirmButton:
													"btn btn-primary",
											},
										}).then(function (e) {
											if (e.isConfirmed) {
												o.map(function (t) {
													t.value = "";
												});
												var n = t.getAttribute(
													"data-kt-redirect-url"
												);
												n && (location.href = n);
											}
										});
							  }, 1e3))
							: swal
									.fire({
										text: "Please enter valid securtiy code and try again.",
										icon: "error",
										buttonsStyling: !1,
										confirmButtonText: "Ok, got it!",
										customClass: {
											confirmButton:
												"btn fw-bold btn-light-primary",
										},
									})
									.then(function () {
										KTUtil.scrollTop();
									});
				}),
				(n = t.querySelector("[name=code_1]")),
				(i = t.querySelector("[name=code_2]")),
				(o = t.querySelector("[name=code_3]")),
				(u = t.querySelector("[name=code_4]")),
				(r = t.querySelector("[name=code_5]")),
				(c = t.querySelector("[name=code_6]")),
				n.focus(),
				n.addEventListener("keyup", function () {
					1 === this.value.length && i.focus();
				}),
				i.addEventListener("keyup", function () {
					1 === this.value.length && o.focus();
				}),
				o.addEventListener("keyup", function () {
					1 === this.value.length && u.focus();
				}),
				u.addEventListener("keyup", function () {
					1 === this.value.length && r.focus();
				}),
				r.addEventListener("keyup", function () {
					1 === this.value.length && c.focus();
				}),
				c.addEventListener("keyup", function () {
					1 === this.value.length && c.blur();
				});
		},
	};
})();
KTUtil.onDOMContentLoaded(function () {
	KTSigninTwoFactor.init();
});
