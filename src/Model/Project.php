<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Model;

use Osumi\OsumiFramework\ORM\OModel;
use Osumi\OsumiFramework\ORM\OPK;
use Osumi\OsumiFramework\ORM\OField;
use Osumi\OsumiFramework\ORM\OCreatedAt;
use Osumi\OsumiFramework\ORM\OUpdatedAt;
use Osumi\OsumiFramework\App\Model\Model;
use Osumi\OsumiFramework\App\Model\ProjectConfig;
use Osumi\OsumiFramework\App\Model\ProjectInclude;
use Osumi\OsumiFramework\App\Model\IncludeVersion;
use Osumi\OsumiFramework\ORM\ODB;

class Project extends OModel {
	#[OPK(
	  comment: 'Id único para cada proyecto'
	)]
	public ?int $id;

	#[OField(
	  comment: 'Id del usuario dueño del proyecto',
	  nullable: false,
	  ref: 'user.id'
	)]
	public ?int $id_user;

	#[OField(
	  comment: 'Nombre del proyecto',
	  nullable: false,
	  max: 50
	)]
	public ?string $name;

	#[OField(
	  comment: 'Slug del nombre del proyecto',
	  nullable: false,
	  max: 50
	)]
	public ?string $slug;

	#[OField(
	  comment: 'Descripción del proyecto',
	  nullable: true,
	  default: null,
	  type: OField::LONGTEXT
	)]
	public ?string $description;

	#[OField(
	  comment: 'Fecha de la última compilación',
	  nullable: true,
	  default: null,
	  type: OField::DATE
	)]
	public ?string $last_compilation;

	#[OCreatedAt(
	  comment: 'Fecha de creación del registro'
	)]
	public ?string $created_at;

	#[OUpdatedAt(
	  comment: 'Fecha de última modificación del registro'
	)]
	public ?string $updated_at;

	/**
	 * Borra un proyecto por completo, con todas sus configuraciones
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$db = new ODB();
		$sql = "DELETE FROM `project_include` WHERE `id_project` = ?";
		$db->query($sql, [$this->id]);
		$sql = "DELETE FROM `project_config_list_item` WHERE `id_project_config` IN (SELECT `id` FROM `project_config` WHERE `id_project` = ?)";
		$db->query($sql, [$this->id]);
		$sql = "DELETE FROM `project_config` WHERE `id_project` = ?";
		$db->query($sql, [$this->id]);
		$sql = "DELETE FROM `row` WHERE `id_model` IN (SELECT `id` FROM `model` WHERE `id_project` = ?)";
		$db->query($sql, [$this->id]);
		$sql = "DELETE FROM `model` WHERE `id_project` = ?";
		$db->query($sql, [$this->id]);

		$this->delete();
	}

	/**
	 * Objeto con la configuración del proyecto
	 */
	private ?ProjectConfig $project_config = null;

	/**
	 * Obtiene la configuración de un proyecto
	 *
	 * @return ProjectConfig Configuración de un proyecto
	 */
	public function getProjectConfig(): ProjectConfig {
		if (is_null($this->project_config)) {
			$this->loadProjectConfig();
		}
		return $this->project_config;
	}

	/**
	 * Guarda la configuración de un proyecto
	 *
	 * @param ProjectConfig $conf Configuración de un proyecto
	 *
	 * @return void
	 */
	public function setProjectConfig(ProjectConfig $conf): void {
		$this->project_config = $conf;
	}

	/**
	 * Carga la configuración de un proyecto
	 *
	 * @return void
	 */
	private function loadProjectConfig(): void {
		$this->setProjectConfig(ProjectConfig::findOne(['id_project' => $this->id]));
	}

	/**
	 * Lista de modelos de un proyecto
	 */
	private ?array $project_models = null;

	/**
	 * Obtiene la lista de modelos de un proyecto
	 *
	 * @return array Lista de modelos
	 */
	public function getProjectModels(): array {
		if (is_null($this->project_models)) {
			$this->loadProjectModels();
		}
		return $this->project_models;
	}

	/**
	 * Guarda la lista de modelos de un proyecto
	 *
	 * @param array $models Lista de modelos
	 *
	 * @return void
	 */
	public function setProjectModels(array $models): void {
		$this->project_models = $models;
	}

	/**
	 * Carga la lista de modelos de un proyecto
	 *
	 * @return void
	 */
	private function loadProjectModels(): void {
		$this->setProjectModels(Model::where(['id_project' => $this->id]));
	}

	/**
	 * Lista de includes de un proyecto
	 */
	private ?array $project_includes = null;

	/**
	 * Obtiene la lista de includes de un proyecto
	 *
	 * @return array Lista de includes
	 */
	public function getProjectIncludes(): array {
		if (is_null($this->project_includes)) {
			$this->loadProjectIncludes();
		}
		return $this->project_includes;
	}

	/**
	 * Guarda la lista de includes de un proyecto
	 *
	 * @param array $includes Lista de includes
	 *
	 * @return void
	 */
	public function setProjectIncludes(array $includes): void {
		$this->project_includes = $includes;
	}

	/**
	 * Carga la lista de includes de un proyecto
	 *
	 * @return void
	 */
	private function loadProjectIncludes(): void {
		$this->setProjectIncludes(ProjectInclude::where(['id_project' => $this->id]));
	}

	/**
	 * Lista de versiones de los includes de un proyecto
	 */
	private $project_include_versions = null;

	/**
	 * Obtiene la lista de versiones de los includes de un proyecto
	 *
	 * @return array Lista de versiones
	 */
	public function getProjectIncludeVersions(): array {
		if (is_null($this->project_include_versions)) {
			$this->loadProjectIncludeVersions();
		}
		return $this->project_include_versions;
	}

	/**
	 * Guarda la lista de versiones de los includes de un proyecto
	 *
	 * @param array $versions Lista de versiones
	 *
	 * @return void
	 */
	public function setProjectIncludeVersions(array $versions): void {
		$this->project_include_versions = $versions;
	}

	/**
	 * Carga la lista de versiones de los includes de un proyecto
	 *
	 * @return void
	 */
	private function loadProjectIncludeVersions(): void {
		$db = new ODB();
		$sql = "SELECT * FROM `include_version` WHERE `id` IN (SELECT `id_type` FROM `project_include` WHERE `id_project` = ?)";
		$db->query($sql, [$this->id]);
		$versions = [];

		while ($res = $db->next()) {
			$versions[] = IncludeVersion::from($res);
		}

		$this->setProjectIncludeVersions($versions);
	}
}
