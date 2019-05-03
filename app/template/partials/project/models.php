<?php if (is_null($values['models'])): ?>
  null
<?php else: ?>
  [
<?php foreach ($values['models'] as $i => $model): ?>
    {
      "id": <?php echo $model->get('id') ?>,
      "name": "<?php echo urlencode($model->get('name')) ?>",
      "tableName": "<?php echo urlencode($model->get('table_name')) ?>",
      "rows": [
<?php foreach ($model->getRows() as $j => $row): ?>
        {
          "id": <?php echo $row->get('id') ?>,
          "name": "<?php echo urlencode($row->get('name')) ?>",
          "type": <?php echo $row->get('type') ?>,
          "size": <?php echo is_null($row->get('size')) ? 'null' : $row->get('size') ?>,
          "autoIncrement": <?php echo $row->get('auto_increment') ? 'true' : 'false' ?>,
          "nullable": <?php echo $row->get('nullable') ? 'true' : 'false' ?>,
          "defaultValue": <?php echo is_null($row->get('default')) ? 'null' : '"'.$row->get('default').'"' ?>,
          "ref": <?php echo is_null($row->get('ref')) ? 'null' : '"'.$row->get('ref').'"' ?>,
          "comment": <?php echo is_null($row->get('comment')) ? 'null' : '"'.$row->get('comment').'"' ?>,
          "order": <?php echo $row->get('order') ?>
        }<?php if ($j<count($model->getRows())-1): ?>,<?php endif ?>
<?php endforeach ?>
      ]
    }<?php if ($i<count($values['models'])-1): ?>,<?php endif ?>
<?php endforeach ?>
  ]
<?php endif ?>