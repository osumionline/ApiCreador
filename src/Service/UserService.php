<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\ORM\ODB;
use Osumi\OsumiFramework\App\Model\IncludeType;
use Osumi\OsumiFramework\App\Model\ProjectInclude;
use Osumi\OsumiFramework\App\Model\Project;

class UserService extends OService {
	/**
	 * Obtiene la lista de proyectos de un usuario
	 *
	 * @param int $id_user Id del usuario
	 *
	 * @return array Lista de proyectos
	 */
	public function getProjects(int $id_user): array {
		return Project::where(['id_user' => $id_user], ['order_by' => 'updated_at#desc']);
	}

	/**
	 * Obtiene la lista de includes completa
	 *
	 * @return array Lista de includes
	 */
	public function getIncludes(): array {
		return IncludeType::where(['show_include' => 1], ['order_by' => 'name']);
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
			$pri = ProjectInclude::create();
			$pri->id_project = $id_project;
			$pri->id_type    = $inc;
			$pri->save();
		}
	}
}
