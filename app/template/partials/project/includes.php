<?php if (is_null($values['includes'])): ?>
  null
<?php else: ?>
  [<?php echo implode(',', $values['includes']) ?>]
<?php endif ?>