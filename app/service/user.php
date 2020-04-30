<?php declare(strict_types=1);
class userService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Obtiene la lista de proyectos de un usuario
	 *
	 * @param int $id_user Id del usuario
	 *
	 * @return array Lista de proyectos
	 */
	public function getProjects(int $id_user): array {
		$db = new ODB();
		$sql = "SELECT * FROM `project` WHERE `id_user` = ? ORDER BY `updated_at` DESC";
		$db->query($sql, [$id_user]);
		$ret = [];

		while ($res = $db->next()) {
			$pr = new Project();
			$pr->update($res);

			array_push($ret, $pr);
		}

		return $ret;
	}

	/**
	 * Obtiene la lista de includes completa
	 *
	 * @return array Lista de includes
	 */
	public function getIncludes(): array {
		$db = new ODB();
		$sql = "SELECT * FROM `include_type` WHERE `show_include` = 1 ORDER BY `name`";
		$db->query($sql);
		$ret = [];

		while ($res = $db->next()) {
			$inc = new IncludeType();
			$inc->update($res);

			array_push($ret, $inc);
		}

		return $ret;
	}

	/**
	 * Limpia las listas de configuraciones de un proyecto
	 *
	 * @param int $id_configuration Id de la configuración de un proyecto
	 *
	 * @return void
	 */
	public function cleanProjectConfigurationLists(int $id_configuration): void {
		$db = new ODB();
		$sql = "DELETE FROM `project_config_list_item` WHERE `id_project_config` = ?";
		$db->query($sql, [$id_configuration]);
	}

	/**
	 * Borra los campos que no se encuentren en la lista de campos actuales
	 *
	 * @param int $id_model Id del modelo a limpiar
	 *
	 * @param array $model_row_ids Ids de los campos que hay que conservar
	 *
	 * @return void
	 */
	public function cleanDeletedRows(int $id_model, array $model_row_ids): void {
		$db = new ODB();
		$in  = str_repeat('?,', count($model_row_ids) - 1) . '?';
		array_unshift($model_row_ids, $id_model);
		$sql = "DELETE FROM `row` WHERE `id_model` = ? AND `id` NOT IN (".$in.")";
		$db->query($sql, $model_row_ids);
	}

	/**
	 * Actualiza la lista de includes de un proyecto borrando la lista anterior y cargando la actual
	 *
	 * @param int $id_project Id del proyecto a actualizar
	 *
	 * @param array $project_includes Lista actual de includes del proyecto
	 *
	 * @return void
	 */
	public function updateProjectIncludes(int $id_project, array $project_includes): void {
		$db = new ODB();
		$sql = "DELETE FROM `project_include` WHERE `id_project` = ?";
		$db->query($sql, [$id_project]);
		foreach ($project_includes as $inc) {
			$pri = new ProjectInclude();
			$pri->set('id_project', $id_project);
			$pri->set('id_type', $inc);
			$pri->save();
		}
	}
}