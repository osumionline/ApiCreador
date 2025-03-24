<?php if (is_null($configuration)): ?>
	null
<?php else: ?>
	{
		"baseUrl": "<?php echo urlencode($configuration->base_url) ?>",
		"adminEmail": "<?php echo urlencode($configuration->admin_email) ?>",
		"defaultTitle": "<?php echo urlencode($configuration->default_title) ?>",
		"lang": "<?php echo urlencode($configuration->lang) ?>",
		"hasDB": <?php echo (!is_null($configuration->db_host) || !is_null($configuration->db_user) || !is_null($configuration->db_pass) || !is_null($configuration->db_name)) ? 'true' : 'false' ?>,
		"dbHost": <?php echo (!is_null($configuration->db_host)) ? '"'.urlencode($configuration->db_host).'"' : 'null' ?>,
		"dbName": <?php echo (!is_null($configuration->db_name)) ? '"'.urlencode($configuration->db_name).'"' : 'null' ?>,
		"dbUser": <?php echo (!is_null($configuration->db_user)) ? '"'.urlencode($configuration->db_user).'"' : 'null' ?>,
		"dbPass": null,
		"dbCharset": <?php echo (!is_null($configuration->db_charset)) ? '"'.urlencode($configuration->db_charset).'"' : '"utf8mb4"' ?>,
		"dbCollate": <?php echo (!is_null($configuration->db_collate)) ? '"'.urlencode($configuration->db_collate).'"' : '"utf8mb4_unicode_ci"' ?>,
		"cookiesPrefix": <?php echo (!is_null($configuration->cookies_prefix)) ? '"'.urlencode($configuration->cookies_prefix).'"' : 'null' ?>,
		"cookiesUrl": <?php echo (!is_null($configuration->cookies_url)) ? '"'.urlencode($configuration->cookies_url).'"' : 'null' ?>,
		"error403": <?php echo (!is_null($configuration->error_403)) ? '"'.urlencode($configuration->error_403).'"' : 'null' ?>,
		"error404": <?php echo (!is_null($configuration->error_404)) ? '"'.urlencode($configuration->error_404).'"' : 'null' ?>,
		"error500": <?php echo (!is_null($configuration->error_500)) ? '"'.urlencode($configuration->error_500).'"' : 'null' ?>
	}
<?php endif ?>
