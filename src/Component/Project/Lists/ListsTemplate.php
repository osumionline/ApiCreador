<?php if (is_null($lists)): ?>
	null
<?php else: ?>
	{
		"css": [<?php echo (count($lists['css']) > 0) ? implode(', ', $lists['css']) : '' ?>],
		"cssExt": [<?php echo (count($lists['css_ext']) > 0) ? implode(', ', $lists['css_ext']) : '' ?>],
		"js": [<?php echo (count($lists['js']) > 0) ? implode(', ', $lists['js']) : '' ?>],
		"jsExt": [<?php echo (count($lists['js_ext']) > 0) ? implode(', ', $lists['js_ext']) : '' ?>],
		"libs": [<?php echo (count($lists['libs']) > 0) ? implode(', ', $lists['libs']) : '' ?>],
		"extra": [
<?php foreach ($lists['extra'] as $i => $item): ?>
			{"key": "<?php echo $item['key'] ?>", "value": "<?php echo $item['value'] ?>"}<?php if ($i < count($lists['extra']) - 1): ?>,<?php endif ?>
<?php endforeach ?>
		],
		"dir": [
<?php foreach ($lists['dir'] as $i => $item): ?>
			{"key": "<?php echo $item['key'] ?>", "value": "<?php echo $item['value'] ?>"}<?php if ($i < count($lists['dir']) - 1): ?>,<?php endif ?>
<?php endforeach ?>
		]
	}
<?php endif ?>
