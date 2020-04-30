<?php if (is_null($values['project'])): ?>
	null
<?php else: ?>
	{
		"id": <?php echo $values['project']->get('id') ?>,
		"name": "<?php echo urlencode($values['project']->get('name')) ?>",
		"slug": "<?php echo $values['project']->get('slug') ?>",
		"description": "<?php echo urlencode($values['project']->get('description')) ?>",
		"updatedAt": "<?php echo $values['project']->get('updated_at', 'd/m/Y H:i:s') ?>",
		"lastCompilationDate": <?php echo is_null($values['project']->get('last_compilation')) ? 'null' : '"'.$values['project']->get('last_compilation', 'd/m/Y H:i:s').'"' ?>
	}
<?php endif ?>