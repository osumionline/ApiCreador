<?php declare(strict_types=1);
class Project extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'project';
		$model = [
			'id' => [
				'type'    => OCore::PK,
				'comment' => 'Id único para cada proyecto'
			],
			'id_user' => [
				'type'     => OCore::NUM,
				'nullable' => false,
				'comment'  => 'Id del usuario dueño del proyecto',
				'ref'      => 'user.id'
			],
			'name' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => false,
				'comment'  => 'Nombre del proyecto'
			],
			'slug' => [
				'type'     => OCore::TEXT,
				'size'     => 50,
				'nullable' => false,
				'comment'  => 'Slug del nombre del proyecto'
			],
			'description' => [
				'type'     => OCore::LONGTEXT,
				'nullable' => true,
				'comment'  => 'Descripción del proyecto'
			],
			'last_compilation' => [
				'type'     => OCore::DATE,
				'nullable' => true,
				'default'  => null,
				'comment'  => 'Fecha de la última compilación'
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
	 * Borra un proyecto por completo, con todas sus configuraciones
	 *
	 * @return void
	 */
	public function deleteFull(): void {
		$sql = "DELETE FROM `project_include` WHERE `id_project` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$sql = "DELETE FROM `project_config_list_item` WHERE `id_project_config` IN (SELECT `id` FROM `project_config` WHERE `id_project` = ?)";
		$this->db->query($sql, [$this->get('id')]);
		$sql = "DELETE FROM `project_config` WHERE `id_project` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$sql = "DELETE FROM `row` WHERE `id_model` IN (SELECT `id` FROM `model` WHERE `id_project` = ?)";
		$this->db->query($sql, [$this->get('id')]);
		$sql = "DELETE FROM `model` WHERE `id_project` = ?";
		$this->db->query($sql, [$this->get('id')]);

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
		$conf = new ProjectConfig();
		$conf->find(['id_project'=>$this->get('id')]);
		$this->setProjectConfig($conf);
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
		$sql = "SELECT * FROM `model` WHERE `id_project` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$models = [];

		while ($res = $this->db->next()) {
			$model = new Model();
			$model->update($res);

			array_push($models, $model);
		}

		$this->setProjectModels($models);
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
		$sql = "SELECT * FROM `project_include` WHERE `id_project` = ?";
		$this->db->query($sql, [$this->get('id')]);
		$includes = [];

		while ($res = $this->db->next()) {
			$pri = new ProjectInclude();
			$pri->update($res);

			array_push($includes, $pri->get('id_type'));
		}

		$this->setProjectIncludes($includes);
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
		$sql = "SELECT * FROM `include_version` WHERE `id` IN (SELECT `id_type` FROM `project_include` WHERE `id_project` = ?)";
		$this->db->query($sql, [$this->get('id')]);
		$versions = [];

		while ($res = $this->db->next()) {
			$ver = new IncludeVersion();
			$ver->update($res);

			array_push($versions, $ver);
		}

		$this->setProjectIncludeVersions($versions);
	}
}