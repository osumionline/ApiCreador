<?php if (is_null($models)): ?>
	null
<?php else: ?>
	[
<?php foreach ($models as $i => $model): ?>
		{
			"id": <?php echo $model->id ?>,
			"name": "<?php echo urlencode($model->name) ?>",
			"tableName": "<?php echo urlencode($model->table_name) ?>",
			"rows": [
<?php foreach ($model->getRows() as $j => $row): ?>
				{
					"id": <?php echo $row->id ?>,
					"name": "<?php echo urlencode($row->name) ?>",
					"type": <?php echo $row->type ?>,
					"size": <?php echo is_null($row->size) ? 'null' : $row->size ?>,
					"autoIncrement": <?php echo $row->auto_increment ? 'true' : 'false' ?>,
					"nullable": <?php echo $row->nullable ? 'true' : 'false' ?>,
					"defaultValue": <?php echo is_null($row->default) ? 'null' : '"'.$row->default.'"' ?>,
					"ref": <?php echo is_null($row->ref) ? 'null' : '"'.$row->ref.'"' ?>,
					"comment": <?php echo is_null($row->comment) ? 'null' : '"'.$row->comment.'"' ?>,
					"order": <?php echo $row->order ?>
				}<?php if ($j < count($model->getRows()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
			]
		}<?php if ($i < count($models) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	]
<?php endif ?>
