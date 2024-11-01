<script>
	const _BASE_URL = '<?php echo base_url(); ?>';
	let current_group_id = <?php if (!empty($group_id)) {
		echo $group_id;
	} ?>;
</script>

<script src="<?= base_url('public/assets/js/menu/jquery-ui-1.10.3.custom.min.js')?>"></script>
<script src="<?= base_url('public/assets/js/menu/jquery.mjs.nestedSortableNew.js')?>"></script>
<!-- <script src="https://local.dev/nestedSortable/jquery.mjs.nestedSortable.js"></script> -->


<script src="<?= base_url('public/assets/js/menu/menu.js')?>"></script>

<script src="<?= base_url('public/assets/js/vanilla-icon-picker/icon-picker.min.js') ?>"></script>

<script>
	const iconPickerInput = new IconPicker('.icon-picker', {
		// theme: 'bootstrap-5',
		iconSource: [
			// 'FontAwesome Brands 6', 
			// 'FontAwesome Solid 6', 
			'FontAwesome Regular 6', 
			'Line Awesome',
		],
		closeOnSelect: true
	});

	const iconElementInput = document.querySelector('.icon-picker');
	iconPickerInput.on('select', (icon) => {
		// console.log('Icon Selected', icon);

		if (iconElementInput.innerHTML !== '') {
			iconElementInput.innerHTML = '';
		}

		iconElementInput.className = `form-control form-control-sm w-100 icon-picker ${icon.name}`;
		iconElementInput.innerHTML = icon.svg;
	});
</script>

