<?php declare(strict_types=1);

namespace OsumiFramework\App\Model;

use OsumiFramework\OFW\DB\OModel;

class User extends OModel {
	/**
	 * Configures current model object based on data-base table structure
	 */
	function __construct() {
		$model = [
			'id' => [
				'type'    => OModel::PK,
				'comment' => 'Id único para cada usuario'
			],
			'username' => [
				'type'     => OModel::TEXT,
				'size'     => 50,
				'nullable' => false,
				'comment'  => 'Nombre de usuario'
			],
			'pass' => [
				'type'     => OModel::TEXT,
				'size'     => 100,
				'nullable' => false,
				'comment'  => 'Contraseña cifrada del usuario'
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
