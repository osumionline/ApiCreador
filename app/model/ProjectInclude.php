<?php declare(strict_types=1);
class ProjectInclude extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$table_name  = 'project_include';
		$model = [
			'id_project' => [
				'type'    => OCore::PK,
				'comment' => 'Id del proyecto en el que se incluye',
				'incr'    => false
			],
			'id_type' => [
				'type'    => OCore::PK,
				'comment' => 'Id del tipo de include',
				'incr'    => false
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
}