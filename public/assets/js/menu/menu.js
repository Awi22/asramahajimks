jQuery(function ($) {
	/* highlight current menu group
	  ------------------------------------------------------------------------- */
	$('#menu-group li[id="group-' + current_group_id + '"]').addClass("current");

	/* modal box
	  ------------------------------------------------------------------------- */
	gbox = {
		defaults: {
			autohide: false,
			buttons: {
				Close: function () {
					gbox.hide();
				},
			},
		},
		init: function () {
			var winHeight = $(window).height();
			var winWidth = $(window).width();
			var box =
				'<div id="gbox">' +
				'<div id="gbox_content" ></div>' +
				"</div>" +
				'<div id="gbox_bg"></div>';

			$("body").append(box);

			$("#gbox").css({
				top: "15%",
				left: winWidth / 2 - $("#gbox").width() / 2,
			});

			$("#gbox_close, #gbox_bg").click(gbox.hide);
		},
		show: function (options) {
			var options = $.extend({}, this.defaults, options);
			var options_temp = this.defaults;
			switch (options.type) {
				case "ajax":
					options_temp.content = '<div id="gbox_loading">Loading...<div>';
					gbox._show(options_temp);
					$.ajax({
						type: "GET",
						global: false,
						datatype: "html",
						url: options.url,
						success: function (data) {
							options.content = data;
							gbox._show(options);
						},
					});
					break;
				default:
					this._show(options);
					break;
			}
		},
		_show: function (options) {
			$("#gbox_footer").remove();
			if (options.buttons) {
				$("#gbox").append('<div id="gbox_footer"></div>');
				$.each(options.buttons, function (k, v) {
					buttonclass = "";
					if (k == "Simpan" || k == "Ya" || k == "OK") {
						buttonclass = "btn btn-sm fw-bold btn-light-primary btn-active-primary";
					} else {
						buttonclass = "btn btn-sm fw-bold btn-light-danger btn-active-danger";
					}
					$("<button></button>")
						.addClass(buttonclass)
						.text(k)
						.click(v)
						.appendTo("#gbox_footer");
				});
			}

			$("#gbox, #gbox_bg").fadeIn();
			$("#gbox_content").html(options.content);
			$("#gbox_content input:first").focus();
			if (options.autohide) {
				setTimeout(function () {
					gbox.hide();
				}, options.autohide);
			}
		},
		hide: function () {
			$("#gbox").fadeOut(function () {
				$("#gbox_content").html("");
				$("#gbox_footer").remove();
			});
			$("#gbox_bg").fadeOut();
		},
	};
	gbox.init();

	/* same as site_url() in php
	  ------------------------------------------------------------------------- */
	function site_url(url) {
		// return _BASE_URL + "index.php?act=" + url;
		return _BASE_URL  + url;
	}

	/* nested sortables
	  ------------------------------------------------------------------------- */
	var menu_serialized;
	$("#easymm").nestedSortable({
		listType: "ul",
		handle: "div",
		items: "li",
		placeholder: "ns-helper",
		opacity: 0.8,
		handle: ".ns-title",
		toleranceElement: "> div",
		forcePlaceholderSize: true,
		tabSize: 15,
		startCollapsed: true,
		update: function () {
			menu_serialized = $("#easymm").nestedSortable("serialize");
			$("#btn-save-menu").attr("disabled", false);
		},
	});
	// $("#easymm").nestedSortable({
	// 	// listType: "ul",
	// 	handle: "div",
	// 	items: 'li',
	// 	placeholder: 'ns-helper',
	// 	opacity: .8,
	// 	handle: '.ns-title',
	// 	toleranceElement: '> div',
	// 	forcePlaceholderSize: true,
	// 	tabSize: 25,

	// 	helper:	'clone',
	// 	revert: 250,
	// 	tolerance: 'pointer',
	// 	maxLevels: 3,
	// 	isTree: true,
	// 	expandOnHover: 700,
	// 	startCollapsed: false,
	// 	update: function () {
	// 		menu_serialized = $("#easymm").nestedSortable("serialize");
	// 		$("#btn-save-menu").attr("disabled", false);
	// 	},
	// });
	$('.disclose').attr('title','Click to show/hide children');
	$('.disclose').on('click', function() {
		$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		$(this).toggleClass('fas fa-angle-down').toggleClass('fas fa-angle-up');
	});

	/* edit menu item
	  ------------------------------------------------------------------------- */
	$("body").on("click", ".edit-menu", function () {
		var menu_id = $(this).next().next().val();
		var menu_div = $(this).parent().parent();
		console.log(_BASE_URL + "wuling_adm_menu/edit/" + menu_id);
		var li = $(this).closest("li");
		gbox.show({
			type: "ajax",
			url: _BASE_URL + "wuling_adm_menu/edit/" + menu_id,
			buttons: {
				// Batal: gbox.hide,
				Simpan: function () {
					$.ajax({
						type: "POST",
						url: $("#gbox form").attr("action"),
						data: $("#gbox form").serialize(),
						success: function (data) {
							switch (data.status) {
								case 1:
									gbox.hide();
									let v_icon = `<i class="${data.menu.icon}"></i>`;
									let v_title = data.menu.title;
									menu_div.find(".ns-title").html(`<i class="${data.menu.icon}"></i> ${data.menu.title}`);
									menu_div.find(".ns-url").html(data.menu.url);
									menu_div.find(".ns-icon").html(data.menu.icon);
									break;
								case 2:
									gbox.hide();
									break;
								case 4:
									gbox.hide();
									li.remove();
									break;
							}
						},
					});
				},
			},
		});
		return false;
	});

	/* delete menu item
	  ------------------------------------------------------------------------- */
	$("body").on("click", ".delete-menu", function () {
		var li = $(this).closest("li");
		var param = { id: $(this).next().val() };
		var menu_title = $(this).parent().parent().children(".ns-title").text();
		konfirmasi("Yakin ingin menghapus menu? Semua sub menu akan ikut terhapus")
			.then(function(e){
				if (e.value) {
					$.post(_BASE_URL + "wuling_adm_menu/delete", param, function (data) {
						if (data.success) {
							peringatan("Sukses","Berhasil menghapus menu","success",1500)
							li.remove();
						} else {
							peringatan("Error","Gagal menghapus menu (masih digunakan)","error",1500)
						}
					});
				}
			});
		return false;
	});

	/* add menu item
	  ------------------------------------------------------------------------- */
	$("#form-add-menu").submit(function () {
		if ($("#menu-title").val() == "") {
			$("#menu-title").focus();
		} else {
			$.ajax({
				type: "POST",
				url: $(this).attr("action"),
				data: $(this).serialize(),
				error: function () {
					gbox.show({
						content: "Add menu item error. Please try again.",
						autohide: 1000,
					});
				},
				success: function (data) {
					switch (data.status) {
						case 1:
							$("#form-add-menu")[0].reset();
							$("#easymm").append(data.li);
							break;
						case 2:
							gbox.show({
								content: data.msg,
								autohide: 1000,
							});
							break;
						case 3:
							$("#menu-title").val("").focus();
							break;
					}
				},
			});
		}
		return false;
	});

	$("body").on("keydown", "#gbox input", function (e) {
		if (e.which == 13) {
			$("#gbox_footer .primary").trigger("click");
			return false;
		}
	});

	/* add group
	  ------------------------------------------------------------------------- */
	$("#btn-tambah").click(function () {
		// console.log($(this).attr('href'))
		gbox.show({
			type: "ajax",
			url: $(this).attr("href"),
			buttons: {
				// Batal: gbox.hide,
				Simpan: function () {
					var group_title = $("#menu-group-title").val();
					if (group_title === "") {
						$("#menu-group-title").focus();
					} else {
						//$('#gbox_ok').attr('disabled', true);
						$.ajax({
							type: "POST",
							url: _BASE_URL + "wuling_adm_menugroup/add",
							data: "title=" + group_title,
							error: function () {
								//$('#gbox_ok').attr('disabled', false);
							},
							success: function (data) {
								//$('#gbox_ok').attr('disabled', false);
								switch (data.status) {
									case 1:
										gbox.hide();
										$("#menu-group").append(
											'<li class="nav-item"><a href="' +
											site_url("wuling_adm_menu/menu/" + data.id) +
											'" class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0">' +
											group_title +
											"</a></li>"
										);
										break;
									case 2:
										$('<span class="error"></span>')
											.text(data.msg)
											.prependTo("#gbox_footer")
											.delay(1000)
											.fadeOut(500, function () {
												$(this).remove();
											});
										break;
									case 3:
										$("#menu-group-title").val("").focus();
										break;
								}
							},
						});
					}
				},
			},
		});
		return false;
	});

	/* update menu / save order
	  ------------------------------------------------------------------------- */
	$("#btn-save-menu").attr("disabled", true);
	$("#form-menu").submit(function () {
		$("#btn-save-menu").attr("disabled", true);
		$.ajax({
			type: "POST",
			url: $(this).attr("action"),
			data: menu_serialized,
			error: function () {
				$("#btn-save-menu").attr("disabled", false);
				peringatan("Error","Gagal menyimpan menu","error");
			},
			success: function () {
				peringatan("Sukses","Berhasil menyimpan menu","success",1500)
			},
		});
		return false;
	});

	/* edit group
	  ------------------------------------------------------------------------- */
	$("#edit-group").click(function () {
		var sgroup = $("#edit-group-input");
		var group_title = sgroup.text();
		sgroup.html(
			'<input class="form-control form-control-sm w-100" value="' +
			group_title +
			'">'
			+ 
			`<p class="text-muted" style="font-size:12px">Tekan ENTER untuk menyimpan, ESC untuk batal</p>`
		);
		var inputgroup = sgroup.find("input");
		inputgroup
			.focus()
			.select()
			.keydown(function (e) {
				// console.log($(this).classList);
				// e.classList.add("form-control");

				if (e.which == 13) {
					var title = $(this).val();
					if (title == "") {
						return false;
					}
					$.ajax({
						type: "POST",
						url: _BASE_URL + "wuling_adm_menugroup/edit",
						data: "id=" + current_group_id + "&title=" + title,
						success: function (data) {
							if (data.success) {
								sgroup.html(title);
								$("#group-" + current_group_id + " a").text(title);
							}
						},
					});
				}
				if (e.which == 27) {
					sgroup.html(group_title);
				}
			});
		return false;
	});

	/* delete group
	  ------------------------------------------------------------------------- */
	$("#delete-group").click(function () {
		var group_title = $("#menu-group li.current a").text();
		var param = { id: current_group_id };
		konfirmasi("Yakin ingin menghapus menu group? Semua menu akan ikut terhapus")
			.then(function(e){
				if (e.value) {
					$.post(_BASE_URL + "wuling_adm_menugroup/delete", param, function (data) {
						if (data.success) {
							window.location = site_url("wuling_adm_menu");
						} else {
						}
					});
				}
			});
		// gbox.show({
		// 	content:
		// 		"<h2>Delete MenuController</h2>Are you sure you want to delete this menu?<br><b>" +
		// 		group_title +
		// 		"</b><br><br>This will also delete all items under this menu.",
		// 	buttons: {
		// 		Yes: function () {
		// 			$.post(_BASE_URL + "menugroup/delete", param, function (data) {
		// 				if (data.success) {
		// 					window.location = site_url("menu");
		// 				} else {
		// 					gbox.show({
		// 						content: "Failed to delete this menu.",
		// 					});
		// 				}
		// 			});
		// 		},
		// 		No: gbox.hide,
		// 	},
		// });
		return false;
	});

	
});
