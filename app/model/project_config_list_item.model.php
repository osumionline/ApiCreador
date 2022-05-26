<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class ProjectConfigListItem extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para cada proyecto'
			],
			'id_project_config' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Id de la configuración a la que hace referencia',
				'ref'      => 'project_config.id'
			],
			'type' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Tipo de elemento 0 css 1 ext_css 2 js 3 ext_js 4 extra 5 libs 6 dir'
			],
			'key' => [
				'type'     => OModel::TEXT,
				'size'     => 20,
				'nullable' => true,
				'default'  => null,
				'comment'  => 'Clave para los tipos extra y dir'
			],
			'value' => [
				'type'     => OModel::TEXT,
				'size'     => 100,
				'nullable' => false,
				'comment'  => 'Valor del elemento de lista'
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

		parent::load($model);
	}
}
