<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class IncludeFile extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para cada archivo a incluir'
			],
			'id_include_version' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Id de la version del include',
				'ref'      => 'include_version.id'
			],
			'type' => [
				'type'     => OModel::NUM,
				'nullable' => false,
				'comment'  => 'Tipo de archivo 0 CSS 1 JS'
			],
			'filename' => [
				'type'     => OModel::TEXT,
				'size'     => 50,
				'nullable' => false,
				'comment'  => 'Nombre del archivo a incluir'
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
