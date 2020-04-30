<?php declare(strict_types=1);
class ProjectConfig extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'project_config';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada proyecto'
			],
			'id_project' => [
				'type'     => OCore::NUM,
				'nullable' => false,
				'comment'  => 'Id del proyecto al que pertenece la configuración',
				'ref'      => 'project.id'
			],
			'db_host' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Host de la base de datos'
			],
			'db_user' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Nombre de usuario para la base de datos'
			],
			'db_pass' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'Contraseña cifrada para la base de datos'
			],
			'db_name' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Nombre de la base de datos'
			],
			'db_charset' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Charset de la base de datos'
			],
			'db_collate' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Collate de la base de datos'
			],
			'cookies_prefix' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Prefijo para las cookies'
			],
			'cookies_url' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'URL para las cookies'
			],
			'module_browser' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo browser 1 o no 0'
			],
			'module_email' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo email 1 o no 0'
			],
			'module_email_smtp' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo browser 1 o no 0'
			],
			'module_ftp' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo ftp 1 o no 0'
			],
			'module_image' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo image 1 o no 0'
			],
			'module_pdf' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo pdf 1 o no 0'
			],
			'module_translate' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo translate 1 o no 0'
			],
			'module_crypt' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo crypt 1 o no 0'
			],
			'module_file' => [
				'type'     => OCore::BOOL,
				'nullable' => false,
				'default'  => false,
				'comment'  => 'Indica si habilitar el módulo file 1 o no 0'
			],
			'base_url' => [
				'type'     => OCore::TEXT,
				'size'     => 250,
				'nullable' => true,
				'comment'  => 'URL base de la aplicación'
			],
			'admin_email' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'Dirección email para notificaciones al admin'
			],
			'default_title' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'Título por defecto para las páginas'
			],
			'lang' => [
				'type'     => OCore::TEXT,
				'size'     => 10,
				'nullable' => true,
				'comment'  => 'Código de idioma por defecto'
			],
			'smtp_host' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'Host para el envío de emails por SMTP'
			],
			'smtp_port' => [
				'type'     => OCore::TEXT,
				'size'     => 5,
				'nullable' => true,
				'comment'  => 'Puerto para el envío de emails por SMTP'
			],
			'smtp_secure' => [
				'type'     => OCore::TEXT,
				'size'     => 10,
				'nullable' => true,
				'comment'  => 'Tipo de cifrado para el envío de emails por SMTP'
			],
			'smtp_user' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => true,
				'comment'  => 'Nombre de usuario para el envío de emails por SMTP'
			],
			'smtp_pass' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'Contraseña cifrada para el envío de emails por SMTP'
			],
			'error_403' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'URL al que redirigir en caso de error 403'
			],
			'error_404' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'URL al que redirigir en caso de error 404'
			],
			'error_500' => [
				'type'     => OCore::TEXT,
				'size'     => 100,
				'nullable' => true,
				'comment'  => 'URL al que redirigir en caso de error 500'
			],
			'created_at' => [
				'type'    => OCore::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OCore::UPDATED,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($table_name, $model);
	}

	/**
	 * Lista de configuraciones del proyecto
	 */
	private ?array $configuration_lists = null;

	/**
	 * Obtiene la lista de configuraciones de un proyecto
	 *
	 * @return array Lista de configuraciones
	 */
	public function getProjectConfigurationLists(): array {
		if (is_null($this->configuration_lists)) {
			$this->loadProjectConfigurationLists();
		}
		return $this->configuration_lists;
	}

	/**
	 * Guarda la lista de configuraciones de un proyecto
	 *
	 * @param array $lists Lista de configuraciones
	 *
	 * @return void
	 */
	public function setProjectConfigurationLists(array $lists): void {
		$this->configuration_lists = $lists;
	}

	/**
	 * Carga la lista de configuraciones de un proyecto
	 *
	 * @return void
	 */
	private function loadProjectConfigurationLists(): void {
		$sql = "SELECT * FROM `project_config_list_item` WHERE `id_project_config` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$lists = ['css' => [], 'css_ext' => [], 'js' => [], 'js_ext' => [], 'libs' => [], 'extra' => [], 'dir' => []];

		while ($res = $this->db->next()) {
			$prcli = new ProjectConfigListItem();
			$prcli->update($res);

			switch ($prcli->get('type')) {
				case 0: { array_push($lists['css'], '"'.urlencode($prcli->get('value')).'"'); }
				break;
				case 1: { array_push($lists['css_ext'], '"'.urlencode($prcli->get('value')).'"'); }
				break;
				case 2: { array_push($lists['js'], '"'.urlencode($prcli->get('value')).'"'); }
				break;
				case 3: { array_push($lists['js_ext'], '"'.urlencode($prcli->get('value')).'"'); }
				break;
				case 4: { array_push($lists['extra'], ['key' => urlencode($prcli->get('key')), 'value' => urlencode($prcli->get('value'))]); }
				break;
				case 5: { array_push($lists['libs'], '"'.urlencode($prcli->get('value')).'"'); }
				break;
				case 6: { array_push($lists['dir'], ['key' => urlencode($prcli->get('key')), 'value' => urlencode($prcli->get('value'))]); }
				break;
			}
		}

		$this->setProjectConfigurationLists($lists);
	}
}