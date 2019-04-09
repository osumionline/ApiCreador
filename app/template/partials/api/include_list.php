<?php foreach ($values['list'] as $i => $inc): ?>
  {
    "id": <?php echo $inc->get('id') ?>,
    "name": "<?php echo urlencode($inc->get('name')) ?>",
    "versions": [
<?php foreach ($inc->getVersions() as $j => $ver): ?>
      {
        "id": <?php echo $ver->get('id') ?>,
        "version": "<?php echo $ver->get('version') ?>"
      }<?php if ($j<count($inc->getVersions())-1): ?>,<?php endif ?>
<?php endforeach ?>
    ]
  }<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>