<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\ORM\ODB;
use Osumi\OsumiFramework\App\Model\ProjectConfigListItem;

class ProjectConfig extends OModel {
	#[OPK(
	  comment: 'Id único para cada proyecto'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del proyecto al que pertenece la configuración',
	  nullable: false,
	  ref: 'project.id'
	)]
	public ?int $id_project;

	#[OField(
	  comment: 'Host de la base de datos',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $db_host;

	#[OField(
	  comment: 'Nombre de usuario para la base de datos',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $db_user;

	#[OField(
	  comment: 'Contraseña cifrada para la base de datos',
	  nullable: true,
		default: null,
	  max: 100
	)]
	public ?string $db_pass;

	#[OField(
	  comment: 'Nombre de la base de datos',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $db_name;

	#[OField(
	  comment: 'Charset de la base de datos',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $db_charset;

	#[OField(
	  comment: 'Collate de la base de datos',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $db_collate;

	#[OField(
	  comment: 'Prefijo para las cookies',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $cookies_prefix;

	#[OField(
	  comment: 'URL para las cookies',
	  nullable: true,
		default: null,
	  max: 50
	)]
	public ?string $cookies_url;

	#[OField(
	  comment: 'URL base de la aplicación',
	  nullable: true,
		default: null,
	  max: 250
	)]
	public ?string $base_url;

	#[OField(
	  comment: 'Dirección email para notificaciones al admin',
	  nullable: true,
		default: null,
	  max: 100
	)]
	public ?string $admin_email;

	#[OField(
	  comment: 'Título por defecto para las páginas',
	  nullable: true,
		default: null,
	  max: 100
	)]
	public ?string $default_title;

	#[OField(
	  comment: 'Código de idioma por defecto',
	  nullable: true,
		default: null,
	  max: 10
	)]
	public ?string $lang;

	#[OField(
	  comment: 'URL al que redirigir en caso de error 403',
	  nullable: true,
		default: null,
	  max: 100
	)]
	public ?string $error_403;

	#[OField(
	  comment: 'URL al que redirigir en caso de error 404',
	  nullable: true,
		default: null,
	  max: 100
	)]
	public ?string $error_404;

	#[OField(
	  comment: 'URL al que redirigir en caso de error 500',
	  nullable: true,
		default: null,
	  max: 100
	)]
	public ?string $error_500;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

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
		$db = new ODB();
		$sql = "SELECT * FROM `project_config_list_item` WHERE `id_project_config` = ?";
		$db->query($sql, [$this->id]);
		$lists = ['css' => [], 'css_ext' => [], 'js' => [], 'js_ext' => [], 'libs' => [], 'extra' => [], 'dir' => []];

		while ($res = $db->next()) {
			$prcli = ProjectConfigListItem::from($res);

			switch ($prcli->type) {
				case 0: { $lists['css'][] = '"' . urlencode($prcli->value) . '"'; }
				break;
				case 1: { $lists['css_ext'][] = '"' . urlencode($prcli->value) . '"'; }
				break;
				case 2: { $lists['js'][] = '"' . urlencode($prcli->value) . '"'; }
				break;
				case 3: { $lists['js_ext'][] = '"' . urlencode($prcli->value) . '"'; }
				break;
				case 4: { $lists['extra'][] = ['key' => urlencode($prcli->key), 'value' => urlencode($prcli->value)]; }
				break;
				case 5: { $lists['libs'][] = '"' . urlencode($prcli->value) . '"'; }
				break;
				case 6: { $lists['dir'][] = ['key' => urlencode($prcli->key), 'value' => urlencode($prcli->value)]; }
				break;
			}
		}

		$this->setProjectConfigurationLists($lists);
	}
}
