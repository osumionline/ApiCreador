<?php foreach ($list as $i => $inc): ?>
	{
		"id": <?php echo $inc->id ?>,
		"name": "<?php echo urlencode($inc->name) ?>",
		"versions": [
<?php foreach ($inc->getVersions() as $j => $ver): ?>
			{
				"id": <?php echo $ver->id ?>,
				"version": "<?php echo $ver->version ?>"
			}<?php if ($j < count($inc->getVersions()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
		]
	}<?php if ($i < count($list) - 1): ?>,<?php endif ?>
<?php endforeach ?>
