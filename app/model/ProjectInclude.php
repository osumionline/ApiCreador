<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class ProjectInclude extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'project_include';
		$model = [
			'id_project' => [
				'type'    => OModel::PK,
				'comment' => 'Id del proyecto en el que se incluye',
				'incr'    => false
			],
			'id_type' => [
				'type'    => OModel::PK,
				'comment' => 'Id del tipo de include',
				'incr'    => false
			],
			'created_at' => [
				'type'    => OModel::CREATED,
				'comment' => 'Fecha de creación del registro'
			],
			'updated_at' => [
				'type'    => OModel::UPDATED,
				'comment' => 'Fecha de última modificación del registro'
			]
		];

		parent::load($table_name, $model);
	}
}