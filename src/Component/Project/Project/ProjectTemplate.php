<?php if (is_null($project)): ?>
	null
<?php else: ?>
	{
		"id": <?php echo $project->id ?>,
		"name": "<?php echo urlencode($project->name) ?>",
		"slug": "<?php echo $project->slug ?>",
		"description": "<?php echo urlencode($project->description) ?>",
		"updatedAt": "<?php echo $project->get('updated_at', 'd/m/Y H:i:s') ?>",
		"lastCompilationDate": <?php echo is_null($project->last_compilation) ? 'null' : '"'.$project->get('last_compilation', 'd/m/Y H:i:s').'"' ?>
	}
<?php endif ?>
