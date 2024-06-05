<h2>Edit Menu Item</h2>
<form method="post" action="<?= site_url('wuling_adm_menu/save'); ?>">
    <div class="fv-row mb-5">
        <label  class="fs-6 mb-1"for="edit-menu-title">Title</label>
        <input required type="text" name="title" id="edit-menu-title" class="form-control form-control-sm w-100" value="<?= htmlentities($row->title) ?>">
    </div>
    <div class="fv-row mb-5">
        <label  class="fs-6 mb-1"for="edit-menu-url">URL</label>
        <input type="text" name="url" class="form-control form-control-sm w-100"  id="edit-menu-url" value="<?= $row->url;?>">
    </div>
    <div class="fv-row mb-5">
        <label class="fs-6 mb-1">Icon</label>
        <input name="icon" class="form-control form-control-sm w-100 icon-picker-edit" value="<?= $row->icon;?>" type="text"/>
    </div>

    <?php if ($row->parent_id == 0) : //only top level menu can be moved ?>
        <div class="fv-row mb-5">
            <label  class="fs-6 mb-1"for="select_group_id">Group</label>
            <select name="group_id" id="select_group_id" class="form-control form-select form-select-sm">
                <?php foreach ($menu_groups as $group): ?>
                    <option value="<?= $group->id; ?>" <?php if ($group->id == $row->group_id) {
                        echo 'selected';
                    } ?>><?= $group->title; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" name="old_group_id" value="<?= $row->group_id; ?>">
    <?php endif; ?>
    <input type="hidden" name="menu_id" value="<?= $row->id; ?>">
</form>


<script src="<?= base_url('public/assets/js/vanilla-icon-picker/icon-picker.min.js') ?>"></script>

<script>
	iconPickerInputEdit = new IconPicker('.icon-picker-edit', {
		// theme: 'bootstrap-5',
		iconSource: [
			// 'FontAwesome Brands 6', 
			// 'FontAwesome Solid 6', 
			'FontAwesome Regular 6', 
			'Line Awesome',
		],
		closeOnSelect: true
	});

	iconElementInputEdit = document.querySelector('.icon-picker-edit');
	iconPickerInputEdit.on('select', (icon) => {
		// console.log('Icon Selected', icon);

		if (iconElementInputEdit.innerHTML !== '') {
			iconElementInputEdit.innerHTML = '';
		}

		iconElementInputEdit.className = `form-control form-control-sm w-100 icon-picker-edit ${icon.name}`;
		iconElementInputEdit.innerHTML = icon.svg;
	});
</script>
