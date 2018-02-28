<option 
	value="<?= $category['id'] ?>" 
	<?php if($category['id'] === $this->model->parent_id) echo ' selected'; ?>
	<?php if($category['id'] === $this->model->parent_id) echo ' disabled'; //текущую категорию нельзя выбрать ?>>
	<?= $tab . $category['name'] ?></option>
<?php if(isset($category['childs'])): ?>
	<ul>
		<?= $this->getMenuHtml($category['childs'], $tab . '-') ?>
	</ul>
<?php endif; ?> 