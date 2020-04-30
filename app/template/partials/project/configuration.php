<?php if (is_null($values['configuration'])): ?>
	null
<?php else: ?>
	{
		"baseUrl": "<?php echo urlencode($values['configuration']->get('base_url')) ?>",
		"adminEmail": "<?php echo urlencode($values['configuration']->get('admin_email')) ?>",
		"defaultTitle": "<?php echo urlencode($values['configuration']->get('default_title')) ?>",
		"lang": "<?php echo urlencode($values['configuration']->get('lang')) ?>",
		"hasDB": <?php echo (!is_null($values['configuration']->get('db_host')) || !is_null($values['configuration']->get('db_user')) || !is_null($values['configuration']->get('db_pass')) || !is_null($values['configuration']->get('db_name'))) ? 'true' : 'false' ?>,
		"dbHost": <?php echo (!is_null($values['configuration']->get('db_host'))) ? '"'.urlencode($values['configuration']->get('db_host')).'"' : 'null' ?>,
		"dbName": <?php echo (!is_null($values['configuration']->get('db_name'))) ? '"'.urlencode($values['configuration']->get('db_name')).'"' : 'null' ?>,
		"dbUser": <?php echo (!is_null($values['configuration']->get('db_user'))) ? '"'.urlencode($values['configuration']->get('db_user')).'"' : 'null' ?>,
		"dbPass": null,
		"dbCharset": <?php echo (!is_null($values['configuration']->get('db_charset'))) ? '"'.urlencode($values['configuration']->get('db_charset')).'"' : '"utf8mb4"' ?>,
		"dbCollate": <?php echo (!is_null($values['configuration']->get('db_collate'))) ? '"'.urlencode($values['configuration']->get('db_collate')).'"' : '"utf8mb4_unicode_ci"' ?>,
		"cookiesPrefix": <?php echo (!is_null($values['configuration']->get('cookies_prefix'))) ? '"'.urlencode($values['configuration']->get('cookies_prefix')).'"' : 'null' ?>,
		"cookiesUrl": <?php echo (!is_null($values['configuration']->get('cookies_url'))) ? '"'.urlencode($values['configuration']->get('cookies_url')).'"' : 'null' ?>,
		"modBrowser": <?php echo $values['configuration']->get('module_browser') ? 'true' : 'false' ?>,
		"modEmail": <?php echo $values['configuration']->get('module_email') ? 'true' : 'false' ?>,
		"modEmailSmtp": <?php echo $values['configuration']->get('module_email_smtp') ? 'true' : 'false' ?>,
		"modFtp": <?php echo $values['configuration']->get('module_ftp') ? 'true' : 'false' ?>,
		"modImage": <?php echo $values['configuration']->get('module_image') ? 'true' : 'false' ?>,
		"modPdf": <?php echo $values['configuration']->get('module_pdf') ? 'true' : 'false' ?>,
		"modTranslate": <?php echo $values['configuration']->get('module_translate') ? 'true' : 'false' ?>,
		"modCrypt": <?php echo $values['configuration']->get('module_crypt') ? 'true' : 'false' ?>,
		"modFile": <?php echo $values['configuration']->get('module_file') ? 'true' : 'false' ?>,
		"smtpHost": <?php echo (!is_null($values['configuration']->get('smtp_host'))) ? '"'.urlencode($values['configuration']->get('smtp_host')).'"' : 'null' ?>,
		"smtpPort": <?php echo (!is_null($values['configuration']->get('smtp_port'))) ? '"'.urlencode($values['configuration']->get('smtp_port')).'"' : 'null' ?>,
		"smtpSecure": <?php echo (!is_null($values['configuration']->get('smtp_secure'))) ? '"'.urlencode($values['configuration']->get('smtp_secure')).'"' : 'null' ?>,
		"smtpUser": <?php echo (!is_null($values['configuration']->get('smtp_user'))) ? '"'.urlencode($values['configuration']->get('smtp_user')).'"' : 'null' ?>,
		"smtpPass": null,
		"error403": <?php echo (!is_null($values['configuration']->get('error_403'))) ? '"'.urlencode($values['configuration']->get('error_403')).'"' : 'null' ?>,
		"error404": <?php echo (!is_null($values['configuration']->get('error_404'))) ? '"'.urlencode($values['configuration']->get('error_404')).'"' : 'null' ?>,
		"error500": <?php echo (!is_null($values['configuration']->get('error_500'))) ? '"'.urlencode($values['configuration']->get('error_500')).'"' : 'null' ?>
	}
<?php endif ?>