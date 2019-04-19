<?php foreach ($values['list'] as $i => $project): ?>
  {
    "id": <?php echo $project->get('id') ?>,
    "name": "<?php echo urlencode($project->get('name')) ?>",
    "slug": "<?php echo $project->get('slug') ?>",
    "description": "<?php echo urlencode($project->get('description')) ?>"
  }<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>