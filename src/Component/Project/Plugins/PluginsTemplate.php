<?php if (is_null($plugins)): ?>
	null
<?php else: ?>
	[
<?php foreach ($plugins as $i => $plugin): ?>
		{
			"id": <?php echo $plugin->id ?>,
			"name": "<?php echo urlencode($plugin->name) ?>",
			"version": "<?php echo urlencode($plugin->version) ?>"
		}<?php if ($i < count($plugins) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	]
<?php endif ?>
