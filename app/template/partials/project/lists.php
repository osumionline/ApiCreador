<?php if (is_null($values['lists'])): ?>
	null
<?php else: ?>
	{
		"css": [<?php echo (count($values['lists']['css'])>0) ? implode(', ', $values['lists']['css']) : '' ?>],
		"cssExt": [<?php echo (count($values['lists']['css_ext'])>0) ? implode(', ', $values['lists']['css_ext']) : '' ?>],
		"js": [<?php echo (count($values['lists']['js'])>0) ? implode(', ', $values['lists']['js']) : '' ?>],
		"jsExt": [<?php echo (count($values['lists']['js_ext'])>0) ? implode(', ', $values['lists']['js_ext']) : '' ?>],
		"libs": [<?php echo (count($values['lists']['libs'])>0) ? implode(', ', $values['lists']['libs']) : '' ?>],
		"extra": [
<?php foreach ($values['lists']['extra'] as $i => $item): ?>
			{"key": "<?php echo $item['key'] ?>", "value": "<?php echo $item['value'] ?>"}<?php if ($i<count($values['lists']['extra'])-1): ?>,<?php endif ?>
<?php endforeach ?>
		],
		"dir": [
<?php foreach ($values['lists']['dir'] as $i => $item): ?>
			{"key": "<?php echo $item['key'] ?>", "value": "<?php echo $item['value'] ?>"}<?php if ($i<count($values['lists']['dir'])-1): ?>,<?php endif ?>
<?php endforeach ?>
		]
	}
<?php endif ?>