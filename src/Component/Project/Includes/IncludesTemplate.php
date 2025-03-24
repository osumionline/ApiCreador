<?php if (is_null($includes)): ?>
	null
<?php else: ?>
	[<?php echo implode(',', $includes) ?>]
<?php endif ?>
