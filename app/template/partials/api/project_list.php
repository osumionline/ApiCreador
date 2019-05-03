<?php foreach ($values['list'] as $i => $project): ?>
  {
    "id": <?php echo $project->get('id') ?>,
    "name": "<?php echo urlencode($project->get('name')) ?>",
    "slug": "<?php echo $project->get('slug') ?>",
    "description": "<?php echo urlencode($project->get('description')) ?>",
    "lastCompilationDate": "<?php echo $project->get('last_compilation', 'd/m/Y H:i:s') ?>"
  }<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>