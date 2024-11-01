<link rel="stylesheet" href="<?= base_url('public/assets/js/vanilla-icon-picker/themes/default.min.css') ?>" />

<style>
	#menu-title,
	#menu-url,
	#menu-class {
		width: 90%;
	}

	#edit-menu-title,
	#edit-menu-url,
	#edit-menu-class {
		width: 70%;
	}

	#menu-group-title {
		width: 70%;
	}

	/*Edit Form*/
	#edit-form {
		display: none;
		border: 1px solid #ccc;
		background: #fcfcfc;
		border-top: none;
		padding: 10px 0;
	}

	#menu-group-add {
		display: none;
	}

	/* nested sortable
------------------------------------------------------------------------- */
	.ns-helper {
		border: 1px dashed #e3e3e3;
		background: #e6e6e6;
		border-radius: 5px;
	}

	.sortable {
		margin: 5px 0;
		clear: both;
		list-style: none;
	}

	.sortable img {
		vertical-align: bottom;
	}

	.sortable.mjs-nestedSortable-collapsed > ul { 
		display: none;
	}


	#ns-header {
		padding: 8px 10px;
		/* font-weight: bold; */
		/* font-size: 14px; */
		/* color: #fff; */
		/* background: #616161 !important; */
		/* border-radius: unset !important; */
	}

	#ns-header div {
		border: none;
	}

	#ns-footer {
		text-align: right;
		margin-top: 10px;
	}

	.ns-row {
		line-height: 18px;
		padding: 10px;
		border-radius: 5px;
		border: 1px solid #cfcfcf;
		/* background: -webkit-gradient(linear, 0 0, 0 bottom, from(#f9f9f9), to(#f5f5f5)); */
		/* background: -moz-linear-gradient(#f9f9f9, #f5f5f5); */
		/* background: linear-gradient(#f9f9f9, #f5f5f5); */

		position: relative;
	}

	.ns-row div {
		border-left: 1px solid #d5d5d5;
		height: 18px;
		overflow: hidden;
		position: absolute;
		top: 6px;
		padding-left: 10px;
	}

	div.ns-title {
		position: static;
		border: none;
		font-weight: 400;
		padding-left: 0;
		cursor: move;
	}

	.actions {
		width: 70px;
		right: 12px;
		height: 20px !important;

	}

	.ns-class {
		width: 100px;
		right: 60px;
	}

	.ns-url {
		width: 40%;
		left: 40%;
	}

	.actions a {
		margin-left: 10px;
	}

	/* error
------------------------------------------------------------------------- */
	span.error {
		color: red;
	}

	/* modal box
------------------------------------------------------------------------- */
	#gbox {
		position: absolute;
		position: fixed;
		display: none;
		z-index: 10002;
		width: 370px;
		border: 1px solid #acacac;
		border-radius: 5px;
		color: #222;
		background: #fff;
		-webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
		-moz-box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
	}

	#gbox_header {
		padding: 5px 10px;
		color: #000;
		font-size: 14px;
		font-weight: bold;
		text-shadow: 1px 1px 0 #fff;
	}

	#gbox h2 {
		font: 15px Arial, sans-serif;
		font-weight: bold;
		color: #333;
		border-bottom: 1px dashed #eaeaea;
		margin: 0 0 10px;
		padding: 0 0 8px;
	}

	#gbox_content {
		padding: 15px 12px;
		overflow: auto;
		max-height: 400px;
	}

	#gbox_footer {
		padding: 10px 15px;
		border-top: 1px solid #eee;
		background: #f9f9f9;
		text-align: right;
		border-radius: 5px;
	}

	#gbox_form input[type="text"] {
		width: 95%;
	}

	#gbox_bg {
		position: fixed;
		top: 0;
		left: 0;
		display: none;
		width: 100%;
		height: 100%;
		background: #000;
		opacity: 0.6;
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=60)";
		filter: alpha(opacity=60);
		z-index: 10001;
		cursor: pointer;
	}

	#gbox_loading {
		font-size: 18px;
		color: #aaa;
		text-align: center;
		margin-bottom: 20px;
		margin-top: 20px;
	}

	#gbox input[type="text"] {
		width: 100%;
		border-radius: 5px;
	}


	/* new library update
-------------------------- */
	#easymm ul {
		margin-left: 15px;
		list-style: none !important;
	}

	.ns-helper {
		margin: 5px 0;
	}

	.ns-row div {
		top: 7px;
	}

	/*Top Header*/
	header {
		background: #616161;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;

	}

	.top-header-text {
		margin-top: 15px;
		color: #ffffff;
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-weight: bold;

	}

	/*Current menu*/
	.edit-group-buttons {
		margin-top: 5px;
	}
</style>
