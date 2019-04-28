<?php if (is_null($values['configuration'])): ?>
  null
<?php else: ?>
  {
    "id": <?php echo $values['project']->get('id') ?>,
    "name": "<?php echo urlencode($values['project']->get('name')) ?>",
    "slug": "<?php echo $values['project']->get('slug') ?>",
    "description": "<?php echo urlencode($values['project']->get('description')) ?>"
  }
<?php endif ?>